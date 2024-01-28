<?php

namespace App\Models;
use \App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['title', 'organizer', 'start_time', 'end_time'];

    // Define the relationship with employees for participants
    public function participants()
    {
        return $this->belongsToMany(Employee::class, 'booking_participants');
    }
}
