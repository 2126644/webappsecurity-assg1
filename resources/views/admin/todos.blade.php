@extends('layouts.app')

@section('content')
<div class="container">
  <h1>To-Dos for {{ $user->name }}</h1>
  <ul class="list-group">
    @forelse($todos as $todo)
      <li class="list-group-item">{{ $todo->title }}</li>
    @empty
      <li class="list-group-item">No to–dos found.</li>
    @endforelse
  </ul>
  <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">
    ← Back to Users
  </a>
</div>
@endsection
