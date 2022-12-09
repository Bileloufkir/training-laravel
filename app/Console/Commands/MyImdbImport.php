<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MyImdbImport extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'myimdb:import
                            {--purge : purge database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Files To Database MyImdb';


    /**
     * @var string
     */
    private $csvPath;
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
        $purge = $this->option('purge');

        $this->purgeTables();

        if (!$purge) {


            //process genres
            DB::beginTransaction();

            $results = [];
            $results[] = $this->processGenres();
            $results[] = $this->processMovies();


            $status = true;

            foreach ($results as $result) {
                if (!$result['status']) {
                    $status = $result['status'];
                    $this->error(json_encode($result));
                    break;
                }
            }
            if ($status) {
                DB::commit();
            } else {
                $this->info('The command was failed!');
                DB::rollBack();
            }
        }

        $this->info('The command was successful!');

    }

    public function getDataFromFile($filename)
    {
        $filename = storage_path('csv/myimdb/'.$filename);

        $csvFile = file($filename);
        $rows = [];

        foreach ($csvFile as $line) {
            $rows[] = str_getcsv($line,"|");
        }

        return $rows;
    }

    public function getDate($date)
    {
        if (!empty($date))
        {
            $date = \DateTime::createFromFormat('F j, Y',$date);
            $date = $date->format('Y-m-d');
        }

        return $date;
    }

    public function valToNull($value)
    {
        return !empty($value)? $value :  null;
    }

    public function purgeTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $tables = ['movies_genres','trailers','release_dates','genres','movies'];
        foreach ($tables as $table)
        {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }

    public function processGenres()
    {
        $rows = $this->getDataFromFile('genres.csv');

        $result =  ['status' => true,'error' => null];

        foreach ($rows as $index => $row)
        {
            //skip first line that contains field names
            if ($index === 0)
            {
                continue;
            }
            if (!empty($row[0]) && !empty($row[1]))
            {
                try {
                    $name = trim($row[0]);
                    $description = trim($row[1]);
                    $created_at = new \DateTime();
                    $created_at = $created_at->format('Y-m-d H:i:s');

                    $id = DB::table('genres')->insertGetId(
                        ['name' => $name, 'description' => $description, 'created_at' => $created_at]
                    );

                }
                catch (\Exception $e)
                {
                    $result =  ['status' => false,'error' => $e->getMessage()];
                    break;
                }
            }


        }


        return $result;
    }

    public function processMovies()
    {
        //fields
        //title    year   running_time   genres rating tmdb_synopsis  directors  actors tmdb_link  enable_import
        $rows = $this->getDataFromFile('movies.csv');

        $result =  ['status' => true,'error' => null];

        foreach ($rows as $index => $row)
        {
            //skip first line that contains field names
            if ($index === 0)
            {
                continue;
            }
            if (!empty($row))
            {
                try {

                    $title = trim($row[0]);
                    $year = trim($row[1]);
                    $running_time = trim($row[2]);
                    $genres = trim($row[3]);
                    $rating = trim(str_replace(',','.',$row[4]));
                    $synopsis = $this->valToNull(trim($row[5]));
                    $directors = trim($row[6]);
                    $actors = trim($row[7]);
                    $trailer['link'] = trim($row[8]);
                    $trailer['running_time'] = trim($row[9]);
                    $release_dates = trim($row[10]);

                    $enable_import = (trim($row[11]) == 1)? true : false;


                    $created_at = new \DateTime();
                    $created_at = $created_at->format('Y-m-d H:i:s');


                    if ($enable_import)
                    {
                        $data = [
                            'title' => $title,
                            'year' => $year,
                            'running_time' => $running_time,
                            'rating' => $rating,
                            'synopsis' => $synopsis,
                            'created_at' => $created_at
                        ];

                        $id = DB::table('movies')->insertGetId($data);

                        //process movie trailer
                        $this->processMovieTrailer($id, $trailer);

                        //process movie trailer
                        $this->processMovieReleaseDates($id, $release_dates);

                        //process movies genres
                        $this->processMoviesGenres($id, $genres);

                    }

                }
                catch (\Exception $e)
                {
                    $result =  ['status' => false,'error' => $e->getMessage(), 'row' => $row];
                    break;
                }
            }


        }


        return $result;
    }

    public function processMovieTrailer($id, $trailer = array())
    {
        $link = $trailer['link'];
        $running_time = $trailer['running_time'];


        $data = [];

        $created_at = new \Datetime();
        $created_at = $created_at->format('Y-m-d');

        if (!empty($link) && !empty($running_time))
        {
            $data = [
                'movie_id' => $id,
                'link' => $link,
                'running_time' => $running_time,
                'created_at' => $created_at,
            ];
        }

        //insert movie trailer

        DB::table('trailers')->insert($data);
    }

    public function processMovieReleaseDates($id, $release_dates)
    {
        if (empty($release_dates))
            return;

        $data = [];

        $created_at = new \Datetime();
        $created_at = $created_at->format('Y-m-d');


        $release_dates = explode(',',$release_dates);
        $tmp = [];
        foreach ($release_dates as $release_date)
        {
            $release_date = explode(':',$release_date);
            $tmp['release_date'] = trim($release_date[0]);
            $tmp['country'] = trim($release_date[1]);
            $tmp['movie_id'] = $id;
            $tmp['created_at'] = $created_at;
            $data[] = $tmp;
        }




        if (!empty($data))
        {
            //insert movie release_dates
            DB::table('release_dates')->insert($data);
        }

    }

    public function processMoviesGenres($movie_id, $genres)
    {
        $genres = explode(',',$genres);

        $a_tmp = [];
        foreach ($genres as $genre)
        {
            $a_tmp[] = trim($genre);
        }

        $genres = $a_tmp;

        $result = DB::table('genres')
            ->whereIn('name', $genres)
            ->get();

        $genre_ids = $result->pluck('id')->toArray();

        $data = [];

        $created_at = new \Datetime();
        $created_at = $created_at->format('Y-m-d');

        $i=0;
        foreach ($genre_ids as $genre_id)
        {
            $main = false;

            if ( $i == 0 )
            {
                $main = true;
            }

            $data[] = [ 'movie_id' => $movie_id, 'genre_id' => $genre_id, 'main' => $main, 'created_at' => $created_at];

            $i++;
        }

        //insert movie genres

        DB::table('movies_genres')->insert($data);

    }

}
