<?php

use App\User;
use App\Role;
use App\File;
use App\ImageFile;
use App\Category;
use App\Organization;
use App\Objective;
use App\Goal;
use App\Milestone;
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
        $faker = Faker\Factory::create('es_AR');
        
        $admin = new User();
        $admin->name = 'Admin';
        $admin->surname = 'Participes';
        $admin->email = 'admin@admin.com';
        $admin->email_verified_at = now();
        $admin->password = Hash::make('participes');
        $admin->remember_token = Str::random(10);
        $admin->save();
        $admin->roles()->attach(Role::where('name', 'user')->first());
        $admin->roles()->attach(Role::where('name', 'admin')->first());
        $admin->save();

        $usrRole = Role::where('name', 'user')->first();
        $users = array();
        for ($i=0; $i < 50; $i++) { 
            $user = new User();
            $user->name = $faker->name;
            $user->surname = "Usuario${i}";
            $user->email = "user${i}@user.com";
            $user->email_verified_at = now();
            $user->password = Hash::make('participes');
            $user->remember_token = Str::random(10);
            $user->save();
            $user->roles()->attach($usrRole);
            $user->save();
            $users[] = $user->id;
        }
        $organizations = array();
        for ($i=0; $i < 25; $i++) { 
            $picture = new ImageFile();
            $picture->name = 'default-avatar.png';
            $picture->size = '100';
            $picture->mime = 'image/png';
            $picture->path = 'img/default-avatar.png';
            $organization = new Organization();
            $organization->name = $faker->company;
            $organization->description = $faker->text;
            $organization->save();
            $organization->logo()->save($picture);
            $organizations[] = $organization->id;
        }

        for ($i=0; $i <= 20; $i++) { 
            $objective = new Objective();
            $category = Category::findorfail($faker->randomElement([1,2,3,4]));
            $objective->title = $faker->sentence;
            $objective->content = $faker->text(600);
            $objective->tags = $faker->randomElements(['tag1','tag2','tag3','tag4','tag5','tag6'],3);
            $objective->category()->associate($category);
            $objective->author()->associate($admin);
            $objective->save();
            $objective->organizations()->attach($faker->randomElements($organizations,3));
            for ($y=0; $y < 7; $y++) { 
                $goal = new Goal();
                $goal->title = $faker->sentence;
                $goal->status = 'ongoing';
                $goal->indicator = $faker->sentence;
                $goal->indicator_goal = $faker->numberBetween(600,1000);
                $goal->indicator_progress = $faker->numberBetween(0,600);
                $goal->indicator_unit = $faker->word;
                $goal->indicator_frequency = $faker->word;
                $goal->source = $faker->sentence;
                $goal->objective()->associate($objective);
                $goal->save();
                for ($z=0; $z < 5; $z++) { 
                    $milestone = new Milestone();
                    $milestone->order = ($z+1);
                    $milestone->title = $faker->sentence;
                    $milestone->goal()->associate($goal);
                    $milestone->save();
                }
            }
            for ($y=0; $y < 3; $y++) { 
                $objective->members()->attach($faker->randomElements($users,2), ['role' => $faker->randomElement(['manager','reporter'])]);
            }
            for ($y=0; $y < 2; $y++) { 
                $objective->subscribers()->attach($faker->randomElements($users,2));
            }
        }
    }
}
