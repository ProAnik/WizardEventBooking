<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WizardEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'date',
        'total_seats',
        'available_seats'
    ];
}
