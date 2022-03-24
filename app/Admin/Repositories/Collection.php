<?php

namespace App\Admin\Repositories;

use App\Models\Collection as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Collection extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
