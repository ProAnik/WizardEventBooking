<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\WizardEvent;
use Illuminate\Http\Response;

class WizardEventControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_stores_a_wizard_event_successfully()
    {
        // Send a post request to create an event
        $response = $this->post(route('wizard.event.store'), [
            'name' => 'New Event',
            'date' => now()->addDays(5)->toDateString(), // Future date
            'total_seats' => 100,
            'description' => 'This is a new event.',
        ]);

        // Assert a successful redirect with a success message
        $response->assertSessionHas('success', 'Successfully Event Created!');

        // Assert the event was created in the database
        $this->assertDatabaseHas('wizard_events', [
            'name' => 'New Event',
            'total_seats' => 100,
            'available_seats' => 100,
        ]);
    }



    /** @test */
    public function it_lists_wizard_events()
    {
        // Create some events
        WizardEvent::factory()->count(3)->create();

        // Call the create method to retrieve events
        $response = $this->get(route('wizard.event.create'));

        // Assert the response is successful
        $response->assertStatus(Response::HTTP_OK);

        // Assert the view has the event list
        $response->assertViewHas('eventList');
        $this->assertCount(3, $response->viewData('eventList'));
    }

    /** @test */
    public function it_deletes_a_wizard_event_successfully()
    {
        // Create an event
        $wizardEvent = WizardEvent::factory()->create();

        // Send a delete request
        $response = $this->delete(route('wizard.event.destroy', $wizardEvent->id));

        // Assert a successful redirect with a success message
        $response->assertSessionHas('success', 'Successfully Deleted!');

        // Assert the event is deleted from the database
        $this->assertDatabaseMissing('wizard_events', [
            'id' => $wizardEvent->id,
        ]);
    }


}
