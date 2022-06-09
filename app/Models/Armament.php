<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Armament extends Model
{
    use SoftDeletes;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['spaceship_id', 'title', 'qty'];

    /**
     * Get the spaceship that owns the armament.
     */
    public function spaceship()
    {
        return $this->belongsTo('App\Models\Spaceship');
    }
}
