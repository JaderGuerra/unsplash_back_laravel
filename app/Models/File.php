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

    protected function imagePath(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => url($value),
        );
    }

    protected function imagePathThumbnail(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => url($value),
        );
    }
}
