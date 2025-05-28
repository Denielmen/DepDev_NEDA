<?php

namespace App\Exports;

use App\Models\Training;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TrainingsExport implements FromCollection, WithHeadings, WithMapping
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
            'Core Competency',
            'Training Program',
            'Competency',
            'CY 2025 Participants',
            'CY 2026 Participants',
            'CY 2027 Participants',
            'Provider',
        ];
    }

    public function map($training): array
    {
        // Prepare participant lists for each year
        $participants2025 = $training->participants_2025->map(function($participant) {
            return $participant->last_name . ', ' . $participant->first_name . ' ' . $participant->mid_init . '.';
        })->implode(', ');

        $participants2026 = $training->participants_2026->map(function($participant) {
            return $participant->last_name . ', ' . $participant->first_name . ' ' . $participant->mid_init . '.';
        })->implode(', ');

        $participants2027 = $training->participants_2027->map(function($participant) {
            return $participant->last_name . ', ' . $participant->first_name . ' ' . $participant->mid_init . '.';
        })->implode(', ');

        return [
            $training->core_competency,
            $training->title,
            $training->competency->name ?? '',
            $participants2025,
            $participants2026,
            $participants2027,
            $training->provider,
        ];
    }
} 