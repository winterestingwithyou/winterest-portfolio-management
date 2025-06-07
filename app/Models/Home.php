<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    use HasFactory;

    protected $table = 'home';
        
    protected $fillable = [
        'intro_id',
        'intro_en',
        'myself_id',
        'myself_en',
        'image'
    ];
}
