@extends('layouts.dashboard')
@section('title', 'Consultations')
@section('sidebar') @include('farmer.dashboard') @endsection
@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-lg font-semibold">My Consultations</h2>
    <a href="{{ route('farmer.consultations.create') }}" class="bg-green-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-800">+ Book Consultation</a>
</div>
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
            <tr><th class="px-4 py-3 text-left">Topic</th><th class="px-4 py-3 text-left">Agrovet</th><th class="px-4 py-3 text-left">Scheduled</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3"></th></tr>
        </thead>
        <tbody class="divide-y">
            @forelse($consultations as $c)
            <tr>
                <td class="px-4 py-3 font-medium">{{ $c->topic }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $c->agrovet->name }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $c->scheduled_at?->format('d M Y, H:i') ?? '—' }}</td>
                <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs capitalize bg-blue-100 text-blue-700">{{ $c->status }}</span></td>
                <td class="px-4 py-3"><a href="{{ route('farmer.consultations.show', $c) }}" class="text-green-700 hover:underline">View</a></td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">No consultations yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $consultations->links() }}</div>
@endsection
