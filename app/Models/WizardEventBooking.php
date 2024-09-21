<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WizardEventBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'wizard_event_id',
        'user_id',
        'seats_booked'
    ];

    public function wizardEvent() {
        return $this->belongsTo(WizardEvent::class);
    }

}
