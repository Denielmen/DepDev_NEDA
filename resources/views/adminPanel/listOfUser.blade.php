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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #003366; /* Dark blue background */
            padding: 10px;
            text-align: center; /* This centers the text */
            border: 1px solid #ddd;
        }

        td {
            padding: 10px;
            text-align: center; /* This centers the text */
            border: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f1f1f1; /* Optional: Highlight row on hover */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            padding-top: 60px;
        }

        .navbar {
            background-color: rgb(255, 255, 255);
            padding: 0.5rem 1rem;
            box-shadow: 1px 3px 3px 0px #737373;
        }

        .navbar-brand {
            color: #003366 !important;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            height: 30px;
            margin-right: 10px;
        }

        .sidebar {
            background-color: #003366;
            min-height: calc(100vh - 56px);
            width: 270px;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 56px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            font-size: 0.9rem;
        }
        .sidebar a.active, .sidebar a:focus {
            background-color: #004080;
            /* background-color: #e7f1ff;
            color: #003366;
            font-weight: bold; */
        }
        .sidebar a:hover {
            background-color: #004080;
            color: #fff;
        }
        .main-content {
            background: #fff; 
            min-height: calc(100vh - 56px);
            margin-left: 270px; /* Match sidebar width */
            width: calc(100% - 270px);
            background-color: rgb(187, 219, 252);
        }
        .list-title{
            background-color: #e7f1ff;
            margin-bottom: 20px;
            border-radius: 5px;
            margin-left: 40px;
            margin-right: 40px;
            margin-top: 40px;
            padding: 15px 20px;
        }
        .list-title h2 {
            color: #003366;
            font-size: 1.5rem;
            margin: 0;
            font-weight: bold;
        }
        .user-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 30px 30px 20px 30px;
            margin: 0 40px;
        }
        .user-card-header {
            font-size: 1.6rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            color: #003366;
        }
        .new-user-btn {
            background: #003366;
            color: #fff;
            border: none;
            cursor: pointer;
            text-transform: uppercase;
            border-radius: 5px;
            padding: 6px 18px;
            font-size: 0.95rem;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        .new-user-btn:hover {
            background: #c6e0ff;
            color: #003366;
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
            margin-top: 10px;
            background: none;
            box-shadow: none;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        thead th {
            background: #003366 !important;
            color: #fff;
            font-weight: bold;
            border-bottom: 2px solid #b5d1fa;
            font-size: 1.05rem;
        }
        tbody tr {
            background: #fff;
            transition: background 0.2s;
        }
        tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        td, th {
            padding: 12px 10px;
            text-align: center;
            border: 1px solid #e7f1ff;
        }
        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 10px;
        }
        .status-indicator.active {
            background-color: #2ecc40;
        }
        .status-indicator.inactive {
            background-color: #bdbdbd;
        }
        .action-btn {
            border: 1px solid #003366;
            background: #fff;
            color: #003366;
            border-radius: 4px;
            padding: 3px 10px;
            font-size: 0.95rem;
            margin-right: 4px;
            transition: background 0.2s, color 0.2s;
        }
        .action-btn:last-child {
            margin-right: 0;
        }
        .action-btn.edit {
            border-color: #003366;
        }
        .action-btn.enable {
            border-color: #2ecc40;
            color: #2ecc40;
        }
        .action-btn.disable {
            border-color: #bdbdbd;
            color: #bdbdbd;
        }
        .action-btn.edit:hover {
            background: #e7f1ff;
        }
        .action-btn.enable:hover {
            background: #eafbe7;
        }
        .action-btn.disable:hover {
            background: #f3f3f3;
        }
        .action-btn.view {
            border-color: #003366;
            color: #003366;
            text-decoration: none;
        }
        .action-btn.view:hover {
            background: #e7f1ff;
            text-decoration: none;
        }

    </style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Toggle Enable/Disable button and status dot
        document.querySelectorAll('.toggle-status').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const isEnable = btn.classList.contains('enable');
                const row = btn.closest('tr');
                const statusDot = row.querySelector('.status-indicator');
                const statusText = row.querySelector('.status-text');
                
                if (isEnable) {
                    // Change to Disable
                    btn.classList.remove('enable');
                    btn.classList.add('disable');
                    btn.innerHTML = '<i class="bi bi-toggle-off"></i> Disable';
                    statusDot.classList.remove('active');
                    statusDot.classList.add('inactive');
                    statusText.textContent = 'Inactive';
                } else {
                    // Change to Enable
                    btn.classList.remove('disable');
                    btn.classList.add('enable');
                    btn.innerHTML = '<i class="bi bi-toggle-on"></i> Enable';
                    statusDot.classList.remove('inactive');
                    statusDot.classList.add('active');
                    statusText.textContent = 'Active';
                }
            });
        });
        // Role filter functionality
        const sortByDropdown = document.getElementById("sort-by");
        const tableBody = document.querySelector(".table-container table tbody");

        // Listen for dropdown selection changes
        sortByDropdown.addEventListener("change", function () {
            const rows = Array.from(tableBody.querySelectorAll("tr")); // Convert rows to an array
            const selectedRole = this.value.trim(); // Get the selected option value

            // Filter rows based on the selected role
            rows.forEach(row => {
                const roleCell = row.querySelector("td:nth-child(3)"); // Get the role column (3rd column)
                
                if (roleCell) { // Ensure roleCell exists
                    const role = roleCell.textContent.trim().toLowerCase(); // Get the role text and normalize it

                    // Show or hide rows based on selected role
                    if (selectedRole === "all-role" || role === selectedRole.toLowerCase()) {
                        row.style.display = ""; // Show row
                    } else {
                        row.style.display = "none"; // Hide row
                    }
                }
            });
        });
    });
