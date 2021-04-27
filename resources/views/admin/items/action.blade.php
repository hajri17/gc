<div>
    <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">
        <i class="fa fa-pencil-alt"></i>
    </a>
    <button class="btn btn-danger btn-sm items-delete-btn" data-action="{{ route('admin.items.destroy', $item->id) }}" data-toggle="tooltip" data-placement="top" title="Delete">
        <i class="fa fa-trash-alt"></i>
    </button>
</div>
