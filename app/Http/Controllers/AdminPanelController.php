<?php

namespace App\Http\Controllers;
use App\Category;
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
    public function viewListCategories(Request $request){
      $categories = Category::all();
      return view('admin.categories.list',['categories' => $categories]);
    }
    public function viewCreateCategory(Request $request){
        return view('admin.categories.create');
    }
    public function viewEditCategory(Request $request, $id){
        $category = Category::findOrFail($id);
        return view('admin.categories.edit',['category' => $category]);
    }
}
