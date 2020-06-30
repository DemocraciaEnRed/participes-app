<?php

use App\User;
use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Administrador';
        $user->email = 'admin@admin.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('participes');
        $user->remember_token = Str::random(10);
        $user->save();
        $user->roles()->attach(Role::where('name', 'user')->first());
        $user->roles()->attach(Role::where('name', 'admin')->first());
        $user->save();
    
        $user = new User();
        $user->name = 'Usuario';
        $user->email = 'user@user.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('participes');
        $user->remember_token = Str::random(10);
        $user->save();
        $user->roles()->attach(Role::where('name', 'user')->first());
        $user->save();

        
    }
}
