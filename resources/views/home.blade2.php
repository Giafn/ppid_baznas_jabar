@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
<div class="p-3 shadow rounded bg-white">
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        {{ __('You are logged in!') }}
    </div>
</div>
@endsection
