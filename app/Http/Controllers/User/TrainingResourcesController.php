<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\TrainingMaterial;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TrainingResourcesController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all'); // materials | links | certificates | all

        // Load trainings with related materials (adjust relation name if different)
        $trainings = Training::with(['materials' => function($q) {
            $q->orderBy('created_at','desc');
        }])->orderBy('title')->get();

        // Prepare list for view: each item => ['training' => Training, 'materials' => Collection]
        $list = $trainings->map(function($t) {
            return [
                'training' => $t,
                'materials' => $t->materials ?? collect(),
            ];
        });

        return view('userPanel.trainingResources', [
            'trainings' => $list,
            'filter' => $filter,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'training_id' => ['required','exists:trainings,id'],
            'type' => ['required', Rule::in(['material','link','certificate'])],
            'title' => ['required','string','max:255'],
            'link' => ['nullable','url'],
            'file' => ['nullable','file','mimes:pdf,doc,docx,ppt,pptx,zip'],
        ]);

        if(in_array($data['type'], ['material','certificate'])) {
            if(!$request->hasFile('file')) {
                return back()->withErrors(['file' => 'File required for material or certificate.']);
            }
            $file = $request->file('file');
            $path = $file->store('training_materials', 'public');
            $material = TrainingMaterial::create([
                'training_id' => $data['training_id'],
                'title' => $data['title'],
                'type' => $data['type'],
                'file_path' => $path,
                'link' => null,
            ]);
        } else { // link
            $material = TrainingMaterial::create([
                'training_id' => $data['training_id'],
                'title' => $data['title'],
                'type' => 'link',
                'link' => $data['link'] ?? null,
                'file_path' => null,
            ]);
        }

        return back()->with('success', 'Resource added.');
    }

    public function download(TrainingMaterial $material)
    {
        if(!$material->file_path || !Storage::disk('public')->exists($material->file_path)) {
            abort(404);
        }
        return Storage::disk('public')->download($material->file_path, $material->title ?? 'download');
    }
}