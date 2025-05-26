<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Status Learning and Development Intervention</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        html, body {
            height: 100%;
            overflow: hidden;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color:rgb(255, 255, 255);
            padding: 0.5rem 1rem;
            box-shadow: 1px 3px 3px 0px #737373;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1040;
        }
        .navbar-brand {
            color:  #003366 !important;
            font-size: 1rem;
            display: flex;
            align-items: center;
            font-weight: bold;
        }
        .navbar-brand img {
            height: 30px;
            margin-right: 10px;
        }
        .nav-link, .user-menu {
            color: black !important;
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
        .sidebar a:hover, .sidebar a.active {
            background-color: #004080;
            font-weight: bold;
        }
        .main-content {
            margin-left: 270px;
            margin-top: 56px;
            height: calc(100vh - 56px);
            overflow-y: auto;
            background-color: rgb(187, 219, 252);
            padding: 20px 0;
            width: calc(100vw - 270px);
        }
        .form-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding-bottom: 50px;
        }
        .back-button {
            text-decoration: none;
            color: #003366;
            display: inline-flex;
            align-items: center;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .back-button:hover {
            color: #004080;
        }
        .form-title {
            background-color: #e6f3ff;
            padding: 15px;
            margin: -20px -20px 20px -20px;
            border-radius: 8px 8px 0 0;
            color: #003366;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .form-control {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 0.5rem;
        }
        .date-range {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .upload-box {
            border: 2px dashed #ced4da;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
        }
        .upload-box:hover {
            border-color: #003366;
        }
        .btn-save {
            background-color: #003366;
            color: white;
            padding: 8px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-save:hover {
            background-color: #004080;
        }
        .text-muted {
            color: #6c757d;
            font-size: 0.8rem;
        }
        input[type="date"] {
            width: 160px;
            min-width: 0;
        }
        .submission-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 2px solid #2d4739;
            background: #fff;
            color: #2d4739;
            border-radius: 6px;
            padding: 18px 28px;
            font-size: 1.1rem;
            cursor: pointer;
            min-width: 110px;
            transition: background 0.2s, color 0.2s, border 0.2s;
        }
        .submission-btn:hover, .submission-btn.active {
            background: #e6f3ee;
            color: #1b2e23;
            border-color: #1b2e23;
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/images/DEPDev_logo.png" alt="NEDA Logo">
                DEPDEV Learning and Development Database System Region VII
            </a>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <div class="user-menu" data-bs-toggle="dropdown" style="cursor:pointer;">
                        <i class="bi bi-person-circle"></i>
                        {{ auth()->user()->last_name ?? 'User' }}
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

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar" style="top: 56px;">
            <a href="{{ route('home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('training.profile') }}"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
            <a href="{{ route('tracking') }}" class="active"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
            <a href="{{ route('training.effectivenesss') }}"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
            <a href="{{ route('training.resources') }}"><i class="bi bi-archive me-2"></i>Training Resources</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div style="max-width: 1040px; margin: 0 auto;">
                <div class="form-container">
                    <div class="form-title">
                        Training Tracking & History
                    </div>

                    <form action="{{ route('tracking.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label">Title of the Training:</label>
                                <input type="text" class="form-control" name="training_title" required>
                            </div>
                            
                            <div class="col-md-6 form-group">
                                <label class="form-label">Aligned Training:</label>
                                <select id="alignedTraining" name="courseTitle" class="form-control" required>
                                    <option value="" disabled selected>Select aligned training</option>
                                    @foreach($programmedTrainings as $training)
                                        <option value="{{ $training->id }}">{{ $training->title }}</option>
                                    @endforeach
                                    <option value="other">Others</option>
                                </select>
                                <input type="text" id="otherTrainingTitle" name="other_training_title" class="form-control mt-2" style="display:none;" placeholder="Enter training title">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 form-group">
                                <label class="form-label">Competency:</label>
                                <input type="text" class="form-control" name="competency" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="form-label">Role:</label>
                                <select id="role" name="role" class="form-control" required>
                                    <option value="" disabled selected>Select Role</option>
                                    <option value="Course 1">Participant</option>
                                    <option value="Course 2">Resource Person</option>
                            
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="form-label">No. of Hours:</label>
                                <input type="text" class="form-control" name="hours" placeholder="1000hrs" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="form-label">Actual Expenses:</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" class="form-control" name="expenses" required>
                                </div>
                            </div> 
                            <div class="col-md-4 form-group">
                                <label class="form-label">Date of Attendance:</label>
                                <div class="date-range">
                                    <input type="date" class="form-control" name="date_from" id="date_from" required onchange="updateDateTo()">
                                    <span>To:</span>
                                    <input type="date" class="form-control" name="date_to" id="date_to" required readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Conducted/Sponsored by/Learning Services Provider:</label>
                            <input type="text" class="form-control" name="provider" required>
                        </div>

                        <div class="submission-types mb-4">
                            <label class="form-label">Choose a submission type</label>
                            <div class="d-flex gap-3">
                                <!-- Upload Button -->
                                <button type="button" class="submission-btn" id="uploadBtn">
                                    <i class="bi bi-upload" style="font-size: 2rem;"></i>
                                    <div>Upload</div>
                                </button>
                                <!-- Link Button -->
                                <button type="button" class="submission-btn" id="linkBtn">
                                    <i class="bi bi-link-45deg" style="font-size: 2rem;"></i>
                                    <div>Text</div>
                                </button>
                            </div>
                        </div>
                        <!-- Hidden actual inputs -->
                        <input type="file" name="uploaded_file[]" id="fileInput" style="display:none;" multiple>
                        <input type="text" name="web_url" id="linkInput" class="form-control mt-2" style="display:none;" placeholder="Paste your link here">
                        <!-- File/Image Preview -->
                        <div id="filePreview" style="margin-top: 15px;"></div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn-save">Save</button>
                        </div>
                    </form>

                    @isset($learning_note)
                    <div class="mt-4">
                        <label class="form-label">Note/Description (with clickable links):</label>
                        <div style="background:#f8f9fa; border-radius:4px; padding:12px;">
                            {!! preg_replace('/(https?:\/\/[^\s]+)/', '<a href="$1" target="_blank">$1</a>', e($learning_note)) !!}
                        </div>
                    </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateDateTo() {
            const dateFromInput = document.getElementById('date_from');
            const dateToInput = document.getElementById('date_to');
            
            if (dateFromInput.value) {
                const dateFrom = new Date(dateFromInput.value);
                const dateTo = new Date(dateFrom);
                dateTo.setFullYear(dateFrom.getFullYear() + 3);
                
                // Format the date to YYYY-MM-DD
                const formattedDate = dateTo.toISOString().split('T')[0];
                dateToInput.value = formattedDate;
            } else {
                dateToInput.value = '';
            }
        }

        // Prepare all programmed trainings as a JS object
        const trainings = @json($programmedTrainings->keyBy('id'));
        document.getElementById('alignedTraining').addEventListener('change', function() {
            const selectedId = this.value;
            if (selectedId === 'other') {
                document.getElementById('otherTrainingTitle').style.display = 'block';
            } else {
                document.getElementById('otherTrainingTitle').style.display = 'none';
                const training = trainings[selectedId];
                if (training) {
                    document.querySelector('input[name="competency"]').value = training.competency || '';
                    document.querySelector('input[name="hours"]').value = training.no_of_hours || '';
                    document.querySelector('input[name="provider"]').value = training.provider || '';
                }
            }
        });

        document.getElementById('uploadBtn').onclick = function() {
            document.getElementById('fileInput').click();
            this.classList.add('active');
            document.getElementById('linkBtn').classList.remove('active');
            document.getElementById('linkInput').style.display = 'none';
        };
        document.getElementById('linkBtn').onclick = function() {
            document.getElementById('linkInput').style.display = 'block';
            this.classList.add('active');
            document.getElementById('uploadBtn').classList.remove('active');
        };

        // File/Image Preview Logic with Remove (X) Button
        let selectedFiles = [];

        document.getElementById('fileInput').addEventListener('change', function(event) {
            selectedFiles = Array.from(event.target.files);
            renderPreviews();
        });

        function renderPreviews() {
            const preview = document.getElementById('filePreview');
            preview.innerHTML = '';
            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const container = document.createElement('div');
                    container.style.display = 'flex';
                    container.style.alignItems = 'center';
                    container.style.marginBottom = '10px';

                    // X button
                    const removeBtn = document.createElement('button');
                    removeBtn.innerHTML = '&times;';
                    removeBtn.style.marginRight = '10px';
                    removeBtn.style.background = 'transparent';
                    removeBtn.style.border = 'none';
                    removeBtn.style.color = 'red';
                    removeBtn.style.fontSize = '1.5rem';
                    removeBtn.style.cursor = 'pointer';
                    removeBtn.onclick = function() {
                        selectedFiles.splice(index, 1);
                        renderPreviews();
                    };
                    container.appendChild(removeBtn);

                    // Image preview (if image)
                    if (file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '50px';
                        img.style.height = '50px';
                        img.style.objectFit = 'cover';
                        img.style.marginRight = '10px';
                        container.appendChild(img);
                    }
                    // File name (with ellipsis for long names)
                    const name = document.createElement('span');
                    name.textContent = file.name.length > 20 ? file.name.slice(0, 10) + '...' + file.name.slice(-7) : file.name;
                    name.style.marginRight = '10px';
                    container.appendChild(name);
                    // File size
                    const size = document.createElement('span');
                    size.textContent = Math.round(file.size / 1024) + ' KB';
                    size.style.marginRight = '10px';
                    container.appendChild(size);
                    // Success icon
                    const icon = document.createElement('span');
                    icon.innerHTML = '<span style="color:green; font-size: 1.2rem;">&#10004;</span>';
                    container.appendChild(icon);

                    preview.appendChild(container);
                };
                reader.readAsDataURL(file);
            });
            updateFileInput();
        }

        function updateFileInput() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            document.getElementById('fileInput').files = dataTransfer.files;
        }
    </script>
</body>
</html>