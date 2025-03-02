@extends('layouts.app')
@section('title', 'Entry Checklist')
@section('content')
    <button id="add_checklist_btn" class="btn btn-primary">Add</button>
    <table id="entry_checklists_table" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Is Mandatory</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

    <x-modal id="add_checklist_modal" size="modal-md" title="Add/Edit Checklist Item">
        <form id="checklist_form" method="post">
            @csrf
            <input type="hidden" id="checklist_id">
            <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input name="title" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Is Mandatory?</label>
                    <select name="is_mandatory" class="form-control" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
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
    var table = $('#entry_checklists_table').DataTable({
        ajax: { url: '{{ route('entry_checklists.all') }}' },
        columns: [
            { data: 'id' },
            { data: 'title' },
            { data: 'is_mandatory' },
            { data: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    // Open Add Checklist Modal
    $('#add_checklist_btn').click(function() {
        $('#checklist_form')[0].reset();
        $('#checklist_id').val('');
        $('#add_checklist_modal').modal('show');
    });

    // Add/Edit Checklist
    $('#checklist_form').submit(function(e) {
        e.preventDefault();
        let id = $('#checklist_id').val();
        let url = id ? `/entry-checklists/${id}` : `/entry-checklists`;
        let method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: $(this).serialize(),
            success: function(response) {
                $('#add_checklist_modal').modal('hide');
                showToast(response.message, response.type);
                table.ajax.reload();
            },
            error: function(response) {
                console.log(response);
            }
        });
    });

    // Edit Checklist
    $('#entry_checklists_table').on('click', '.edit-checklist', function() {
        let id = $(this).data('id');
        $.get(`/entry-checklists/${id}`, function(data) {
            $('#checklist_id').val(data.id);
            $('input[name="title"]').val(data.title);
            $('select[name="is_mandatory"]').val(data.is_mandatory);
            $('#add_checklist_modal').modal('show');
        });
    });

    // Delete Checklist
    $('#entry_checklists_table').on('click', '.delete-checklist', function() {
        let id = $(this).data('id');
        if (confirm('Are you sure you want to delete this checklist item?')) {
            $.ajax({
                url: `/entry-checklists/${id}`,
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
