@extends('backend.layouts.base')
@include('backend.partials.alert')

@section('content')
    <h3>Dashboard</h3>

    <form action="{{ route('auth.check') }}" method="post">
        @csrf
        <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Email">
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>

@endsection
