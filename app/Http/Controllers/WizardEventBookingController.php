<?php

namespace App\Http\Controllers;

use App\Models\WizardEvent;
use App\Models\WizardEventBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WizardEventBookingController extends Controller
{
    public function create() {
        $eventList = WizardEvent::orderBy('created_at', 'desc')->whereDate('date', '>=' , today())->get();
        $bookingList = WizardEventBooking::orderBy('created_at', 'desc')->get();
        return view('wizard_event.booking',compact('bookingList' ,'eventList'));
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'wizard_event_id' => ['required'],
                'seats_booked' => ['required', 'numeric', 'min:1']
            ]);

            DB::beginTransaction();

            $wizardEvent = WizardEvent::find($request->wizard_event_id);

            if(!$wizardEvent || $wizardEvent->available_seats < $request->seats_booked) {
                DB::rollBack();
                return back()->with('error', "Event or Seats not available!");
            }

            WizardEventBooking::create([
               'wizard_event_id' => $request->wizard_event_id,
               'user_id' => Auth::user()->id,
               'seats_booked' => $request->seats_booked
            ]);
            $wizardEvent->available_seats = $wizardEvent->available_seats - $request->seats_booked;
            $wizardEvent->update();
            DB::commit();
            return back()->with('success', "Successfully booking created!");

        }
        catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
