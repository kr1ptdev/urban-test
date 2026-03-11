<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class DomObject extends Model
{
    protected $table = 'dom_objects';

    protected $fillable = [
        'dom_id',
        'name',
    ];

    protected $casts = [
        'dom_id' => 'integer',
        'name' => 'string',
    ];

    public $timestamps = true;
}
