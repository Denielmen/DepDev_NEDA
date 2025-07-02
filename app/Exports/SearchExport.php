<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SearchExport implements FromCollection, WithHeadings, WithMapping
{
    protected $results;

    public function __construct($results)
    {
        $this->results = $results;
    }

    public function collection()
    {
        return $this->results;
    }

    public function headings(): array
    {
        return [
            'Type',
            'Title/Name',
            'Competency/Position',
            'Participants/Division',
        ];
    }

    public function map($result): array
    {
        $details = '';
        $relatedInfo = '';

        switch ($result->search_type) {
            case 'training':
                $details = $result->competency->name ?? 'N/A';
                $relatedInfo = $result->participants->map(function($participant) {
                    // Handle both array format and User model format
                    if (is_array($participant)) {
                        return $participant['name'] ?? 'N/A';
                    } else {
                        // User model format
                        return $participant->last_name . ', ' . $participant->first_name . ' ' . $participant->mid_init . '.';
                    }
                })->implode(', ');
                break;

            case 'user':
                $details = $result->position ?? 'N/A';
                $relatedInfo = $result->division ?? 'N/A';
                break;

            case 'training_material':
                $details = $result->competency->name ?? 'N/A';
                $relatedInfo = $result->user ? 
                    $result->user->last_name . ', ' . $result->user->first_name . ' ' . $result->user->mid_init . '.' : 
                    'N/A';
                break;
        }

        return [
            ucfirst($result->search_type),
            $result->title ?? ($result->last_name . ', ' . $result->first_name . ' ' . $result->mid_init . '.'),
            $details,
            $relatedInfo
        ];
    }
} 