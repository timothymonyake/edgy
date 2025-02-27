@extends('layouts.app')
@section('title', 'Trading Plans')
@section('content')
    <button id="add_plan_btn" class="btn btn-primary">Add</button>
    <table id="trading_plans_table" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Markets</th>
                <th>Timeframes</th>
                <th>Strategies</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

    <x-modal id="add_plan_modal" size="modal-md" title="Add Trading Plan">
        <form id="add_plan_form" action="{{ url('/trading-plans') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Markets</label>
                    <input name="markets" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Timeframes</label>
                    <input name="timeframes" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Strategies</label>
                    <textarea name="strategies" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label>Max Risk Per Trade</label>
                    <input name="max_risk_per_trade" type="number" step="0.01" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Max Weekly Drawdown</label>
                    <input name="max_weekly_drawdown" type="number" step="0.01" class="form-control" required>
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


    $('#add_plan_btn').click(function() {
        $('#add_plan_modal').modal('show');
    });

    $('#trading_plans_table').DataTable({
        ajax: { url: '{{ route('trading_plans.all') }}', data: { draw: true } },
        columns: [
            { data: 'id' },
            { data: 'markets' },
            { data: 'timeframes' },
            { data: 'strategies' },
            { data: 'created_at' },
            { data: 'action' }
        ]
    });
});
</script>
