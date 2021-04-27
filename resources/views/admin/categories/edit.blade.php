@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">
                Edit Category
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
@stop

@php
    $lcc = 'col-sm-2';
    $mcc = 'col-sm-10';
@endphp

@section('content')
    <form class="card" action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group row">
                <label for="name" class="{{ $lcc }} col-form-label">Name</label>
                <div class="{{ $mcc }}">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $category->name }}" id="name">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="category_id" class="{{ $lcc }} col-form-label">Parent Category</label>
                <div class="{{ $mcc }}">
                    <select id="category_id" name="category_id" class="form-control select2 @error('category_id') is-invalid @enderror">
                        <option value="">Choose parent category...</option>
                        @foreach($categories as $parent)
                            <option value="{{ $parent->id }}" {{ !old('category_id') ? ($category->category_id == $parent->id ? 'selected' : '') : (old('category_id') == $parent->id ? 'selected' : '') }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer d-flex">
            <button class="btn btn-primary ml-auto">Update Category</button>
        </div>
    </form>
@stop

@section('js')
    <script></script>
@stop
