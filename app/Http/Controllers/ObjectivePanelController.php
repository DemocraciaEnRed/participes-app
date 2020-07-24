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
use App\Notifications\NewReport;
use Illuminate\Http\Request;

class ObjectivePanelController extends Controller
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
        $this->middleware('can_manage_objective');
    }

    private function hasManagerPrivileges(Request $request){
      if(!$request->user()->hasRole('admin') && !$request->user()->isManagerObjective($request->objective->id)){
        abort(403, 'No autorizado');
      }
      return;
    }

    public function index(Request $request){
      return view('objective.manage.index', ['objective' => $request->objective]);
    }

    public function viewListTeam(Request $request){
      return view('objective.manage.team.list', ['objective' => $request->objective]);
    }

    public function viewListSubscribers(Request $request){      
      $subscribers = $request->objective->subscribers()->paginate(10);
      return view('objective.manage.subscribers.list', ['objective' => $request->objective, 'subscribers' => $subscribers]);
    }

    public function viewAddTeam(Request $request){
      $this->hasManagerPrivileges($request);
      return view('objective.manage.team.add', ['objective' => $request->objective]);
    }

    public function formAddTeam(Request $request){
      $this->hasManagerPrivileges($request);
      $user = User::findOrFail($request->input('userId'));
      $request->objective->members()->attach($user, ['role' => $request->input('role')]);
      return redirect()->route('objective.manage.team', ['objId' => $request->objective->id])->with('success','Miembro agregado');
    }
    public function formRemoveTeam(Request $request){
      $this->hasManagerPrivileges($request);
      //TODO
      return redirect()->route('objective.manage.team', ['objId' => $request->objective->id])->with('success','Miembro eliminado');
    }
    public function viewListGoals(Request $request){
      return view('objective.manage.goals.list',['objective' => $request->objective]);
    }

    public function viewAddGoal(Request $request){
      $this->hasManagerPrivileges($request);
      return view('objective.manage.goals.add',['objective' => $request->objective]);
    }

    public function formAddGoal(Request $request){
      $this->hasManagerPrivileges($request);

      $rules = [
        'title' => 'required|string|max:550',
        'status' => 'required|string|in:ongoing,delayed,inactive',
        'indicator' => 'required|string|max:550',
        'indicator_goal' => 'integer|min:1',
        'indicator_progress' => 'integer|min:0',
        'indicator_unit' => 'required|string|max:550',
        'indicator_frequency' => 'string|max:550',
        'source' => 'string|max:550',
        'milestones' => 'array',
        'milestones.*' => 'required|string|max:550',
      ];

      $request->validate($rules);
      
      $goal = new Goal();
      $goal->title = $request->input('title');
      $goal->status = $request->input('status');
      $goal->indicator = $request->input('indicator');
      $goal->indicator_goal = $request->input('indicator_goal');
      $goal->indicator_progress = $request->input('indicator_progress');
      $goal->indicator_unit = $request->input('indicator_unit');
      $goal->indicator_frequency = $request->input('indicator_frequency');
      $goal->source = $request->input('source');
      $goal->objective()->associate($request->objective);
      $goal->save();
      foreach($request->input('milestones') as $key => $inputMilestone){
        $milestone = new Milestone();
        error_log($key);
        $milestone->order = $key + 1;
        $milestone->title = $inputMilestone;
        $milestone->goal()->associate($goal);
        $milestone->save();
      }
      return redirect()->route('objective.manage.goals.index', ['objId' => $request->objective->id, 'goalId' => $goal->id])->with('success','Meta creada');
    }

    public function viewGoal(Request $request, $objId, $goalId){
      $goal = Goal::findorfail($goalId);
      return view('objective.manage.goals.view',['objective' => $request->objective, 'goal' => $goal]);
    }

    public function viewListGoalMilestones(Request $request, $objId, $goalId){
      $goal = Goal::findorfail($goalId);
      return view('objective.manage.goals.milestones.list',['objective' => $request->objective, 'goal' => $goal]);
    }

    public function viewAddGoalMilestone(Request $request, $objId, $goalId){
      $this->hasManagerPrivileges($request);
      $goal = Goal::findorfail($goalId);
      return view('objective.manage.goals.milestones.add',['objective' => $request->objective, 'goal' => $goal]);
    }

    public function formAddGoalMilestone(Request $request, $objId, $goalId){
      $this->hasManagerPrivileges($request);

      $rules = [
        'title' => 'required|string|max:550',
      ];

      $request->validate($rules);

      $goal = Goal::findorfail($goalId);
      $lastMilestone = Milestone::where('goal_id', $goalId)->orderBy('order', 'desc')->first();
      $milestone = new Milestone();
      $milestone->order = $lastMilestone->order + 1;
      $milestone->title = $request->input('title');
      $milestone->goal()->associate($goal);
      $milestone->save();
      
      return redirect()->route('objective.manage.goals.milestones', ['objId' => $request->objective->id, 'goalId' => $goal->id])->with('success','Hito creado');
    }

    public function viewListGoalReports(Request $request, $objId, $goalId){
      $goal = Goal::findorfail($goalId);
      $reports = Report::where('goal_id',$goalId)->orderBy('date','DESC')->paginate(10);
      return view('objective.manage.goals.reports.list',['objective' => $request->objective, 'goal' => $goal, 'reports' => $reports]);
    }

    public function viewNewGoalReport(Request $request, $objId, $goalId){
      $this->hasManagerPrivileges($request);
      $goal = Goal::findorfail($goalId);
      return view('objective.manage.goals.reports.add',['objective' => $request->objective, 'goal' => $goal]);
    }

    public function formNewGoalReport(Request $request, $objId, $goalId){
      $this->hasManagerPrivileges($request);
     
      $rules = [
        'title' => 'required|string|max:550',
        'type' => 'required|string|in:post,progress,milestone',
        'content' => 'required|string',
        'date' => 'required|date',
        'status' => 'nullable|string|max:550',
        'lat' => 'nullable|string',
        'long' => 'nullable|string',
        'progress' => 'integer|min:1',
        'milestone_date' => 'nullable|date',
        'milestone' => 'integer',
        'tags' => 'array' ,
        'tags.*' => 'required|string|max:100' ,
      ];

      $request->validate($rules);
     
      $goal = Goal::findorfail($goalId);
      $goalDirty = false;
      $milestoneDirty = false;

      $report = new Report();
      $report->title = $request->input('title');
      $report->type = $request->input('type');
      $report->content = $request->input('content');
      $report->date = $request->input('date');
      $report->tags = $request->input('tags');
      if(!empty($request->input('status'))){
        $report->status = $request->input('status');
        $goal->status = $request->input('status');
        $goalDirty = true;
      }
      switch($request->input('type')){
        case 'post':
          break;
        case 'progress':
          $report->progress = $request->input('progress');
          $goal->indicator_progress += intval($request->input('progress'));
          $goalDirty = true;
          break;
        case 'milestone':
          $milestone = Milestone::findorfail($request->input('milestone'));
          
          if(!empty($request->input('milestone_date'))){
            $milestone->completed = $request->input('milestone_date');
          } else {
            $milestone->completed = $request->input('date');
          }
          $milestoneDirty = true;
          $report->milestone()->associate($milestone);
          break;
      }
      if($goalDirty){
        $goal->save();
      }
      if($milestoneDirty){
        $milestone->save();
      }
      $report->author()->associate($request->user());
      $report->goal()->associate($goal);
      $report->save();
      
      // Notify
      Notification::locale('es_AR')->send($request->objective->subscribers, new NewReport($request->objective, $goal, $report));

      return redirect()->route('objective.manage.goals.index', ['objId' => $request->objective->id, 'goalId' => $goal->id])->with('success','Reporte creado');
    }


    public function viewObjectiveConfiguration (Request $request){
      return view('objective.manage.configuration', ['objective' => $request->objective]);
    } 

    public function formObjectiveConfiguration (Request $request){
      $rules = [
        'hidden' => 'nullable|string|in:true',
      ];
      $request->validate($rules);
      $request->objective->hidden = $request->input('hidden') == 'true' ? true : false;
      $request->objective->save();
      return redirect()->route('objective.manage.configuration', ['objId' => $request->objective->id])->with('success','Se actualizó el objetivo');
    }

    public function viewObjectiveCover (Request $request){
      return view('objective.manage.cover', ['objective' => $request->objective]);
    } 

    public function formObjectiveCover (Request $request){
      $this->hasManagerPrivileges($request);

      $rules = [
          'image' => 'required|image|max:8000'
      ];
      $request->validate($rules);
      $cover = Image::make($request->file('image'));
      $cover->resize(1366, null, function ($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();
      });
      $coverThumbnail = Image::make($request->file('image'));
      $coverThumbnail->resize(500, null, function ($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();
      });
      // Get mimeType
      $mimeType = $cover->mime();
      // Get Extension
      // $fileExtension = explode('/',$mimeType)[1];
      $fileExtension = 'jpg';
      // Create New Name
      $fileName = 'cover-'.$request->objective->id.'-'.substr(uniqid(),-5).'.'.$fileExtension;
      $fileNameThumbnail = 'cover-'.$request->objective->id.'-'.substr(uniqid(),-5).'-thumbnail.'.$fileExtension;
      // Make the File path
      $filePath = 'storage/objectives/covers/'.$fileName;
      $filePathThumbnail = 'storage/objectives/covers/'.$fileNameThumbnail;
      if(is_null($request->objective->cover)){
        Storage::disk('objectives')->put("covers/".$fileName, (string) $cover->encode('jpg'));
        Storage::disk('objectives')->put("covers/".$fileNameThumbnail, (string) $coverThumbnail->encode('jpg',80));
        $imageFile = new ImageFile();
        $imageFile->name = $fileName;
        $imageFile->size = Storage::disk('objectives')->size("covers/".$fileName);
        $imageFile->mime = $mimeType;
        $imageFile->path = $filePath;
        $imageFile->thumbnail_name = $fileNameThumbnail;
        $imageFile->thumbnail_size = Storage::disk('objectives')->size("covers/".$fileNameThumbnail);
        $imageFile->thumbnail_mime = $mimeType;
        $imageFile->thumbnail_path = $filePathThumbnail;
        $request->objective->cover()->save($imageFile);
      } else {
          $deletePath = Str::replaceFirst('storage/', '', $request->objective->cover->path);
          Storage::disk('objectives')->delete($deletePath);
          $deletePath = Str::replaceFirst('storage/', '', $request->objective->cover->thumbnail_path);
          Storage::disk('objectives')->delete($deletePath);
          // Create File and update relationship
          Storage::disk('objectives')->put("covers/".$fileName, (string) $cover->encode('jpg'));
          Storage::disk('objectives')->put("covers/".$fileNameThumbnail, (string) $coverThumbnail->encode('jpg'));
          $request->objective->cover->name = $fileName;
          $request->objective->cover->size = Storage::disk('public')->size("objectives/covers/".$fileName);
          $request->objective->cover->mime = $mimeType;
          $request->objective->cover->path = $filePath;
          $request->objective->cover->thumbnail_name = $fileNameThumbnail;
          $request->objective->cover->thumbnail_size = Storage::disk('public')->size("objectives/covers/".$fileNameThumbnail);
          $request->objective->cover->thumbnail_mime = $mimeType;
          $request->objective->cover->thumbnail_path = $filePathThumbnail;
          $request->objective->cover->save();
      }
      // Save Logo
      return redirect()->route('objective.manage.cover', ['objId' => $request->objective->id])->with('success','Se actualizó la imagen de portada del objetivo');
    } 

    public function viewObjectiveFiles (Request $request){
      $files = $request->objective->files()->paginate(10);
      return view('objective.manage.files', ['objective' => $request->objective, 'files' => $files]);
    } 

    public function formObjectiveFile (Request $request){
      $this->hasManagerPrivileges($request);

      $rules = [
          'files' => 'required|array',
          'files.*' => 'required|file|max:102400'
      ];
      $request->validate($rules);

      foreach($request->file('files') as $file){
        $fileName = 'obj-'.$request->objective->id.'-'.$file->getClientOriginalName();
        $exists = Storage::disk('objectives')->exists('files/'.$fileName);
        $filePath = $file->storeAs('files',$fileName, 'objectives');
        if($exists){
          $existingFile = File::where('name',$fileName)->first();
          $existingFile->name = $fileName;
          $existingFile->size = $file->getSize();
          $existingFile->mime = $file->getMimeType();
          $existingFile->path = 'storage/objectives/'.$filePath;
          $existingFile->save();
        } else {
          $saveFile = new File();
          $saveFile->name = $fileName;
          $saveFile->size = $file->getSize();
          $saveFile->mime = $file->getMimeType();
          $saveFile->path = 'storage/objectives/'.$filePath;
          $request->objective->files()->save($saveFile);
        }
      }

      return redirect()->route('objective.manage.files', ['objId' => $request->objective->id])->with('success','Se agrego el archivo al repositorio del objetivo');
    } 

    public function viewObjectiveAlbum (Request $request){
      return view('objective.manage.album', ['objective' => $request->objective]);
    } 

    public function viewObjectiveMap (Request $request){
      return view('objective.manage.map', ['objective' => $request->objective]);
    } 

    // public function viewAlbumReport (Request $request){
    //   return view('objective.manage.')
    // } 
}
