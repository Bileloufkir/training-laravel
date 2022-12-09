<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MyImdbCreateSchema extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'myimdb:create:schema
                            {--drop : drop database tables}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create MyImdb Database Schema';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $drop = $this->option('drop');

        //drop database schema if exists
        $this->dropSchema();

        if ($drop)
        {
            $this->info('Database schema myimdb droped with success!');
            return;
        }

        //create table movies
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->smallInteger('year');
            $table->text('synopsis')->nullable();
            $table->smallInteger('running_time');
            $table->decimal('rating',3,1);
            $table->timestamps();

            $table->unique(['title','year'],'idx_01');
        });

        //create table genres
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique('idx_01');
            $table->string('description',5000)->nullable();
            $table->timestamps();

        });

        //create table trailers
        Schema::create('trailers', function (Blueprint $table) {
            $table->id();
            $table->string('link');
            $table->smallInteger('running_time');
            $table->unsignedBigInteger('movie_id')->unique('idx_01');
            $table->timestamps();
        });

        //create table release_dates
        Schema::create('release_dates', function (Blueprint $table) {
            $table->id();
            $table->date('release_date');
            $table->string('country');
            $table->unsignedBigInteger('movie_id');
            $table->timestamps();
        });

        //create table movies_genres
        Schema::create('movies_genres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id');
            $table->unsignedBigInteger('genre_id');
            $table->boolean('main')->default(false);
            $table->timestamps();
        });

        //relations movie trailer
        Schema::table('trailers', function (Blueprint $table) {
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
        });

        //relations movie trailer
        Schema::table('release_dates', function (Blueprint $table) {
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
        });

        //relations movies_genres
        Schema::table('movies_genres', function (Blueprint $table) {
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');

            $table->unique(['movie_id','genre_id']);
        });

        $this->info('Database schema myimdb created with success!');

        return 0;
    }

    public function dropSchema()
    {
        Schema::dropIfExists('movies_genres');
        Schema::dropIfExists('genres');
        Schema::dropIfExists('trailers');
        Schema::dropIfExists('release_dates');
        Schema::dropIfExists('movies');
    }
}
