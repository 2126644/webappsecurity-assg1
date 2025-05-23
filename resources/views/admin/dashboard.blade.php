@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Admin Dashboard</h1>

  <p>Welcome back, {{ Auth::user()->name }}!</p>

  <ul>
    <li><a href="{{ route('admin.users.index') }}">Manage Users</a></li>
    <li><a href="{{ route('admin.dashboard') }}">Dashboard Home</a></li>
    <!-- add more admin links here -->
  </ul>
</div>
@endsection
