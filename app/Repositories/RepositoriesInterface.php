<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoriesInterface {
    /**
     * @param array $opts
     * @return Collection
     */
    public function list(array $opts): Collection;

    /**
     * @param int $id
     * @return Model
     */
    public function find(int $id): Model;
}