@extends('adminlte::page')

@section('title', 'Items')

@section('content_header')
    <div class="d-flex">
        <h1>Items</h1>
        <a href="{{ route('admin.items.create') }}" class="btn btn-primary ml-3">
            <i class="fa fa-fw fa-plus fa-sm"></i> Tambah
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
@stop

@section('js')
    {{ $dataTable->scripts() }}
@stop
