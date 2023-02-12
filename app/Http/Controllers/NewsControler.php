<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Repositories\NewsRepository;
use Illuminate\Database\Eloquent\Builder;

class NewsControler extends Controller
{
    function index() {

    }

    function list(Request $request) {
        // $page = intVal($request->input('p', 0));
        // $total = News::all()->count();
        // $news = News::select()
        //     ->with('rubrics', function($query) {
        //         return $query->select(['id', 'name']);
        //     })
        //     ->orderByRaw('updated_at DESC')
        //     ->skip($page * 10)
        //     ->take(10)
        //     ->get()
        //     ->toArray();
        $rep = new NewsRepository();
        $page = intVal($request->input('p', 0));
        $news = $rep->list([
            'page' => $page,
            'per_page' => 10,
            'search' => urldecode(strval($request->input('search', '')))
        ])->toArray();
        return response()->json([
            'total' => $rep->total,
            'range' => [($page * 10), ($page * 10) + 10 - 1],
            'news' => $news
        ]);
    }

    function add(Request $request) {
        $title = $request->input('new-title');
        if ($request->ajax()) {
            return response()->json([

            ]);
        } else {
            return redirect('/');
        }
    }

    function view(Request $request, string $id) {
        $rep = new NewsRepository();
        $model = $rep->find(intval($id));
        return view('news-detail', [
            'model' => $model
        ]);
    }
}
