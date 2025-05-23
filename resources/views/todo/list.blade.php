@extends('layouts.app')
@section('content')
<div class="container">
  <br>
  <div class="row justify-content-center">
    <div class="col-md-6">
      <h2>To-Dos List</h2>
    </div>
    <div class="col-md-6">
      <div class="float-right">
        <a href="{{ route('todo.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add new todo</a>
      </div>
    </div>
    <br>
    <div class="col-md-12">
      @if (session('success'))
      <div class="alert alert-success" role="alert">
        {{ session('success') }}
      </div>
      @endif
      @if (session('error'))
      <div class="alert alert-danger" role="alert">
        {{ session('error') }}
      </div>
      @endif
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th width="5%">
              <center>Number</center></th>
            <th>
              <center>Task Name</center></th>
            <th width="30%">
              <center>Description</center>
            </th>
            <th width="10%">
              <center>Task Status</center>
            </th>
            <th width="14%">
              <center>Action</center>
            </th>
          </tr>
        </thead>
        <tbody>
          @forelse($todos as $todo)
          <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">{{ $todo->title }}</td>
            <td class="text-center">{{ $todo->description }}</td>
            <td class="text-center">{{ $todo->status }}</td>
            <td class="text-center">
              <a href="{{ route('todo.edit', $todo) }}"
                class="btn btn-warning btn-sm">
                Edit
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4">
              <center>You currently have no to-do.</center>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection