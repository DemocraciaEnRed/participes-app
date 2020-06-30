<?php

namespace App\Http\Controllers;
use App\Category;
use App\Organization;
use App\File;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\OrganizationRequest;

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
}
