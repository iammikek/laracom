<?php

namespace App\Shop\Slides;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'photo',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     *
     */
}