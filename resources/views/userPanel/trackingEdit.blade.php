<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Training Resources - DEPDEV Learning and Development System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
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

        .training-info {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .training-info h5 {
            color: #003366;
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: 600;
            min-width: 150px;
            color: #495057;
        }

        .info-value {
            color: #212529;
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

        .submission-desc {
            font-size: 1rem;
            color: #6c757d;
            text-align: center;
            margin-bottom: 0;
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

        .existing-resources {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .resource-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            margin-bottom: 10px;
            background-color: white;
        }

        .resource-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .resource-icon {
            font-size: 1.5rem;
            color: #003366;
        }

        .resource-details {
            display: flex;
            flex-direction: column;
        }

        .resource-title {
            font-weight: 600;
            color: #003366;
        }

        .resource-type {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .resource-actions {
            display: flex;
            gap: 5px;
        }

        .btn-sm {
            padding: 4px 8px;
            font-size: 0.8rem;
        }

        @media (max-width: 900px) {
            .submission-flex {
                flex-direction: column;
                align-items: stretch;
                gap: 20px;
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
                DEPDEV Learning and Development Database System Region VII
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
            <a href="{{ route('user.training.profile') }}"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
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
                    <a href="{{ route('user.tracking') }}" class="back-button">
                        <i class="bi bi-arrow-left me-2"></i>Back to Training Tracking & History
                    </a>

                    <div class="form-title">
                        Add Training Resources
                    </div>

                    <!-- Training Information -->
                    <div class="training-info">
                        <h5><i class="bi bi-info-circle me-2"></i>Training Information</h5>
                        <div class="info-row">
                            <span class="info-label">Training Title:</span>
                            <span class="info-value">{{ $training->title }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Competency:</span>
                            <span class="info-value">{{ $training->competency->name ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Classification:</span>
                            <span class="info-value">{{ $training->core_competency }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Implementation Date:</span>
                            <span class="info-value">
                                {{ \Carbon\Carbon::parse($training->implementation_date_from)->format('M d, Y') }}
                                @if($training->implementation_date_to && $training->implementation_date_to != $training->implementation_date_from)
                                    - {{ \Carbon\Carbon::parse($training->implementation_date_to)->format('M d, Y') }}
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Provider:</span>
                            <span class="info-value">{{ $training->provider ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <!-- Existing Resources -->
                    @if($materials->count() > 0)
                        <div class="existing-resources">
                            <h5><i class="bi bi-folder2-open me-2"></i>Existing Resources</h5>
                            @foreach($materials as $material)
                                <div class="resource-item">
                                    <div class="resource-info">
                                        <div class="resource-icon">
                                            @if($material->type === 'certificate')
                                                <i class="bi bi-file-earmark-check"></i>
                                            @else
                                                <i class="bi bi-file-earmark-text"></i>
                                            @endif
                                        </div>
                                        <div class="resource-details">
                                            <div class="resource-title">{{ $material->title }}</div>
                                            <div class="resource-type">{{ ucfirst($material->type) }}</div>
                                        </div>
                                    </div>
                                    <div class="resource-actions">
                                        @if($material->file_path)
                                            <a href="{{ route('user.training_materials.download', $material) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-download me-1"></i>Download
                                            </a>
                                        @endif
                                        @if($material->link)
                                            <a href="{{ $material->link }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="bi bi-box-arrow-up-right me-1"></i>View
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Add New Resources Form -->
                    <form action="{{ route('user.tracking.update', $training) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label class="mb-2 form-label">Add New Resources</label>
                            <div class="submission-flex">
                                <div class="submission-col">
                                    <label for="uploadMaterials" class="submission-btn submission-large" id="uploadMaterialsLabel">
                                        <i class="bi bi-cloud-arrow-up"></i>
                                        Upload Training Materials
                                    </label>
                                    <input type="file" id="uploadMaterials" name="uploadMaterials[]"
                                        accept="image/jpeg,image/png,application/pdf" style="display: none;">
                                    <p class="submission-desc">Accepted file types: pdf, png, jpg, jpeg</p>
                                    <p class="submission-desc">Max file size: 50 MB</p>
                                </div>
                                <div class="submission-col">
                                    <label for="linkMaterials" class="submission-btn submission-large" id="linkMaterialsLabel">
                                        <i class="bi bi-link-45deg"></i>
                                        Paste Link of Training Materials
                                    </label>
                                    <input type="text" id="linkMaterials" name="linkMaterials"
                                        class="mt-2 form-control" placeholder="Paste your link here"
                                        style="display: none;">
                                </div>
                                <div class="submission-col">
                                    <label for="uploadCertificates" class="submission-btn submission-large" id="uploadCertificatesLabel">
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
                            <button type="submit" class="btn-save">Save Resources</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadMaterialsInput = document.getElementById('uploadMaterials');
            const uploadCertificatesInput = document.getElementById('uploadCertificates');
            const filePreview = document.getElementById('filePreview');
            const certPreview = document.getElementById('certPreview');
            const linkMaterialsLabel = document.getElementById('linkMaterialsLabel');
            const uploadMaterialsLabel = document.getElementById('uploadMaterialsLabel');
            const linkMaterialsInput = document.getElementById('linkMaterials');

            // Function to handle file previews
            function handleFilePreview(input, previewContainer) {
                previewContainer.innerHTML = ''; // Clear previous previews
                const files = input.files;

                if (files.length > 0) {
                    Array.from(files).forEach(file => {
                        const fileType = file.type;
                        const fileName = file.name;

                        // Create a preview element
                        const previewElement = document.createElement('div');
                        previewElement.style.marginBottom = '10px';

                        if (fileType.startsWith('image/')) {
                            const img = document.createElement('img');
                            img.src = URL.createObjectURL(file);
                            img.style.maxWidth = '100px';
                            img.style.marginRight = '10px';
                            previewElement.appendChild(img);
                        }

                        const fileLabel = document.createElement('span');
                        fileLabel.textContent = fileName;
                        previewElement.appendChild(fileLabel);

                        previewContainer.appendChild(previewElement);
                    });
                }
            }

            // Event listeners for file inputs
            uploadMaterialsInput.addEventListener('change', function() {
                handleFilePreview(uploadMaterialsInput, filePreview);
            });

            uploadCertificatesInput.addEventListener('change', function() {
                handleFilePreview(uploadCertificatesInput, certPreview);
            });

            // File validation
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

            // Handle submission button clicks
            uploadMaterialsLabel.addEventListener('click', function(e) {
                e.preventDefault();
                uploadMaterialsInput.style.display = '';
                uploadMaterialsInput.click();
                linkMaterialsInput.style.display = 'none';
            });

            linkMaterialsLabel.addEventListener('click', function(e) {
                e.preventDefault();
                linkMaterialsInput.style.display = '';
                linkMaterialsInput.focus();
                uploadMaterialsInput.style.display = 'none';
            });

            // Hide link input when user selects a file
            uploadMaterialsInput.addEventListener('change', function() {
                if (uploadMaterialsInput.files.length > 0) {
                    linkMaterialsInput.style.display = 'none';
                }
            });

            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const hasFiles = uploadMaterialsInput.files.length > 0 || 
                               uploadCertificatesInput.files.length > 0 || 
                               linkMaterialsInput.value.trim() !== '';

                if (!hasFiles) {
                    alert('Please add at least one resource (file upload or link) before saving.');
                    e.preventDefault();
                    return false;
                }

                // Validate link input if visible and has a value
                if (linkMaterialsInput.style.display !== 'none' && linkMaterialsInput.value.trim() !== '') {
                    const urlPattern = /^(https?:\/\/)[^\s/$.?#].[^\s]*$/i;
                    if (!urlPattern.test(linkMaterialsInput.value.trim())) {
                        alert('Please enter a valid URL for the training materials link.');
                        linkMaterialsInput.focus();
                        e.preventDefault();
                        return false;
                    }
                }
            });
        });
    </script>
</body>

</html> 