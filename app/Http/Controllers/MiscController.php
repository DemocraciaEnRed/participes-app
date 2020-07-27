<?php

namespace App\Http\Controllers;
use App;
use Artisan;
use Hash;
use Str;
use App\User;
use App\Role;
use Illuminate\Http\Request;

class MiscController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
			// Forces to be authenticated.
			// $this->middleware('auth');
	}

	public function start(Request $request){

		if (App::environment(['local','staging'])) {
			//The environment is either local OR staging...
			return view('start');
		}
		return redirect()->route('home');
	}    
	public function startApp(Request $request){
		if(App::environment(['local','staging'])){
			$rules = [
				'name' => 'required|string|max:255',
				'surname' => 'required|string|max:255',
				'email' => 'required|string|email|max:255',
				'password' => 'required|string|min:8|confirmed',
				'demo' => 'nullable|boolean',
			];

			$request->validate($rules);
			Artisan::call('migrate:fresh');
			Artisan::call("db:seed", ['--class' => "RoleTableSeeder"]);
			$admin = new User();
			$admin->name = $request->input('name');
			$admin->surname = $request->input('surname');
			$admin->email = $request->input('email');
			$admin->email_verified_at = now();
			$admin->password = Hash::make($request->input('password'));
			$admin->remember_token = Str::random(10);
			$admin->save();
			$admin->roles()->attach(Role::where('name', 'user')->first());
			$admin->roles()->attach(Role::where('name', 'admin')->first());
			if(boolval($request->input('demo'))){
				Artisan::call("db:seed", ['--class' => "DemoSeeder"]);
			}
			return redirect()->route('home')->with('success','Aplicacion instalada!');
		}
		return redirect()->route('home');
	}    
}
