<?php

namespace Database\Factories;

use App\Models\WizardEvent;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class WizardEventFactory extends Factory
{
    protected $model = WizardEvent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3), // Random event name
            'description' => $this->faker->paragraph, // Random description
            'date' => Carbon::now()->addDays($this->faker->numberBetween(1, 30)), // Future date
            'total_seats' => $this->faker->numberBetween(50, 200), // Total seats between 50-200
            'available_seats' => $this->faker->numberBetween(10, 50) // Available seats between 10-50
        ];
    }
}
