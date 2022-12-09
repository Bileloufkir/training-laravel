<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DatabaseQueryBuilderController extends Controller
{
    /**
     * Show the query results
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $query = $request->get('query');

        $result = [
            'sql' => '',
            'result' => [],
            'title' => ''
        ];

        $q = $request->get('q');
        switch ($q)
        {
            case('generic-query'):
                $result = $this->getGenericQuery();
                break;
        }

        $menu = $this->getMenu();

        $data = (!empty($result['result']))? json_encode($result['result'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '';


        $title = $result['title'];

        $method = isset($result['method'])? $result['method'] : '' ;

        return view('backoffice.database-query.query-builder', compact('menu', 'title','method', 'query','data'));
    }

    /**
     * return the internal navigation menu
     * @return array
     */
    public function getMenu()
    {
        $menu = [
            [
                'title' => 'Generic Query',
                'items' => [
                    [
                        'title' => 'Generic Query',
                        'link' => route('backoffice.database.query.builder', ['q' => 'generic-query'])
                    ],
                ]
            ]
        ];

        return $menu;
    }

    /**
     * Execute a query QueryBuilder against database
     * @return array
     */
    /**
     * Execute a query QueryBuilder against database
     * @return array
     */
    public function getGenericQuery()
    {
        $movies = Movie::all();

        $result = $movies->diff(Movie::where('title','like','%father%')->get());


        return ['title' => 'Collection Eloquent Methods', 'result' => $result];
    }













}
