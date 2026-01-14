<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lnd.dro7.depdev</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        body {
            background-color: #f7f8fa;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #fff;
            padding: 0.5rem 1rem;
            box-shadow: 1px 3px 3px 0px #737373;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1040;
        }

        .navbar-brand {
            color: #003366 !important;
            font-size: 1rem;
            display: flex;
            align-items: center;
            font-weight: bold;
        }

        .navbar-brand img {
            height: 30px;
            margin-right: 10px;
        }

        .sidebar {
            background-color: #003366;
            position: fixed;
            top: 56px;
            left: 0;
            width: 270px;
            height: calc(100vh - 56px);
            padding-top: 20px;
            z-index: 1030;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            font-size: 0.9rem;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #004080;
            font-weight: bold;
        }

        .main-content {
            margin-left: 270px;
            margin-top: 56px;
            height: calc(100vh - 56px);
            overflow-y: auto;
            background-color: rgb(187, 219, 252);
            padding: 40px 0;
        }

        .resources-header-wrapper {
            display: flex;
            justify-content: center;
        }

        .content-header {
            background-color: #e7f1ff;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            width: 96%;
            max-width: 1800px;
        }

        .resources-title {
            color: #003366;
            font-size: 1.5rem;
            margin: 0;
            font-weight: bold;
        }

        .resources-card-wrapper {
            display: flex;
            justify-content: center;
        }

        .resources-card {
            width: 96%;
            max-width: 1800px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 32px;
        }

        .search-container {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .resources-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        .accordion-button:not(.collapsed) {
            background-color: #e7f1ff;
            color: #0d6efd;
        }
        
        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(0,0,0,.125);
        }
        
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        
        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }

        .table thead th {
            background-color: #003366;
            color: #fff;
        }

        .content-wrapper {
            width: 100%;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item.text-danger:hover {
            background-color: #dc3545;
            color: white !important;
        }
        .profile-picture {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #003366;
            box-shadow: 0 0 0 2px #fff;
            margin-right: 8px;
        }   
        .user-menu {
            display: flex;
            align-items: center;
        }

        .user-menu .bi-person-circle {
            font-size: 32px;
            margin-right: 8px;
        }
    </style>
</head>

<body>
@php
    // ensure variables are defined so the view never errors
    $filter = $filter ?? request()->query('filter', 'all');
    $user = $user ?? auth()->user();
@endphp
    <!-- DEPDEV Header Bar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/images/DEPDev_logo.png" alt="NEDA Logo">
                DEPDEV Region VII Learning and Development Database System
            </a>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    @php $user = auth()->user(); @endphp
                    <div class="user-menu" data-bs-toggle="dropdown" style="cursor:pointer;">
                        @if($user && $user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="profile-picture">
                        @else
                            <i class="bi bi-person-circle"></i>
                        @endif
                       {{ $user ? ($user->first_name . ' ' . $user->last_name) : '' }}
                        <i class="bi bi-chevron-down ms-1"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                        <a href="{{ $user ? route('user.profile.info') : '#' }}" class="dropdown-item">
                                <i class="bi bi-person-lines-fill me-2"></i> Profile Info
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item logout-btn">
                                    <i class="bi bi-box-arrow-right text-danger me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="sidebar">
        <a href="{{ route('user.home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
        <a href="{{ route('user.training.profile') }}"><i class="bi bi-person-vcard me-2"></i>Individual Training Profile</a>
        <a href="{{ route('user.tracking') }}"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
        <a href="{{ route('user.training.effectiveness') }}"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
        <a href="{{ route('user.training.resources') }}" class="active"><i class="bi bi-archive me-2"></i>Training Resources</a>
    </div>
    <div class="main-content">
        <div class="content-wrapper flex-grow-1">
            <div class="resources-header-wrapper">
                <div class="content-header">
                    <h2 class="resources-title">Training Resources</h2>
                </div>
            </div>
            <div class="resources-card-wrapper">
                <div class="resources-card">
                    <div class="d-flex align-items-center mb-3 flex-wrap">
                        <div class="search-container w-100 mb-3">
                            <div class="row g-2">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="searchInput" placeholder="Search resources..." name="search" value="{{ request('search') }}">
                                        <button class="btn btn-outline-secondary" type="button" id="searchButton">
                                            <i class="bi bi-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="filterMaterials" name="filter_materials" value="1" {{ request('filter_materials') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="filterMaterials">Training Materials</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="resources-container">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <a href="{{ route('user.training.resources', ['filter' => 'all']) }}" class="btn btn-sm {{ $filter === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">All</a>
                                <a href="{{ route('user.training.resources', ['filter' => 'materials']) }}" class="btn btn-sm {{ $filter === 'materials' ? 'btn-primary' : 'btn-outline-primary' }}">Materials</a>
                                <a href="{{ route('user.training.resources', ['filter' => 'links']) }}" class="btn btn-sm {{ $filter === 'links' ? 'btn-primary' : 'btn-outline-primary' }}">Links</a>
                                <a href="{{ route('user.training.resources', ['filter' => 'certificates']) }}" class="btn btn-sm {{ $filter === 'certificates' ? 'btn-primary' : 'btn-outline-primary' }}">Certificates</a>
                            </div>
                            <div>
                                <!-- Upload/Open modal trigger -->
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addResourceModal">
                                    <i class="bi bi-plus-lg"></i> Add Resource
                                </button>
                            </div>
                        </div>

                        @if(!empty($trainings) && count($trainings) > 0)
                            <div class="accordion" id="resourcesAccordion">
                                @foreach($trainings as $item)
                                    @php
                                        $training = $item['training'] ?? $item;
                                        $materials = collect($item['materials'] ?? [])->where('type','material')->whereNotNull('file_path');
                                        $links = collect($item['materials'] ?? [])->where('type','link')->whereNotNull('link');
                                        $certificates = collect($item['materials'] ?? [])->where('type','certificate');
                                        $total = $materials->count() + $links->count() + $certificates->count();
                                    @endphp

                                    @if($total === 0)
                                        @continue
                                    @endif

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $loop->index }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}" aria-expanded="false" aria-controls="collapse{{ $loop->index }}">
                                                {{ $training->title ?? 'Untitled Training' }}
                                                <span class="badge bg-primary ms-2">{{ $total }} items</span>
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#resourcesAccordion">
                                            <div class="accordion-body">
                                                @if(in_array($filter, ['all','materials']) && $materials->count() > 0)
                                                    <h6 class="text-primary"><i class="bi bi-file-earmark-text me-2"></i>Materials <span class="badge bg-secondary">{{ $materials->count() }}</span></h6>
                                                    <div class="table-responsive mb-3">
                                                        <table class="table table-hover">
                                                            <tbody>
                                                                @foreach($materials as $material)
                                                                    <tr>
                                                                        <td>{{ $material->title ?? 'Untitled Material' }}</td>
                                                                        <td>{{ optional($material->created_at)->format('M d, Y') }}</td>
                                                                        <td class="text-end">
                                                                            <a href="{{ route('user.training_materials.download', $material) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-download"></i> Download</a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif

                                                @if(in_array($filter, ['all','links']) && $links->count() > 0)
                                                    <h6 class="text-primary"><i class="bi bi-link-45deg me-2"></i>Links <span class="badge bg-secondary">{{ $links->count() }}</span></h6>
                                                    <div class="table-responsive mb-3">
                                                        <table class="table table-hover">
                                                            <tbody>
                                                                @foreach($links as $link)
                                                                    <tr>
                                                                        <td>{{ $link->title ?? 'Untitled Link' }}</td>
                                                                        <td>{{ optional($link->created_at)->format('M d, Y') }}</td>
                                                                        <td class="text-end">
                                                                            <a href="{{ $link->link }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-box-arrow-up-right"></i> Open Link</a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif

                                                @if(in_array($filter, ['all','certificates']) && $certificates->count() > 0)
                                                    <h6 class="text-primary"><i class="bi bi-award me-2"></i>Certificates <span class="badge bg-secondary">{{ $certificates->count() }}</span></h6>
                                                    <div class="table-responsive mb-3">
                                                        <table class="table table-hover">
                                                            <tbody>
                                                                @foreach($certificates as $certificate)
                                                                    <tr>
                                                                        <td>{{ $certificate->title ?? 'Untitled Certificate' }}</td>
                                                                        <td>{{ optional($certificate->created_at)->format('M d, Y') }}</td>
                                                                        <td class="text-end">
                                                                            @if(!empty($certificate->file_path))
                                                                                <a href="{{ route('user.training_materials.download', $certificate) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-download"></i> Download</a>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info text-center">No materials found.</div>
                        @endif
                    </div>

                    <!-- Add Resource Modal -->
                    <div class="modal fade" id="addResourceModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('user.training.resources.store') }}" enctype="multipart/form-data" class="modal-content">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Resource</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label class="form-label">Training</label>
                                        <select name="training_id" class="form-select" required>
                                            @foreach($trainings as $t)
                                                <option value="{{ $t['training']->id }}">{{ $t['training']->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Type</label>
                                        <select name="type" id="resourceType" class="form-select" required>
                                            <option value="material">Material (file)</option>
                                            <option value="link">Link (URL)</option>
                                            <option value="certificate">Certificate (file)</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Title</label>
                                        <input name="title" class="form-control" required>
                                    </div>
                                    <div class="mb-2" id="fileInputWrap">
                                        <label class="form-label">File</label>
                                        <input type="file" name="file" class="form-control">
                                    </div>
                                    <div class="mb-2 d-none" id="linkInputWrap">
                                        <label class="form-label">Link (URL)</label>
                                        <input type="url" name="link" class="form-control" placeholder="https://example.com">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const typeSel = document.getElementById('resourceType');
                            const fileWrap = document.getElementById('fileInputWrap');
                            const linkWrap = document.getElementById('linkInputWrap');

                            function toggleInputs() {
                                const v = typeSel.value;
                                if (v === 'link') {
                                    linkWrap.classList.remove('d-none');
                                    fileWrap.classList.add('d-none');
                                } else {
                                    linkWrap.classList.add('d-none');
                                    fileWrap.classList.remove('d-none');
                                }
                            }
                            typeSel.addEventListener('change', toggleInputs);
                            toggleInputs();
                        });
                    </script>
                </div>
            </div>

            @php
                // Ensure $filter is defined (fallback to query param or 'all')
                $filter = $filter ?? request()->query('filter', 'all');
            @endphp

            <div class="resources-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <a href="{{ route('user.training.resources', ['filter' => 'all']) }}" class="btn btn-sm {{ $filter === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">All</a>
                        <a href="{{ route('user.training.resources', ['filter' => 'materials']) }}" class="btn btn-sm {{ $filter === 'materials' ? 'btn-primary' : 'btn-outline-primary' }}">Materials</a>
                        <a href="{{ route('user.training.resources', ['filter' => 'links']) }}" class="btn btn-sm {{ $filter === 'links' ? 'btn-primary' : 'btn-outline-primary' }}">Links</a>
                        <a href="{{ route('user.training.resources', ['filter' => 'certificates']) }}" class="btn btn-sm {{ $filter === 'certificates' ? 'btn-primary' : 'btn-outline-primary' }}">Certificates</a>
                    </div>
                    <div>
                        <!-- Upload/Open modal trigger -->
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addResourceModal">
                            <i class="bi bi-plus-lg"></i> Add Resource
                        </button>
                    </div>
                </div>

                @if(!empty($trainings) && count($trainings) > 0)
                    <div class="accordion" id="resourcesAccordion">
                        @foreach($trainings as $item)
                            @php
                                $training = $item['training'] ?? $item;
                                $materials = collect($item['materials'] ?? [])->where('type','material')->whereNotNull('file_path');
                                $links = collect($item['materials'] ?? [])->where('type','link')->whereNotNull('link');
                                $certificates = collect($item['materials'] ?? [])->where('type','certificate');
                                $total = $materials->count() + $links->count() + $certificates->count();
                            @endphp

                            @if($total === 0)
                                @continue
                            @endif

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $loop->index }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}" aria-expanded="false" aria-controls="collapse{{ $loop->index }}">
                                        {{ $training->title ?? 'Untitled Training' }}
                                        <span class="badge bg-primary ms-2">{{ $total }} items</span>
                                    </button>
                                </h2>
                                <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#resourcesAccordion">
                                    <div class="accordion-body">
                                        @if(in_array($filter, ['all','materials']) && $materials->count() > 0)
                                            <h6 class="text-primary"><i class="bi bi-file-earmark-text me-2"></i>Materials <span class="badge bg-secondary">{{ $materials->count() }}</span></h6>
                                            <div class="table-responsive mb-3">
                                                <table class="table table-hover">
                                                    <tbody>
                                                        @foreach($materials as $material)
                                                            <tr>
                                                                <td>{{ $material->title ?? 'Untitled Material' }}</td>
                                                                <td>{{ optional($material->created_at)->format('M d, Y') }}</td>
                                                                <td class="text-end">
                                                                    <a href="{{ route('user.training_materials.download', $material) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-download"></i> Download</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif

                                        @if(in_array($filter, ['all','links']) && $links->count() > 0)
                                            <h6 class="text-primary"><i class="bi bi-link-45deg me-2"></i>Links <span class="badge bg-secondary">{{ $links->count() }}</span></h6>
                                            <div class="table-responsive mb-3">
                                                <table class="table table-hover">
                                                    <tbody>
                                                        @foreach($links as $link)
                                                            <tr>
                                                                <td>{{ $link->title ?? 'Untitled Link' }}</td>
                                                                <td>{{ optional($link->created_at)->format('M d, Y') }}</td>
                                                                <td class="text-end">
                                                                    <a href="{{ $link->link }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-box-arrow-up-right"></i> Open Link</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif

                                        @if(in_array($filter, ['all','certificates']) && $certificates->count() > 0)
                                            <h6 class="text-primary"><i class="bi bi-award me-2"></i>Certificates <span class="badge bg-secondary">{{ $certificates->count() }}</span></h6>
                                            <div class="table-responsive mb-3">
                                                <table class="table table-hover">
                                                    <tbody>
                                                        @foreach($certificates as $certificate)
                                                            <tr>
                                                                <td>{{ $certificate->title ?? 'Untitled Certificate' }}</td>
                                                                <td>{{ optional($certificate->created_at)->format('M d, Y') }}</td>
                                                                <td class="text-end">
                                                                    @if(!empty($certificate->file_path))
                                                                        <a href="{{ route('user.training_materials.download', $certificate) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-download"></i> Download</a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info text-center">No materials found.</div>
                @endif
            </div>

            <!-- Add Resource Modal -->
            <div class="modal fade" id="addResourceModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('user.training.resources.store') }}" enctype="multipart/form-data" class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Add Resource</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-2">
                                <label class="form-label">Training</label>
                                <select name="training_id" class="form-select" required>
                                    @foreach($trainings as $t)
                                        <option value="{{ $t['training']->id }}">{{ $t['training']->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Type</label>
                                <select name="type" id="resourceType" class="form-select" required>
                                    <option value="material">Material (file)</option>
                                    <option value="link">Link (URL)</option>
                                    <option value="certificate">Certificate (file)</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Title</label>
                                <input name="title" class="form-control" required>
                            </div>
                            <div class="mb-2" id="fileInputWrap">
                                <label class="form-label">File</label>
                                <input type="file" name="file" class="form-control">
                            </div>
                            <div class="mb-2 d-none" id="linkInputWrap">
                                <label class="form-label">Link (URL)</label>
                                <input type="url" name="link" class="form-control" placeholder="https://example.com">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const typeSel = document.getElementById('resourceType');
                    const fileWrap = document.getElementById('fileInputWrap');
                    const linkWrap = document.getElementById('linkInputWrap');

                    function toggleInputs() {
                        const v = typeSel.value;
                        if (v === 'link') {
                            linkWrap.classList.remove('d-none');
                            fileWrap.classList.add('d-none');
                        } else {
                            linkWrap.classList.add('d-none');
                            fileWrap.classList.remove('d-none');
                        }
                    }
                    typeSel.addEventListener('change', toggleInputs);
                    toggleInputs();
                });
            </script>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle search form submission
            const searchForm = document.createElement('form');
            searchForm.method = 'GET';
            searchForm.action = window.location.pathname;
            
            // Add existing query parameters
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.forEach((value, key) => {
                if (key !== 'search' && key !== 'filter_materials' && key !== 'page') {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = value;
                    searchForm.appendChild(input);
                }
            });
            
            // Add search input
            const searchInput = document.createElement('input');
            searchInput.type = 'hidden';
            searchInput.name = 'search';
            searchForm.appendChild(searchInput);
            
            // Add materials filter
            const materialsFilter = document.createElement('input');
            materialsFilter.type = 'hidden';
            materialsFilter.name = 'filter_materials';
            searchForm.appendChild(materialsFilter);
            
            document.body.appendChild(searchForm);
            
            // Handle search button click
            document.getElementById('searchButton').addEventListener('click', function() {
                const searchValue = document.getElementById('searchInput').value.trim();
                searchInput.value = searchValue;
                materialsFilter.value = document.getElementById('filterMaterials').checked ? '1' : '0';
                searchForm.submit();
            });
            
            // Handle Enter key in search input
            document.getElementById('searchInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('searchButton').click();
                }
            });
            
            // Handle filter change
            document.getElementById('filterMaterials').addEventListener('change', function() {
                document.getElementById('searchButton').click();
            });
            
            // Auto-expand accordion if there's a search term
            const searchTerm = '{{ request('search') }}';
            if (searchTerm) {
                const accordionButtons = document.querySelectorAll('.accordion-button');
                accordionButtons.forEach(button => {
                    button.classList.remove('collapsed');
                    const target = document.querySelector(button.getAttribute('data-bs-target'));
                    if (target) {
                        target.classList.add('show');
                    }
                });
            }
        });
    </script>
</body>

</html>
