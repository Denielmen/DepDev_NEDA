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
        .submission-large {
            min-width: 220px;
            min-height: 120px;
            font-size: 1.1rem;
            padding: 18px 18px;
            border-width: 2px;
            margin-bottom: 10px;
        }
        .submission-flex {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 40px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .submission-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1 1 260px;
            min-width: 260px;
            max-width: 320px;
        }
        .submission-or {
            align-self: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #003366;
            margin: 0 10px;
        }
        .submission-btn i {
            font-size: 2.5rem;
            margin-bottom: 8px;
        }
        .submission-desc {
            font-size: 1rem;
            color: #6c757d;
            text-align: center;
            margin-bottom: 0;
        }
        .submission-cert-row {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }
        .hidden {
            display: none;
        }
        @media (max-width: 900px) {
            .submission-flex {
                flex-direction: column;
                align-items: stretch;
                gap: 20px;
            }
            .submission-or {
                margin: 10px 0;
            }
            .submission-cert-row {
                margin-top: 20px;
            }
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
            <a href="{{ route('user.home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('user.training.profile') }}"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
            <a href="{{ route('user.tracking') }}" class="active"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
            <a href="{{ route('user.training.effectivenesss') }}"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
            <a href="{{ route('user.training.resources') }}"><i class="bi bi-archive me-2"></i>Training Resources</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div style="max-width: 1040px; margin: 0 auto;">
            <div class="form-container">
                <div class="form-title">
                        Training Tracking & History
                </div>

                    <form action="{{ route('user.tracking.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Aligned Training:</label>
                            <select id="alignedTraining" name="courseTitle" class="form-control" required>
                                <option value="" disabled selected>Select aligned training</option>
                                @foreach($programmedTrainings as $training)
                                    <option value="{{ $training->id }}">{{ $training->title }}</option>
                                @endforeach
                                <option value="other">Others</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 form-group">
                            <label class="form-label">Title of the Training:</label>
                            <input type="text" class="form-control" name="training_title" required>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-8 form-group">
                            <label class="form-label">Competency:</label><select id="competency" class="form-control @error('competency_id') is-invalid @enderror" name="competency_id" required>
                     <option value="">Select Competency</option>
                           @foreach($competencies as $competency)
                           <option value="{{ $competency->id }}" {{ old('competency_id') == $competency->id ? 'selected' : '' }}>
                              {{ $competency->name }}
            </option>
            @endforeach
    </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="form-label">Role:</label>
                            <select id="role" name="participation_type_id" class="form-control" required>
                                <option value="" disabled selected>Select Role</option>
                                @foreach($participationTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="form-label">No. of Hours:</label>
                            <input type="number" class="form-control" name="no_of_hours" placeholder="hours" required>
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
                                <input type="date" class="form-control" name="implementation_date_from" id="implementation_date_from" required>
                                <span>To:</span>
                                <input type="date" class="form-control" name="implementation_date_to" id="implementation_date_to" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Conducted/Sponsored by/Learning Services Provider:</label>
                        <input type="text" class="form-control" name="provider" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label mb-2">Choose a submission type</label>
                        <div class="d-flex justify-content-center flex-wrap gap-3">
                            <div class="submission-col">
                                <label for="uploadMaterials" class="submission-btn submission-large" id="uploadMaterialsLabel">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                    Upload Training Materials
                                </label>
                                <input type="file" id="uploadMaterials" name="uploadMaterials" accept="image/jpeg,image/png,application/pdf" style="display: none;">
                                <p class="submission-desc">Accepted file types: pdf, png, jpg, jpeg</p>
                                <p class="submission-desc">Max file size: 50 MB</p>
                            </div>
                            <div class="submission-col">
                                <label for="linkMaterials" class="submission-btn submission-large" id="linkMaterialsLabel">
                                    <i class="bi bi-link-45deg"></i>
                                    Paste Link of Training Materials
                                </label>
                                <input type="text" id="linkMaterials" name="linkMaterials" class="form-control mt-2" placeholder="Paste your link here" style="display: none;">
                                <p class="submission-desc mt-2">Accepted file types: pdf, png, jpg, jpeg</p>
                                <p class="submission-desc">Max file size: 50 MB</p>
                            </div>
                            <div class="submission-col">
                                <label for="uploadCertificates" class="submission-btn submission-large" id="uploadCertificatesLabel">
                                    <i class="bi bi-file-earmark-check"></i>
                                    Upload Training Certificates
                                </label>
                                <input type="file" id="uploadCertificates" name="uploadCertificates" accept="image/jpeg,image/png,application/pdf" style="display: none;">
                                <p class="submission-desc">Accepted file types: pdf, png, jpg, jpeg</p>
                                <p class="submission-desc">Max file size: 50 MB</p>
                            </div>
                        </div>
                        <div id="filePreview" class="mt-3"></div>
                        <div id="certPreview" class="mt-3"></div>
                    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>;
    <script>
        function updateDateTo() {
            const dateFromInput = document.getElementById('implementation_date_from');
            const dateToInput = document.getElementById('implementation_date_to');
            if (dateFromInput.value) {
                const dateFrom = new Date(dateFromInput.value);
                const dateTo = new Date(dateFrom);
                dateTo.setDate(dateFrom.getDate() + 2);

                // Format the date to YYYY-MM-DD
                const formattedDate = dateTo.toISOString().split('T')[0];
                dateToInput.value = formattedDate;
            } else {
                dateToInput.value = '';
            }
        }

        // Prepare all programmed trainings as a JS object
      const trainings = @json($programmedTrainings->keyBy('id'));

const alignedTraining = document.getElementById('alignedTraining');
const mainTitleInput = document.querySelector('input[name="training_title"]');
const competencySelect = document.querySelector('select[name="competency_id"]');
const hoursInput = document.querySelector('input[name="no_of_hours"]');
const expensesInput = document.querySelector('input[name="expenses"]');
const dateFromInput = document.querySelector('input[name="implementation_date_from"]');
const dateToInput = document.querySelector('input[name="implementation_date_to"]');
const providerInput = document.querySelector('input[name="provider"]');
const roleSelect = document.querySelector('select[name="participation_type_id"]');

alignedTraining.addEventListener('change', function() {
    const selectedId = this.value;
    if (selectedId === 'other') {
        mainTitleInput.value = '';
        mainTitleInput.readOnly = false;
        // Clear autofilled fields
        competencySelect.value = '';
        hoursInput.value = '';
        expensesInput.value = '';
        dateFromInput.value = '';
        dateToInput.value = '';
        providerInput.value = '';
        roleSelect.value = '';
    } else {
        const training = trainings[selectedId];
        if (training) {
            mainTitleInput.value = training.title || '';
            mainTitleInput.readOnly = true;
            competencySelect.value = training.competency_id || '';
            hoursInput.value = training.no_of_hours || '';
            expensesInput.value = training.budget || '';
            dateFromInput.value = training.implementation_date_from || '';
            dateToInput.value = training.implementation_date_to || '';
            providerInput.value = training.provider || '';
            roleSelect.value = 'Course 1'; // Default to Participant, adjust as needed
        }
    }
});

        document.getElementById('uploadMaterialsLabel').onclick = function() {
            document.getElementById('uploadMaterials').click();
            this.classList.add('active');
            document.getElementById('linkMaterials').style.display = 'none';
            document.getElementById('linkMaterialsLabel').classList.remove('active');
            document.getElementById('uploadCertificatesLabel').classList.remove('active');
        };
        document.getElementById('linkMaterialsLabel').onclick = function() {
            console.log('Paste Link button clicked!');
            document.getElementById('linkMaterials').style.display = 'block';
            this.classList.add('active');
            document.getElementById('uploadMaterialsLabel').classList.remove('active');
            document.getElementById('uploadCertificatesLabel').classList.remove('active');
        };
        document.getElementById('uploadCertificatesLabel').onclick = function() {
            document.getElementById('uploadCertificates').click();
            this.classList.add('active');
            document.getElementById('linkMaterials').style.display = 'none';
            document.getElementById('linkMaterialsLabel').classList.remove('active');
            document.getElementById('uploadMaterialsLabel').classList.remove('active');
        };

        // File/Image Preview Logic with Remove (X) Button
        let selectedFiles = [];

        document.getElementById('uploadMaterials').addEventListener('change', function(event) {
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
            document.getElementById('uploadMaterials').files = dataTransfer.files;
        }

        // Certificate file preview logic (optional, similar to filePreview)
        let selectedCertFiles = [];
        document.getElementById('uploadCertificates').addEventListener('change', function(event) {
            selectedCertFiles = Array.from(event.target.files);
            renderCertPreviews();
        });

        function renderCertPreviews() {
            const preview = document.getElementById('certPreview');
            preview.innerHTML = '';
            selectedCertFiles.forEach((file, index) => {
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
                        selectedCertFiles.splice(index, 1);
                        renderCertPreviews();
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
            updateCertInput();
        }

        function updateCertInput() {
            const dataTransfer = new DataTransfer();
            selectedCertFiles.forEach(file => dataTransfer.items.add(file));
            document.getElementById('uploadCertificates').files = dataTransfer.files;
        }
    </script>
</body>
</html>
