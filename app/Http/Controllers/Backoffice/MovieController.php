<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class  MovieController extends Controller
{
    /**
     * Show list of movies
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $input = $request->all();

        //store movies list in collection
        $input = ( !isset($input['sort_by']) ) ? array_merge(['sort_by' => 'title','sort_dir' => 'asc'],$input) : $input;
        $movies = $this->getMovies($input);

        // call view 'backoffice.movies.index'
        return view('backoffice.movies.index',
            compact('movies','input'));
    }

    /**
     * Show a movie
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        //get movie  based on $id

        $movie = $this->getMovie($id);

        // call view 'backoffice.movies.show'
        return view('backoffice.movies.show',
            compact('movie'));

    }

    /**
     * Edit a movie
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        //get movie  based on $id

        $movie = $this->getMovie($id);

        // call view 'backoffice.movies.edit
        return view('backoffice.movies.edit',
            compact('movie'));

    }

    /**
     * Update a movie
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    /**
     * Update a movie
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function update($id, Request $request)
    {
        //get movie  based on $id
        $movie = $this->getMovie($id);

        //get data from form
        $input = $request->only([
            'title',
            'year',
            'running_time',
            'synopsis',
            'rating'
        ]);

        //update $movie
        $movie->fill($input);

        //save $movie
        $result = $movie->save();

        // redirect to action edit
        return Redirect::route('backoffice.movies.edit', ['id' => $id]);

    }

    /**
     * Add a movie
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {

        // call view 'backoffice.movies.add'
        return view('backoffice.movies.create');

    }

    /**
     * Store a movie
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function store(Request $request)
    {
        //get data from form
        $input = $request->only([
            'title',
            'year',
            'running_time',
            'synopsis',
            'rating'
        ]);

        //create $movie
        $movie = new Movie();
        $movie->fill($input);

        //save movie
        $result = $movie->save();

        // redirect to action index
        return Redirect::route('backoffice.movies.index', [ 'sort_by' => 'id', 'sort_dir' => 'desc' ]);

    }



    /**
     * Delete a movie
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function delete($id)
    {
        //get movie  based on $id
        $movie = $this->getMovie($id);

        // call view 'backoffice.movies.delete'
        return view('backoffice.movies.delete',
            compact('movie'));

    }

    /**
     * Remove the movie from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get the movie
        $movie = $this->getMovie($id);

        //delete the movie
        $result = $movie->delete();

        //redirect to movies list
        return redirect(route('backoffice.movies.index'));
    }


    /**
     * Get movies
     *
     * @return array
     */
    private function getMovies($params = array())
    {
        $query = Movie::select('id','title','year','running_time','rating','created_at','updated_at');

        //search by id
        if ( isset($params['id']) && !empty($params['id']) )
        {
            $query->where('id','=', $params['id']);

        }

        //search by title
        if ( isset($params['title']) && !empty($params['title']) )
        {
            $query->where('title','like', '%'.$params['title'].'%');

        }

        //search by year
        if ( isset($params['start_year']) && !empty($params['start_year']) )
        {
            $query->where('year','>=', $params['start_year']);

        }
        if ( isset($params['end_year']) && !empty($params['end_year']) )
        {
            $query->where('year','<=', $params['end_year']);

        }

        //search by created_at
        if ( isset($params['start_created_at']) && !empty($params['start_created_at']) )
        {
            $query->where('created_at','>=', $params['start_created_at']);

        }
        if ( isset($params['end_created_at']) && !empty($params['end_created_at']) )
        {
            $query->where('created_at','<=', $params['end_created_at']);

        }

        //search by running_time
        if ( isset($params['start_running_time']) && !empty($params['start_running_time']) )
        {
            $query->where('running_time','>=', $params['start_running_time']);

        }
        if ( isset($params['end_running_time']) && !empty($params['end_running_time']) )
        {
            $query->where('running_time','<=', $params['end_running_time']);

        }

        //search by rating
        if ( isset($params['start_rating']) && !empty($params['start_rating']) )
        {
            $query->where('rating','>=', $params['start_rating']);

        }
        if ( isset($params['end_rating']) && !empty($params['end_rating']) )
        {
            $query->where('rating','<=', $params['end_rating']);

        }

        //search by updated_at
        if ( isset($params['start_updated_at']) && !empty($params['start_updated_at']) )
        {
            $query->where('updated_at','>=', $params['start_updated_at']);

        }
        if ( isset($params['end_updated_at']) && !empty($params['end_updated_at']) )
        {
            $query->where('updated_at','<=', $params['end_updated_at']);

        }

        //sort by
        if (isset($params['sort_by']) && !empty($params['sort_by'])
            && isset($params['sort_dir']) && !empty($params['sort_dir']))
        {
            $sort_by = $params['sort_by'];
            $sort_dir = $params['sort_dir'];
        }

        $query->orderBy($sort_by, $sort_dir);

        $movies = $query->paginate(10)->withQueryString();

        return $movies;
    }

    /**
     * Get movie
     *
     * @param $id
     * @return mixed|null
     */
    private function getMovie($id)
    {
        $movie = Movie::find($id);

        return $movie;
    }


}
