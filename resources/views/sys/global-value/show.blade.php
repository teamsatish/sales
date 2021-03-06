@extends('layouts.app')

@section('content')
<div class="container">

    <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('sys/global-value') }}">Global Values</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ URL::to('sys/global-value') }}">View All Global Values</a></li>
            <li><a href="{{ URL::to('sys/global-value/create') }}">Create a Global Value</a>
        </ul>
    </nav>

<h1>All the Global Values</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<div class="card bg-light mb-3" style="max-width: 18rem;">
  <div class="card-header"> {{ $globalValue->code }} :: {{ $globalValue->name }}</div>
  <div class="card-body">
    <h5 class="card-title">{{ $globalValue->value }}</h5>
    <p class="card-text">{{ $globalValue->description }}</p>
  </div>
</div>

</div>
@endsection