{{-- resources/views/farmer/advice/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Ask for Advice - FarmConnect')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('farmer.advice.index') }}">Advice</a></li>
            <li class="breadcrumb-item active">Ask for Advice</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Ask for Expert Advice</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('farmer.advice.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="agrovet_id" class="form-label">Select Agrovet (Optional)</label>
                            <select class="form-select @error('agrovet_id') is-invalid @enderror" 
                                    id="agrovet_id" 
                                    name="agrovet_id">
                                <option value="">Any Agrovet</option>
                                @foreach($agrovets as $agrovet)
                                    <option value="{{ $agrovet->id }}" {{ old('agrovet_id') == $agrovet->id ? 'selected' : '' }}>
                                        {{ $agrovet->name }} - {{ $agrovet->business_name ?? 'Agrovet' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('agrovet_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" 
                                   class="form-control @error('subject') is-invalid @enderror" 
                                   id="subject" 
                                   name="subject" 
                                   value="{{ old('subject') }}" 
                                   required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" 
                                      name="message" 
                                      rows="6" 
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Please provide as much detail as possible about your farming issue.</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Submit Request
                            </button>
                            <a href="{{ route('farmer.advice.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection