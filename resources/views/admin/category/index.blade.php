@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-12">
        @if (session('message'))
            <h2 class="alert alert-success">{{ session('message') }}</h2>
        @endif
        <div class="card">
            <div class="card-header">
                <h4>Category
                    <a href="{{ url('admin/category/create') }}" class="btn btn-primary btn-sm float-end">Add category</a>
                </h4>
            </div>
            
        </div>

    </div>
</div>

@endsection