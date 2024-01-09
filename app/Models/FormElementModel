<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormElementModel extends Model
{
    protected $table = 'form_elements'; // The name of the table in the database

    protected $fillable = ['user_id', 'form_id', 'label', 'type', 'name', 'value']; // Allow mass assignment on these columns

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
