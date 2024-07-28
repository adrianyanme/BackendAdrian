<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all();
        return response()->json($schedules);
    }

    // Store a new schedule
    public function store(Request $request)
    {
        $user = Auth::user();

        // Cek apakah pengguna adalah superadmin
        if ($user->role != 'superadmin') {
            return response()->json(['message' => 'You do not have permission to create a schedule'], 403);
        }

        $validatedData = $request->validate([
            'hearing_number' => 'required|string|max:255',
            'agenda' => 'required|string|max:255',
            'hearing_time' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $schedule = Schedule::create($validatedData);

        return response()->json($schedule, 201);
    }

    // Show a specific schedule
    public function show($id)
    {
        $schedule = Schedule::findOrFail($id);
        return response()->json($schedule);
    }

    // Update a specific schedule
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'hearing_number' => 'sometimes|required|string|max:255',
            'agenda' => 'sometimes|required|string|max:255',
            'hearing_time' => 'sometimes|required|date_format:Y-m-d H:i:s',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->update($validatedData);

        return response()->json($schedule);
    }

    // Delete a specific schedule
    public function destroy($id)
    {
        $user = Auth::user();

        // Cek apakah pengguna adalah superadmin
        if ($user->role != 'superadmin') {
            return response()->json(['message' => 'You do not have permission to delete this schedule'], 403);
        }

        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return response()->json(null, 204);
    }
}