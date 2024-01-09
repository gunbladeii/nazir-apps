<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form; // Make sure this is the correct path to your Form model
use App\Models\FormElementModel;
class FormBuilderController extends Controller
{
    // Show the form builder page
    public function index()
    {
        return view('user.formBuilder', compact('data'));
    }

    public function formId()
    {
        $formId = "/";// Make sure you have a Role model and it's imported at the top of your controller
        return view('user.formBuilder', compact('formId'));
    }

    // Handle form submission
    // Handle form submission
    public function store(Request $request, $formId = null)
    {
        $formElements = json_decode($request->input('form_data'), true);
        
        if ($formId) {
            // Fetch the existing Form model or handle it if it doesn't exist
            $form = Form::find($formId);
            if (!$form) {
                // Handle the case where the form doesn't exist
                return back()->withErrors('Invalid form ID.');
            }
            // Presumably update the form structure here
            $form->structure = json_encode($formElements);
        } else {
            // If creating a new form, instantiate a new Form model
            $form = new Form([
                'user_id' => auth()->id(),
                'structure' => json_encode($formElements), // Make sure to provide the structure
            ]);
        }
        
        $form->save();
        // ... rest of your code for handling form elements

        return back()->with('success', 'Form saved successfully!');
    }



    // Handle form submission for updating existing forms
    public function update(Request $request, $formId)
    {
        // The rest of your code here, making sure to use $formId to update the correct form.
        return view('user.formBuilder', compact('formId'));
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
