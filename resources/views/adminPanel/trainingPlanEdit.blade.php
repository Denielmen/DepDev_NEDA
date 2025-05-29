<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Training Plan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        /* Copy the existing styles from trainingPlan.blade.php */
    </style>
</head>
<body>
    <!-- Copy the existing navbar and sidebar from trainingPlan.blade.php -->

    <div class="main-content">
        <div class="content-header">
            <h2>Edit Training Plan</h2>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.training-plan.update', $training->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Training Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $training->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="competency" class="form-label">Competency</label>
                        <input type="text" class="form-control" id="competency" name="competency" value="{{ $training->competency }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="implementation_date_from" class="form-label">Implementation Date From</label>
                        <input type="date" class="form-control" id="implementation_date_from" name="implementation_date_from" value="{{ $training->implementation_date_from->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="implementation_date_to" class="form-label">Implementation Date To</label>
                        <input type="date" class="form-control" id="implementation_date_to" name="implementation_date_to" value="{{ $training->implementation_date_to->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="Program" {{ $training->type === 'Program' ? 'selected' : '' }}>Program</option>
                            <option value="Unprogrammed" {{ $training->type === 'Unprogrammed' ? 'selected' : '' }}>Unprogrammed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Training</button>
                    <a href="{{ route('admin.training-plan.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 