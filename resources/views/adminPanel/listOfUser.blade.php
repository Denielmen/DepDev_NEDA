<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DEPDEV Learning and Development System</title>
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
            width: 300px;
        }
        .search-box input {
            width: 100%;
            padding: 8px 15px;
            padding-right: 35px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
        .search-box .search-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        .table-container {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 20px;
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
        .table-container tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
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
            padding: 5px 15px;
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
        .tab-buttons {
            display: inline-flex;
            gap: 5px;
            margin-right: 38rem;
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.home') }}">
                <img src="/images/neda-logo.png" alt="NEDA Logo">
                DEPDEV Learning and Development Database System Region VII
            </a>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <div class="user-menu" data-bs-toggle="dropdown" style="cursor:pointer;">
                        <i class="bi bi-person-circle"></i>
                        {{ auth()->user()->last_name ?? 'Admin' }}
                        <i class="bi bi-chevron-down ms-1"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
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
            <a href="{{ route('admin.training-plan') }}"><i class="bi bi-calendar-check me-2"></i>Training Plan</a>
            <a href="{{ route('admin.participants') }}" class="active"><i class="bi bi-people me-2"></i>Employee's Profile</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Reports</a>
            <a href="{{ route('admin.search.index') }}"><i class="bi bi-search me-2"></i>Search</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="list-title">
                <h2>List of Employee's</h2>
            </div>
            <div class="user-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('register') }}" class="new-user-btn">
                        <i class="bi bi-person-plus-fill"></i> NEW USER
                    </a>
                    <div class="search-box">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" placeholder="Search..." id="searchInput" onkeyup="searchUsers()">
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-2">
                <div class="tab-buttons">
                    <a href="#" class="tab-button active" id="active-tab" onclick="filterUsersByStatus('active'); return false;">Active</a>
                    <a href="#" class="tab-button" id="inactive-tab" onclick="filterUsersByStatus('inactive'); return false;">Disable</a>
                </div>
                    <label for="sort-by" class="me-2">Sort by</label>
                    <select id="sort-by" class="form-select" style="width: 200px; display: inline-block;" onchange="sortUsers()">
                        <option value="all">All Positions</option>
                        @foreach($positions as $position)
                            <option value="{{ $position }}">{{ $position }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 25%;">Name</th>
                                <th style="width: 25%;">Position</th>
                                <th style="width: 20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users->sortBy([
                                ['is_active', 'desc'],
                                ['last_name', 'asc']
                            ]) as $user)
                            <tr>
                                <td>
                                    <span class="status-indicator {{ $user->is_active ? 'active' : 'inactive' }}"></span>
                                    <span class="status-text">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                                </td>
                                <td>{{ $user->last_name }}, {{ $user->first_name }} {{ $user->mid_init }}.</td>
                                <td>{{ $user->position }}</td>
                                <td>
                                    <a href="{{ route('admin.participants.info', ['id' => $user->id]) }}" class="action-btn view">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <form action="{{ route('admin.toggleUserStatus', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn {{ $user->is_active ? 'disable' : 'enable' }}">
                                            <i class="bi bi-toggle-{{ $user->is_active ? 'on' : 'off' }}"></i> {{ $user->is_active ? 'Disable' : 'Enable' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function searchUsers() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toUpperCase();
    const table = document.querySelector('.table-container table');
    const tr = table.getElementsByTagName('tr');
    const activeTab = document.querySelector('.tab-button.active').id;
    const statusFilter = activeTab === 'active-tab' ? 'Active' : 'Inactive';

    for (let i = 1; i < tr.length; i++) {
        const nameCell = tr[i].getElementsByTagName('td')[1]; // Name column
        const statusCell = tr[i].getElementsByTagName('td')[0]; // Status column
        
        if (nameCell && statusCell) {
            const nameValue = nameCell.textContent || nameCell.innerText;
            const statusText = statusCell.textContent || statusCell.innerText;
            
            // Only search within the current tab's status (active or inactive)
            if (statusText.includes(statusFilter)) {
                if (nameValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = '';
                } else {
                    tr[i].style.display = 'none';
                }
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
}

function sortUsers() {
    const select = document.getElementById('sort-by');
    const position = select.value;
    const table = document.querySelector('.table-container table');
    const tr = Array.from(table.getElementsByTagName('tr')).slice(1); // Skip header row
    const activeTab = document.querySelector('.tab-button.active').id;
    const statusFilter = activeTab === 'active-tab' ? 'Active' : 'Inactive';

    tr.forEach(row => {
        const userPosition = row.getElementsByTagName('td')[2].textContent; // Position column
        const statusText = row.getElementsByTagName('td')[0].textContent; // Status column
        
        // Only sort within the current tab's status (active or inactive)
        if (statusText.includes(statusFilter)) {
            if (position === 'all' || userPosition.trim() === position.trim()) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        } else {
            row.style.display = 'none';
        }
    });
}

function filterUsersByStatus(status) {
    // Update active tab
    document.getElementById('active-tab').classList.remove('active');
    document.getElementById('inactive-tab').classList.remove('active');
    document.getElementById(status + '-tab').classList.add('active');
    
    // Filter table rows
    const table = document.querySelector('.table-container table');
    const tr = table.getElementsByTagName('tr');
    
    for (let i = 1; i < tr.length; i++) {
        const statusCell = tr[i].getElementsByTagName('td')[0];
        if (statusCell) {
            const statusText = statusCell.textContent.trim();
            if ((status === 'active' && statusText.includes('Active')) || 
                (status === 'inactive' && statusText.includes('Inactive'))) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
    
    // Reset search and sort when switching tabs
    document.getElementById('searchInput').value = '';
    document.getElementById('sort-by').value = 'all';
}

        function filterUsersByStatus(status) {
    // Update active tab
    document.getElementById('active-tab').classList.remove('active');
    document.getElementById('inactive-tab').classList.remove('active');
    document.getElementById(status + '-tab').classList.add('active');
    
    // Filter table rows
    const table = document.querySelector('.table-container table');
    const tr = table.getElementsByTagName('tr');
    
    for (let i = 1; i < tr.length; i++) {
        const statusCell = tr[i].getElementsByTagName('td')[0];
        if (statusCell) {
            const statusText = statusCell.textContent.trim();
            if ((status === 'active' && statusText.includes('Active')) || 
                (status === 'inactive' && statusText.includes('Inactive'))) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
}

// Initialize to show only active users when page loads
document.addEventListener('DOMContentLoaded', function() {
    filterUsersByStatus('active');
});
    </script>
</body>
</html>

