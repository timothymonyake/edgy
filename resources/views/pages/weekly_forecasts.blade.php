@extends('layouts.app')

@section('title', 'Weekly Forecasts')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
@endsection

@section('content')
    <button id="add_forecast_btn" class="btn btn-primary rounded-pill shadow-sm" style="display:{{ $show_seed_btn == 1 ? 'block' : 'none' }}">
        <i class="fas fa-plus-circle"></i> Add Year Weeks
    </button>
    <br>
    <div class="card mt-3 shadow-sm rounded-lg">
        <div class="card-body">
            <table id="forecasts_table" class="table table-dark table-striped table-hover rounded-lg">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Week</th>
                        <th>Status</th>
                        <th>News Calendar</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

<x-modal id="add_forecast_modal" size="modal-md" title="Add Weekly Forecast" class="bg-dark text-white">
    <form id="add_forecast_form" action="{{ url('/weekly-forecasts') }}" method="post">
        @csrf
        <div class="modal-body bg-dark text-white">
            <div class="form-group">
                <label>Week Start</label>
                <input type="date" name="week_start" class="form-control bg-secondary text-white border-0 rounded-lg" required>
            </div>
            <div class="form-group">
                <label>Week End</label>
                <input type="date" name="week_end" class="form-control bg-secondary text-white border-0 rounded-lg" required>
            </div>
            <div class="form-group">
                <label>Market Bias</label>
                <input type="text" name="market_bias" class="form-control bg-secondary text-white border-0 rounded-lg" required>
            </div>
            <div class="form-group">
                <label>Key Levels</label>
                <textarea name="key_levels" class="form-control bg-secondary text-white border-0 rounded-lg"></textarea>
            </div>
            <div class="form-group">
                <label>News Events</label>
                <textarea name="news_events" class="form-control bg-secondary text-white border-0 rounded-lg"></textarea>
            </div>
            <div class="form-group">
                <label>Trade Ideas</label>
                <textarea name="trade_ideas" class="form-control bg-secondary text-white border-0 rounded-lg"></textarea>
            </div>
            <div class="form-group">
                <label>Notion Link</label>
                <input type="url" name="notion_link" class="form-control bg-secondary text-white border-0 rounded-lg">
            </div>
            <div class="form-group">
                <label>Economic Calendar Link</label>
                <input type="url" name="economic_calendar_link" class="form-control bg-secondary text-white border-0 rounded-lg">
            </div>
        </div>
        <div class="modal-footer bg-dark border-0">
            <button type="submit" class="btn btn-primary rounded-pill">Add</button>
        </div>
    </form>
</x-modal>


@push('custom-scripts')
    <script>
        $(document).ready(function() {
            $('#forecasts_table').DataTable({
                ajax: {
                    url: '{{ route('weekly_forecasts.all') }}',
                    data: {
                        draw: true
                    }
                },
                order: [
                    [2, 'asc']
                ],
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'week'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'economic_calendar'
                    },
                    {
                        data: 'action'
                    }
                ]
            });

            $('#add_forecast_btn').click(function() {
                //$('#add_forecast_modal').modal('show');
                window.location.href = '{{ url('/weekly-forecasts/seed-year-weeks') }}';
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
