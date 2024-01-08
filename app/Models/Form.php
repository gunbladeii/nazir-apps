<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    // Fillable fields for your model
    protected $fillable = ['structure'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
