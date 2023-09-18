<?php

namespace App\Http\Controllers;

use App\Models\ScheduledExport;
use Illuminate\Http\Request;

class ExportScheduleController extends Controller
{
    public function index()
    {
        return view('admin.export.index', [
            'exports' => ScheduledExport::all()
        ]);
    }


    public function store(Request $request)
    {
        // $attributes = request()->validate([
        //     'date' => 'required|date',
        // ]);

        // ScheduledExport::create($attributes);


        $rules = [
            'date' => 'required|date',
            'categories' => 'array',
        ];

        $request->validate($rules);

        // Create a new instance of your model
        $export = new ScheduledExport();
        
        // Assign values from the form to the model attributes
        $export->date = $request->input('date');
        $export->categories = json_encode($request->input('categories')); // Store categories as JSON
        
        // Save the model to the database
        $export->save();

        return redirect()->back()->with('success', 'Export scheduled successfully');
    }

    public function update(ScheduledExport $export)
    {
        $attributes = request()->validate([
            'date' => 'required|date',
        ]);

        $export->update($attributes);

        return back()->with('success', 'Export schedule updated');
    }

    public function destroy(ScheduledExport $export)
    {
        $export->delete();

        return back()->with('success', 'Ecport schedule cancelled');
    }

    public function past()
    {
        return view('admin.export.past', [
            'exports' => ScheduledExport::all()
        ]);
    }
}
