{{-- resources/views/farmer/messages/create.blade.php --}}
@extends('layouts.app')

@section('title', 'New Message - FarmConnect')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">New Message</h5>
                </div>
                <div class="card-body">
                    @if($receiver)
                        <div class="alert alert-info">
                            <i class="fas fa-user"></i> Sending message to: <strong>{{ $receiver->name }}</strong>
                        </div>
                    @endif
                    
                    @if($product)
                        <div class="alert alert-success">
                            <i class="fas fa-box"></i> Regarding product: <strong>{{ $product->name }}</strong>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('farmer.messages.send', $receiver ? $receiver->id : '') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" 
                                      name="message" 
                                      rows="5" 
                                      required 
                                      placeholder="Write your message here...">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Send Message
                            </button>
                            <a href="{{ route('farmer.messages.index') }}" class="btn btn-secondary">
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