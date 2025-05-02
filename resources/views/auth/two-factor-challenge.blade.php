@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Two-Factor Authentication</h2>

    @if (session('error'))
        <div style="color:red;">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('two-factor.store') }}">
        @csrf

        <div>
            <label for="two_factor_code">Enter the 6-digit code sent to your email</label>
            <input id="two_factor_code" type="text" name="two_factor_code" required autofocus>

            @error('two_factor_code')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Verify</button>
    </form>
</div>
@endsection


