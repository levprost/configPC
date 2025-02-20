<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Configuration extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_config',
        'title_config',
        'subtitle_config',
        'description_config',
        'explication_config',
        'image_config',
        'benchmark_config',
        'user_id'
    ];

    public function users()
    {
        return $this->hasMany(UserConfiguration::class);
    }
    public function components()
    {
        return $this->hasMany(Component::class);
    }
}
