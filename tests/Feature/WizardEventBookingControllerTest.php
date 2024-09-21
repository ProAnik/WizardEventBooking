<?php

namespace Tests\Feature;

use App\Models\WizardEvent;
use App\Models\WizardEventBooking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WizardEventBookingControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_successfully_books_seats_when_available()
    {
        // Simulate the authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);  // Correctly set the authenticated user

        // Create an event with enough seats
        $wizardEvent = WizardEvent::factory()->create([
            'available_seats' => 10, // Ensure sufficient seats
        ]);

        // Send the post request
        $response = $this->post(route('wizard.event.booking.store'), [
            'wizard_event_id' => $wizardEvent->id,
            'seats_booked' => 2,
        ]);

        // Assert a successful redirect with a success message
        $response->assertSessionHas('success', 'Successfully booking created!');

        // Check if the booking was created in the database
        $this->assertDatabaseHas('wizard_event_bookings', [
            'wizard_event_id' => $wizardEvent->id,
            'user_id' => $user->id,
            'seats_booked' => 2,
        ]);

        // Check if the available seats were updated correctly
        $this->assertDatabaseHas('wizard_events', [
            'id' => $wizardEvent->id,
            'available_seats' => 8, // 10 - 2 = 8
        ]);
    }

    /** @test */
    public function it_fails_booking_when_not_enough_seats()
    {
        // Simulate the authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);  // Ensure the user is set as authenticated

        // Create an event with limited seats
        $wizardEvent = WizardEvent::factory()->create([
            'available_seats' => 5,
        ]);

        // Mock DB transactions
        DB::shouldReceive('beginTransaction')->once();
        DB::shouldReceive('rollBack')->once();
        DB::shouldReceive('commit')->never();

        // Mock locking for update
        DB::shouldReceive('table->where->lockForUpdate->first')
            ->once()
            ->andReturn((object) $wizardEvent->toArray()); // Return the event as an object

        // Send the post request
        $response = $this->post(route('wizard.event.booking.store'), [
            'wizard_event_id' => $wizardEvent->id,
            'seats_booked' => 10,  // Requesting more seats than available
        ]);

        // Assert a redirect with an error message
        $response->assertSessionHas('error', 'Event or Seats not available!');
    }
}
