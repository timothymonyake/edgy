@extends('layouts.app')
@push('custom-styles')
@endpush
@section('title')
    Pairs
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
@endsection
@section('content')
    <button id="add_resource_btn" class="btn btn-primary">Add</button>
    <table id="pairs_table" class="table table-bordered table-hover">
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
<x-modal id="add_pair_modal" size="modal-md" title="Add Pair">
    <form id="add_resource_form" action="{{ url('/pairs') }}" method="post">
        @csrf
        <div class="modal-body" style="background: white">
            <div class="row gy-4">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form-label" for="default-01">Name</label>
                        <div class="form-control-wrap">
                            <input name="name" required type="text" class="form-control" id="default-01"
                                placeholder="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form-label" for="default-01">Description</label>
                        <div class="form-control-wrap">
                            <textarea name="description" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer" style="border-top:0px">
            <span class="sub-text">
                <button type="submit" class="btn btn-primary">Add</button>
            </span>
        </div>
    </form>
</x-modal>
@push('custom-scripts')
    <script>

        $(document).ready(function() {

            $('#add_resource_form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#add_pair_modal').modal('hide');
                        showToast(response.message,response.type);
                        $('#pairs_table').DataTable().ajax.reload();
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            });

            $('#add_resource_btn').click(function() {
                $('#add_pair_modal').modal('show');
            });
            $('#pairs_table').DataTable({
                ajax: {
                    url: '{{ route('pairs.all') }}',
                    data: {
                        draw: true
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'action'
                    }
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
    </script>
@endpush
