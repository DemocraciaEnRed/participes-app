<?php

namespace App\Http\Controllers;
use Notification;
use Image;
use Storage;
use Str;
use App\Category;
use App\Organization;
use App\Role;
use App\File;
use App\ImageFile;
use App\User;
use App\Objective;
use App\Goal;
use App\Milestone;
use App\Report;
use App\Comment;
use App\Notifications\NewReport;
use Illuminate\Http\Request;

class ReportPanelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Forces to be authenticated.
        $this->middleware('auth');
        $this->middleware('fetch_objective');
        $this->middleware('goal_belongs_objective');
        $this->middleware('fetch_goal');
        $this->middleware('report_belongs_goal');
        $this->middleware('fetch_report');
        $this->middleware('can_manage_objective');
    }

    private function hasManagerPrivileges(Request $request){
      if(!$request->user()->hasRole('admin') && !$request->user()->isManagerObjective($request->objective->id)){
        abort(403, 'No autorizado');
      }
      return;
    }

    public function viewReport(Request $request, $objectiveId, $goalId, $reportId){

      return view('objective.manage.goals.reports.view',['objective' => $request->objective, 'goal' => $request->goal, 'report' => $request->report]);
    }

     public function viewReportComments (Request $request){
      $comments = $request->report->comments()->paginate(10);
      return view('objective.manage.goals.reports.comments', ['objective' => $request->objective, 'goal' => $request->goal, 'report' => $request->report, 'comments' => $comments]);
    } 
    public function formReportComment (Request $request){
      $rules = [
        'content' => 'required|string|max:2000'
      ];

      $request->validate($rules);

      $comment = new Comment();
      $comment->content = $request->input('content');
      $comment->user()->associate($request->user());
      $request->report->comments()->save($comment);

      return redirect()->route('objectives.manage.goals.reports.comments', ['objectiveId' => $request->objective->id, 'goalId' => $request->goal->id, 'reportId' => $request->report->id])->with('success','Se agrego un comentario al reporte');
    }
    public function formReportReplyComment (Request $request){
      $rules = [
        'content' => 'required|string|max:2000'
      ];

      $request->validate($rules);

      $comment = new Comment();
      $comment->content = $request->input('content');
      $comment->user()->attach($request->user());
      $request->report->comments()->save($comment);

      return redirect()->route('objectives.manage.goals.reports.comments', ['objectiveId' => $request->objective->id, 'goalId' => $request->goal->id, 'reportId' => $request->report->id])->with('success','Se agrego un comentario al reporte');
    }

     public function viewReportAlbum (Request $request){
      $photos = $request->report->photos()->paginate(10);
      return view('objective.manage.goals.reports.album', ['objective' => $request->objective, 'goal' => $request->goal, 'report' => $request->report, 'photos' => $photos]);
    } 
    public function formReportAlbum (Request $request){
      $rules = [
        'photo' => 'required|file|max:102400',
      ];

      $request->validate($rules);
      if($request->hasFile('photo')){
        $photoFile = $request->file('photo');
        $photo = Image::make($photoFile);
        $photo->resize(1366, 910, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $photoThumbnail = Image::make($photoFile);
        $photoThumbnail->resize(400, 266, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        // Get mimeType
        $mimeType = $photo->mime();
        // Get Extension
        $fileExtension = strtolower($photoFile->getClientOriginalExtension());
        $uniqueHash = substr(uniqid(),-5);
        $photoName = 'photo-'.$request->report->id.'-'.$uniqueHash.'.'.$fileExtension;
        $photoNameThumbnail = 'photo-'.$request->report->id.'-'.$uniqueHash.'-thumbnail.'.$fileExtension;
        // Make the File path
        $photoPath = 'storage/reports/photos/'.$photoName;
        $photoPathThumbnail = 'storage/reports/photos/'.$photoNameThumbnail;
        Storage::disk('reports')->put("photos/".$photoName, (string) $photo->encode($fileExtension));
        Storage::disk('reports')->put("photos/".$photoNameThumbnail, (string) $photoThumbnail->encode($fileExtension,80));
        $imageFile = new ImageFile();
        $imageFile->name = $photoName;
        $imageFile->size = Storage::disk('reports')->size("photos/".$photoName);
        $imageFile->mime = $mimeType;
        $imageFile->path = $photoPath;
        $imageFile->thumbnail_name = $photoNameThumbnail;
        $imageFile->thumbnail_size = Storage::disk('reports')->size("photos/".$photoNameThumbnail);
        $imageFile->thumbnail_mime = $mimeType;
        $imageFile->thumbnail_path = $photoPathThumbnail;
        $request->report->photos()->save($imageFile);
      }

      return redirect()->route('objectives.manage.goals.reports.album', ['objectiveId' => $request->objective->id, 'goalId' => $request->goal->id, 'reportId' => $request->report->id])->with('success','Se agrego la foto al album del reporte');
    }

    public function viewReportFiles (Request $request){
      $files = $request->report->files()->paginate(10);
      return view('objective.manage.goals.reports.files', ['objective' => $request->objective, 'goal' => $request->goal, 'report' => $request->report, 'files' => $files]);
    } 
    public function formReportFile (Request $request){
      $rules = [
        'file' => 'required|file|max:102400'
      ];

      $request->validate($rules);

      if($request->hasFile('file')){
        $file = $request->file('file');
        $fileName = 'report-'.$request->report->id.'-'.$file->getClientOriginalName();
        $exists = Storage::disk('reports')->exists('files/'.$fileName);
        $filePath = $file->storeAs('files',$fileName, 'reports');
        if($exists){
          $existingFile = File::where('name',$fileName)->first();
          $existingFile->name = $file->getClientOriginalName();
          $existingFile->size = $file->getSize();
          $existingFile->mime = $file->getMimeType();
          $existingFile->path = 'storage/reports/'.$filePath;
          $existingFile->save();
        } else {
          $saveFile = new File();
          $saveFile->name = $file->getClientOriginalName();
          $saveFile->size = $file->getSize();
          $saveFile->mime = $file->getMimeType();
          $saveFile->path = 'storage/reports/'.$filePath;
          $request->report->files()->save($saveFile);
        }
      }

      return redirect()->route('objectives.manage.goals.reports.files', ['objectiveId' => $request->objective->id, 'goalId' => $request->goal->id, 'reportId' => $request->report->id])->with('success','Se agrego el archivo al repositorio del objetivo');
    } 

    public function viewReportMap (Request $request){
      return view('objective.manage.goals.reports.map', ['objective' => $request->objective, 'goal' => $request->goal, 'report' => $request->report]);
    }  

     public function formReportMap (Request $request){
      $rules = [
        'map_lat' => 'nullable|numeric',
        'map_long' => 'nullable|numeric',
        'map_zoom' => 'nullable|numeric',
        'map_geometries' => 'nullable|string',
        'map_center' => 'nullable|string',
      ];

      $request->validate($rules);
      $report = $request->report;
      $report->map_lat = $request->input('map_lat');
      $report->map_long = $request->input('map_long');
      $report->map_zoom = $request->input('map_zoom');
      $report->map_geometries = $request->input('map_geometries');
      $report->map_center = $request->input('map_center');
      $report->save();

      return redirect()->route('objectives.manage.goals.reports.map', ['objectiveId' => $request->objective->id, 'goalId' => $request->goal->id, 'reportId' => $request->report->id])->with('success','Geometria actualizada!');
    } 
}