<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = "documents";

    protected $fillable = [
        'name',
        'object',
        'entity',
        'active'
    ];

    protected $hidden = [
        'active', 'updated_at', 'id'
    ];

}
