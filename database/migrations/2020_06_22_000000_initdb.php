<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

class InitDB extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // admin
            $table->string('description');
            $table->timestamps();
        });
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
        Schema::create('organizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description',550);
            $table->timestamps();
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('icon',100);
            $table->string('color',100);
            $table->timestamps();
        });
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('file_size');
            $table->string('mime_type');
            $table->string('path',550);
            $table->morphs('fileable'); 
            $table->timestamps();
        });
        Schema::create('objectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('author_id')->constrained('users');
            $table->string('title',550);
            $table->text('content');
            $table->json('tags')->nullable();
            $table->boolean('archived')->default(false);
            $table->boolean('hidden')->default(true);
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
        });
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('objective_id')->constrained('objectives')->onDelete('cascade'); // Si el "id" en "objectives" se elimina, se elimina esta entrada
            $table->string('title',550);
            $table->string('status')->nullable();
            $table->string('indicator',550);
            $table->smallInteger('indicator_goal')->default(0);
            $table->smallInteger('indicator_progress')->default(0);
            $table->string('indicator_unit',550);
            $table->string('indicator_frequency',550)->nullable();
            $table->string('source',550)->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
        });
        Schema::create('milestones', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('order')->default(0);
            $table->foreignId('goal_id')->constrained('goals')->onDelete('cascade'); // Si el "id" en "objectives" se elimina, se elimina esta entrada
            $table->string('title',550);
            $table->date('completed')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
        });
        Schema::create('objective_organization', function (Blueprint $table) {
            $table->id();
            $table->foreignId('objective_id')->constrained('objectives');
            $table->foreignId('organization_id')->constrained('organizations');
        });
        Schema::create('objective_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('objective_id')->constrained('objectives')->onDelete('cascade'); // Si el "id" en "objectives" se elimina, se elimina esta entrada
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Si el "id" en "goals" se elimina, se elimina esta entrada
            $table->string('role'); // manager, reporter
            $table->timestamps();
        });
        Schema::create('objective_subscriber', function (Blueprint $table) {
            $table->id();
            $table->foreignId('objective_id')->constrained('objectives')->onDelete('cascade'); // Si el "id" en "objectives" se elimina, se elimina esta entrada
            $table->foreignId('subscriber_id')->constrained('users')->onDelete('cascade'); // Si el "id" en "users" se elimina, se elimina esta entrada
            $table->timestamps();
        });
        Schema::create('objective_file', function (Blueprint $table) {
            $table->id();
            $table->foreignId('objective_id')->constrained('objectives')->onDelete('cascade'); // Si el "id" en "objectives" se elimina, se elimina esta entrada
            $table->foreignId('file_id')->constrained('files')->onDelete('cascade'); // Si el "id" en "files" se elimina, se elimina esta entrada
            $table->string('name');
            $table->string('description');
        });
        Schema::create('objective_picture', function (Blueprint $table) {
            $table->id();
            $table->foreignId('objective_id')->constrained('objectives')->onDelete('cascade'); // Si el "id" en "objectives" se elimina, se elimina esta entrada
            $table->foreignId('file_id')->constrained('files')->onDelete('cascade'); // Si el "id" en "files" se elimina, se elimina esta entrada
        });
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users');
            $table->foreignId('goal_id')->constrained('goals');
            $table->string('type');
            $table->string('title',550);
            $table->text('content');
            $table->datetime('date');
            $table->json('tags')->nullable();
            $table->string('status')->nullable();
            $table->integer('progress')->nullable();
            $table->string('map_url')->nullable();
            $table->foreignId('milestone_achieved')->nullable()->constrained('milestones');
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
        });
        Schema::create('report_file', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->foreignId('file_id')->constrained('files')->onDelete('cascade');
            $table->string('type'); // file, picture
        });
        Schema::create('testimonies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('liked');
            $table->text('comment');
            $table->timestamps();
        });
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users');
            $table->datetime('date');
            $table->string('title',550);
            $table->text('content');
            $table->string('address',550)->nullable();
            $table->json('urls')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
        });
        Schema::create('event_objective', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('objective_id')->constrained('objectives')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('action_logs', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->json('meta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('organizations');
        Schema::dropIfExists('organization_users');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('files');
        Schema::dropIfExists('milestones');
        Schema::dropIfExists('goals');
        Schema::dropIfExists('objectives');
        Schema::dropIfExists('objective_goal');
        Schema::dropIfExists('objective_milestone');
        Schema::dropIfExists('objective_subscriber');
        Schema::dropIfExists('objective_file');
        Schema::dropIfExists('objective_picture');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('report_file');
        Schema::dropIfExists('report_picture');
        Schema::dropIfExists('testimonies');
        Schema::dropIfExists('action_logs');

    }
}
