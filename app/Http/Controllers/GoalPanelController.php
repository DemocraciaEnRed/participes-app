<?php

namespace App\Http\Controllers;
use Notification;
use Image;
use Storage;
use Str;
use Log;
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
use App\Notifications\EditGoal;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;

class GoalPanelController extends Controller
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
        $this->middleware('can_manage_objective');
    }

    private function hasManagerPrivileges(Request $request){
      if(!$request->user()->hasRole('admin') && !$request->user()->isManagerObjective($request->objective->id)){
        abort(403, 'No autorizado');
      }
      return;
    }

    public function viewGoal(Request $request, $objectiveId, $goalId){    
      return view('objective.manage.goals.view',['objective' => $request->objective, 'goal' => $request->goal]);
    }

    public function viewEditGoal(Request $request, $objectiveId, $goalId){
      $this->hasManagerPrivileges($request);
      return view('objective.manage.goals.edit',['objective' => $request->objective, 'goal' => $request->goal]);
    }

    public function formEditGoal(Request $request, $objectiveId, $goalId){
      $this->hasManagerPrivileges($request);

      $rules = [
        'title' => 'required|string|max:550',
        'status' => 'required|string|in:ongoing,delayed,inactive,reached',
        'indicator' => 'required|string|max:550',
        'indicator_goal' => 'integer|min:1',
        'indicator_progress' => 'integer|min:0',
        'indicator_unit' => 'required|string|max:550',
        'indicator_frequency' => 'nullable|string|max:550',
        'source' => 'nullable|string|max:550',
        'notify' => 'nullable|string|in:true',
      ];

      $request->validate($rules);
      $goal = $request->goal;
      $goal->title = $request->input('title');
      $goal->status = $request->input('status');
      $goal->indicator = $request->input('indicator');
      $goal->indicator_goal = $request->input('indicator_goal');
      $goal->indicator_progress = $request->input('indicator_progress');
      $goal->indicator_unit = $request->input('indicator_unit');
      $goal->indicator_frequency = $request->input('indicator_frequency');
      $goal->source = $request->input('source');
      $goal->save();
      $request->objective->touch();
      
      $notifySubscriber = $request->boolean('notify');
      if(!$request->objective->hidden && $notifySubscriber){
        Notification::locale('es')->send($request->objective->subscribers, new EditGoal($request->objective, $goal));
      }

      return redirect()->route('objectives.manage.goals.index', ['objectiveId' => $request->objective->id, 'goalId' => $goal->id])->with('success','La meta ha sido editada correctamente');
    }

    public function viewListGoalMilestones(Request $request, $objectiveId, $goalId){
      return view('objective.manage.goals.milestones.list',['objective' => $request->objective, 'goal' => $request->goal]);
    }

    public function viewAddGoalMilestone(Request $request, $objectiveId, $goalId){
      $this->hasManagerPrivileges($request);
      return view('objective.manage.goals.milestones.add',['objective' => $request->objective, 'goal' => $request->goal]);
    }

    public function formAddGoalMilestone(Request $request, $objectiveId, $goalId){
      $this->hasManagerPrivileges($request);

      $rules = [
        'title' => 'required|string|max:550',
      ];

      $request->validate($rules);

      $goal = $request->goal;
      $lastMilestone = Milestone::where('goal_id', $goalId)->orderBy('order', 'desc')->first();
      $milestone = new Milestone();
      $milestone->order = $lastMilestone->order + 1;
      $milestone->title = $request->input('title');
      $milestone->goal()->associate($goal);
      $milestone->save();
      
      return redirect()->route('objectives.manage.goals.milestones', ['objectiveId' => $request->objective->id, 'goalId' => $goal->id])->with('success','Hito creado');
    }

    public function viewListGoalReports(Request $request, $objectiveId, $goalId){
      $goal = $request->goal;
      $reports = Report::where('goal_id',$goalId)->orderBy('date','DESC')->paginate(10);
      return view('objective.manage.goals.reports.list',['objective' => $request->objective, 'goal' => $request->goal, 'reports' => $reports]);
    }

    public function viewNewGoalReport(Request $request, $objectiveId, $goalId){
      $goal = $request->goal;
      return view('objective.manage.goals.reports.add',['objective' => $request->objective, 'goal' => $request->goal]);
    }

    public function formNewGoalReport(Request $request, $objectiveId, $goalId){
     
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
        'tags.*' => 'required|string|max:100',
        'photos' => 'array',
        'photos.*' => 'required|file|max:102400',
        'files' => 'array',
        'files.*' => 'required|file|max:102400'
      ];

      $request->validate($rules);
     
      $goal = $request->goal;
      $goalDirty = false;
      $milestoneDirty = false;

      $report = new Report();
      $report->title = $request->input('title');
      $report->type = $request->input('type');
      $report->content = $request->input('content');
      $report->date = $request->input('date');
      $report->tags = $request->input('tags');
      if(!empty($request->input('status'))){
        $report->previous_status = $goal->status;
        $report->status = $request->input('status');
        $goal->status = $request->input('status');
        $goalDirty = true;
      }
      switch($request->input('type')){
        case 'post':
          break;
        case 'progress':
          $report->previous_progress = $goal->indicator_progress;
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
      
      if($request->hasFile('photos')){
        foreach($request->file('photos') as $photoFile){
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
          // dd( strtolower($photoFile->getClientOriginalExtension()) );
          // Get Extension
          // $fileExtension = explode('/',$mimeType)[1];
          $fileExtension = strtolower($photoFile->getClientOriginalExtension());
          $uniqueHash = substr(uniqid(),-5);
          $photoName = 'photo-'.$report->id.'-'.$uniqueHash.'.'.$fileExtension;
          $photoNameThumbnail = 'photo-'.$report->id.'-'.$uniqueHash.'-thumbnail.'.$fileExtension;
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
          $report->photos()->save($imageFile);
        }
      }
      if($request->hasFile('files')){
        foreach($request->file('files') as $file){
          $fileName = 'report-'.$report->id.'-'.$file->getClientOriginalName();
          $filePath = $file->storeAs('files',$fileName, 'reports');
          $saveFile = new File();
          $saveFile->name = $file->getClientOriginalName();
          $saveFile->size = $file->getSize();
          $saveFile->mime = $file->getMimeType();
          $saveFile->path = '/storage/reports/'.$filePath;
          $report->files()->save($saveFile);
        }
      }

      // Notify
      if(!$request->objective->hidden){
        Notification::locale('es')->send($request->objective->subscribers, new NewReport($request->objective, $goal, $report));
      }
      
      return redirect()->route('objectives.manage.goals.reports.index', ['objectiveId' => $request->objective->id, 'goalId' => $goal->id,'reportId' => $report->id])->with('success','El reporte fue creado con exito');
    }

    public function viewGoalConfiguration(Request $request){
      return view('objective.manage.goals.configuration',['objective' => $request->objective, 'goal' => $request->goal]);
    }

    public function formDeleteGoal(Request $request){
      $this->hasManagerPrivileges($request);

      $rules = [
        'password' =>  ['required', new MatchOldPassword],
        'notify' => 'nullable|string|in:true',
      ];

      $request->validate($rules);

      Log::channel('mysql')->debug("{$request->user()->fullname} ha eliminado la meta {$request->goal->title} del objetivo {$request->objective->title}", [
        'objective' => $request->objective->id,
        'objective_title' => $request->objective->title,
        'goal_title' => $request->goal->id,
        'goal_title' => $request->goal->title,
        'user_id' => $request->user()->id,
        'user_fullname' => $request->user()->fullname,
        'email' => $request->user()->email
        ]);

      $reports = $request->goal->reports;
      foreach ($reports as $report) {
        $report->delete();
      }
      $request->goal->delete();
      // Notify
      // $notifySubscriber = $request->boolean('notify');
      // if(!$request->objective->hidden && $notifySubscriber){
      //   Notification::locale('es')->send($request->objective->subscribers, new EditReport($request->objective, $request->goal, $report));
      // }


      return redirect()->route('objectives.manage.index', ['objectiveId' => $request->objective->id])->with('success','Meta eliminada correctamente');

    }

}