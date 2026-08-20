@extends('layouts.admin')

@section('page-title', 'Create Farm')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('admin.farms.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Farm Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Farming Type</label>
                        <input type="text" name="farming_type" class="form-control" value="{{ old('farming_type') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Area (Acres)</label>
                        <input type="number" step="0.01" name="area_acres" class="form-control" value="{{ old('area_acres') }}" required>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Create Farm</button>
                        <a href="{{ route('admin.farms.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
