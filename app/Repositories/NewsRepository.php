<?php

namespace App\Repositories;

use App\Models\News;
use App\Repositories\RepositoriesInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class NewsRepository implements RepositoriesInterface
{
    const DEFAULT_PAGE = 0;
    const DEFAULT_PER_PAGE = 10;

    public $total;

    function __construct() {
        $this->total = 0;
    }

    public function list(array $opts):Collection {
        $page = $opts['page'] ?? 0;
        $per_page = $opts['per_page'] ?? 10;
        $orderBy = $opts['order_by'] ?? 'updated_at DESC';

        $news = News::select()
            ->with('rubrics', function($query) {
                return $query->select(['id', 'name']);
            });
        if (!empty($opts['search'])) {
            $news->whereRaw('MATCH (title, announce, content) AGAINST (?)', [$opts['search']]);
        }
        $this->total = $news->count();
        $news->orderByRaw($orderBy)
            ->skip($page * $per_page)
            ->take($per_page);
        return $news->get();
    }

    public function find(int $id): Model {
        return News::where('id', '=', $id)->with('rubrics', function($query) {
            return $query->select(['id', 'name']);
        })->first();
    }
} 