@extends('layouts.app')

@section('title', 'Weekly Forecasts')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
@endsection

@section('content')

    <button id="add_forecast_btn" class="btn btn-primary">Add Year Weeks</button>

    <table id="forecasts_table" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Week</th>
                <th>Market Bias</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
@endsection

<x-modal id="add_forecast_modal" size="modal-md" title="Add Weekly Forecast">
    <form id="add_forecast_form" action="{{ url('/weekly-forecasts') }}" method="post">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label>Week Start</label>
                <input type="date" name="week_start" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Week End</label>
                <input type="date" name="week_end" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Market Bias</label>
                <input type="text" name="market_bias" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Key Levels</label>
                <textarea name="key_levels" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>News Events</label>
                <textarea name="news_events" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>Trade Ideas</label>
                <textarea name="trade_ideas" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>Notion Link</label>
                <input type="url" name="notion_link" class="form-control">
            </div>
            <div class="form-group">
                <label>Economic Calendar Link</label>
                <input type="url" name="economic_calendar_link" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </form>
</x-modal>

@push('custom-scripts')
<script>
    $(document).ready(function() {
        $('#forecasts_table').DataTable({
            ajax: {
                url: '{{ route('weekly_forecasts.all') }}',
                data:{
                    draw:true
                }
            },
            columns: [
                { data: 'id' },
                { data: 'week' },
                { data: 'status' },
                { data: 'action' }
            ]
        });

        $('#add_forecast_btn').click(function() {
            $('#add_forecast_modal').modal('show');
        });

        $('#add_forecast_form').submit(function(e) {
            e.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function(response) {
                $('#add_forecast_modal').modal('hide');
                showToast(response.message, response.type);
                $('#forecasts_table').DataTable().ajax.reload();
            });
        });
    });
</script>
@endpush
