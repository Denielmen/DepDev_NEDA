<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function viewUserInfo($id)
    {
        $training = Training::findOrFail($id);
        return view('adminPanel.viewUserInfo', compact('training'));
    }

    public function viewUserInfoUnprog($id)
    {
        $training = Training::findOrFail($id);
        return view('adminPanel.viewUserInfoUnprog', compact('training'));
    }

    public function reports()
    {
        // Fetch all trainings.
        // It's assumed that your Training model has accessors (e.g., getParticipants2025Attribute)
        // or relationships that provide the 'participants_2025', 'participants_2026', 
        // and 'participants_2027' collections as used in your Blade template.
        // It is also assumed that each Training model has an attribute representing its category.
        $allTrainings = Training::all(); // You might need to use Training::with('relevant_relationship_for_accessors')->get();

        // Group the trainings by category.
        // IMPORTANT: Replace 'category' with the actual attribute name on your Training model
        // that holds the category name (e.g., 'name', 'category_name', 'type', etc.).
        // If your category is determined by a related model (e.g., $training->categoryRelation->name),
        // the grouping logic would be:
        // $trainings = $allTrainings->groupBy(function ($training) {
        //     return $training->categoryRelation->name ?? 'Uncategorized'; // Adjust to your model structure
        // });
        // For a direct attribute on the Training model:
        $trainings = $allTrainings->groupBy('category'); 

        return view('adminPanel.report', compact('trainings'));
    }
} 