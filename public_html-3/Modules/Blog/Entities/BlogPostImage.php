<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogPostImage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
}
