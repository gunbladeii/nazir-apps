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
    public function store(Request $request, $formId) // Assume $formId is passed as a parameter
    {
        $formElements = json_decode($request->input('form_data'), true);
        
        foreach ($formElements as $element) {
            $newElement = new FormElementModel([
                'user_id' => auth()->id(), // Get the authenticated user's ID
                'form_id' => $formId, // Use the passed form ID
                'label'   => $element['label'],
                'type'    => $element['type'],
                'name'    => $element['name'],
                'value'   => is_array($element['value']) ? json_encode($element['value']) : $element['value'],
            ]);
            
            $newElement->save();
        }

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
