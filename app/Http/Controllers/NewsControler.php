<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Rubrics;
use App\Repositories\NewsRepository;
use Illuminate\Database\Eloquent\Builder;

class NewsControler extends Controller
{

    function index(Request $request) {
        $rubrics = Rubrics::where('rubrics_id', '=', null)->with('children')->get()->keyBy('id');
        return view('index', [
            'rubrics' => $rubrics
        ]);
    }

    function list(Request $request) {
        $rep = new NewsRepository();
        $page = intVal($request->input('p', 0));
        $news = $rep->list([
            'page' => $page,
            'per_page' => 10,
            'search' => urldecode(strval($request->input('search', ''))),
            'with' => 'rubrics',
        ])->toArray();

        return response()->json([
            'total' => $rep->total,
            'range' => [($page * 10), ($page * 10) + 10 - 1],
            'news' => $news
        ]);
    }

    function add(Request $request) {
        $rubrics_ids = $request->input('rubrics_ids', []);
        $rubrics = Rubrics::whereIn('id', $rubrics_ids)->get();
        
        $data = [
            'title' => filter_var($request->input('new-title', ''), 513), // FILTER_SANITIZE_STRING = 513
            'announce' => filter_var($request->input('new-announce', ''), 513),
            'content' => filter_var(nl2br($request->input('new-content', '')), 513)
        ];
        $result = [
            'status' => 'ok',
            'model' => null
        ];

        $model = News::create($data);
        if (!empty($model->id)) {
            foreach ($rubrics as $r) {
                $model->rubrics()->attach($r);
            }
        } else {
            $result['status'] = 'error';
        }
        $result['model'] = $model->toArray();
        $result['model']['rubrics'] = $rubrics->toArray();

        if ($request->ajax()) {
            return response()
                ->json($result, 200, ['X-CSRF-TOKEN' => csrf_token()]);
        } else {
            return view('message', [
                'result' => $result
            ]);
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
