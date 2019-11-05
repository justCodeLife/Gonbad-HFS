<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Category extends Model
{
    use Searchable;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'description', 'creator_name'
    ];

    protected $hidden = ['creator_name'];

    public function files()
    {
        return $this->hasMany('App\File');
    }

}
