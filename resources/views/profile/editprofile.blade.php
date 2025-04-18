@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Profile</h2>

    <form method="POST" action="{{route ('profile.update') }}" enctype="multipart/form-data">
    @csrf 
    @method('PUT')

    <label>Nickname</label>
    <input type="text" name="nickname" value="{{ old('nickname', $user->nickname) }}"><br>

    <label>Email</label>
    <input type="email" name="email" value="{{ old('email', $user->email) }}"><br>

    <label>Phone Number</label>
    <input type="text" name="phone_no" value="{{ old('phone_no', $user->phone_no) }}"><br>

    <label>City</label>
    <input type="text" name="city" value="{{ old('city', $user->city) }}"><br>

    <label>New Password</label>
    <input type="password" name="password"><br>

    <label>Confirm Password</label>
    <input type="password" name="password_confirmation"><br>

    <label>Avatar</label>
    <input type="file" name="avatar"><br>

    @if ($user->avatar)
        <img src="{{ asset('storage/' . $user->avatar) }}" width="100">
    @endif

    <button type="submit" style="color:blue;">Update Profile</button>
    </form>

    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')
        <button type="submit" style="color:red;">Delete Account</button>
    </form>
</div>
@endsection


    