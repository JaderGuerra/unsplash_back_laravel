<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'image_path',
        'image_path_thumbnail',
    ];

    protected $hidden = [
        'image_path',
        'image_path_thumbnail',
    ];

    protected $appends = [
        'url',
        'thumbnail'
    ];

    protected function url(): Attribute
    {
        return new Attribute(
            get: fn () => url($this->image_path),
        );
    }

    protected function thumbnail(): Attribute
    {
        return new Attribute(
            get: fn () => url($this->image_path_thumbnail),
        );
    }
}
