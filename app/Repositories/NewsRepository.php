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

        $news = News::select()
            ->with('rubrics', function($query) {
                return $query->select(['id', 'name']);
            })
            ->skip($page * $per_page)
            ->take($per_page);
        if (!empty($opts['search'])) {
            $news
                ->orWhere('announce', 'LIKE', '%' . $opts['search'] . '%')
                ->orWhere('content', 'LIKE', '%' . $opts['search'] . '%')
                ->orWhere('title', 'LIKE', '%' . $opts['search'] . '%');
        }
        $this->total = $news->count();
        return $news->get();
    }

    public function find(int $id): Model {
        return News::find($id);
    }
} 