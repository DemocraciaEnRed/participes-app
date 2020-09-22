<?php

namespace App\Http\Controllers;
use Cache;
use Storage;
use Image;
use Log;
use Excel;
use Notification;
use App\Category;
use App\Organization;
use App\Role;
use App\File;
use App\ImageFile;
use App\User;
use App\Event;
use App\Objective;
use App\ActionLog;
use App\Faq;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\ObjectivesExport;
use App\Rules\MatchOldPassword;
use App\Notifications\NewEvent;
use App\Notifications\EditEvent;
use App\Notifications\DeleteEvent;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;

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
        return redirect()->route('admin.categories')->with('success','La categoria ha sido creada correctamente');
    }
    public function viewEditCategory(Request $request, $categoryId){
        $category = Category::findOrFail($categoryId);
        return view('admin.categories.edit',['category' => $category]);
    }
    public function formEditCategory(Request $request, $categoryId){
        $rules = [
            'title' => 'required|string|max:255' ,
            'icon' => 'required|string|max:100',
            'color' => 'required|string|max:100' ,
        ];

        $request->validate($rules);

        $category = Category::findorfail($categoryId);
        $category->title = $request->input('title');
        $category->icon = $request->input('icon');
        $category->color = $request->input('color');
        $category->save();

        return redirect()->route('admin.categories')->with('success','La categoria ha sido editada correctamente');
    }
    public function viewDeleteCategory(Request $request, $categoryId){
        $category = Category::findorfail($categoryId);
        $categories = Category::all();
        if(count($categories) == 1){
            return redirect()->route('admin.categories')->with('warning','No puede eliminar la categoria porque se requiere migrar los objetivos de la categoria que eliminara a otra categoria. Cree una nueva categoria para poder migrarlos');
        }
        return view('admin.categories.delete',['category' => $category, 'categories' => $categories]);
    }
    public function formDeleteCategory(Request $request, $categoryId){
        $rules = [
            'password' =>  ['required', new MatchOldPassword],
            'category' => 'required|numeric' ,
        ];
        $request->validate($rules);

        $category = Category::findorfail($categoryId);
        $newCategory = Category::findorfail($request->input('category'));
        foreach ($category->objectives as $objective) {
            $objective->category()->associate($newCategory);
            $objective->save();
        }
        $category->delete();

        return redirect()->route('admin.categories')->with('success','La categoria ha sido eliminada correctamente y los objetivos han sido migrado a otra categoria');
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
            Storage::disk('organizations')->put($fileName, (string) $orgLogo->encode());
            Storage::disk('organizations')->put($fileNameThumbnail, (string) $orgLogoThumbnail->encode());
            $imageFile = new ImageFile();
            $imageFile->name = $fileName;
            $imageFile->size = Storage::disk('organizations')->size($fileName);
            $imageFile->mime = $mimeType;
            $imageFile->path = $filePath;
            $imageFile->thumbnail_name = $fileNameThumbnail;
            $imageFile->thumbnail_size = Storage::disk('organizations')->size($fileNameThumbnail);
            $imageFile->thumbnail_mime = $mimeType;
            $imageFile->thumbnail_path = $filePathThumbnail;
            $newOrganization->logo()->save($imageFile);
        }
        
        return redirect()->route('admin.organizations')->with('success','La organizacion ha sido creada correctamente');
    }
    public function viewEditOrganization(Request $request, $organizationId){
        $organization = Organization::findOrFail($organizationId);
        return view('admin.organizations.edit',['organization' => $organization]);
    }
    public function formEditOrganization(Request $request, $organizationId){
        $rules = [
            'name' => 'required|string|max:225',
            'description' => 'required|string|max:550',
            'logo' => 'image|nullable|max:1999'
        ];
        $request->validate($rules);
        
        // Handle data
        $organization = Organization::findOrFail($organizationId);
        $organization->name = $request->input('name');
        $organization->description = $request->input('description');
        $organization->save();
        
        if($request->hasFile('logo')){
            //Has logo?
            if(!is_null($organization->logo)){
                Storage::disk('organizations')->delete($organization->logo->name);
                Storage::disk('organizations')->delete($organization->logo->thumbnail_name);
                $organization->logo->delete();
            }

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
            $fileName = 'org-'.$organization->id.'-'.substr(uniqid(),-5).'.'.$fileExtension;
            $fileNameThumbnail = 'org-'.$organization->id.'-'.substr(uniqid(),-5).'-thumbnail.'.$fileExtension;
            // Make the File path
            $filePath = '/storage/organizations/'.$fileName;
            $filePathThumbnail = '/storage/organizations/'.$fileNameThumbnail;
            // Save Logo
            Storage::disk('organizations')->put($fileName, (string) $orgLogo->encode());
            Storage::disk('organizations')->put($fileNameThumbnail, (string) $orgLogoThumbnail->encode());
            $imageFile = new ImageFile();
            $imageFile->name = $fileName;
            $imageFile->size = Storage::disk('organizations')->size($fileName);
            $imageFile->mime = $mimeType;
            $imageFile->path = $filePath;
            $imageFile->thumbnail_name = $fileNameThumbnail;
            $imageFile->thumbnail_size = Storage::disk('organizations')->size($fileNameThumbnail);
            $imageFile->thumbnail_mime = $mimeType;
            $imageFile->thumbnail_path = $filePathThumbnail;
            $organization->logo()->save($imageFile);
        }
        return redirect()->route('admin.organizations')->with('success','La organizacion ha sido editada correctamente');
    }
    public function viewDeleteOrganization(Request $request, $organizationId){
        $organization = Organization::findOrFail($organizationId);
        return view('admin.organizations.delete',['organization' => $organization]);
    }
    public function formDeleteOrganization(Request $request, $organizationId){
        $rules = [
            'password' =>  ['required', new MatchOldPassword],
        ];
        $request->validate($rules);
        $organization = Organization::findOrFail($organizationId);
        $organization->delete();
        return redirect()->route('admin.organizations')->with('success','La organizacion ha sido eliminada correctamente');
    }
    // ====================================
    // Admin FAQS
    // ====================================

    public function viewListFaqs(Request $request){
      $faqs = Faq::orderBy('section','ASC')->orderBy('order','ASC')->paginate(10);
      return view('admin.faqs.list',['faqs' => $faqs]);
    }
    public function viewCreateFaq(Request $request){
        return view('admin.faqs.create');
    }
    public function formCreateFaq(Request $request){
        $rules = [
            'section' => 'required|string|max:225',
            'title' => 'required|string|max:550',
            'order' => 'required|integer|min:0',
            'content' => 'required|string',
        ];
        $request->validate($rules);
        
        // Handle data
        $faq = new Faq();
        $faq->title = $request->input('title');
        $faq->order = $request->input('order');
        $faq->section = $request->input('section');
        $faq->content = $request->input('content');
        $faq->save();
        
        return redirect()->route('admin.faqs')->with('success','La pregunta frecuente ha sido creada correctamente');
    }
    public function viewEditFaq(Request $request, $faqId){
        $faq = Faq::findOrFail($faqId);
        return view('admin.faqs.edit',['faq' => $faq]);
    }
    public function formEditFaq(Request $request, $faqId){
        $rules = [
            'section' => 'required|string|max:225',
            'title' => 'required|string|max:225',
            'order' => 'required|integer|min:0',
            'content' => 'required|string',
        ];

        $request->validate($rules);
        
        $faq = Faq::findOrFail($faqId);
        $faq->title = $request->input('title');
        $faq->order = $request->input('order');
        $faq->section = $request->input('section');
        $faq->content = $request->input('content');
        $faq->save();
       
        return redirect()->route('admin.faqs')->with('success','La pregunta frecuente ha sido editada correctamente');
    }
    public function viewDeleteFaq(Request $request, $faqId){
        $faq = Faq::findOrFail($faqId);
        return view('admin.faqs.delete',['faq' => $faq]);
    }

    public function formDeleteFaq(Request $request, $faqId){
        $rules = [
            'password' =>  ['required', new MatchOldPassword],
        ];

        $request->validate($rules);

        $faq = Faq::findOrFail($faqId);
        $faq->delete();

        return redirect()->route('admin.faqs')->with('success','La pregunta frecuente ha sido eliminada correctamente');
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

        Log::channel('mysql')->info("[{$request->user()->fullname}] le ha ortorgado el rol de administrador al usuario  [{$user->fullname}]", [
            'admin_id' => $user->id,
            'admin_fullname' => $user->fullname,
            'admin_email' => $user->email,
            'user_id' => $request->user()->id,
            'user_fullname' => $request->user()->fullname,
            'user_email' => $request->user()->email
            ]);

        return redirect()->route('admin.administrators')->with('success','¡Nuevo administrador creado!');
    }
    public function formDeleteAdministrator(Request $request, $id){
        $user = User::findOrFail($id);
        $user->roles()->detach(Role::where('name', 'admin')->first());

        Log::channel('mysql')->info("[{$request->user()->fullname}] ha quitado el rol de administrador al usuario  [{$user->fullname}]", [
            'admin_id' => $user->id,
            'admin_fullname' => $user->fullname,
            'admin_email' => $user->email,
            'user_id' => $request->user()->id,
            'user_fullname' => $request->user()->fullname,
            'user_email' => $request->user()->email
            ]);

        return redirect()->route('admin.administrators')->with('success','Administrador eliminado');
    }
    // ====================================
    // Admin Objectives
    // ====================================

    public function viewListObjectives(Request $request){
      $objectives = Objective::paginate(10);
      return view('admin.objectives.list',['objectives' => $objectives]);
    }

    public function downloadListObjectives(Request $request){
      return Excel::download(new ObjectivesExport, Carbon::now()->format('Ymd').'-objetivos.xlsx');
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
            'category' => 'required',
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

        Log::channel('mysql')->info("[{$request->user()->fullname}] ha creado el objetivo [{$objective->title}]", [
            'objective_id' => $objective->id,
            'objective_title' => $objective->title,
            'user_id' => $request->user()->id,
            'user_fullname' => $request->user()->fullname,
            'user_email' => $request->user()->email
            ]);

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

        Log::channel('mysql')->info("[{$request->user()->fullname}] ha creado el evento [{$event->title}]", [
            'event_id' => $event->id,
            'event_title' => $event->title,
            'user_id' => $request->user()->id,
            'user_fullname' => $request->user()->fullname,
            'user_email' => $request->user()->email
            ]);

        $notifySubscribers = $request->boolean('notify');
        if($notifySubscribers){
            $usersToNotify = new EloquentCollection();
            foreach($event->objectives as $objective) {
                if(!$objective->hidden){
                    $usersToNotify = $usersToNotify->merge($objective->subscribers);
                }
            }
            if(!$usersToNotify->isEmpty()){
            Notification::send($usersToNotify, new NewEvent($event));
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

        Log::channel('mysql')->info("[{$request->user()->fullname}] ha editado el evento [{$event->title}]", [
            'event_id' => $event->id,
            'event_title' => $event->title,
            'user_id' => $request->user()->id,
            'user_fullname' => $request->user()->fullname,
            'user_email' => $request->user()->email
            ]);

        $notifySubscribers = $request->boolean('notify');
        if($notifySubscribers){
            $usersToNotify = new EloquentCollection();
            foreach($event->objectives as $objective) {
                if(!$objective->hidden){
                    $usersToNotify = $usersToNotify->merge($objective->subscribers);
                }
            }
            if(!$usersToNotify->isEmpty()){
                Notification::send($usersToNotify, new EditEvent($event));
            }
        }

        return redirect()->route('admin.events')->with('success','El evento ha sido editado correctamente');
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

    public function viewDeleteEvent(Request $request, $eventId)
    {
        $event = Event::findorfail($eventId);
        return view('admin.events.delete',['event' => $event]);
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
        
        $notifySubscribers = $request->boolean('notify');
        if($notifySubscribers){
            $usersToNotify = new EloquentCollection();
            foreach($event->objectives as $objective) {
                if(!$objective->hidden){
                    $usersToNotify = $usersToNotify->merge($objective->subscribers);
                }
            }
            if(!$usersToNotify->isEmpty()){
                Notification::send($usersToNotify, new DeleteEvent($event));
            }
        }
        
        $event->objectives()->detach();
        $event->delete();

        Log::channel('mysql')->info("[{$request->user()->fullname}] ha eliminado el evento [{$event->title}]", [
            'event_id' => $event->id,
            'event_title' => $event->title,
            'user_id' => $request->user()->id,
            'user_fullname' => $request->user()->fullname,
            'user_email' => $request->user()->email
            ]);

        
        return redirect()->route('admin.events')->with('success','El evento ha sido eliminado correctamente');
    }

    public function viewEditSettings(Request $request)
    {
        $settings = Setting::all()->keyBy('name');
        return view('admin.settings.edit',['settings' => $settings]);
    }
    public function formEditSetting(Request $request)
    {
        $rules = [
            'name' =>  'required|string',
            'type' =>  'required|string',
            'value' => 'nullable|string',
        ];

        $request->validate($rules);

        $setting = Setting::where('name', $request->input('name'))->first();
        $setting->name = $request->input('name');
        $setting->type = $request->input('type');
        $setting->value = $request->input('value');
        $setting->cached = $request->boolean('cached');
        $setting->save();
        return redirect()->route('admin.settings')->with('success','Configuración guardada');

    }
    public function formEditFileSetting(Request $request)
    {
        $rules = [
            'name' =>  'required|string',
            'type' =>  'required|string',
            'file' => 'required|file|max:102400',
        ];

        $request->validate($rules);

        $setting = Setting::where('name', $request->input('name'))->first();
        $setting->name = $request->input('name');
        $setting->type = $request->input('type');
        $setting->cached = $request->boolean('cached');
        if($request->hasFile('file')){
            $file = $request->file('file');
            // Get Extension
            $fileExtension = strtolower($file->getClientOriginalExtension());
            $uniqueHash = substr(uniqid(),-5);
            $fileName = $setting->name.'-'.$uniqueHash.'.'.$fileExtension;
            $filePath = '/storage/settings/'.$fileName;
            $file->storeAs('/',$fileName,'settings');
            $setting->value = $filePath;
        }
        $setting->save();
        return redirect()->route('admin.settings')->with('success','Configuración guardada');

    }
    public function clearCacheSettings(Request $request)
    {
        $settings = Setting::all();
        foreach ($settings as $setting) {
            Cache::put($setting->name, $setting->value);
        }
        return view('admin.events.delete',['event' => $event]);
    }

}