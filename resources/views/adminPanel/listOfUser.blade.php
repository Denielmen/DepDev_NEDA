
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
        }

        .navbar {
            background-color: rgb(255, 255, 255);
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
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            font-size: 0.9rem;
        }

        .sidebar a:hover {
            background-color: #004080;
        }
    </style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Select all buttons with the class 'btn-success' (Enable) and 'btn-secondary' (Disable)
        const buttons = document.querySelectorAll("button");

        buttons.forEach(button => {
            button.addEventListener("click", function () {
                // Check if the button is 'Enable' or 'Disable'
                if (this.classList.contains("btn-success")) {
                    this.classList.remove("btn-success");
                    this.classList.add("btn-secondary");
                    this.innerHTML = '<i class="bi bi-toggle-off"></i> Disable'; // Change text and icon
                    this.closest("tr").querySelector(".status-indicator").classList.remove("inactive");
                    this.closest("tr").querySelector(".status-indicator").classList.add("active");
                } else if (this.classList.contains("btn-secondary")) {
                    this.classList.remove("btn-secondary");
                    this.classList.add("btn-success");
                    this.innerHTML = '<i class="bi bi-toggle-on"></i> Enable'; // Change text and icon
                    this.closest("tr").querySelector(".status-indicator").classList.remove("active");
                    this.closest("tr").querySelector(".status-indicator").classList.add("inactive");
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
    <nav class="navbar navbar-expand-lg">
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
            <a href="{{ route('admin.home') }}" class="active"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('admin.training-plan') }}"><i class="bi bi-calendar-check me-2"></i>Training Plan</a>
            <a href="{{ route('admin.participants') }}"><i class="bi bi-people me-2"></i>List of Participants</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Reports</a>
        </div>

        <!-- Main Content -->
        <div class="main-content" style="padding: 20px; flex-grow: 1;">
            <div class="table-container" style="background-color: #f8f9fa; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <h2 style="margin-bottom: 20px;">List of Staffs</h2>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>User ID</th>
                            <th>Position</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Smith</td>
                            <td>2023035084</td>
                            <td>Administrative</td>
                            <td>
                                <button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</button>
                                <button class="btn btn-secondary btn-sm"><i class="bi bi-toggle-off"></i> Disable</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Jane Doe</td>
                            <td>2024045509</td>
                            <td>Manager</td>
                            <td>
                                <button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</button>
                                <button class="btn btn-success btn-sm"><i class="bi bi-toggle-on"></i> Enable</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


