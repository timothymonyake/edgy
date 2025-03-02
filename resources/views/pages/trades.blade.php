@extends('layouts.app')
@section('title', 'Trades')
@section('content')
    <button id="add_trade_btn" class="btn btn-primary">Add Trade</button>
    <table id="trades_table" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Account</th>
                <th>Pair</th>
                <th>Lot Size</th>
                <th>Entry Price</th>
                <th>Exit Price</th>
                <th>Profit/Loss</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

    <x-modal id="add_trade_modal" size="modal-md" title="Add Trade">
        <form id="add_trade_form" action="{{ url('/trades') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Account</label>
                    <input name="account_id" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Pair</label>
                    <input name="pair_id" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Lot Size</label>
                    <input name="lot_size" type="number" step="0.01" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Entry Price</label>
                    <input name="entry_price" type="number" step="0.0001" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Exit Price</label>
                    <input name="exit_price" type="number" step="0.0001" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Profit/Loss</label>
                    <input name="profit_loss" type="number" step="0.01" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Complete">Complete</option>
                        <option value="Verified">Verified</option>
                        <option value="Annulled">Annulled</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </x-modal>
@endsection
@push('custom-scripts')
<script>
$(document).ready(function() {
    $('#trades_table').DataTable({
        ajax: { url: '{{ route('trades.all') }}', data: { draw: true } },
        columns: [
            { data: 'id' },
            { data: 'account.name' },
            { data: 'pair.name' },
            { data: 'lot_size' },
            { data: 'entry_price' },
            { data: 'exit_price' },
            { data: 'profit_loss' },
            { data: 'status' },
            { data: 'created_at' },
            { data: 'action' }
        ]
    });

    $('#add_trade_btn').click(function() {
        $('#add_trade_modal').modal('show');
    });

    $('#add_trade_form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#add_trade_modal').modal('hide');
                showToast(response.message, response.type);
                $('#trades_table').DataTable().ajax.reload();
            },
            error: function(response) {
                console.log(response);
            }
        });
    });
});
</script>
@endpush
