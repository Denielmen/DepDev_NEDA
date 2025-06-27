<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\TrainingMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingTrackingController extends Controller
{
    public function index()
    {
        // Fetch programmed trainings that are not implemented and where the user is a participant
        $coreCompetencies = [
        'Foundational/Mandatory',
        'Competency Enhancement',
        'Leadership/Executive Development',
        'Gender and Development(GAD)-Related',
        'Others'
    ];
        $competencies = \App\Models\Competency::paginate(10); // <-- Add pagination here
        $userId = Auth::id();
        $programmedTrainings = Training::where('type', 'Program')
            ->where('status', '!=', 'Implemented')
            ->whereHas('participants', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->with(['participants' => function ($query) use ($userId) {
                $query->where('users.id', $userId);
            }])
            ->paginate(10);

        $participationTypes = \App\Models\ParticipationType::all();

        // Fetch and group materials by training_id
        $materials = TrainingMaterial::with(['competency', 'training'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('training_id');

        // Return all data to a single view
        return view('userPanel.tracking', compact(
            'programmedTrainings',
            'competencies',
            'participationTypes',
            'materials',
            'coreCompetencies'
        ));
    }

    public function store(Request $request)
    {
        // 1. Validate request
        $request->validate([
            'uploadMaterials'      => 'nullable',
            'uploadMaterials.*'    => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:51200',
            'uploadCertificates'   => 'nullable',
            'uploadCertificates.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:51200',
            'linkMaterials'        => 'nullable',
            'courseTitle'          => 'required',
            'training_title'       => 'required_if:courseTitle,other',
            'competency_id'        => 'required|exists:competencies,id',
            'participation_type_id' => 'required|exists:participation_types,id',
            'no_of_hours'          => 'required|numeric',
            'expenses'             => 'required|numeric',
            'provider'             => 'required',
            'implementation_date_from' => 'required|date',
            'implementation_date_to'   => 'required|date|after_or_equal:implementation_date_from',
             'core_competency'    => 'required|string|max:255',
        ]);

        // 2. Determine training (programmed or unprogrammed)
        if ($request->input('courseTitle') === 'other') {
            $training = Training::create([
                'title' => $request->input('training_title'),
                'core_competency' => $request->input('core_competency'), // Add this
                'competency_id' => $request->input('competency_id'),
                'provider' => $request->input('provider'),
                'no_of_hours' => $request->input('no_of_hours'),
                'budget' => $request->input('expenses'),
                'type' => 'Unprogrammed',
                'status' => 'Implemented',
                'implementation_date_from' => $request->input('implementation_date_from'),
                'implementation_date_to' => $request->input('implementation_date_to'),
                'user_id' => Auth::id(),
            ]);
            $training->participants()->attach(Auth::id(), [
                'participation_type_id' => $request->input('participation_type_id'),
                'year' => date('Y')
            ]);
        } else {
            $training = Training::find($request->input('courseTitle'));
            if ($training) {
                $training->status = 'Implemented';
                $training->implementation_date_from = $request->input('implementation_date_from');
                $training->core_competency = $request->input('core_competency'); // Add this
                $training->implementation_date_to = $request->input('implementation_date_to');
                $training->save();
                // Attach participant if not already attached
                if (!$training->participants()->where('training_participants.user_id', Auth::id())->exists()) {
                    $training->participants()->attach(Auth::id(), [
                        'participation_type_id' => $request->input('participation_type_id'),
                        'year' => date('Y')
                    ]);
                }
            }
        }

        // 3. Save uploaded materials
        if ($training && $request->hasFile('uploadMaterials')) {
            foreach ($request->file('uploadMaterials') as $file) {
                $filePath = $file->store('uploads', [
                    'disk' => 'public',
                    'visibility' => 'public',
                ]);
                TrainingMaterial::create([
                    'title'         => $training->title,
                    'competency_id' => $training->competency_id,
                    'user_id'       => Auth::id(),
                    'source'        => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                    'file_path'     => $filePath,
                    'link'          => null,
                    'type'          => 'material',
                    'training_id'   => $training->id, // Ensure training_id is set
                ]);
            }
        }

        // 4. Save link material
        if ($training && $request->filled('linkMaterials')) {
            TrainingMaterial::create([
                'title'         => $training->title,
                'competency_id' => $training->competency_id,
                'user_id'       => Auth::id(),
                'source'        => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                'file_path'     => null,
                'link'          => $request->linkMaterials,
                'type'          => 'material',
                'training_id'   => $training->id, // Ensure training_id is set
            ]);
        }

        // 5. Save uploaded certificates
        if ($training && $request->hasFile('uploadCertificates')) {
            foreach ($request->file('uploadCertificates') as $file) {
                $certificatePath = $file->store('certificates', [
                    'disk' => 'public',
                    'visibility' => 'public',
                ]);
                TrainingMaterial::create([
                    'title'         => $training->title . ' Certificate',
                    'competency_id' => $training->competency_id,
                    'user_id'       => Auth::id(),
                    'source'        => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                    'file_path'     => $certificatePath,
                    'link'          => null,
                    'type'          => 'certificate',
                    'training_id'   => $training->id, // Ensure training_id is set
                ]);
            }
        }

        // 6. Redirect to training list
        return redirect()->route('user.training.profile')->with('success', 'Training data, materials, and certificates uploaded successfully!');
    }
}
