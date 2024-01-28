<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'department'];

    // Define the "created" event to create a corresponding user
   
    // Define the relationship with the User model
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
