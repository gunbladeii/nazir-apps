<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form; // Make sure this is the correct path to your Form model

class FormBuilderController extends Controller
{
    // Show the form builder page
    public function index()
    {
        $user = auth()->user(); // Get the currently authenticated user
        $userForms = $user->forms; // Get all forms associated with the user

        return view('user.formBuilder', compact('userForms')); // Pass the forms to your view
    }

    // Handle form submission
    public function store(Request $request)
    {
        // Validate the request as needed
        $request->validate([
            // Validation rules for your form data
            'structure' => 'required|json', // Assuming 'structure' is a JSON string
        ]);

        // Create the form structure
        $form = new Form; // Make sure this references your actual Form model
        $form->structure = $request->input('structure'); // No need to json_encode, as it's already a JSON string from the input
        $form->user_id = auth()->id(); // Set the user_id to the currently authenticated user's id
        $form->save();

        return back()->with('success', 'Form saved successfully!');
    }
}
