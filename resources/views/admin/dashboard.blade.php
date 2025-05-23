@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Admin Dashboard — All Users</h1>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Active?</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $i => $u)
        <tr>
          <td>{{ $i+1 }}</td>
          <td>
            <a href="{{ route('admin.users.todos', $u) }}">
              {{ $u->name }}
            </a>
          </td>
          <td>{{ $u->email }}</td>
          <td>{{ $u->role_id === 1 ? 'Admin' : 'Student' }}</td>
          <td>{{ $u->active ? 'Yes' : 'No' }}</td>
          <td class="d-flex">
            <!-- Toggle Active/Inactive -->
            <form method="POST"
                  action="{{ route('admin.users.toggle', $u) }}"
                  class="me-2">
              @csrf @method('PATCH')
              <button class="btn btn-sm btn-{{ $u->active ? 'warning' : 'success' }}">
                {{ $u->active ? 'Deactivate' : 'Activate' }}
              </button>
            </form>

            <!-- Delete User -->
            <form method="POST"
                  action="{{ route('admin.users.destroy', $u) }}"
                  onsubmit="return confirm('Delete this user?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger">Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
