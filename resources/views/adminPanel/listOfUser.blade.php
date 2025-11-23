<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>lnd.dro7.depdev</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background-color: rgb(187, 219, 252);
            padding-top: 60px;
        }
        .navbar {
            background-color: #fff;
            padding: 0.5rem 1rem;
            box-shadow: 1px 3px 3px 0px #737373;
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
        .user-icon, .user-menu {
            color: black !important;
        }
        .sidebar {
            background-color: #003366;
            min-height: calc(100vh - 56px);
            width: 270px;
            padding-top: 20px;
            position: fixed;
            top: 56px;
            left: 0;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            font-size: 0.9rem;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #004080;
            font-weight: bold;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: rgb(187, 219, 252);
            margin-left: 270px;
            margin-top: 30px;
            padding-bottom: 20px;

        }
        .list-title {
            background-color: #e7f1ff;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .list-title h2 {
            color: #003366;
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0;
        }
        .new-user-btn {
            background-color: #003366;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .new-user-btn:hover {
            background-color: #004080;
            color: white;
        }
        .search-box {
            position: relative;
            display: flex;
            align-items: center;
            background: white;
            border-radius: 10px;
            padding: 8px 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 300px;
        }

        .search-box input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            padding: 8px 15px;
            padding-right: 40px;
            border: 1px solid #ced4da;
            border-radius: 10px;
        }

        .search-icon {
            color: #666;
            margin-right: 10px;
        }

        .clear-search {
            position: absolute;
            right: 40px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        .search-box .clear-search {
            position: absolute;
            right: 40px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        .search-box .clear-search {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 0;
            font-size: 16px;
        }
        .search-box .clear-search:hover {
            color: #dc3545;
        }
        .table-container {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 20px;
            overflow-x: auto;
        }
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-container th {
            background-color: #003366;
            color: white;
            font-weight: 500;
            padding: 12px 15px;
            text-align: left;
        }
        .table-container td {
            padding: 12px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #dee2e6;
        }
        .table-container td:nth-child(4) {
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .table-container td:nth-child(5) {
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .table-container tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
        }
        .status-indicator.active {
            background-color: #28a745;
        }
        .status-indicator.inactive {
            background-color: #dc3545;
        }
        .status-text {
            font-size: 0.9rem;
        }
        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-right: 5px;
        }
        .action-btn.view {
            background-color: #4a90e2;
            color: white;
        }
        .action-btn.view:hover {
            background-color: #357abd;
            color: white;
        }
        .action-btn.enable {
            background-color: #28a745;
            color: white;
        }
        .action-btn.enable:hover {
            background-color: #218838;
            color: white;
        }
        .action-btn.disable {
            background-color: #dc3545;
            color: white;
        }
        .action-btn.disable:hover {
            background-color: #c82333;
            color: white;
        }
        .action-btn.delete {
            background-color: #6c757d;
            color: white;
        }
        .action-btn.delete:hover {
            background-color: #5a6268;
            color: white;
        }
        .tab-buttons {
            display: inline-flex;
            gap: 5px;
        }
        .tab-button {
            background-color: white;
            border: none;
            padding: 8px 20px;
            font-weight: 500;
            color: #003366;
            text-decoration: none;
            border-radius: 4px;
        }
        .tab-button:hover {
            text-decoration: none;
            color: #003366;
        }
        .tab-button.active {
            background-color: #003366;
            color: white;
        }

        /* Pagination Styling */
        .pagination-info {
            color: #666;
            font-size: 0.9rem;
        }

        .pagination-links .pagination {
            margin: 0;
        }

        .pagination-links .page-link {
            color: #003366;
            border-color: #dee2e6;
            padding: 0.5rem 0.75rem;
        }

        .pagination-links .page-link:hover {
            color: #004080;
            background-color: #e7f1ff;
            border-color: #003366;
        }

        .pagination-links .page-item.active .page-link {
            background-color: #003366;
            border-color: #003366;
            color: white;
        }

        .pagination-links .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }

        /* Style Previous/Next buttons with simple text */
        .pagination-links .page-item:first-child .page-link {
            border-top-left-radius: 0.375rem;
            border-bottom-left-radius: 0.375rem;
        }

        .pagination-links .page-item:last-child .page-link {
            border-top-right-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.home') }}">
                <img src="/images/DEPDev_logo.png" alt="NEDA Logo">
                DEPDEV Region VII Learning and Development Database System
            </a>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <div class="user-menu" data-bs-toggle="dropdown" style="cursor:pointer;">
                    @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="profile-picture">
                        @else
                            <i class="bi bi-person-circle"></i>
                        @endif
                        {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                        <i class="bi bi-chevron-down ms-1"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                            <a href="{{ route('admin.participants.info', ['id' => Auth::user()->id]) }}" class="dropdown-item">
                                <i class="bi bi-person-lines-fill me-2"></i> Profile Info
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="{{ route('admin.home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('admin.training-plan') }}"><i class="bi bi-calendar-check me-2"></i>Training Profile</a>
            <a href="{{ route('admin.participants') }}" class="active"><i class="bi bi-people me-2"></i>Employees Information</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Training Plan</a>
            <a href="{{ route('admin.search.index') }}"><i class="bi bi-search me-2"></i>Search</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="list-title">
                <h2>Employees Information</h2>
                @if((isset($positionFilter) && $positionFilter !== 'all') || (isset($searchQuery) && trim($searchQuery) !== ''))
                    <div class="alert alert-info mt-2 mb-0">
                        <i class="bi bi-filter"></i>
                        @if(isset($positionFilter) && $positionFilter !== 'all')
                            Showing employees with position: <strong>{{ $positionFilter }}</strong>
                        @endif
                        @if(isset($searchQuery) && trim($searchQuery) !== '')
                            @if(isset($positionFilter) && $positionFilter !== 'all') and @endif
                            Searching for: <strong>"{{ $searchQuery }}"</strong>
                        @endif
                        <a href="{{ route('admin.participants', ['status' => $status]) }}" class="btn btn-sm btn-outline-primary ms-2">
                            <i class="bi bi-x"></i> Clear All Filters
                        </a>
                    </div>
                @endif
            </div>
            <div class="user-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    @if(!$isReadOnlyAdmin)
                    <a href="{{ route('register') }}" class="new-user-btn">
                        <i class="bi bi-person-plus-fill"></i> NEW USER
                    </a>
                    @endif
                    <div class="search-box">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" placeholder="Search all employees..." id="searchInput" value="{{ $searchQuery ?? '' }}" onkeyup="handleSearch(event)">
                        @if(isset($searchQuery) && trim($searchQuery) !== '')
                            <button type="button" class="clear-search" onclick="clearSearch()" title="Clear search">
                                <i class="bi bi-x-circle-fill"></i>
                            </button>
                        @endif
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <div class="tab-buttons">
                        <a href="{{ route('admin.participants', ['status' => 'active', 'search' => $searchQuery ?? '']) }}" class="tab-button {{ $status === 'active' ? 'active' : '' }}" id="active-tab">Active</a>
                        <a href="{{ route('admin.participants', ['status' => 'inactive', 'search' => $searchQuery ?? '']) }}" class="tab-button {{ $status === 'inactive' ? 'active' : '' }}" id="inactive-tab">Disable</a>
                    </div>
                    <div>
                        <label for="sort-by" class="me-2">Sort by</label>
                        <div style="position: relative; display: inline-block; width: 200px;">
                            <input type="text" id="sort-by-search" class="form-control" placeholder="Search positions..." style="width: 200px;" autocomplete="off">
                            <select id="sort-by" class="form-select" style="width: 200px; display: none; position: absolute; top: 0; left: 0;" onchange="sortUsers();">
                                <option value="all" {{ (!isset($positionFilter) || $positionFilter === 'all') ? 'selected' : '' }}></option>
                                @foreach($positions as $position)
                                    <option value="{{ $position }}" {{ (isset($positionFilter) && $positionFilter === $position) ? 'selected' : '' }}>{{ $position }}</option>
                                @endforeach
                            </select>
                            <div id="sort-by-dropdown" class="position-absolute bg-white border rounded mt-1" style="width: 200px; max-height: 200px; overflow-y: auto; display: none; z-index: 1000; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"></div>
                        </div>
                    </div>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 15%;">User ID</th>
                                <th style="width: 25%;">Name</th>
                                <th style="width: 25%;">Position</th>
                                <th style="width: 30%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <span class="status-indicator {{ $user->is_active ? 'active' : 'inactive' }}"></span>
                                    <span class="status-text">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                                </td>
                                <td>{{ $user->user_id }}</td>
                                <td>{{ $user->last_name }}, {{ $user->first_name }} {{ $user->mid_init }}.</td>
                                <td>{{ $user->position }}</td>
                                <td>
                                    <a href="{{ route('admin.participants.info', ['id' => $user->id]) }}" class="action-btn view">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    @if(!$isReadOnlyAdmin)
                                    <form action="{{ route('admin.toggleUserStatus', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn {{ $user->is_active ? 'disable' : 'enable' }}">
                                            <i class="bi bi-toggle-{{ $user->is_active ? 'on' : 'off' }}"></i> {{ $user->is_active ? 'Disable' : 'Enable' }}
                                        </button>
                                    </form>
                                    @endif
                                    @if(!$isReadOnlyAdmin)
                                    <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" onclick="return confirm('Are you sure you want to delete {{ $user->first_name }} {{ $user->last_name }}? This action cannot be undone.')">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Info and Links -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="pagination-info">
                        <small class="text-muted">
                            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }}
                            of {{ $users->total() }} employees
                        </small>
                    </div>
                    <div class="pagination-links">
                        @if ($users->hasPages())
                            <nav aria-label="Pagination Navigation">
                                <ul class="pagination">
                                    {{-- Previous Page Link --}}
                                    @if ($users->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $users->previousPageUrl() }}">Previous</a></li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                        @if ($page == $users->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($users->hasMorePages())
                                        <li class="page-item"><a class="page-link" href="{{ $users->nextPageUrl() }}">Next</a></li>
                                    @else
                                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                                    @endif
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize page when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Page initialization complete
        });

        // Handle search with debouncing to avoid too many requests
        let searchTimeout;
        function handleSearch(event) {
            clearTimeout(searchTimeout);

            // If Enter key is pressed, search immediately
            if (event.key === 'Enter') {
                performSearch();
                return;
            }

            // Otherwise, wait 500ms after user stops typing
            searchTimeout = setTimeout(performSearch, 500);
        }

        function performSearch() {
            const input = document.getElementById('searchInput');
            const searchQuery = input.value.trim();

            // Get current URL parameters
            const url = new URL(window.location);

            // Update or remove search parameter
            if (searchQuery === '') {
                url.searchParams.delete('search');
            } else {
                url.searchParams.set('search', searchQuery);
            }

            // Preserve position filter if it exists
            const positionSelect = document.getElementById('sort-by');
            if (positionSelect && positionSelect.value !== 'all') {
                url.searchParams.set('position', positionSelect.value);
            }

            // Redirect to the new URL to reload with server-side search
            window.location.href = url.toString();
        }

        function clearSearch() {
            const url = new URL(window.location);
            url.searchParams.delete('search');
            window.location.href = url.toString();
        }

        function sortUsers() {
            try {
                const select = document.getElementById('sort-by');
                if (!select) return;

                const position = select.value;

                // Get current URL parameters
                const url = new URL(window.location);

                // Update or remove position parameter
                if (position === 'all') {
                    url.searchParams.delete('position');
                } else {
                    url.searchParams.set('position', position);
                }

                // Preserve search query if it exists
                const searchInput = document.getElementById('searchInput');
                if (searchInput && searchInput.value.trim() !== '') {
                    url.searchParams.set('search', searchInput.value.trim());
                }

                // Redirect to the new URL to reload with server-side filtering
                window.location.href = url.toString();

            } catch (error) {
                console.error('Error in sortUsers:', error);
            }
        }

        // Initialize searchable position dropdown
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('sort-by-search');
            const dropdown = document.getElementById('sort-by-dropdown');
            const select = document.getElementById('sort-by');

            if (!searchInput || !dropdown || !select) return;

            // Get all options from select
            const options = Array.from(select.options).map(opt => ({
                value: opt.value,
                text: opt.text
            }));

            function renderDropdown(filter = '') {
                const filtered = options.filter(opt => 
                    opt.text.toLowerCase().includes(filter.toLowerCase())
                );

                dropdown.innerHTML = filtered.map(opt => `
                    <div class="p-2" style="cursor: pointer; border-bottom: 1px solid #f0f0f0; hover-background: #f5f5f5;" 
                         onclick="selectPosition('${opt.value}', '${opt.text}')">
                        ${opt.text}
                    </div>
                `).join('');
            }

            searchInput.addEventListener('focus', function() {
                renderDropdown(searchInput.value);
                dropdown.style.display = 'block';
            });

            searchInput.addEventListener('input', function() {
                renderDropdown(searchInput.value);
                dropdown.style.display = 'block';
            });

            document.addEventListener('click', function(e) {
                if (e.target !== searchInput && e.target !== dropdown) {
                    dropdown.style.display = 'none';
                }
            });

            // Display current selection
            const currentValue = select.value;
            const currentOption = options.find(opt => opt.value === currentValue);
            if (currentOption) {
                searchInput.value = currentOption.text;
            }
        });

        function selectPosition(value, text) {
            const select = document.getElementById('sort-by');
            const searchInput = document.getElementById('sort-by-search');
            const dropdown = document.getElementById('sort-by-dropdown');

            select.value = value;
            searchInput.value = text;
            dropdown.style.display = 'none';
            sortUsers();
        }
    </script>
</body>
</html>





