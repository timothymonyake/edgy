@extends('layouts.app')

@push('custom-styles')
<link rel="stylesheet" href="{{ asset('core/plugins/chart.js/Chart.min.css') }}">
@endpush

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="accountSelect">Select Account:</label>
                <select id="accountSelect" class="form-control">
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Balance</h5>
                        <p id="balance" class="card-text">$0.00</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">P&L</h5>
                        <p id="profitLoss" class="card-text">$0.00</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Win Rate</h5>
                        <p id="winRate" class="card-text">0%</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Risk-Reward Ratio</h5>
                        <p id="rrRatio" class="card-text">0.00</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <canvas id="equityCurveChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="profitLossChart"></canvas>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-12">
                <table class="table table-striped" id="tradeTable">
                    <thead>
                        <tr>
                            <th>Trade ID</th>
                            <th>Pair</th>
                            <th>Lot Size</th>
                            <th>Entry Price</th>
                            <th>Exit Price</th>
                            <th>Profit/Loss</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Data to be loaded via SSE --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('core/plugins/chart.js/Chart.min.js') }}"></script>>
    <script>
        $(document).ready(function() {
            $('#accountSelect').select2({
                placeholder: "Select an account",
                ajax: {
                    url: "{{ route('accounts.all') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { q: params.term };
                    },
                    processResults: function (data) {
                        return { results: $.map(data, function (item) {
                            return { text: item.name, id: item.id };
                        }) };
                    },
                    cache: true
                }
            });

            const eventSource = new EventSource("{{ route('dashboard.stream') }}");
            eventSource.onmessage = function(event) {
                const data = JSON.parse(event.data);
                $('#balance').text(`$${data.balance}`);
                $('#profitLoss').text(`$${data.profit_loss}`);
                $('#winRate').text(`${data.win_rate}%`);
                $('#rrRatio').text(`${data.rr_ratio}`);

                updateCharts(data.equity_curve, data.profit_loss_chart);
                updateTable(data.trades);
            };

            function updateCharts(equityData, profitData) {
                new Chart(document.getElementById('equityCurveChart'), {
                    type: 'line',
                    data: { labels: equityData.labels, datasets: [{ data: equityData.values, borderColor: 'blue' }] }
                });

                new Chart(document.getElementById('profitLossChart'), {
                    type: 'bar',
                    data: { labels: profitData.labels, datasets: [{ data: profitData.values, backgroundColor: 'green' }] }
                });
            }

            function updateTable(trades) {
                let rows = '';
                trades.forEach(trade => {
                    rows += `<tr><td>${trade.id}</td><td>${trade.pair}</td><td>${trade.lot_size}</td><td>${trade.entry_price}</td><td>${trade.exit_price}</td><td>${trade.profit_loss}</td></tr>`;
                });
                $('#tradeTable tbody').html(rows);
            }
        });
    </script>
@endpush
