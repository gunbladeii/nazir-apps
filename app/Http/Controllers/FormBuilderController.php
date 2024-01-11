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

    public function store(Request $request, $formId = null)
    {
        $formElements = json_decode($request->input('form_data'), true);
        
        // Check if we are editing an existing form
        if ($formId) {
            // Fetch the existing Form model or handle it if it doesn't exist
            $form = Form::find($formId);
            if (!$form) {
                // Handle the case where the form doesn't exist
                return back()->withErrors('Invalid form ID.');
            }
        } else {
            // If creating a new form, instantiate a new Form model
            $form = new Form();
            $form->user_id = auth()->id(); // Set the user_id to the current authenticated user's ID
            $form->structure = json_encode($formElements);
            $form->save(); // Save the new form to get an ID

            // Update the $formId with the ID of the new form
            $formId = $form->id;
        }

        // Now continue to save form elements associated with $formId...
        foreach ($formElements as $element) {
            $newElement = new FormElementModel(); // Use your actual form element model
            $newElement->form_id = $formId; // Set the form_id to associate with the form
            $newElement->user_id = auth()->id();
            $newElement->label = $element['label'];
            $newElement->type = $element['type'];
            $newElement->name = $element['name'];
            // If the element is a checkbox, store its value as a JSON string
            $newElement->value = is_array($element['value']) ? json_encode($element['value']) : $element['value'];
            $newElement->save();
        }

        return back()->with('success', 'Borang telah disimpan');
    }




    // Handle form submission for updating existing forms
    public function update(Request $request, $formId)
    {
        // Validate the request...

        $form = Form::findOrFail($formId);
        $formElements = json_decode($request->input('form_data'), true);

        if ($formElements) {
            foreach ($formElements as $element) {
                $newElement = new FormElementModel(); // Use your actual form element model
                $newElement->form_id = $formId; // Set the form_id to associate with the form
                $newElement->user_id = auth()->id();
                $newElement->label = $element['label'];
                $newElement->type = $element['type'];
                $newElement->name = $element['name'];
                $formElement = FormElement::where('form_id', $formId)
                                        ->where('name', $element['name'])
                                        ->first();
                
                if ($formElement) {
                    // Update the existing form element
                    $formElement->value = is_array($element['value']) ? json_encode($element['value']) : $element['value'];
                    $formElement->save();
                } else {
                    // Handle cases where the form element does not exist, if necessary
                }
            }
        } else {
            return back()->with('failure', 'Sila isi medan yang kosong');
        }

        // Redirect back with a success message
        return back()->with('success', 'Borang telah dikemaskini');
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
