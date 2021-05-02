@extends('adminlte::page')

@push('css')
    <style>
        .gc__upload-preview-container {
            height: 200px;
            margin-left: 10px;
            display: flex;
            overflow: scroll;
        }
        .gc__upload-preview-box {
            flex-basis: 200px;
            flex-grow: 0;
            flex-shrink: 0;
            width: 200px;
            height: 200px;
            padding: 1px;
            border: 1px solid #d0d4db;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 10px;
        }
        .gc__upload-preview-box img {
            max-width: 196px;
            max-height: 196px;
        }
        .gc__upload-form-box:first-child {
            margin-left: 0;
        }
        .gc__upload-form-box {
            width: 200px;
            height: 200px;
            flex-basis: 200px;
            flex-grow: 0;
            flex-shrink: 0;
            position: relative;
            border-width: 1px;
            border-style: dashed;
            border-color: #d0d4db;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .gc__upload-form-input {
            width: 100%;
            height: 100%;
            position: absolute;
            opacity: 0;
            z-index: 999;
            cursor: pointer;
        }
    </style>
@endpush

@section('title', 'Items')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">
                Edit Item
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.items.index') }}">Items</a></li>
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
    <form class="card" action="{{ route('admin.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body form-horizontal">
            <div class="form-group row">
                <label for="main_image" class="{{ $lcc }} col-form-label">Upload main image</label>
                <div class="{{ $mcc }} d-flex">
                    <div class="gc__upload-form-box">
                        <input type="file" class="gc__upload-form-input" id="main_image" name="main_image">
                        <div>Choose file...</div>
                    </div>
                    <div id="main_image-preview-container" class="gc__upload-preview-container">
                        <div class="gc__upload-preview-box">
                            <img src="{{ asset('storage/' . $item->main_image->url) }}" alt="preview-1">
                        </div>
                    </div>
                </div>
                @error('main_image')
                <div class="{{ $lcc }}"></div>
                <div class="{{ $mcc }} d-block invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="images" class="{{ $lcc }} col-form-label">Upload images</label>
                <div class="{{ $mcc }} d-flex">
                    <div class="gc__upload-form-box">
                        <input type="file" class="gc__upload-form-input" id="images" name="images[]" multiple>
                        <div>Choose files...</div>
                    </div>
                    <div id="images-preview-container" class="gc__upload-preview-container">
                        @foreach($item->images as $image)
                        <div class="gc__upload-preview-box">
                            <img src="{{ asset('storage/' . $image->url) }}" alt="preview-1">
                        </div>
                        @endforeach
                    </div>
                </div>
                @error('images')
                <div class="{{ $lcc }}"></div>
                <div class="{{ $mcc }} d-block invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                @error('images.*')
                <div class="{{ $lcc }}"></div>
                <div class="{{ $mcc }} d-block invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="category_id" class="{{ $lcc }} col-form-label">Category</label>
                <div class="{{ $mcc }}">
                    <select id="category_id" name="category_id" class="form-control select2 @error('category_id') is-invalid @enderror">
                        <option value="">Choose category...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ !old('category_id') ? ($item->category_id == $category->id ? 'selected' : '') : (old('category_id') == $category->id ? 'selected' : '') }}>
                                {{ $category->name }}
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
            <div class="form-group row">
                <label for="name" class="{{ $lcc }} col-form-label">Name</label>
                <div class="{{ $mcc }}">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') ?? $item->name }}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="price" class="{{ $lcc }} col-form-label">Price</label>
                <div class="{{ $mcc }}">
                    <input type="number" min="0" class="form-control @error('price') is-invalid @enderror" name="price" id="price" value="{{ old('price') ?? $item->price }}">
                    @error('price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="{{ $lcc }} col-form-label">Description</label>
                <div class="{{ $mcc }}">
                    <textarea name="description" id="description" rows="2" class="form-control @error('description') is-invalid @enderror">{{ old('description') ?? $item->description }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer d-flex">
            <button class="btn btn-primary ml-auto">Update Item</button>
        </div>
    </form>
@stop

@push('js')
    <script>
        function readURL(input, target) {
            const filesAmount = input.files.length;

            for (let i = 0; i < filesAmount; i++) {
                const reader = new FileReader();

                reader.onload = function(event) {
                    let el =
                        `<div class="gc__upload-preview-box">
                            <img src="${event.target.result}" alt="preview-${i+1}">
                        </div>`
                    $(target).append(el);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

        $('#images').on('change', function () {
            const container = '#images-preview-container';
            if (this.files) {
                $(container).html(``)
                readURL(this, container)
            } else {
                Swal.fire(
                    'Failed',
                    'No file selected.',
                    'warning'
                )
            }
        })

        $('#main_image').on('change', function () {
            const container = '#main_image-preview-container';
            if (this.files) {
                $(container).html(``)
                readURL(this, container)
            } else {
                Swal.fire(
                    'Failed',
                    'No file selected.',
                    'warning'
                )
            }
        })
    </script>
@endpush
