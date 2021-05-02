<div>
    @if($transaction->canceled)
    @elseif($transaction->accepted_at)

    @elseif($transaction->proof && !$transaction->paid_at)
        <a href="{{ route('admin.transactions.confirm', $transaction->id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Confirm">
            Confirm
        </a>
        <a href="{{ route('admin.transactions.cancel', $transaction->id) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Cancel">
            Cancel
        </a>
    @elseif($transaction->paid_at && !$transaction->shipped_at)
        <span data-action="{{ route('admin.transactions.ship', $transaction->id) }}" data-toggle="modal" data-target="#ship-modal">
            <button class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Confirm Shipping">
                Confirm Shipping
            </button>
        </span>
        <a href="{{ route('admin.transactions.cancel', $transaction->id) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Cancel">
            Cancel
        </a>
    @elseif($transaction->shipped_at)
        <a href="{{ route('admin.transactions.ship.edit', $transaction->id) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Shipping">
            Edit Shipping
        </a>
    @elseif(!$transaction->proof)
        <a href="{{ route('admin.transactions.cancel', $transaction->id) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Cancel">
            Cancel
        </a>
    @endif
</div>
