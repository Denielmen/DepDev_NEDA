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
        html,
        body {
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
            background-color: rgb(255, 255, 255);
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

        .nav-link,
        .user-menu {
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

        .submission-btn:hover,
        .submission-btn.active {
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
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
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
                            <a href="{{ route('user.profile.info') }}" class="dropdown-item">
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

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar" style="top: 56px;">
            <a href="{{ route('user.home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('user.training.profile') }}"><i class="bi bi-person-vcard me-2"></i>Individual Training Profile</a>
            <a href="{{ route('user.tracking') }}" class="active"><i class="bi bi-clock-history me-2"></i>Training
                Tracking & History</a>
            <a href="{{ route('user.training.effectiveness') }}"><i class="bi bi-graph-up me-2"></i>Training
                Effectiveness</a>
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
                                <label class="form-label">Related Programmed Traings, if any:</label>
                                <select id="alignedTraining" name="courseTitle" class="form-control" required>
                                    <option value="" disabled selected>Select from list of programmed training activity</option>
                                    @foreach ($programmedTrainings as $training)
                                        @php
                                            $evaluation = $training->evaluations->first();
                                            $hasPreEvaluation = $evaluation && $evaluation->participant_pre_rating !== null;
                                        @endphp
                                        @if(!$hasPreEvaluation)
                                            <option value="{{ $training->id }}" disabled>{{ $training->title }} <span style='color:#dc3545;'>(Pre-Evaluation Required)</span></option>
                                        @else
                                            <option value="{{ $training->id }}">{{ $training->title }}</option>
                                        @endif
                                    @endforeach
                                    <option value="other">Others</option>
                                </select>

                            </div>

                            <div class="col-md-6 form-group">
                                <label class="form-label">Title of the Training Attended:</label>
                                <input type="text" class="form-control" name="training_title" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 form-group">
                                <label class="form-label">Type:</label>
                                <select id="core_competency" name="core_competency" class="form-control" required onchange="toggleClassificationInput()">
                                    <option value="" disabled selected>Select Classification</option>
                                    @foreach ($coreCompetencies as $core)
                                        <option value="{{ $core }}">{{ $core }}</option>
                                    @endforeach
                                </select>
                                <input type="text" class="form-control mt-2" id="core_competency_input" name="core_competency_input"
                                    placeholder="Enter custom classification" style="display: none;">
                            </div>
                            <div class="col-md-8 form-group">
                                <label class="form-label">Competency:</label>
                                <select id="competency" name="competency_id" class="form-control" required onchange="toggleCompetencyInput()">
                                    <option value="" disabled selected>Select Competency</option>
                                    @foreach ($competencies as $competency)
                                        <option value="{{ $competency->id }}">{{ $competency->name }}</option>
                                    @endforeach
                                    <option value="others">Others</option>
                                </select>
                                <input type="text" class="form-control mt-2" id="competency_input" name="competency_input"
                                    placeholder="Enter custom competency" style="display: none;">
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="form-label">Role:</label>
                                <select id="role" name="participation_type_id" class="form-control" required>
                                    <option value="" disabled selected>Select Role</option>
                                    @foreach ($participationTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="form-label">No. of Hours:</label>
                                <input type="number" class="form-control" name="no_of_hours" placeholder="hours"
                                    required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="form-label">Inclusive Date's of Attendance:</label>
                                <div class="date-range">
                                    <input type="date" class="form-control" name="implementation_date_from"
                                        id="implementation_date_from" required>
                                    <span>To:</span>
                                    <input type="date" class="form-control" name="implementation_date_to"
                                        id="implementation_date_to" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Conducted/Sponsored by/Learning Services Provider/Organizer:</label>
                            <input type="text" class="form-control" name="provider" required>
                        </div>

                        <div class="form-group">
                            <label class="mb-2 form-label">Choose a submission type</label>
                            <div class="flex-wrap gap-3 d-flex justify-content-center">
                                <div class="submission-col">
                                    <label for="uploadMaterials" class="submission-btn submission-large"
                                        id="uploadMaterialsLabel">
                                        <i class="bi bi-cloud-arrow-up"></i>
                                        Upload Training Materials
                                    </label>
                                    <input type="file" id="uploadMaterials" name="uploadMaterials[]"
                                        accept="image/jpeg,image/png,application/pdf" style="display: none;" multiple>
                                    <p class="submission-desc">Accepted file types: pdf, png, jpg, jpeg</p>
                                    <p class="submission-desc">Max file size: 50 MB</p>
                                </div>
                                <div class="submission-col">
                                    <label for="linkMaterials" class="submission-btn submission-large"
                                        id="linkMaterialsLabel">
                                        <i class="bi bi-link-45deg"></i>
                                        Paste Link of Training Materials
                                    </label>
                                    <input type="text" id="linkMaterials" name="linkMaterials"
                                        class="mt-2 form-control" placeholder="Paste your link here"
                                        style="display: none;">
                                </div>
                                <div class="submission-col">
                                    <label for="uploadCertificates" class="submission-btn submission-large"
                                        id="uploadCertificatesLabel">
                                        <i class="bi bi-file-earmark-check"></i>
                                        Upload Training Certificates
                                    </label>
                                    <input type="file" id="uploadCertificates" name="uploadCertificates[]"
                                        accept="image/jpeg,image/png,application/pdf" style="display: none;" multiple>
                                    <p class="submission-desc">Accepted file types: pdf, png, jpg, jpeg</p>
                                    <p class="submission-desc">Max file size: 50 MB</p>
                                </div>
                            </div>
                            <div id="filePreview" class="mt-3"></div>
                            <div id="certPreview" class="mt-3"></div>
                        </div>

                        <div class="mt-4 text-center">
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
        document.addEventListener('DOMContentLoaded', function() {
            const alignedTrainingSelect = document.getElementById('alignedTraining');
            const trainingTitleInput = document.querySelector('input[name="training_title"]');
            const competencySelect = document.getElementById('competency');
            const roleSelect = document.getElementById('role');
            const noOfHoursInput = document.querySelector('input[name="no_of_hours"]');
            const expensesInput = document.querySelector('input[name="expenses"]');
            const providerInput = document.querySelector('input[name="provider"]');
            const dateFromInput = document.getElementById('implementation_date_from');
            const dateToInput = document.getElementById('implementation_date_to');
            const uploadMaterialsInput = document.getElementById('uploadMaterials');
            const uploadCertificatesInput = document.getElementById('uploadCertificates');
            const filePreview = document.getElementById('filePreview');
            const certPreview = document.getElementById('certPreview');
            const linkMaterialsLabel = document.getElementById('linkMaterialsLabel');
            const uploadMaterialsLabel = document.getElementById('uploadMaterialsLabel');
            const linkMaterialsInput = document.getElementById('linkMaterials');

            // Store accumulated files
            let accumulatedMaterials = [];
            let accumulatedCertificates = [];

            // Training data fetched from the database
            const trainings = @json($programmedTrainings->items()); // Get the actual training items from pagination
            const competencies = @json($competencies); // Replace with actual data from the backend

            // Validate link input on form submit
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                // Only validate if link input is visible and has a value
                if (linkMaterialsInput.style.display !== 'none' && linkMaterialsInput.value.trim() !== '') {
                    const urlPattern = /^(https?:\/\/)[^\s/$.?#].[^\s]*$/i;
                    if (!urlPattern.test(linkMaterialsInput.value.trim())) {
                        alert('Please enter a valid URL for the training materials link.');
                        linkMaterialsInput.focus();
                        e.preventDefault();
                        return false;
                    }
                }
                // ...existing code...
            });

            // Competencies are already populated by server-side rendering
            // No need to repopulate them via JavaScript

            // Handle training selection
            alignedTrainingSelect.addEventListener('change', function() {
                const selectedTrainingId = this.value;
                const coreCompetencySelect = document.getElementById('core_competency');

                console.log('Selected Training ID:', selectedTrainingId);
                console.log('Available trainings:', trainings);

                if (selectedTrainingId === 'other') {
                    // Clear fields for "Other" selection
                    trainingTitleInput.value = '';
                    competencySelect.value = '';
                    coreCompetencySelect.value = '';
                    roleSelect.value = '';
                    noOfHoursInput.value = '';
                    expensesInput.value = '';
                    providerInput.value = '';
                    dateFromInput.value = '';
                    dateToInput.value = '';

                    // Reset competency input visibility
                    const competencyInput = document.getElementById('competency_input');
                    competencySelect.style.display = 'block';
                    competencyInput.style.display = 'none';
                    competencyInput.required = false;
                    competencyInput.value = '';

                    // Reset classification input visibility
                    const classificationInput = document.getElementById('core_competency_input');
                    coreCompetencySelect.style.display = 'block';
                    classificationInput.style.display = 'none';
                    classificationInput.required = false;
                    classificationInput.value = '';

                    return;
                }

                // Find the selected training
                const selectedTraining = trainings.find(training => training.id == selectedTrainingId);

                console.log('Found training:', selectedTraining);

                if (selectedTraining) {
                    // Populate fields with training data
                    trainingTitleInput.value = selectedTraining.title || '';

                    // Set competency and reset input visibility
                    const competencyInput = document.getElementById('competency_input');

                    if (selectedTraining.competency_id) {
                        // Check if the competency exists in the dropdown
                        const competencyOption = competencySelect.querySelector(`option[value="${selectedTraining.competency_id}"]`);

                        if (competencyOption) {
                            // Standard competency - show dropdown and select it
                            competencySelect.style.display = 'block';
                            competencyInput.style.display = 'none';
                            competencyInput.required = false;
                            competencySelect.value = selectedTraining.competency_id;
                        } else if (selectedTraining.competency && selectedTraining.competency.name) {
                            // Custom competency - show input field with the competency name
                            competencySelect.style.display = 'none';
                            competencyInput.style.display = 'block';
                            competencyInput.required = true;
                            competencyInput.value = selectedTraining.competency.name;
                            competencySelect.value = 'others';
                        }
                    }

                    // Set core competency (classification)
                    const classificationInput = document.getElementById('core_competency_input');

                    if (selectedTraining.core_competency) {
                        // Check if the classification exists in the dropdown
                        const classificationOption = coreCompetencySelect.querySelector(`option[value="${selectedTraining.core_competency}"]`);

                        if (classificationOption) {
                            // Standard classification - show dropdown and select it
                            coreCompetencySelect.style.display = 'block';
                            classificationInput.style.display = 'none';
                            classificationInput.required = false;
                            coreCompetencySelect.value = selectedTraining.core_competency;
                        } else {
                            // Custom classification - show input field with the custom value
                            coreCompetencySelect.style.display = 'none';
                            classificationInput.style.display = 'block';
                            classificationInput.required = true;
                            classificationInput.value = selectedTraining.core_competency;
                            coreCompetencySelect.value = 'Others';
                        }
                    }

                    // Set role (participation type)
                    if (selectedTraining.participants && selectedTraining.participants.length > 0) {
                        const participationTypeId = selectedTraining.participants[0].pivot.participation_type_id;
                        roleSelect.value = participationTypeId;
                    }

                    noOfHoursInput.value = selectedTraining.no_of_hours || '';
                    expensesInput.value = selectedTraining.budget || '';
                    providerInput.value = selectedTraining.provider || '';

                    // Handle dates
                    if (selectedTraining.implementation_date_from) {
                        dateFromInput.value = selectedTraining.implementation_date_from;
                    }
                    if (selectedTraining.implementation_date_to) {
                        dateToInput.value = selectedTraining.implementation_date_to;
                    }

                    console.log('Fields populated successfully');
                } else {
                    console.log('Training not found!');
                }
            });

            // Automatically set "To" date based on "From" date
            dateFromInput.addEventListener('change', function() {
                if (!dateToInput.value) {
                    dateToInput.value = this.value;
                }
            });

            // Function to toggle competency input field
            window.toggleCompetencyInput = function() {
                const competencySelect = document.getElementById('competency');
                const competencyInput = document.getElementById('competency_input');

                if (competencySelect.value === 'others') {
                    competencySelect.style.display = 'none';
                    competencyInput.style.display = 'block';
                    competencyInput.required = true;
                    competencyInput.focus();
                } else {
                    competencySelect.style.display = 'block';
                    competencyInput.style.display = 'none';
                    competencyInput.required = false;
                }
            };

            // Function to toggle classification input field
            window.toggleClassificationInput = function() {
                const classificationSelect = document.getElementById('core_competency');
                const classificationInput = document.getElementById('core_competency_input');

                if (classificationSelect.value === 'Others') {
                    classificationSelect.style.display = 'none';
                    classificationInput.style.display = 'block';
                    classificationInput.required = true;
                    classificationInput.focus();
                } else {
                    classificationSelect.style.display = 'block';
                    classificationInput.style.display = 'none';
                    classificationInput.required = false;
                }
            };
            
            // Helper function to update preview display
            function updatePreviewDisplay(input, previewContainer, accumulatedFiles) {
                // Update the input with accumulated files
                const dataTransfer = new DataTransfer();
                accumulatedFiles.forEach(file => {
                    dataTransfer.items.add(file);
                });
                input.files = dataTransfer.files;

                // Update preview
                previewContainer.innerHTML = ''; // Clear previous previews
                accumulatedFiles.forEach((file, index) => {
                    const fileType = file.type;
                    const fileName = file.name;

                    // Create a preview element
                    const previewElement = document.createElement('div');
                    previewElement.style.marginBottom = '10px';
                    previewElement.style.display = 'flex';
                    previewElement.style.alignItems = 'center';

                    if (fileType.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = URL.createObjectURL(file);
                        img.style.maxWidth = '100px';
                        img.style.marginRight = '10px';
                        previewElement.appendChild(img);
                    }

                    const fileLabel = document.createElement('span');
                    fileLabel.textContent = fileName;
                    fileLabel.style.marginRight = '10px';
                    previewElement.appendChild(fileLabel);

                    // Add remove button
                    const removeBtn = document.createElement('button');
                    removeBtn.textContent = 'Remove';
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-sm btn-danger';
                    removeBtn.onclick = function() {
                        // Remove file from array
                        accumulatedFiles.splice(index, 1);
                        // Update display
                        updatePreviewDisplay(input, previewContainer, accumulatedFiles);
                    };
                    previewElement.appendChild(removeBtn);

                    previewContainer.appendChild(previewElement);
                });
            }
            
            // Function to handle file previews
            function handleFilePreview(input, previewContainer, accumulatedFiles) {
                const files = input.files;

                if (files.length > 0) {
                    // Add new files to accumulated array
                    Array.from(files).forEach(file => {
                        accumulatedFiles.push(file);
                    });
                    
                    // Update display
                    updatePreviewDisplay(input, previewContainer, accumulatedFiles);
                }
            }

            // Event listeners for file inputs
            uploadMaterialsInput.addEventListener('change', function() {
                handleFilePreview(uploadMaterialsInput, filePreview, accumulatedMaterials);
            });

            uploadCertificatesInput.addEventListener('change', function() {
                handleFilePreview(uploadCertificatesInput, certPreview, accumulatedCertificates);
            });

            // Optional: Add validation for file size and type
            const maxFileSize = 50 * 1024 * 1024; // 50 MB
            const allowedFileTypes = ['image/jpeg', 'image/png', 'application/pdf'];

            function validateFiles(input) {
                const files = input.files;
                for (const file of files) {
                    if (!allowedFileTypes.includes(file.type)) {
                        alert(`Invalid file type: ${file.name}`);
                        input.value = ''; // Clear the input
                        return false;
                    }
                    if (file.size > maxFileSize) {
                        alert(`File size exceeds 50 MB: ${file.name}`);
                        input.value = ''; // Clear the input
                        return false;
                    }
                }
                return true;
            }

            uploadMaterialsInput.addEventListener('change', function() {
                validateFiles(uploadMaterialsInput);
            });

            uploadCertificatesInput.addEventListener('change', function() {
                validateFiles(uploadCertificatesInput);
            });

            function hideAllSubmissionFields() {
                uploadMaterialsInput.style.display = 'none';
                linkMaterialsInput.style.display = 'none';
                uploadCertificatesInput.style.display = 'none';
            }
            uploadMaterialsLabel.addEventListener('click', function(e) {
                e.preventDefault();
                uploadMaterialsInput.style.display = '';
                uploadMaterialsInput.click();
                linkMaterialsInput.style.display = 'none';
            });


            // Show link input, hide file upload for materials
            linkMaterialsLabel.addEventListener('click', function(e) {
                e.preventDefault();
                linkMaterialsInput.style.display = '';
                linkMaterialsInput.focus();
                uploadMaterialsInput.style.display = 'none';
            });

            // Optionally, hide link input when user selects a file
            uploadMaterialsInput.addEventListener('change', function() {
                if (uploadMaterialsInput.files.length > 0) {
                    linkMaterialsInput.style.display = 'none';
                }
            });


        });
    </script>
</body>

</html>
