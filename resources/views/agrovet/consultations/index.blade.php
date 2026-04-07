@extends('layouts.dashboard')
@section('title', 'Consultations')
@section('sidebar') @include('agrovet.dashboard') @endsection
@section('content')
<h2 class="text-lg font-semibold mb-4">Consultations</h2>
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
            <tr><th class="px-4 py-3 text-left">Topic</th><th class="px-4 py-3 text-left">Farmer</th><th class="px-4 py-3 text-left">Scheduled</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3"></th></tr>
        </thead>
        <tbody class="divide-y">
            @forelse($consultations as $c)
            <tr>
                <td class="px-4 py-3 font-medium">{{ $c->topic }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $c->farmer->name }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $c->scheduled_at?->format('d M Y, H:i') ?? '—' }}</td>
                <td class="px-4 py-3">
                    <form method="POST" action="{{ route('agrovet.consultations.status', $c) }}" class="flex gap-1">
                        @csrf @method('PATCH')
                        <select name="status" class="border rounded px-2 py-0.5 text-xs" onchange="this.form.submit()">
                            @foreach(['requested','confirmed','completed','cancelled'] as $s)
                                <option value="{{ $s }}" @selected($c->status === $s)>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </form>
                </td>
                <td class="px-4 py-3"><a href="{{ route('agrovet.consultations.show', $c) }}" class="text-green-700 hover:underline">View</a></td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">No consultations.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $consultations->links() }}</div>
@endsection
