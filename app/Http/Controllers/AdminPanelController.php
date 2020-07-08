<?php

namespace App\Http\Controllers;
use App\Category;
use App\Organization;
use App\Role;
use App\File;
use App\User;
use App\Objective;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\OrganizationRequest;
use App\Http\Requests\ObjectiveRequest;

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
    public function formCreateCategory(CategoryRequest $request){
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
      $organizations = Organization::all();
      return view('admin.organizations.list',['organizations' => $organizations]);
    }
    public function viewCreateOrganization(Request $request){
        return view('admin.organizations.create');
    }
    public function formCreateOrganization(OrganizationRequest $request){
        
        // Handle data
        $newOrganization = new Organization();
        $newOrganization->name = $request->input('name');
        $newOrganization->description = $request->input('description');
        $newOrganization->save();
        //Handle Logo
        if($request->hasFile('logo')){
            $newFile = new File();
            // Get Extension
            $extension = $request->file('logo')->getClientOriginalExtension();
            // Create New Name
            $fileName = 'logo-org-'.$newOrganization->id.'.'.$extension;
            // Get Size
            $fileSize = $request->file('logo')->getSize();
            // Get Mime Type
            $mimeType = $request->file('logo')->getClientMimeType();
            // Save in storage/app/public/organizations
            $filePath = $request->file('logo')->storeAs('organizations', $fileName,'public');
            $filePath = 'storage/'.$filePath;
            error_log('Filepath: '. $filePath);
            $newFile->file_name = $fileName;
            $newFile->file_size = $fileSize;
            $newFile->mime_type = $mimeType;
            $newFile->path= $filePath;
            $newOrganization->logo()->save($newFile);
            $newOrganization->save();
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
    public function formCreateObjectives(ObjectiveRequest $request){
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
        return redirect()->route('objective.manage.index',['objId' => $objective->id])->with('success','¡Nuevo objetivo creado! Ahora le toca configurar el objetivo');
    }
}
