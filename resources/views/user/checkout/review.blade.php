<div class="container quickView-container" style="max-width: 780px;">
    <div class="quickView-content">
        <h5 class="font-weight-normal">Review Product(s)</h5>
        <form class="mt-3" action="{{ route('review.store', $transaction->id) }}" method="POST">
            @csrf
            @foreach($transaction->transaction_details as $index => $transactionDetail)
                <div class="@if(!$loop->last) mb-4 @endif">
                    <div class="d-flex product-col mb-2">
                        <div style="max-width: 100px;max-height: 100px" class="mr-4">
                            <img style="max-width: 100%;max-height: 100%" src="{{ asset('storage/' . $transactionDetail->item->main_image->url) }}" alt="">
                        </div>
                        <div class="product flex-column align-items-start">
                            <h5 class="product-title">{{ $transactionDetail->item->name }}</h5>
                            <div>Rp{{ number_format($transactionDetail->item->price, 0, ',', '.') }}</div>
                            <div><span>x {{ $transactionDetail->qty }}</span></div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <input type="hidden" name="reviews[{{ $index }}][item_id]" value="{{ $transactionDetail->item->id }}">
                            <label for="content">Review</label>
                            <textarea rows="2" style="min-height: 90px;" class="form-control" id="content" name="reviews[{{ $index }}][content]"></textarea>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="d-flex">
                <button class="btn btn-primary ml-auto">Send</button>
            </div>
        </form>
    </div>
</div>
