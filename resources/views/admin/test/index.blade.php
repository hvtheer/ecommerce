@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-12">
        @if (session('message'))
            <h2 class="alert alert-success">{{ session('message') }}</h2>
        @endif
        <div class="card">
            <div class="card-header">
                <h4>Test
                    <a href="{{ url('admin/test/create') }}" class="btn btn-primary btn-sm float-end">Add Test</a>
                </h4>
            </div>
            
        </div>

    </div>
</div>

@endsection