@extends('userPanel.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2>Completed Trainings</h2>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('user.training.profile.completed') }}" method="GET" class="row g-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search by title or competency..." 
                               value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Sort by Date</option>
                            <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Sort by Title</option>
                        </select>
                        <select name="order" class="form-select" onchange="this.form.submit()">
                            <option value="desc" {{ request('order', 'desc') == 'desc' ? 'selected' : '' }}>Newest First</option>
                            <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Oldest First</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Trainings Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Training Title</th>
                            <th>Type</th>
                            <th>Competency</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trainings as $training)
                            <tr>
                                <td>
                                    {{ $training->title }}
                                    @if($training->type === 'Program')
                                        <span class="badge bg-primary ms-2">Programmed</span>
                                    @else
                                        <span class="badge bg-secondary ms-2">Unprogrammed</span>
                                    @endif
                                </td>
                                <td>{{ $training->type }}</td>
                                <td>{{ $training->competency->name ?? 'N/A' }}</td>
                                <td>
                                    @if($training->implementation_date_from && $training->implementation_date_to)
                                        {{ \Carbon\Carbon::parse($training->implementation_date_from)->format('M d, Y') }} - 
                                        {{ \Carbon\Carbon::parse($training->implementation_date_to)->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-success">Completed</span>
                                </td>
                                <td>
                                    @if($training->type === 'Program')
                                        <a href="{{ route('user.training.profile.show', $training->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    @else
                                        <a href="{{ route('user.training.profile.unprogram.show', $training->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No completed trainings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($trainings->hasPages())
                <div class="card-footer">
                    {{ $trainings->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection