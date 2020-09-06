<?php

namespace App\Http\Controllers;
use Storage;
use Str;
use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\User as UserResource;


class UserController extends Controller
{

    public function __construct()
    {
        // Forces to be authenticated.
        $this->middleware('auth');
        // $this->middleware('check_role:admin');
    }
    public function fetch(Request $request){
        $users = User::query();
        if($request->query('name')){
            $keywords = $request->query('name');
            $keywords = explode(' ', $keywords);
            $users->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('trace', 'like', "%{$keyword}%");
                }
            });
        }
        $users = $users->paginate(10)->withQueryString();

        return UserResource::collection($users);
    }
    public function fetchOne(Request $request, $id){
        $user = User::find($id);
        if(is_null($user)){
            return response()->json(['message' => 'Not found'], 404); 
        }
        return new UserResource($user);
    }

    public function fetchAvatar(Request $request){
        if($request->query('thumbnail') == '1'){
            $path = Str::replaceFirst("/storage/avatars", '', $request->user()->avatar->thumbnail_path);
        } else {
            $path = Str::replaceFirst("/storage/avatars", '', $request->user()->avatar->path);
        }
        return Storage::disk('avatars')->get($path);
    }
}
