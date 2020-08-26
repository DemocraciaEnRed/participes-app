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
use App\Notifications\EditObjective;
use App\Notifications\JoinObjectiveTeam;
use App\Rules\MatchOldPassword;
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

    public function viewEditObjective(Request $request){
      $this->hasManagerPrivileges($request);
      $categories = Category::all();
      $organizations = Organization::all();
      return view('objective.manage.edit',['objective' => $request->objective, 'categories' => $categories, 'organizations' => $organizations]);
    }

    public function formEditObjective(Request $request){
      $this->hasManagerPrivileges($request);
      $rules = [
          'title' => 'required|string|max:550' ,
          'content' => 'required|string|max:2000',
          'category' => 'required' ,
          'tags' => 'array' ,
          'tags.*' => 'required|string|max:100' ,
          'organizations' => 'array' ,
          'organizations.*' => 'required|numeric' ,
      ];
      $request->validate($rules);

      $category = Category::findOrFail($request->input('category'));
      $objective = $request->objective;
      $objective->title = $request->input('title');
      $objective->content = $request->input('content');
      $objective->tags = $request->input('tags');
      $objective->category()->associate($category);
      $objective->author()->associate($request->user());
      $objective->save();
      $objective->organizations()->sync($request->input('organizations'));

      $notifySubscriber = $request->boolean('notify');
      if(!$objective->hidden && $notifySubscriber){
        Notification::locale('es')->send($objective->subscribers, new EditObjective($objective));
      }

      return redirect()->route('objectives.manage.index',['objectiveId' => $objective->id])->with('success','El objetivo ha sido editado correctamente');
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
      // Attach
      $request->objective->members()->attach($user, ['role' => $request->input('role')]);
      // Subscribe
      $request->objective->subscribers()->attach($user);
      // Notify
      $user->notify(new JoinObjectiveTeam($request->objective, $request->input('role')));
      return redirect()->route('objectives.manage.team', ['objectiveId' => $request->objective->id])->with('success','Se ha agregado al nuevo miembro en el equipo y se lo ha notificado exitosamente');
    }
    public function formRemoveTeam(Request $request, $objectiveId, $userId){
      $this->hasManagerPrivileges($request);
      $request->objective->members()->detach($userId);
      return redirect()->route('objectives.manage.team', ['objectiveId' => $request->objective->id])->with('success','Se ha eliminado al miembro del equipo');
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
        'indicator_frequency' => 'nullable|string|max:550',
        'source' => 'nullable|string|max:550',
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
        $milestone->order = $key + 1;
        $milestone->title = $inputMilestone;
        $milestone->goal()->associate($goal);
        $milestone->save();
      }
      return redirect()->route('objectives.manage.goals.index', ['objectiveId' => $request->objective->id, 'goalId' => $goal->id])->with('success','Meta creada');
    }

    public function viewObjectiveConfiguration (Request $request){
      return view('objective.manage.configuration', ['objective' => $request->objective]);
    } 

    public function formObjectiveConfigurationHide (Request $request){
      $rules = [
        'hidden' => 'nullable|string|in:true',
      ];
      $request->validate($rules);
      $request->objective->hidden = $request->boolean('hidden');
      $request->objective->save();
      return redirect()->route('objectives.manage.configuration', ['objectiveId' => $request->objective->id])->with('success','Se actualizó el objetivo');
    }
    public function formObjectiveConfigurationMap (Request $request){
      $rules = [
        'map_lat' => 'nullable|numeric',
        'map_long' => 'nullable|numeric',
        'map_zoom' => 'nullable|numeric',
      ];
      $request->validate($rules);
      if ($request->has(['map_lat', 'map_long', 'map_zoom'])) {
        $request->objective->map_lat = $request->input('map_lat');
        $request->objective->map_long = $request->input('map_long');
        $request->objective->map_zoom = $request->input('map_zoom');
      }
      $request->objective->save();
      return redirect()->route('objectives.manage.configuration', ['objectiveId' => $request->objective->id])->with('success','Se actualizó el objetivo');
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
      $uniqueHash = substr(uniqid(),-5);
      $fileName = 'cover-'.$request->objective->id.'-'.$uniqueHash.'.'.$fileExtension;
      $fileNameThumbnail = 'cover-'.$request->objective->id.'-'.$uniqueHash.'-thumbnail.'.$fileExtension;
      // Make the File path
      $filePath = '/storage/objectives/covers/'.$fileName;
      $filePathThumbnail = '/storage/objectives/covers/'.$fileNameThumbnail;
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
      return redirect()->route('objectives.manage.cover', ['objectiveId' => $request->objective->id])->with('success','Se actualizó la imagen de portada del objetivo');
    } 

    public function viewObjectiveFiles (Request $request){
      $files = $request->objective->files()->paginate(10);
      return view('objective.manage.files', ['objective' => $request->objective, 'files' => $files]);
    } 

    public function formObjectiveFile (Request $request){
      $this->hasManagerPrivileges($request);

      // FOR MULTIPLE FILES

      // $rules = [
      //     'files' => 'required|array',
      //     'files.*' => 'required|file|max:102400'
      // ];
      // $request->validate($rules);

      // foreach($request->file('files') as $file){
      //   $fileName = 'objective-'.$request->objective->id.'-'.$file->getClientOriginalName();
      //   $exists = Storage::disk('objectives')->exists('files/'.$fileName);
      //   $filePath = $file->storeAs('files',$fileName, 'objectives');
      //   if($exists){
      //     $existingFile = File::where('name',$fileName)->first();
      //     $existingFile->name = $file->getClientOriginalName();
      //     $existingFile->size = $file->getSize();
      //     $existingFile->mime = $file->getMimeType();
      //     $existingFile->path = 'storage/objectives/'.$filePath;
      //     $existingFile->save();
      //   } else {
      //     $saveFile = new File();
      //     $saveFile->name = $file->getClientOriginalName();
      //     $saveFile->size = $file->getSize();
      //     $saveFile->mime = $file->getMimeType();
      //     $saveFile->path = 'storage/objectives/'.$filePath;
      //     $request->objective->files()->save($saveFile);
      //   }
      // }

      $rules = [
        'file' => 'required|file|max:102400'
      ];

      $request->validate($rules);

      if($request->hasFile('file')){
        $file = $request->file('file');
        $fileName = 'objective-'.$request->objective->id.'-'.$file->getClientOriginalName();
        $exists = Storage::disk('objectives')->exists('files/'.$fileName);
        $filePath = $file->storeAs('files',$fileName, 'objectives');
        if($exists){
          $existingFile = File::where('name',$fileName)->first();
          $existingFile->name = $file->getClientOriginalName();
          $existingFile->size = $file->getSize();
          $existingFile->mime = $file->getMimeType();
          $existingFile->path = 'storage/objectives/'.$filePath;
          $existingFile->save();
        } else {
          $saveFile = new File();
          $saveFile->name = $file->getClientOriginalName();
          $saveFile->size = $file->getSize();
          $saveFile->mime = $file->getMimeType();
          $saveFile->path = 'storage/objectives/'.$filePath;
          $request->objective->files()->save($saveFile);
        }
      }
      
      return redirect()->route('objectives.manage.files', ['objectiveId' => $request->objective->id])->with('success','Se agrego el archivo al repositorio del objetivo');
    } 

    public function viewObjectiveAlbum (Request $request){
      return view('objective.manage.album', ['objective' => $request->objective]);
    } 

    public function viewObjectiveMap (Request $request){
      return view('objective.manage.map', ['objective' => $request->objective]);
    } 

    public function formDeleteObjective(Request $request){
      $this->hasManagerPrivileges($request);

      $rules = [
        'password' =>  ['required', new MatchOldPassword],
        'notify' => 'nullable|string|in:true',
      ];

      $request->validate($rules);

      Log::channel('mysql')->debug("{$request->user()->fullname} el objetivo {$request->objective->title}", [
        'objective' => $request->objective->id,
        'objective_title' => $request->objective->title,
        'user_id' => $request->user()->id,
        'user_fullname' => $request->user()->fullname,
        'email' => $request->user()->email
        ]);

      $goals = $request->objective->goals;
      foreach ($goals as $goal) {
        $reports = $goal->reports;
        foreach ($reports as $report) {
          $report->delete();
        }
        $goal->delete();
      }
      $request->objective->delete();
      // Notify
      // $notifySubscriber = $request->boolean('notify');
      // if(!$request->objective->hidden && $notifySubscriber){
      //   Notification::locale('es')->send($request->objective->subscribers, new EditReport($request->objective, $request->goal, $report));
      // }


      return redirect()->route('home')->with('success','Objetivo eliminado correctamente');

    }
}
