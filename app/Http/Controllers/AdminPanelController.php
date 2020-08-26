<?php

namespace App\Http\Controllers;
use Image;
use Storage;
use Log;
use App\Category;
use App\Organization;
use App\Role;
use App\File;
use App\ImageFile;
use App\User;
use App\Event;
use App\Objective;
use App\ActionLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;

class AdminPanelController extends Controller
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
        $this->middleware('check_role:admin');
    }

    public function index(Request $request){
        return view('admin.index');
    }

    // ====================================
    // Admin - Categories
    // ====================================
    
    public function viewListCategories(Request $request){
      $categories = Category::all();
      return view('admin.categories.list',['categories' => $categories]);
    }
    public function viewCreateCategory(Request $request){
        return view('admin.categories.create');
    }
    public function formCreateCategory(Request $request){
        $rules = [
            'title' => 'required|string|max:255' ,
            'icon' => 'required|string|max:100',
            'color' => 'required|string|max:100' ,
        ];

        $request->validate($rules);

        $category = new Category();
        $category->title = $request->input('title');
        $category->icon = $request->input('icon');
        $category->color = $request->input('color');
        $category->save();
        return redirect()->route('admin.categories')->with('success','Categoria creada!');
    }
    public function viewEditCategory(Request $request, $id){
        $category = Category::findOrFail($id);
        return view('admin.categories.edit',['category' => $category]);
    }

    // ====================================
    // Admin Organizations
    // ====================================

    public function viewListOrganizations(Request $request){
      $organizations = Organization::paginate(5);
      return view('admin.organizations.list',['organizations' => $organizations]);
    }
    public function viewCreateOrganization(Request $request){
        return view('admin.organizations.create');
    }
    public function formCreateOrganization(Request $request){
        $rules = [
            'name' => 'required|string|max:225',
            'description' => 'required|string|max:550',
            'logo' => 'image|nullable|max:1999'
        ];
        $request->validate($rules);
        
        // Handle data
        $newOrganization = new Organization();
        $newOrganization->name = $request->input('name');
        $newOrganization->description = $request->input('description');
        $newOrganization->save();
        //Handle Logo
        if($request->hasFile('logo')){
            $orgLogo = Image::make($request->file('logo'));
            $orgLogo->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $orgLogoThumbnail = Image::make($request->file('logo'));
            $orgLogoThumbnail->resize(96, 96, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            // Get mimeType
            $mimeType = $orgLogo->mime();
            // Get Extension
            $fileExtension = explode('/',$mimeType)[1];
            // Create New Name
            $fileName = 'org-'.$newOrganization->id.'-'.substr(uniqid(),-5).'.'.$fileExtension;
            $fileNameThumbnail = 'org-'.$newOrganization->id.'-'.substr(uniqid(),-5).'-thumbnail.'.$fileExtension;
            // Make the File path
            $filePath = '/storage/organizations/'.$fileName;
            $filePathThumbnail = '/storage/organizations/'.$fileNameThumbnail;
            // Save Logo
            Storage::disk('public')->put("organizations/".$fileName, (string) $orgLogo->encode());
            Storage::disk('public')->put("organizations/".$fileNameThumbnail, (string) $orgLogoThumbnail->encode());
            $imageFile = new ImageFile();
            $imageFile->name = $fileName;
            $imageFile->size = Storage::disk('public')->size("organizations/".$fileName);
            $imageFile->mime = $mimeType;
            $imageFile->path = $filePath;
            $imageFile->thumbnail_name = $fileNameThumbnail;
            $imageFile->thumbnail_size = Storage::disk('public')->size("organizations/".$fileNameThumbnail);
            $imageFile->thumbnail_mime = $mimeType;
            $imageFile->thumbnail_path = $filePathThumbnail;
            $newOrganization->logo()->save($imageFile);
        }
        
        return redirect()->route('admin.organizations')->with('success','¡Organizacion creada!');
    }
    public function viewEditOrganization(Request $request, $id){
        $organization = Organization::findOrFail($id);
        return view('admin.organizations.edit',['organization' => $organization]);
    }
    // ====================================
    // Admin Administrators
    // ====================================

    public function viewListAdministrators(Request $request){
      $administrators = User::whereHas('roles', function ($q) { 
            $q->where('name','admin');
          })->get();
      return view('admin.administrators.list',['administrators' => $administrators]);
    }
    public function viewAddAdministrator(Request $request){
        return view('admin.administrators.add');
    }
    public function formAddAdministrator(Request $request){
        $user = User::findOrFail($request->input('userId'));
        $user->roles()->attach(Role::where('name', 'admin')->first());
        return redirect()->route('admin.administrators')->with('success','¡Nuevo administrador creado!');
    }
    public function formDeleteAdministrator(Request $request, $id){
        $user = User::findOrFail($id);
        $user->roles()->detach(Role::where('name', 'admin')->first());

        return redirect()->route('admin.administrators')->with('success','Administrador eliminado');
    }
    // ====================================
    // Admin Objectives
    // ====================================

    public function viewListObjectives(Request $request){
      $objectives = Objective::paginate(10);
      return view('admin.objectives.list',['objectives' => $objectives]);
    }
    public function viewCreateObjective(Request $request){
        $categories = Category::all();
        $organizations = Organization::all();
        return view('admin.objectives.create',['categories' => $categories, 'organizations' => $organizations]);
    }
    public function formCreateObjective(Request $request){

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
        $objective = new Objective();
        $objective->title = $request->input('title');
        $objective->content = $request->input('content');
        $objective->tags = $request->input('tags');
        $objective->category()->associate($category);
        $objective->author()->associate($request->user());
        $objective->hidden = true;
        $objective->save();
        $objective->organizations()->attach($request->input('organizations'));
        return redirect()->route('objectives.manage.index',['objectiveId' => $objective->id])->with('success','¡Nuevo objetivo creado! Ahora le toca configurar el objetivo');
    }

    public function viewLogs(Request $request)
    {
      $logs = ActionLog::orderBy('record_datetime','DESC')->paginate(25);
      return view('admin.logs.list',['logs' => $logs]);
    }

    public function viewUpcomingEvents(Request $request)
    {
        $events = Event::where('date', '>=', Carbon::today())->orderBy('date','DESC')->paginate(10);
        return view('admin.events.upcoming',['events' => $events]);
    }
    public function viewPastEvents(Request $request)
    {
        $events = Event::where('date', '<', Carbon::today())->orderBy('date','DESC')->paginate(10);
        return view('admin.events.past',['events' => $events]);
    }

    public function viewCreateEvent(Request $request)
    {
        $objectives = Objective::select(['id','title','hidden'])->get();
        return view('admin.events.create',['objectives'=>$objectives]);
    }

    public function formCreateEvent(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:550',
            'content' => 'required|string',
            'date' => 'required|date',
            'hour' => 'required|numeric|between:0,23',
            'minute' => 'required|numeric|between:0,55',
            'address' => 'required|string|max:550',
            'urls' => 'array' ,
            'urls.*' => 'required|string' ,
            'objectives' => 'array' ,
            'objectives.*' => 'required|numeric' ,
            'notify' => 'nullable|string|in:true',
        ];

        $request->validate($rules);  

        $event = new Event();
        $event->title = $request->input('title');
        $event->content = $request->input('content');
        $event->date = "{$request->input('date')} {$request->input('hour','00')}:{$request->input('minute','00')}:00";
        $event->address = $request->input('address');
        $event->urls = $request->input('urls');
        $event->author()->associate($request->user());
        $event->save();
        $event->objectives()->attach($request->input('objectives'));

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
            // Get Extension
            $fileExtension = strtolower($photoFile->getClientOriginalExtension());
            $uniqueHash = substr(uniqid(),-5);
            $photoName = 'photo-'.$event->id.'-'.$uniqueHash.'.'.$fileExtension;
            $photoNameThumbnail = 'photo-'.$event->id.'-'.$uniqueHash.'-thumbnail.'.$fileExtension;
            // Make the File path
            $photoPath = '/storage/events/photos/'.$photoName;
            $photoPathThumbnail = '/storage/events/photos/'.$photoNameThumbnail;
            Storage::disk('events')->put("photos/".$photoName, (string) $photo->encode($fileExtension));
            Storage::disk('events')->put("photos/".$photoNameThumbnail, (string) $photoThumbnail->encode($fileExtension,80));
            $imageFile = new ImageFile();
            $imageFile->name = $photoName;
            $imageFile->size = Storage::disk('events')->size("photos/".$photoName);
            $imageFile->mime = $mimeType;
            $imageFile->path = $photoPath;
            $imageFile->thumbnail_name = $photoNameThumbnail;
            $imageFile->thumbnail_size = Storage::disk('events')->size("photos/".$photoNameThumbnail);
            $imageFile->thumbnail_mime = $mimeType;
            $imageFile->thumbnail_path = $photoPathThumbnail;
            $event->photos()->save($imageFile);
            }
        }

        return redirect()->route('admin.events')->with('success','¡Nuevo evento creado!');

    }

    public function viewEditEvent(Request $request, $eventId)
    {
        $event = Event::findorfail($eventId);
        $objectives = Objective::select(['id','title','hidden'])->get();
        return view('admin.events.edit',['event' => $event, 'objectives' => $objectives]);
    }

    public function formEditEvent(Request $request, $eventId)
    {
        $rules = [
            'title' => 'required|string|max:550',
            'content' => 'required|string',
            'date' => 'required|date',
            'hour' => 'required|numeric|between:0,23',
            'minute' => 'required|numeric|between:0,55',
            'address' => 'required|string|max:550',
            'urls' => 'array' ,
            'urls.*' => 'required|string',
            'objectives' => 'array' ,
            'objectives.*' => 'required|numeric' ,
            'notify' => 'nullable|string|in:true',
        ];
        $request->validate($rules);  

        $event = Event::findorfail($eventId);

        $event->title = $request->input('title');
        $event->content = $request->input('content');
        $event->date = "{$request->input('date')} {$request->input('hour','00')}:{$request->input('minute','00')}:00";
        $event->address = $request->input('address');
        $event->urls = $request->input('urls');
        $event->author()->associate($request->user());
        $event->objectives()->sync($request->input('objectives'));
        $event->save();

        return redirect()->route('admin.events.edit',['eventId' => $eventId])->with('success','El evento ha sido editado correctamente');
    }

    public function formAddPictureEvent(Request $request, $eventId)
    {
        $rules = [
            'photo' => 'required|file|max:102400',
        ];

        $request->validate($rules);

        $event = Event::findorfail($eventId);

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
            $photoName = 'photo-'.$event->id.'-'.$uniqueHash.'.'.$fileExtension;
            $photoNameThumbnail = 'photo-'.$event->id.'-'.$uniqueHash.'-thumbnail.'.$fileExtension;
            // Make the File path
            $photoPath = '/storage/events/photos/'.$photoName;
            $photoPathThumbnail = '/storage/events/photos/'.$photoNameThumbnail;
            Storage::disk('events')->put("photos/".$photoName, (string) $photo->encode($fileExtension));
            Storage::disk('events')->put("photos/".$photoNameThumbnail, (string) $photoThumbnail->encode($fileExtension,80));
            $imageFile = new ImageFile();
            $imageFile->name = $photoName;
            $imageFile->size = Storage::disk('events')->size("photos/".$photoName);
            $imageFile->mime = $mimeType;
            $imageFile->path = $photoPath;
            $imageFile->thumbnail_name = $photoNameThumbnail;
            $imageFile->thumbnail_size = Storage::disk('events')->size("photos/".$photoNameThumbnail);
            $imageFile->thumbnail_mime = $mimeType;
            $imageFile->thumbnail_path = $photoPathThumbnail;
            $event->photos()->save($imageFile);
        }

        return redirect()->route('admin.events.edit',['eventId' => $eventId])->with('success','Se ha agregado la imagen correctamente');
    }

    public function formDeletePictureEvent(Request $request, $eventId, $pictureId)
    {
        $event = Event::findorfail($eventId);
        $picture = ImageFile::findorfail($pictureId);
        Storage::disk('events')->delete("photos/".$picture->name);
        Storage::disk('events')->delete("photos/".$picture->thumbnail_name);
        $picture->delete();
        return redirect()->route('admin.events.edit',['eventId' => $eventId])->with('success','La imagen ha sido eliminada correctamente');
    }

    public function formDeleteEvent(Request $request, $eventId)
    {
        $rules = [
            'password' =>  ['required', new MatchOldPassword],
            'notify' => 'nullable|string|in:true',
        ];

        $request->validate($rules);
        $event = Event::findorfail($eventId);
        if(!$event->photos->isEmpty()){
            foreach ($event->photos as $photo) {
                Storage::disk('events')->delete("photos/".$photo->name);
                Storage::disk('events')->delete("photos/".$photo->thumbnail_name);
                $photo->delete();
            }
        }
        $event->objectives()->detach();
        $event->delete();

        Log::channel('mysql')->debug("{$request->user()->fullname} ha eliminado el evento {$event->title}", [
            'event_id' => $event->id,
            'event_title' => $event->title,
            'event_author' => $event->author->fullname,
            'user_fullname' => $request->user()->fullname,
            'email' => $request->user()->email
            ]);
        
        return redirect()->route('admin.events')->with('success','El evento ha sido eliminado correctamente');
    }

}