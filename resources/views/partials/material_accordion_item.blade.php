@php
    $materials = $training->materials->where('type', $type);
    $collapseId = "collapse-{$training->id}-{$type}";
    $headingId = "heading-{$training->id}-{$type}";
    $accordionId = $accordionId ?? 'materialsAccordion';
    $count = $count ?? $materials->count();
@endphp

<div class="accordion-item">
    <h2 class="accordion-header" id="{{ $headingId }}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
            data-bs-target="#{{ $collapseId }}" aria-expanded="false" 
            aria-controls="{{ $collapseId }}">
            <strong>{{ $training->title }}</strong>
            <span class="badge bg-light text-dark ms-2">{{ $count }} item(s)</span>
        </button>
    </h2>
    <div id="{{ $collapseId }}" class="accordion-collapse collapse" 
        aria-labelledby="{{ $headingId }}" data-bs-parent="#{{ $accordionId }}">
        <div class="accordion-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">Title</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Source</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materials as $material)
                        <tr>
                            <td class="text-center">{{ $material->title }}</td>
                            <td class="text-center">{{ ucfirst($material->type) }}</td>
                            <td class="text-center">{{ $material->source ?? 'N/A' }}</td>
                            <td class="text-center">
                                @if ($material->type === 'material' || $material->type === 'certificate')
                                    @if ($material->file_path)
                                        <a href="{{ route('user.training_materials.download', $material->id) }}" 
                                           class="btn btn-sm btn-info">
                                            Download
                                        </a>
                                    @else
                                        <span class="text-muted">No file</span>
                                    @endif
                                @elseif ($material->type === 'link')
                                    @if ($material->link)
                                        <a href="{{ $material->link }}" target="_blank" 
                                           class="btn btn-sm btn-primary">
                                            Open Link
                                        </a>
                                    @else
                                        <span class="text-muted">No link</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
