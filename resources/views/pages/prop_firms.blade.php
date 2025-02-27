@extends('layouts.app')
@section('title', 'Prop Firms')
@section('content')
    <button id="add_prop_firm_btn" class="btn btn-primary">Add</button>
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

    <x-modal id="add_prop_firm_modal" size="modal-md" title="Add/Edit Prop Firm">
        <form id="prop_firm_form" method="post">
            @csrf
            <input type="hidden" id="prop_firm_id">
            <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <input name="name" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Website URL</label>
                    <input name="website_url" type="url" class="form-control" required>
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
    var table = $('#prop_firms_table').DataTable({
        ajax: { url: '{{ route('prop_firms.all') }}' },
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'website_url' },
            { data: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    // Open Add Prop Firm Modal
    $('#add_prop_firm_btn').click(function() {
        $('#prop_firm_form')[0].reset();
        $('#prop_firm_id').val('');
        $('#add_prop_firm_modal').modal('show');
    });

    // Add/Edit Prop Firm
    $('#prop_firm_form').submit(function(e) {
        e.preventDefault();
        let id = $('#prop_firm_id').val();
        let url = id ? `{{url('/prop-firms')}}/${id}` : `{{url('/prop-firms')}}`;
        let method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: $(this).serialize(),
            success: function(response) {
                $('#add_prop_firm_modal').modal('hide');
                showToast(response.message, response.type);
                table.ajax.reload();
            },
            error: function(response) {
                console.log(response);
            }
        });
    });

    // Edit Prop Firm
    $('#prop_firms_table').on('click', '.edit-prop-firm', function() {
        let id = $(this).data('id');
        $.get(`{{url('/prop-firms')}}/${id}`, function(data) {
            $('#prop_firm_id').val(data.id);
            $('input[name="name"]').val(data.name);
            $('input[name="website_url"]').val(data.website_url);
            $('#add_prop_firm_modal').modal('show');
        });
    });

    // Delete Prop Firm
    $('#prop_firms_table').on('click', '.delete-prop-firm', function() {
        let id = $(this).data('id');
        if (confirm('Are you sure you want to delete this prop firm?')) {
            $.ajax({
                url: `{{url('/prop-firms')}}/${id}`,
                type: 'DELETE',
                success: function(response) {
                    showToast(response.message, response.type);
                    table.ajax.reload();
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }
    });
});
</script>
@endpush
