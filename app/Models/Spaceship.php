<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spaceship extends Model
{
    use SoftDeletes;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'class', 'crew', 'image', 'value', 'status'];

    /**
     * Get the armaments for the spaceship.
     */
    public function armaments()
    {
        return $this->hasMany('App\Models\Armament');
    }
}
