<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form; // Make sure this is the correct path to your Form model

class FormBuilderController extends Controller
{
    // Show the form builder page
    public function index()
    {
        return view('user.formBuilder', compact('data'));
    }

    // Handle form submission
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'structure' => 'required', // Your validation rules
        ]);

        // Create a new form instance and save it to the database
        $form = new Form; // Assuming you have a Form model
        $form->user_id = auth()->id(); // Assign the user id
        $form->structure = json_encode($validatedData['structure']); // Store the form structure
        $form->save();

        // Redirect back or to another page with a success message
        return back()->with('success', 'Form saved successfully!');
    }
}
