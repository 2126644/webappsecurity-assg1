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
                <th>Number</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $i => $u)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $u->id }}</td>
                <td>
                    <a href="{{ route('admin.todos', $u) }}">
                        {{ $u->name }}
                    </a>
                </td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->role_id === 1 ? 'Administrator' : 'Ordinary user / Student' }}</td>
                <td>
                    <!-- Activate/Inactivate User -->
                    <form method="POST"
                        action="{{ route('admin.users.toggle', $u) }}">
                        @csrf
                        @method('PATCH')
                        <div class="form check form-switch">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="status"
                                id="active-switch-{{ $u->id }}"
                                onchange="this.form.submit()"
                                {{ $u->status ? 'checked' : '' }}>
                            <label
                                class="form-check-label"
                                for="active-switch-{{ $u->id }}">
                                {{ $u->status ? 'Active' : 'Inactive' }}
                            </label>
                        </div>
                    </form>
                </td>
                <td class="d-flex">
                    <!-- Delete User -->
                    <form method="POST"
                        action="{{ route('admin.users.destroy', $u) }}"
                        onsubmit="return confirm('Delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection