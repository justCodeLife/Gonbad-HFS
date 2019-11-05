<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class File extends Model
{
    use Searchable;

    protected $table = 'files';
    protected $primaryKey = 'id';

    protected $fillable = [
        'file_name', 'file_type', 'file_description', 'file_size', 'file_image', 'file_url', 'uploader_name', 'visibility', 'category_id'
    ];

    protected $hidden = ['file_size', 'file_image', 'file_url', 'uploader_name'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

}
