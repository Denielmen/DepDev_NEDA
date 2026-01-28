<div class="accordion" id="{{ $accordionId }}">
    @php
        // Group materials by training title and clean up the title
        $groupedMaterials = $materials->groupBy(function($item) {
            $title = $item->title ?? 'Untitled';
            
            // Remove file extensions (including complex filenames)
            $title = preg_replace('/\s*-\s*[^-]+\.(pdf|png|jpg|jpeg|doc|docx|xls|xlsx|ppt|pptx)$/i', '', $title);
            $title = preg_replace('/\.(pdf|png|jpg|jpeg|doc|docx|xls|xlsx|ppt|pptx)$/i', '', $title);
            
            // Remove " - Link" suffix
            $title = preg_replace('/\s*-\s*Link\s*$/i', '', $title);
            
            // Remove " Certificate" suffix (but keep "Certificate" if it's the main title)
            if (preg_match('/^(.+)\s+Certificate\s*$/i', $title, $matches)) {
                $title = $matches[1] . ' Certificate';
            }
            
            return trim($title);
        });
    @endphp
    @foreach ($groupedMaterials as $trainingTitle => $materials)
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                        data-bs-target="#collapse{{ $accordionId }}{{ $loop->index }}" aria-expanded="false" 
                        aria-controls="collapse{{ $accordionId }}{{ $loop->index }}">
                    <strong>{{ $trainingTitle }}</strong> 
                    <span class="badge bg-primary ms-2">{{ $materials->count() }} {{ str_contains($accordionId, 'links') ? 'Link(s)' : (str_contains($accordionId, 'certificates') ? 'Certificate(s)' : 'Material(s)') }}</span>
                </button>
            </h2>
            <div id="collapse{{ $accordionId }}{{ $loop->index }}" class="accordion-collapse collapse" 
                 data-bs-parent="#{{ $accordionId }}">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-muted mb-3">Training: {{ $trainingTitle }}</h6>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Uploader</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($materials as $material)
                                            <tr>
                                                <td class="text-center">
                                                    @if ($material->user)
                                                        {{ $material->user->last_name . ', ' . $material->user->first_name . ' ' . $material->user->mid_init . '.' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($material->file_path)
                                                        Material
                                                    @elseif ($material->link)
                                                        Link
                                                    @else
                                                        Certificate
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($material->file_path)
                                                        <button class="btn btn-primary btn-sm"
                                                            onclick="window.location.href = '{{ route('user.training_materials.download', $material->id) }}'"
                                                            title="Download file">
                                                            <i class="bi bi-download"></i> Download
                                                        </button>
                                                    @elseif ($material->link)
                                                        <button class="btn btn-info btn-sm"
                                                            onclick="window.open('{{ $material->link }}', '_blank')"
                                                            title="Open link">
                                                            <i class="bi bi-box-arrow-up-right"></i> Open Link
                                                        </button>
                                                    @else
                                                        <button class="btn btn-primary btn-sm"
                                                            onclick="window.location.href = '{{ route('user.training_materials.download', $material->id) }}'"
                                                            title="Download certificate">
                                                            <i class="bi bi-download"></i> Download
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
