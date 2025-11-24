<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserTrainingsExport implements FromCollection, WithHeadings, WithMapping
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
            'Period of Implementation',
            'Provider/Organizer',
            'Status',
            'User Role',
        ];
    }

    public function map($training): array
    {
        // Format the period of implementation - try both field names
        $periodFrom = '';
        $periodTo = '';
        
        if ($training->implementation_date_from) {
            $periodFrom = is_string($training->implementation_date_from) 
                ? substr($training->implementation_date_from, 0, 4)
                : (is_int($training->implementation_date_from) ? $training->implementation_date_from : $training->implementation_date_from->format('Y'));
        } elseif ($training->period_from) {
            $periodFrom = is_int($training->period_from)
                ? $training->period_from
                : (is_string($training->period_from) ? substr($training->period_from, 0, 4) : $training->period_from->format('Y'));
        }
        
        if ($training->implementation_date_to) {
            $periodTo = is_string($training->implementation_date_to)
                ? substr($training->implementation_date_to, 0, 4)
                : (is_int($training->implementation_date_to) ? $training->implementation_date_to : $training->implementation_date_to->format('Y'));
        } elseif ($training->period_to) {
            $periodTo = is_int($training->period_to)
                ? $training->period_to
                : (is_string($training->period_to) ? substr($training->period_to, 0, 4) : $training->period_to->format('Y'));
        }
        
        $period = ($periodFrom && $periodTo) ? "{$periodFrom} - {$periodTo}" : '';

        // Get the participation type for the current user
        $participationType = $training->getParticipantType(auth()->id());
        $userRole = $participationType ? $participationType->name : 'Participant';

        return [
            $training->title,
            $training->core_competency,
            $period,
            $training->provider,
            $training->status,
            $userRole,
        ];
    }
}
