<?php

namespace App\Http\Controllers;

use App\Models\ScheduledImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImportScheduleController extends Controller
{

    public function index()
    {
        return view('admin.import.index', [
            'imports' => ScheduledImport::all()
        ]);
    }

    public function store(Request $request)
    {
        $attributes = request()->validate([
            'date' => 'required|date',
            'file' => 'required|file',
        ]);

        $attributes['file'] = request()->file('file')->store('files');
        $attributes['user_id'] = auth()->id();

        ScheduledImport::create($attributes);

        return redirect()->back()->with('success', 'Import scheduled successfully');
    }

    public function update(ScheduledImport $import)
    {
        $attributes = request()->validate([
            'date' => 'required|date',
        ]);

        $import->update($attributes);

        return back()->with('success', 'Import schedule updated');
    }

    public function destroy(ScheduledImport $import)
    {
        $import->delete();

        Storage::disk('local')->delete('public/' . $import->file);

        return back()->with('success', 'Import schedule cancelled');
    }

    public function past()
    {
        return view('admin.import.past', [
            'imports' => ScheduledImport::all()
        ]);
    }
}
