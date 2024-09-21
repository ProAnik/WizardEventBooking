<?php

namespace App\Http\Controllers;

use App\Models\WizardEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WizardEventController extends Controller
{
    public function create()
    {
        $eventList = WizardEvent::orderBy('created_at', 'desc')->get();
        return view('wizard_event.index', compact('eventList'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:' . WizardEvent::class],
                'date' => ['required', 'date'],
                'total_seats' => ['required', 'numeric', 'min:1']
            ]);

            WizardEvent::create([
                'name' => $request->name,
                'date' => $request->date,
                'total_seats' => $request->total_seats,
                'available_seats' => $request->total_seats,
                'description' => $request->description,
            ]);
            return back()->with('success', "Successfully Event Created!");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function destroy($id) {
        WizardEvent::where('id', $id)->delete();
        return back()->with('success', "Successfully Deleted!");
    }
}
