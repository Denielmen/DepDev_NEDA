<?php
use App\Models\TrainingMaterial;
use Illuminate\Http\Request;

class TrainingMaterialController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // Get the search term from the request

        $trainingMaterials = TrainingMaterial::search($search)->get();

        // Now you can pass $trainingMaterials to your view
        return view('training_materials.index', compact('trainingMaterials', 'search'));
    }

    // ... other controller methods
}
