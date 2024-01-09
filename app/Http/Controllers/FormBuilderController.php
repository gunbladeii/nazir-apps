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
            'form_data' => 'required', // Ensure this matches your form's input name
        ]);

        // Decode the form data from JSON to associative array
        $formElements = json_decode($validatedData['form_data'], true);

        // Create a new form instance and save it
        $form = new Form; // Assuming you have a Form model
        $form->user_id = auth()->id(); // Assign the user id if you need to associate the form with a user
        $form->structure = $validatedData['form_data']; // Save the raw JSON data
        $form->save();
        // Process each form element and save it to the database
        foreach ($formElements as $element) {
            // Here you would create a new database entry for each form element
            // Make sure you have a database column to store the label
            // Example:
            // $newElement = new FormElementModel(); // Replace with your actual model
            // $newElement->label = $element['label'];
            // $newElement->type = $element['type'];
            // $newElement->name = $element['name'];
            // $newElement->value = $element['value'];
            // $newElement->save();
        }

        // Redirect back or to another page with a success message
        return back()->with('success', 'Form saved successfully!');
    }


    public function storeResponse(Request $request, $formId)
    {
        // You need to validate the request data here
        // ...

        $formResponse = new FormResponse; // Assume you have a FormResponse model
        $formResponse->form_id = $formId; // Make sure you pass the correct formId as a parameter
        $formResponse->data = json_encode($request->all()); // Convert the response data to JSON
        $formResponse->save();

        // Redirect to a page with a success message
        return back()->with('success', 'Response saved successfully!');
    }

    

}
