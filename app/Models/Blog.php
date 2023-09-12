<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blogs';
    protected $primary = 'id';
    public $timestamps= false;
    protected $fillable=[
        'title','slug','summary','content', 'author', 'tag', 'picture', 'video', 'id_category '
    ];
}
