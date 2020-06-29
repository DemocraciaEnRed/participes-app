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
        $category->color = '#000000';
        $category->save();
        $category = new Category();
        $category->title = 'Seguridad';
        $category->icon = 'fas fa-shield';
        $category->color = '#000000';
        $category->save();
        $category = new Category();
        $category->title = 'Ecologia';
        $category->icon = 'fas fa-tree';
        $category->color = '#000000';
        $category->save();
        $category = new Category();
        $category->title = 'Economia comunitaria';
        $category->icon = 'fas fa-group';
        $category->color = '#000000';
        $category->save();
    }
}
