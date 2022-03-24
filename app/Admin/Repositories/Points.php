<?php

namespace App\Admin\Repositories;

use App\Models\Points as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Points extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
