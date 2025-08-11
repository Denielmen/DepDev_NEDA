<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Resources</title>
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

        .search-bar {
            max-width: 400px;
            margin: 0 auto 24px auto;
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
    </style>
</head>

<body>
    <!-- DEPDEV Header Bar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/images/DEPDev_logo.png" alt="NEDA Logo">
                DEPDEV Learning and Development Database System Region VII
            </a>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <div class="user-menu" data-bs-toggle="dropdown" style="cursor:pointer;">
                        <i class="bi bi-person-circle"></i>
                       {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                        <i class="bi bi-chevron-down ms-1"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
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
        <a href="{{ route('user.training.profile') }}"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
        <a href="{{ route('user.tracking') }}"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
        <a href="{{ route('user.training.effectiveness') }}"><i class="bi bi-graph-up me-2"></i>Training
            Effectiveness</a>
        <a href="{{ route('user.training.resources') }}" class="active"><i class="bi bi-archive me-2"></i>Training
            Resources</a>
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
                        <ul class="nav nav-tabs me-2 mb-0">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->get('tab', 'materials') == 'materials' ? 'active' : '' }}" href="?tab=materials">Materials</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->get('tab') == 'links' ? 'active' : '' }}" href="?tab=links">Links</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->get('tab') == 'certificates' ? 'active' : '' }}" href="?tab=certificates">Certificates</a>
                            </li>
                        </ul>
                        <div class="dropdown ms-2 mb-0">
                            <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-funnel-fill me-1"></i> Filter
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                                <li><a class="dropdown-item {{ request('sort') == 'title' && request('order') == 'asc' ? 'active' : '' }}" href="?sort=title&order=asc">Title (A-Z)</a></li>
                                <li><a class="dropdown-item {{ request('sort') == 'title' && request('order') == 'desc' ? 'active' : '' }}" href="?sort=title&order=desc">Title (Z-A)</a></li>
                                <li><a class="dropdown-item {{ request('sort') == 'created_at' && request('order') == 'desc' ? 'active' : '' }}" href="?sort=created_at&order=desc">Date Uploaded (Newest)</a></li>
                                <li><a class="dropdown-item {{ request('sort') == 'created_at' && request('order') == 'asc' ? 'active' : '' }}" href="?sort=created_at&order=asc">Date Uploaded (Oldest)</a></li>
                            </ul>
                        </div>
                        <form class="search-bar ms-2 flex-grow-1 mb-0" method="GET" style="max-width: 400px;">
                        <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search by title, competency, source, or date..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                    </div>
                    <div class="tab-content" id="resourceTabsContent">
                        <!-- Materials Tab -->
                        <div class="tab-pane fade{{ request()->get('tab', 'materials') == 'materials' ? ' show active' : '' }}" id="materials" role="tabpanel" aria-labelledby="materials-tab">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Title</th>
                                <th class="text-center">Competency</th>
                                <th class="text-center">Source</th>
                                <th class="text-center">Date Uploaded</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($materials as $material)
                                <tr>
                                    <td class="text-center">{{ $material->title }}</td>
                                    <td class="text-center">{{ $material->competency->name ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $material->source }}</td>
                                    <td class="text-center">{{ $material->created_at->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-primary btn-sm me-1"
                                            @if (!$material->file_path) disabled @endif
                                            onclick="@if ($material->file_path) window.location.href = '{{ route('user.training_materials.download', $material->id) }}' @else alert('There\'s no file uploaded.') @endif"
                                            title="@if (!$material->file_path) No file available @endif">
                                            <i class="fas fa-download"></i> Download File
                                        </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No materials found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @if(isset($allMaterials))
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $allMaterials->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                        <!-- Links Tab -->
                        <div class="tab-pane fade{{ request()->get('tab') == 'links' ? ' show active' : '' }}" id="links" role="tabpanel" aria-labelledby="links-tab">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Title</th>
                                        <th class="text-center">Competency</th>
                                        <th class="text-center">Source</th>
                                        <th class="text-center">Date Uploaded</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($links as $link)
                                        <tr>
                                            <td class="text-center">{{ $link->title }}</td>
                                            <td class="text-center">{{ $link->competency->name ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $link->source }}</td>
                                            <td class="text-center">{{ $link->created_at->format('Y-m-d') }}</td>
                                            <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                                    @if (!$link->link) disabled @endif
                                                    onclick="@if ($link->link) window.open('{{ $link->link }}', '_blank') @else alert('There\'s no link pasted.') @endif"
                                                    title="@if (!$link->link) No link available @endif">
                                            <i class="fas fa-external-link-alt"></i> Open Link
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                            <td colspan="5" class="text-center">No links found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- Certificates Tab -->
                        <div class="tab-pane fade{{ request()->get('tab') == 'certificates' ? ' show active' : '' }}" id="certificates" role="tabpanel" aria-labelledby="certificates-tab">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Title</th>
                                        <th class="text-center">Competency</th>
                                        <th class="text-center">Source</th>
                                        <th class="text-center">Date Uploaded</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($certificates as $certificate)
                                        <tr>
                                            <td class="text-center">{{ $certificate->title }}</td>
                                            <td class="text-center">{{ $certificate->competency->name ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $certificate->source }}</td>
                                            <td class="text-center">{{ $certificate->created_at->format('Y-m-d') }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-primary btn-sm"
                                                    @if (!$certificate->file_path) disabled @endif
                                                    onclick="@if ($certificate->file_path) window.location.href = '{{ route('user.training_materials.download', $certificate->id) }}' @else alert('There\'s no file uploaded.') @endif"
                                                    title="@if (!$certificate->file_path) No file available @endif">
                                                    <i class="fas fa-download"></i> Download Certificate
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No certificates found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
