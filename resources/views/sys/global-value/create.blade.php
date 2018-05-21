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

<h1>Create a Global Values</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        {{ Html::ul($errors->all()) }}
    </div>
@endif

<!-- if there are creation errors, they will show here -->


{{ Form::open(array('url' => 'sys/global-value','method' => 'post')) }}
    @include('sys.global-value.global-value-form')    
{{ Form::submit('Create the Global Value', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

</div>
@endsection