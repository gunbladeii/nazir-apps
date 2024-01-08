<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    // Fillable fields for your model
    protected $fillable = ['user_id', 'structure'];
    // or
    protected $guarded = []; // if you want to allow mass assignment for all fields

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
