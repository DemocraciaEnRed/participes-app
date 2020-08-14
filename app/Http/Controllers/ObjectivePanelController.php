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
      return redirect()->route('objectives.manage.team', ['objectiveId' => $request->objective->id])->with('success','Miembro agregado');
    }
    public function formRemoveTeam(Request $request){
      $this->hasManagerPrivileges($request);
      //TODO
      return redirect()->route('objectives.manage.team', ['objectiveId' => $request->objective->id])->with('success','Miembro eliminado');
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

    // public function viewAlbumReport (Request $request){
    //   return view('objective.manage.')
    // } 
}
