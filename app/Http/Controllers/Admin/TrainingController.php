<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\Competency;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index()
    {
        $competencies = Competency::all();
        $trainings = Training::where('type', 'Program')->get();
        return view('adminPanel.trainingPlan', compact('trainings', 'competencies'));
    }

    public function unprogrammed()
    {
        $trainings = Training::where('type', 'Unprogrammed')->get();
        return view('adminPanel.trainingPlanUnProg', compact('trainings'));
    }

    public function create()
    {
        $competencies = Competency::all();
        return view('adminPanel.trainingPlanCreate', compact('competencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'competency_id' => 'required',
            'competency_input' => 'required_if:competency_id,others|nullable|string|max:255',
            'core_competency' => 'required|string|in:Foundational/Mandatory,Competency Enhancement,Leadership/Executive Development,Gender and Development (GAD)-Related,Others',
            'period_from' => 'required|integer|digits:4',
            'period_to' => 'required|integer|digits:4|gte:period_from',
            'implementation_date_from' => 'required|date',
            'implementation_date_to' => 'required|date',
            'budget' => 'nullable|numeric',
            'no_of_hours' => 'nullable|integer',
            'superior' => 'nullable|string|max:255',
            'provider' => 'nullable|string|max:255',
            'dev_target' => 'nullable|string',
            'performance_goal' => 'nullable|string',
            'objective' => 'nullable|string',
            'type' => 'required|in:Program,Unprogrammed',
            'participants' => 'required|array|min:1',
            'participants.*' => 'exists:users,id',
            'participation_types' => 'required|array',
            'participation_types.*' => 'exists:participation_types,id'
        ]);

        // Handle custom competency
        if ($request->competency_id === 'others') {
            // Check if competency already exists
            $existingCompetency = Competency::where('name', $request->competency_input)->first();

            if ($existingCompetency) {
                $competencyId = $existingCompetency->id;
            } else {
                // Create new competency
                $newCompetency = Competency::create([
                    'name' => $request->competency_input,
                    'description' => 'Custom competency created by user'
                ]);
                $competencyId = $newCompetency->id;
            }
        } else {
            $competencyId = $request->competency_id;
        }

        // Prepare training data with the correct competency_id
        $trainingData = $request->all();
        $trainingData['competency_id'] = $competencyId;

        $training = Training::create($trainingData);

        // Attach participants with their participation types
        foreach ($request->participants as $participantId) {
            $participationTypeId = $request->participation_types[$participantId] ?? null;
            if ($participationTypeId) {
                $training->participants()->attach($participantId, [
                    'participation_type_id' => $participationTypeId
                ]);
            }
        }

        return redirect()->route('admin.training-plan')
            ->with('success', 'Training created successfully.');
    }

    public function edit(Training $training)
    {
        return view('adminPanel.trainingPlanEdit', compact('training'));
    }

    public function update(Request $request, Training $training)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'competency' => 'required|string|max:255',
            'implementation_date_from' => 'required|date',
            'implementation_date_to' => 'required|date',
            'provider' => 'nullable|string|max:255',
            'type' => 'required|in:Program,Unprogrammed',
        ]);

        $training->update($request->all());

        return redirect()->route('admin.training-plan')
            ->with('success', 'Training updated successfully.');
    }

    public function destroy(Training $training)
    {
        $training->delete();
        return redirect()->route('admin.training-plan')
            ->with('success', 'Training deleted successfully.');
    }

    public function searchTrainings(Request $request)
    {
        $query = $request->input('query');
        $includeMaterials = $request->has('include_materials');
        
        // Base query for searching trainings
        $trainings = Training::where('title', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->with(['materials' => function($q) use ($includeMaterials) {
                if ($includeMaterials) {
                    $q->where('type', 'material');
                }
            }])
            ->get();
            
        return view('adminPanel.searchResults', [
            'trainings' => $trainings,
            'searchQuery' => $query,
            'includeMaterials' => $includeMaterials
        ]);
    }
    
    public function resources(Request $request)
    {
        $tab = $request->input('tab', 'materials');
        
        // Base query for trainings with materials/links/certificates
        $query = Training::query();
        
        // Filter based on the active tab
        $query->whereHas('materials', function($q) use ($tab) {
            if ($tab === 'materials') {
                $q->where('type', 'material')->whereNotNull('file_path');
            } elseif ($tab === 'links') {
                $q->where('type', 'material')->whereNotNull('link');
            } else { // certificates
                $q->where('type', 'certificate');
            }
        });

        // Apply search filter if present
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhereHas('materials', function($q) use ($search) {
                      $q->where('title', 'like', "%$search%")
                        ->orWhere('source', 'like', "%$search%");
                  });
            });
        }

        // Apply sorting
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'desc');
        $query->orderBy($sort, $order);

        // Get paginated trainings
        $trainings = $query->paginate(10);

        // Load only the needed relationships based on the active tab
        $trainings->load(['materials' => function($q) use ($tab) {
            if ($tab === 'materials') {
                $q->where('type', 'material')->whereNotNull('file_path');
            } elseif ($tab === 'links') {
                $q->where('type', 'material')->whereNotNull('link');
            } else { // certificates
                $q->where('type', 'certificate');
            }
        }]);

        // Prepare the data for the view with proper filtering
        $groupedTrainings = [];
        foreach ($trainings as $training) {
            $materials = $training->materials->filter(function($item) use ($tab) {
                return $tab === 'materials' && $item->type === 'material' && $item->file_path;
            });
            
            $links = $training->materials->filter(function($item) use ($tab) {
                return $tab === 'links' && $item->type === 'material' && $item->link;
            });
            
            $certificates = $training->materials->filter(function($item) use ($tab) {
                return $tab === 'certificates' && $item->type === 'certificate';
            });
            
            // Only add to results if there are items for the current tab
            if (($tab === 'materials' && $materials->isNotEmpty()) ||
                ($tab === 'links' && $links->isNotEmpty()) ||
                ($tab === 'certificates' && $certificates->isNotEmpty())) {
                $groupedTrainings[] = [
                    'training' => $training,
                    'materials' => $materials,
                    'links' => $links,
                    'certificates' => $certificates
                ];
            }
        }

        // Apply sorting
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'desc');
        
        usort($groupedTrainings, function($a, $b) use ($sort, $order) {
            $valueA = $sort === 'title' ? $a['training']->title : $a['training']->created_at;
            $valueB = $sort === 'title' ? $b['training']->title : $b['training']->created_at;
            
            if ($order === 'asc') {
                return $valueA <=> $valueB;
            } else {
                return $valueB <=> $valueA;
            }
        });

        // Paginate the results
        $page = $request->input('page', 1);
        $perPage = 10;
        $currentPageItems = array_slice($groupedTrainings, ($page - 1) * $perPage, $perPage);
        $paginatedTrainings = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            count($groupedTrainings),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('adminPanel.trainingResources', [
            'trainings' => $paginatedTrainings,
            'tab' => $tab
        ]);
    }
}
