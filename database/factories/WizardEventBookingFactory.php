<?php

namespace Database\Factories;

use App\Models\WizardEventBooking;
use App\Models\User;
use App\Models\WizardEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

class WizardEventBookingFactory extends Factory
{
    protected $model = WizardEventBooking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'wizard_event_id' => WizardEvent::factory(), // Create or associate with an event
            'user_id' => User::factory(), // Create or associate with a user
            'seats_booked' => $this->faker->numberBetween(1, 5), // Random number of seats booked
        ];
    }
}
