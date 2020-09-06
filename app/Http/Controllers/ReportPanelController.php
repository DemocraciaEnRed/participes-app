<?php

namespace App\Http\Controllers;
use Notification;
use Image;
use Storage;
use Str;
use Log;
use Excel;
use Carbon\Carbon;
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
use App\Exports\ReportCommentsExport;
use App\Exports\ReportTestimoniesExport;
use App\Notifications\EditReport;
use App\Notifications\DeleteReport;
use App\Rules\MatchOldPassword;
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
        $this->middleware('verified');
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

    public function viewEditReport(Request $request, $objectiveId, $goalId, $reportId){
      $request->goal->load('milestones');
      return view('objective.manage.goals.reports.edit',['objective' => $request->objective, 'goal' => $request->goal, 'report' => $request->report]);
    }

    public function formEditReport(Request $request, $objectiveId, $goalId, $reportId){
     
      $rules = [
        'title' => 'required|string|max:550',
        'content' => 'required|string',
        'date' => 'required|date',
        'previous_status' => 'nullable|string|max:550',
        'status' => 'nullable|string|max:550',
        'previous_progress' => 'integer|min:0',
        'progress' => 'integer|min:0',
        'milestone_date' => 'nullable|date',
        'milestone' => 'integer',
        'tags' => 'array',
        'tags.*' => 'required|string|max:100',
        'notify' => 'nullable|string|in:true',
      ];

      $request->validate($rules);
     
      $goal = $request->goal;
      $goalDirty = false;
      $milestoneDirty = false;

      $report = $request->report;
      $report->title = $request->input('title');
      $report->content = $request->input('content');
      $report->date = $request->input('date');
      $report->tags = $request->input('tags');
      if(!empty($request->input('status'))){
        $report->previous_status = $request->input('previous_status');
        $report->status = $request->input('status');
      }
      switch($report->type){
        case 'post':
          break;
        case 'progress':
          $report->previous_progress = $request->input('previous_progress');
          $report->progress = $request->input('progress');
          break;
        case 'milestone':
          if($report->milestone->id == $request->input('milestone')){
            if(!empty($request->input('milestone_date'))){
              $report->milestone->completed = $request->input('milestone_date');
            } else {
              $report->milestone->completed = $request->input('date');
            }
          } else {
            $milestone = Milestone::findorfail($request->input('milestone'));
            $report->milestone()->associate($milestone);
            if(!empty($request->input('milestone_date'))){
              $milestone->completed = $request->input('milestone_date');
            } else {
              $milestone->completed = $request->input('date');
            }
            $milestone->save();
          }
          break;
      }

      $report->save();
      
      Log::channel('mysql')->info("[{$request->user()->fullname}] ha editado el reporte [{$report->title}] de la meta [{$request->goal->title}] del objetivo [{$request->objective->title}]", [
        'objective_id' => $request->objective->id,
        'objective_title' => $request->objective->title,
        'goal_id' => $request->goal->id,
        'goal_title' => $request->goal->title,
        'report_id' => $report->id,
        'report_title' => $report->title,
        'user_id' => $request->user()->id,
        'user_fullname' => $request->user()->fullname,
        'user_email' => $request->user()->email
        ]);

      // Notify
      $notifySubscriber = $request->boolean('notify');
      if(!$request->objective->hidden && $notifySubscriber){
        Notification::send($request->objective->subscribers, new EditReport($request->objective, $request->goal, $report));
      }
      
      return redirect()->route('objectives.manage.goals.reports.index', ['objectiveId' => $request->objective->id, 'goalId' => $goal->id,'reportId' => $report->id])->with('success','El reporte ha sido editado con exito');
    }

    public function viewReportComments (Request $request){
      $comments = $request->report->comments()->paginate(10);
      return view('objective.manage.goals.reports.comments', ['objective' => $request->objective, 'goal' => $request->goal, 'report' => $request->report, 'comments' => $comments]);
    } 

    public function downloadReportComments (Request $request, $objectiveId, $goalId, $reportId){
      $this->hasManagerPrivileges($request);
      return Excel::download(new ReportCommentsExport($reportId), Carbon::now()->format('Ymd').'-comentarios-reporte-'.$reportId.'.xlsx');
    }

    public function viewReportTestimonies (Request $request){
      $testimonies = $request->report->testimonies()->paginate(10);
      return view('objective.manage.goals.reports.testimonies', ['objective' => $request->objective, 'goal' => $request->goal, 'report' => $request->report, 'testimonies' => $testimonies]);
    } 

    public function downloadReportTestimonies (Request $request, $objectiveId, $goalId, $reportId){
      $this->hasManagerPrivileges($request);
      return Excel::download(new ReportTestimoniesExport($reportId), Carbon::now()->format('Ymd').'-feedbacks-reporte-'.$reportId.'.xlsx');
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
        $photoPath = '/storage/reports/photos/'.$photoName;
        $photoPathThumbnail = '/storage/reports/photos/'.$photoNameThumbnail;
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

    public function formDeletePictureReport(Request $request, $objectiveId, $goalId, $reportId, $pictureId)
    {
        $report = Report::findorfail($reportId);
        $picture = ImageFile::findorfail($pictureId);
        Storage::disk('reports')->delete("photos/".$picture->name);
        Storage::disk('reports')->delete("photos/".$picture->thumbnail_name);
        $picture->delete();
        return redirect()->route('objectives.manage.goals.reports.album', ['objectiveId' => $request->objective->id, 'goalId' => $request->goal->id, 'reportId' => $request->report->id])->with('success','Se elimino la foto del album del reporte');
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
          $existingFile->path = '/storage/reports/'.$filePath;
          $existingFile->save();
        } else {
          $saveFile = new File();
          $saveFile->name = $file->getClientOriginalName();
          $saveFile->size = $file->getSize();
          $saveFile->mime = $file->getMimeType();
          $saveFile->path = '/storage/reports/'.$filePath;
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

    public function viewReportConfiguration(Request $request){
      return view('objective.manage.goals.reports.configuration',['objective' => $request->objective, 'goal' => $request->goal, 'report' => $request->report]);
    }

    public function formDeleteReport(Request $request){
      $this->hasManagerPrivileges($request);

      $rules = [
        'password' =>  ['required', new MatchOldPassword],
        'notify' => 'nullable|string|in:true',
      ];

      $request->validate($rules);

      Log::channel('mysql')->info("[{$request->user()->fullname}] ha eliminado el reporte [{$request->report->title}] de la meta [{$request->goal->title}] del objetivo [{$request->objective->title}]", [
        'objective_id' => $request->objective->id,
        'objective_title' => $request->objective->title,
        'goal_title' => $request->goal->id,
        'goal_title' => $request->goal->title,
        'report_id' => $request->report->id,
        'report_title' => $request->report->title,
        'user_id' => $request->user()->id,
        'user_fullname' => $request->user()->fullname,
        'user_email' => $request->user()->email
        ]);

      $request->report->delete();
      
      // Notify
      $notifySubscribers = $request->boolean('notify');
      if(!$request->objective->hidden && $notifySubscribers){
        Notification::send($request->objective->subscribers, new DeleteReport($request->objective, $request->goal, $request->report));
      }


      return redirect()->route('objectives.manage.goals.index', ['objectiveId' => $request->objective->id, 'goalId' => $request->goal->id])->with('success','Reporte eliminado correctamente');

    }

}