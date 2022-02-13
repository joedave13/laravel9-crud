<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'title', 'content'];

    protected function createdAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => date('j F Y H:i:s', strtotime($value)),
        );
    }
}
