<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = "authors";

    protected $fillable = [
        'name',
        'surname',
        'middlename',
        'country',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
