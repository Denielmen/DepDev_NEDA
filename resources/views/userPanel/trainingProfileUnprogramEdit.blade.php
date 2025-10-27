<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lnd.dro7.depdev</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: rgb(187, 219, 252); font-family: Arial, sans-serif; }
        .navbar { background-color:#fff; box-shadow: 1px 3px 3px 0px #737373; }
        .navbar-brand { color:#003366 !important; font-size:1rem; font-weight:bold; display:flex; align-items:center; }
        .navbar-brand img { height:30px; margin-right:10px; }
        .user-menu { color:black !important; }
        .sidebar { background-color:#003366; min-height:calc(100vh - 56px); width:270px; padding-top:20px; position:fixed; top:56px; left:0; }
        .sidebar a { color:white; text-decoration:none; display:block; padding:12px 20px; font-size:0.9rem; }
        .sidebar a:hover, .sidebar a.active { background-color:#004080; font-weight:bold; }
        .main-content { margin-left:270px; margin-top:56px; padding:20px; }
        .content-header { background-color:#e7f1ff; padding:15px 20px; margin-bottom:20px; border-radius:5px; }
        .content-header h2 { color:#003366; font-size:1.5rem; margin:0; font-weight:bold; }
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
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('user.home') }}">
            <img src="/images/neda-logo.png" alt="NEDA Logo"> DEPDEV Region VII Learning and Development Database System
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
            </div>
        </div>
    </div>
</nav>
<div class="d-flex">
    <div class="sidebar">
        <a href="{{ route('user.home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
        <a href="{{ route('user.training.profile') }}" class="active"><i class="bi bi-person-vcard me-2"></i>Individual Training Profile</a>
        <a href="{{ route('user.tracking') }}"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
        <a href="{{ route('user.training.effectiveness') }}"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
        <a href="{{ route('user.training.resources') }}"><i class="bi bi-archive me-2"></i>Training Resources</a>
    </div>
    <div class="main-content">
        <div class="content-header d-flex justify-content-between align-items-center">
            <h2>Edit Unprogrammed Training</h2>
            <div>
                <a href="{{ route('user.training.profile.unprogram.show', $training->id) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Details
                </a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('user.training.profile.unprogram.update', $training->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Title/Area</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $training->title) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Competency</label>
                            <select class="form-select" name="competency_id" id="competencySelect" required>
                                <option value="" disabled {{ !$training->competency_id ? 'selected' : '' }}>Select competency</option>
                                @foreach($competencies as $competency)
                                    <option value="{{ $competency->id }}" {{ (old('competency_id', $training->competency_id) == $competency->id) ? 'selected' : '' }}>{{ $competency->name }}</option>
                                @endforeach
                                <option value="others">Others</option>
                            </select>
                            <input type="text" name="competency_input" id="competencyInput" class="form-control mt-2" placeholder="Enter new competency" style="display:none;"/>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">User Role</label>
                            <select name="participation_type_id" class="form-select">
                                <option value="">Keep current</option>
                                @foreach($participationTypes as $ptype)
                                    <option value="{{ $ptype->id }}">{{ $ptype->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No. of Hours</label>
                            <input type="number" name="no_of_hours" class="form-control" value="{{ old('no_of_hours', $training->no_of_hours) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Date of Attendance (From)</label>
                            <input type="date" name="implementation_date_from" class="form-control" value="{{ old('implementation_date_from', optional($training->implementation_date_from)->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Attendance (To)</label>
                            <input type="date" name="implementation_date_to" class="form-control" value="{{ old('implementation_date_to', optional($training->implementation_date_to)->format('Y-m-d')) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Learning Service Provider</label>
                            <input type="text" name="provider" class="form-control" value="{{ old('provider', $training->provider) }}">
                        </div>
                    </div>

                    <hr class="my-4"/>
                    <div class="form-group">
                        <label class="mb-2 form-label">Choose a submission type</label>
                        <div class="flex-wrap gap-3 d-flex justify-content-center">
                            <div class="submission-col">
                                <label for="uploadMaterials" class="submission-btn submission-large" id="uploadMaterialsLabel">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                    Upload Training Materials
                                </label>
                                <input type="file" id="uploadMaterials" name="uploadMaterials[]" accept="image/jpeg,image/png,application/pdf" style="display: none;" multiple>
                                <p class="submission-desc">Accepted file types: pdf, png, jpg, jpeg</p>
                                <p class="submission-desc">Max file size: 50 MB</p>
                                <div id="filePreview" class="mt-3 preview-grid"></div>
                            </div>
                            <div class="submission-col">
                                <label for="linkMaterials" class="submission-btn submission-large" id="linkMaterialsLabel">
                                    <i class="bi bi-link-45deg"></i>
                                    Paste Link of Training Materials
                                </label>
                                <input type="text" id="linkMaterials" name="linkMaterials" class="mt-2 form-control" placeholder="Paste your link here" style="display: none;">
                            </div>
                            <div class="submission-col">
                                <label for="uploadCertificates" class="submission-btn submission-large" id="uploadCertificatesLabel">
                                    <i class="bi bi-file-earmark-check"></i>
                                    Upload Training Certificates
                                </label>
                                <input type="file" id="uploadCertificates" name="uploadCertificates[]" accept="image/jpeg,image/png,application/pdf" style="display: none;" multiple>
                                <p class="submission-desc">Accepted file types: pdf, png, jpg, jpeg</p>
                                <p class="submission-desc">Max file size: 50 MB</p>
                                <div id="certPreview" class="mt-3 preview-grid"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save Changes</button>
                        <a href="{{ route('user.training.profile.unprogram.show', $training->id) }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
 const competencySelect = document.getElementById('competencySelect');
 const competencyInput = document.getElementById('competencyInput');
 if (competencySelect) {
     const toggleInput = () => {
         competencyInput.style.display = competencySelect.value === 'others' ? 'block' : 'none';
     };
     competencySelect.addEventListener('change', toggleInput);
     toggleInput();
 }
// Toggle link input visibility when clicking its label
const linkLabel = document.getElementById('linkMaterialsLabel');
const linkInput = document.getElementById('linkMaterials');
if (linkLabel && linkInput) {
    linkLabel.addEventListener('click', () => {
        linkInput.style.display = linkInput.style.display === 'none' ? 'block' : 'none';
        if (linkInput.style.display === 'block') linkInput.focus();
    });
}

// File previews and validation
const uploadMaterialsInput = document.getElementById('uploadMaterials');
const uploadCertificatesInput = document.getElementById('uploadCertificates');
const filePreview = document.getElementById('filePreview');
const certPreview = document.getElementById('certPreview');

function handleFilePreview(input, previewContainer) {
    previewContainer.innerHTML = '';
    const files = input.files;
    if (files && files.length > 0) {
        Array.from(files).forEach((file, index) => {
            const fileType = file.type;
            const card = document.createElement('div');
            card.className = 'preview-card';

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'preview-remove';
            removeBtn.innerHTML = '&times;';
            removeBtn.title = 'Remove';
            removeBtn.addEventListener('click', () => {
                // Remove the file from the FileList via DataTransfer
                const dt = new DataTransfer();
                Array.from(input.files).forEach((f, i) => { if (i !== index) dt.items.add(f); });
                input.files = dt.files;
                handleFilePreview(input, previewContainer);
            });

            const body = document.createElement('div');
            body.className = 'preview-body';

            if (fileType.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.onload = () => URL.revokeObjectURL(img.src);
                body.appendChild(img);
            } else {
                const icon = document.createElement('div');
                icon.className = 'preview-icon';
                icon.textContent = fileType.includes('pdf') ? 'PDF' : 'FILE';
                body.appendChild(icon);
            }

            const caption = document.createElement('div');
            caption.className = 'preview-caption';
            caption.textContent = file.name;

            card.appendChild(removeBtn);
            card.appendChild(body);
            card.appendChild(caption);
            previewContainer.appendChild(card);
        });
    }
}

const maxFileSize = 50 * 1024 * 1024;
const allowedFileTypes = ['image/jpeg', 'image/png', 'application/pdf'];
function validateFiles(input) {
    const files = input.files;
    for (const file of files) {
        if (!allowedFileTypes.includes(file.type)) {
            alert(`Invalid file type: ${file.name}`);
            input.value = '';
            return false;
        }
        if (file.size > maxFileSize) {
            alert(`File size exceeds 50 MB: ${file.name}`);
            input.value = '';
            return false;
        }
    }
    return true;
}

if (uploadMaterialsInput) {
    uploadMaterialsInput.addEventListener('change', function() {
        if (validateFiles(uploadMaterialsInput)) handleFilePreview(uploadMaterialsInput, filePreview);
    });
}
if (uploadCertificatesInput) {
    uploadCertificatesInput.addEventListener('change', function() {
        if (validateFiles(uploadCertificatesInput)) handleFilePreview(uploadCertificatesInput, certPreview);
    });
}
</script>
<style>
.submission-col { text-align:center; }
.submission-btn { cursor:pointer; display:block; background:#fff; border:1px solid #dcdcdc; border-radius:8px; padding:20px; min-width:260px; }
.submission-large i { font-size:24px; display:block; margin-bottom:8px; }
.submission-desc { font-size:12px; color:#6c757d; margin:4px 0 0; }
.submission-btn:hover { background:#f8f9fa; }
/* Preview grid styles */
.preview-grid { display:grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap:12px; margin-top:12px; }
.preview-card { position:relative; background:#fff; border:1px solid #e2e6ea; border-radius:8px; padding:8px; text-align:center; }
.preview-body { height:100px; display:flex; align-items:center; justify-content:center; overflow:hidden; }
.preview-body img { max-width:100%; max-height:100%; border-radius:4px; }
.preview-icon { font-size:24px; color:#6c757d; }
.preview-caption { margin-top:6px; font-size:12px; word-break: break-word; }
.preview-remove { position:absolute; top:4px; right:6px; border:none; background:#dc3545; color:#fff; width:22px; height:22px; border-radius:50%; line-height:20px; cursor:pointer; padding:0; }
.preview-remove:hover { background:#b02a37; }
</style>
</body>
</html> 