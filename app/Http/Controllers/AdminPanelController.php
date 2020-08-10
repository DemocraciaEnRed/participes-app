<?php

namespace App\Http\Controllers;
use Image;
use Storage;
use App\Category;
use App\Organization;
use App\Role;
use App\File;
use App\ImageFile;
use App\User;
use App\Objective;
use Illuminate\Http\Request;

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
    public function viewCreateObjectives(Request $request){
        $categories = Category::all();
        $organizations = Organization::all();
        return view('admin.objectives.create',['categories' => $categories, 'organizations' => $organizations]);
    }
    public function formCreateObjectives(Request $request){

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
}
