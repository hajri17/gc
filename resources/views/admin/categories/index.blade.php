@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6 d-flex">
            <h1 class="m-0 text-dark">
                Categories
            </h1>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary ml-3">
                <i class="fa fa-fw fa-plus fa-sm"></i> Create
            </a>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
    <form id="categories-delete" action="" method="POST">
        @csrf
        @method('DELETE')
    </form>
@stop

@section('js')
    {{ $dataTable->scripts() }}
    <script>
        $(document).on('click', '.categories-delete-btn', function () {
            let action = $(this).data('action');
            let form = $('#categories-delete');

            form.attr('action', action)

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.value) {
                    form.submit();
                } else {
                    form.attr('action', '');
                }
            });
        });
    </script>
@stop
