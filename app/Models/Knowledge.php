<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Knowledge extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'knowledge';

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
