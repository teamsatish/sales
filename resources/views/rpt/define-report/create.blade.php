@extends('rpt.define-report.layout')

@section('resource-body')

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

        {{ Form::open(array('url' => 'rpt/define-report', 'method' => 'post','files' => true)) }}
            @include('rpt.define-report.define-report-form')    
        {{ Form::submit('Create a report', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}

@endsection
