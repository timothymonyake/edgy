@extends('layouts.app')

@section('title')
    Killzones
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
@endsection

@section('content')
    <button id="add_killzone_btn" class="btn btn-primary">Add</button>
    <table id="killzones_table" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
@endsection

<x-modal id="add_killzone_modal" size="modal-md" title="Add Killzone">
    <form id="add_killzone_form" action="{{ url('/kill-zones') }}" method="post">
        @csrf
        <div class="modal-body">
            <div class="row gy-4">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <div class="form-control-wrap">
                            <input name="name" required type="text" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <div class="form-control-wrap">
                            <textarea name="description" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>
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
            $('#add_killzone_form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#add_killzone_modal').modal('hide');
                        showToast(response.message, response.type);
                        $('#killzones_table').DataTable().ajax.reload();
                    },
                    error: function(response) {
                        showToast("Something went wrong!", "error");
                    }
                });
            });

            $('#add_killzone_btn').click(function() {
                $('#add_killzone_modal').modal('show');
            });

            $('#killzones_table').DataTable({
                ajax: {
                    url: '{{ route('killzones.all') }}',
                    data: {
                        draw: true
                    }
                },
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'status' },
                    { data: 'created_at' },
                    { data: 'action' }
                ],
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

        function deleteKillzone(id) {
            if (confirm('Are you sure you want to delete this Killzone?')) {
                $.ajax({
                    url: '/killzones/' + id + '/delete',
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        showToast(response.message, response.type);
                        $('#killzones_table').DataTable().ajax.reload();
                    },
                    error: function(response) {
                        showToast('Error deleting killzone!', 'error');
                    }
                });
            }
        }
    </script>
@endpush
