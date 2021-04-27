<div>
    <a href="{{ route('admin.transactions.paid', $transaction->id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Paid">
        Paid
    </a>
    <a href="{{ route('admin.transactions.cancel', $transaction->id) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Cancel">
        Cancel
    </a>
</div>
