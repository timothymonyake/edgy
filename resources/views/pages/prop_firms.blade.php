@extends('layouts.app')
@section('title', 'Prop Firms')
@section('content')
    <button id="add_firm_btn" class="btn btn-primary">Add
    </button>
    <table id="prop_firms_table" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Website URL</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

    <x-modal id="add_firm_modal" size="modal-md" title="Add Prop Firm">
        <form id="add_firm_form" action="{{ url('/prop-firms') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <input name="name" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Website URL</label>
                    <input name="website_url" type="url" class="form-control">
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
    $('#prop_firms_table').DataTable({
        ajax: { url: '{{ route('prop_firms.all') }}', data: { draw: true } },
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'website_url' },
            { data: 'created_at' },
            { data: 'action' }
        ]
    });

    $('#add_firm_btn').click(function() {
        $('#add_firm_modal').modal('show');
    });
});
</script>
@endpush
