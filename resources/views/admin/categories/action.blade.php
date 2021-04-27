<div>
    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">
        <i class="fa fa-pencil-alt"></i>
    </a>
    <button class="btn btn-danger btn-sm categories-delete-btn" data-action="{{ route('admin.categories.destroy', $category->id) }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="fa fa-trash-alt"></i>
    </button>
</div>