</script>

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/images/neda-logo.png" alt="NEDA Logo">
                DEPDEV Learning and Development Database System Region VII
            </a>
            <div class="d-flex align-items-center">
                <i class="bi bi-bell-fill me-3 user-icon"></i>
                <div class="dropdown">
                    <div class="user-menu" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        Admin
                        <i class="bi bi-chevron-down ms-1"></i>
                    </div>
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
        </div>
        <!-- Main Content -->
        <div class="main-content">
            <div class="list-title"><h2>List of Staffs</h2></div>
            <div class="user-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <button class="new-user-btn"><i class="bi bi-person-plus-fill"></i> + NEW USER</button>
                    <div class="search-box">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" placeholder="Search...">
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-2">
                    <label for="sort-by" class="me-2">Sort by</label>
                    <select id="sort-by" class="form-select" style="width: 120px; display: inline-block;">
                        <option value="all-role">All role</option>
                        <option value="supervisor">Supervisor</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <span class="status-indicator active"></span>
                                    <span class="status-text">Active</span>
                                </td>
                                <td>John Smith</td>
                                <td>Administrative</td>
                                <td>
                                    <a href="{{ route('admin.participants.info', ['id' => 1]) }}" class="action-btn view">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <button class="action-btn edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button class="action-btn enable toggle-status">
                                        <i class="bi bi-toggle-on"></i> Enable
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="status-indicator inactive"></span>
                                    <span class="status-text">Inactive</span>
                                </td>
                                <td>John Doe</td>
                                <td>Administrative Assistant</td>
                                <td>
                                    <a href="{{ route('admin.participants.info', ['id' => 1]) }}" class="action-btn view">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <button class="action-btn edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button class="action-btn enable toggle-status">
                                        <i class="bi bi-toggle-on"></i> Enable
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="status-indicator inactive"></span>
                                    <span class="status-text">Inactive</span>
                                </td>
                                <td>Jane Watson</td>
                                <td>Supervisor</td>
                                <td>
                                    <a href="{{ route('admin.participants.info', ['id' => 1]) }}" class="action-btn view">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <button class="action-btn edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button class="action-btn enable toggle-status">
                                        <i class="bi bi-toggle-on"></i> Enable
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="status-indicator inactive"></span>
                                    <span class="status-text">Inactive</span>
                                </td>
                                <td>Sophia Walter</td>
                                <td>Supervisor</td>
                                <td>
                                    <a href="{{ route('admin.participants.info', ['id' => 1]) }}" class="action-btn view">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <button class="action-btn edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button class="action-btn enable toggle-status">
                                        <i class="bi bi-toggle-on"></i> Enable
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="status-indicator inactive"></span>
                                    <span class="status-text">Inactive</span>
                                </td>
                                <td>Peter Parker</td>
                                <td>User</td>
                                <td>
                                    <a href="{{ route('admin.participants.info', ['id' => 1]) }}" class="action-btn view">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <button class="action-btn edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button class="action-btn enable toggle-status">
                                        <i class="bi bi-toggle-on"></i> Enable
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



 