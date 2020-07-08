<?php

use App\User;
use App\Role;
use App\Organization;
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
        $user->name = 'Admin Participes';
        $user->email = 'admin@admin.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('participes');
        $user->remember_token = Str::random(10);
        $user->save();
        $user->roles()->attach(Role::where('name', 'user')->first());
        $user->roles()->attach(Role::where('name', 'admin')->first());
        $user->save();
    
        $user = new User();
        $user->name = 'Juan Marco';
        $user->email = 'user1@user.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('participes');
        $user->remember_token = Str::random(10);
        $user->save();
        $user->roles()->attach(Role::where('name', 'user')->first());
        $user->save();
        $user = new User();
        $user->name = 'Jose Gutierrez';
        $user->email = 'user2@user.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('participes');
        $user->remember_token = Str::random(10);
        $user->save();
        $user->roles()->attach(Role::where('name', 'user')->first());
        $user->save();
        $user = new User();
        $user->name = 'Eli Holliday';
        $user->email = 'user3@user.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('participes');
        $user->remember_token = Str::random(10);
        $user->save();
        $user->roles()->attach(Role::where('name', 'user')->first());
        $user->save();

        $org = new Organization();
        $org->name = 'Mi ONG Numero 1';
        $org->description = 'Pellentesque eget molestie neque. Nulla hendrerit congue sapien, quis maximus magna cursus nec.';
        $org->save();
        $org = new Organization();
        $org->name = 'Mi ONG Numero 2';
        $org->description = 'Pellentesque eget molestie neque. Nulla hendrerit congue sapien, quis maximus magna cursus nec.';
        $org->save();        
    }
}
