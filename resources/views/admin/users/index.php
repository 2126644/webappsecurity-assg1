@extends('layouts.app')

@section('content')
<div class="container">
  <h1>All Users</h1>

  <table class="table">
    <thead>
      <tr>
        <th>Name</th><th>Email</th><th>Role</th><th>Active?</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $u)
        <tr>
          <td>{{ $u->name }}</td>
          <td>{{ $u->email }}</td>
          <td>{{ $u->role_id === 1 ? 'Admin' : 'Student' }}</td>
          <td>{{ $u->active ? 'Yes' : 'No' }}</td>
          <td>
            <form action="{{ route('admin.users.toggle', $u) }}" method="POST" style="display:inline">
              @csrf
              @method('PATCH')
              <button class="btn btn-sm">
                {{ $u->active ? 'Deactivate' : 'Activate' }}
              </button>
            </form>
            <a href="{{ route('admin.users.todos', $u) }}"
               class="btn btn-sm btn-info">
              View Todos
            </a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
