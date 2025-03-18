@extends('layouts.app')
@section('title', 'Trades')
@section('content')
    <button id="add_trade_btn" class="btn btn-primary">Add</button>
    <table id="trades_table" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Account</th>
                <th>Phase</th>
                <th>Pair</th>
                <th>Kill Zone</th>
                <th>Plan</th>
                <th>Lot Size</th>
                <th>Entry Price</th>
                <th>Exit Price</th>
                <th>Profit/Loss</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>


    <x-modal id="add_trade_modal" size="modal-lg" title="Add Trade">
        <form id="add_trade_form" action="{{ url('/trades') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Account</label>
                        <select id="account_id" name="account_id" class="form-control"></select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Phase</label>
                        <select id="account_phase_id" name="account_phase_id" class="form-control"></select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Pair</label>
                        <select id="pair_id" name="pair_id" class="form-control"></select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Kill Zone</label>
                        <select id="kill_zone_id" name="kill_zone_id" class="form-control"></select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Plan</label>
                        <select id="trading_plan_id" name="trading_plan_id" class="form-control"></select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Lot Size</label>
                        <input name="lot_size" type="number" step="0.01" class="form-control" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Entry Price</label>
                        <input name="entry_price" type="number" step="0.00001" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Exit Price</label>
                        <input name="exit_price" type="number" step="0.00001" class="form-control" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Profit/Loss</label>
                        <input name="profit_loss" type="number" step="0.01" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </x-modal>
  {{--   <x-modal id="add_trade_modal" size="modal-md" title="Add Trade">
        <form id="add_trade_form" action="{{ url('/trades') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Account</label>
                    <select id="account_id" name="account_id" class="form-control"></select>
                </div>
                <div class="form-group">
                    <label>Phase</label>
                    <select id="account_phase_id" name="account_phase_id" class="form-control"></select>
                </div>
                <div class="form-group">
                    <label>Pair</label>
                    <select id="pair_id" name="pair_id" class="form-control"></select>
                </div>
                <div class="form-group">
                    <label>Kill Zone</label>
                    <select id="kill_zone_id" name="kill_zone_id" class="form-control"></select>
                </div>
                <div class="form-group">
                    <label>Plan</label>
                    <select id="trading_plan_id" name="trading_plan_id" class="form-control"></select>
                </div>
                <div class="form-group">
                    <label>Lot Size</label>
                    <input name="lot_size" type="number" step="0.01" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Entry Price</label>
                    <input name="entry_price" type="number" step="0.00001" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Exit Price</label>
                    <input name="exit_price" type="number" step="0.00001" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Profit/Loss</label>
                    <input name="profit_loss" type="number" step="0.01" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </x-modal> --}}
@endsection
@push('custom-scripts')
<script>
$(document).ready(function() {
    $('#trades_table').DataTable({
        ajax: { url: '{{ route('trades.all') }}', data: { draw: true } },
        columns: [
            { data: 'id' },
            { data: 'account_id' },
            { data: 'account_phase_id' },
            { data: 'pair_id' },
            { data: 'kill_zone_id' },
            { data: 'trading_plan_id' },
            { data: 'lot_size' },
            { data: 'entry_price' },
            { data: 'exit_price' },
            { data: 'profit_loss' },
            { data: 'created_at' },
            { data: 'action' }
        ]
    });

    $('#add_trade_btn').click(function() {
        $('#add_trade_modal').modal('show');
    });

    function initSelect2(id, url, placeholder) {
        $('#' + id).select2({
            placeholder: placeholder,
            ajax: {
                url: url,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term };
                },
                processResults: function (data) {
                    return { results: $.map(data, function (item) {
                        return { text: item['name'], id: item['id'] };
                    }) };
                },
                cache: true
            }
        });
    }

    initSelect2('account_id', "{{ route('accounts.all') }}", 'Select Account');
    initSelect2('account_phase_id', "{{ route('phases.all') }}", 'Select Phase');
    initSelect2('pair_id', "{{ route('pairs.all') }}", 'Select Pair');
    initSelect2('kill_zone_id', "{{ route('killzones.all') }}", 'Select Kill Zone');
    initSelect2('trading_plan_id', "{{ route('trading_plans.all') }}", 'Select Trading Plan');
});
</script>
@endpush
