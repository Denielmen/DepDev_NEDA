<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserTrainingsUnprogrammedExport implements FromCollection, WithHeadings, WithMapping
{
    protected $trainings;

    public function __construct($trainings)
    {
        $this->trainings = $trainings;
    }

    public function collection()
    {
        return $this->trainings;
    }

    public function headings(): array
    {
        return [
            'Training Title/Subject',
            'Type',
            'Inclusive Dates of Attendance',
            'Number of Hours',
            'Provider/Organizer',
            'User Role',
        ];
    }

    public function map($training): array
    {
        // Format the inclusive dates of attendance
        $dates = '';
        if ($training->implementation_date_from && $training->implementation_date_to) {
            $dates = $training->implementation_date_from->format('m/d/Y') . ' - ' . $training->implementation_date_to->format('m/d/Y');
        } elseif ($training->implementation_date_from) {
            $dates = $training->implementation_date_from->format('m/d/Y') . ' - N/A';
        } elseif ($training->implementation_date_to) {
            $dates = 'N/A - ' . $training->implementation_date_to->format('m/d/Y');
        } else {
            $dates = 'N/A';
        }

        // Get the participation type for the current user
        $currentUser = auth()->user();
        $userRole = 'Resource Speaker';
        
        if ($currentUser) {
            $participant = $training->participants->where('id', $currentUser->id)->first();
            if ($participant && isset($participant->pivot->participation_type_id)) {
                $participationType = \App\Models\ParticipationType::find($participant->pivot->participation_type_id);
                $userRole = $participationType ? $participationType->name : 'Resource Speaker';
            }
        }

        return [
            $training->title,
            $training->core_competency,
            $dates,
            $training->no_of_hours ?? 'N/A',
            $training->provider ?? 'N/A',
            $userRole,
        ];
    }
}
