<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->title = 'Educacion';
        $category->icon = 'fas fa-book';
        $category->color = '#602282';
        $category->save();
        $category = new Category();
        $category->title = 'Seguridad';
        $category->icon = 'fas fa-shield-alt';
        $category->color = '#30689c';
        $category->save();
        $category = new Category();
        $category->title = 'Ecologia';
        $category->icon = 'fas fa-tree';
        $category->color = '#32a852';
        $category->save();
        $category = new Category();
        $category->title = 'Economia comunitaria';
        $category->icon = 'fas fa-wallet';
        $category->color = '#b52260';
        $category->save();
        $category = new Category();
        $category->title = 'Musica';
        $category->icon = 'fas fa-music';
        $category->color = '#ba8e14';
        $category->save();
    }
}
