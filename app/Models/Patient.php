<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    //// Eloquent ORM Model Relationships
    /*
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    */

}
