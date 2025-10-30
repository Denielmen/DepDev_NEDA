<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TrainingsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $trainings;

    protected $year;

    public function __construct($trainings, $year)
    {
        $this->trainings = $trainings;
        $this->year = $year;
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
            'CY '.$this->year.' Participants',
            'CY '.($this->year + 1).' Participants',
            'CY '.($this->year + 2).' Participants',
            'Provider',
        ];
    }

    public function map($training): array
    {
        // Prepare participant lists for each year in the range
        $participants = [];
        for ($i = 0; $i < 3; $i++) {
            $yr = $this->year + $i;
            $participants[$yr] = collect($training->participants_for_years[$yr] ?? [])->map(function ($participant) {
                return $participant->last_name.', '.$participant->first_name.' '.($participant->mid_init ?? '').'.';
            })->implode(', ');
        }

        return [
            $training->core_competency,
            $training->title,
            $training->competency->name ?? '',
            $participants[$this->year],
            $participants[$this->year + 1],
            $participants[$this->year + 2],
            $training->provider,
        ];
    }
}
