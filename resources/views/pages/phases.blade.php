@extends('layouts.app')
@section('title', 'Phases')
@section('content')

<button id="add_phase_btn" class="btn btn-primary">Add</button>
<table id="phases_table" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>
</table>

<x-modal id="add_phase_modal" size="modal-md" title="Add/Edit Phase">
    <form id="add_phase_form">
        @csrf
        <input type="hidden" name="id" id="phase_id">
        <div class="modal-body">
            <div class="form-group">
                <label>Name</label>
                <input name="name" id="phase_name" type="text" class="form-control" required>
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
    let table = $('#phases_table').DataTable({
        ajax: { url: '{{ route('phases.all') }}', data: { draw: true } },
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'created_at' },
            { data: 'action' }
        ]
    });

    $('#add_phase_btn').click(function() {
        $('#phase_id').val('');
        $('#phase_name').val('');
        $('#add_phase_modal').modal('show');
    });

    $('#add_phase_form').submit(function(e) {
        e.preventDefault();
        let id = $('#phase_id').val();
        let url = id ? `/phases/${id}` : '/phases';
        let type = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: type,
            data: $(this).serialize(),
            success: function(response) {
                $('#add_phase_modal').modal('hide');
                showToast(response.message, response.type);
                table.ajax.reload();
            },
            error: function(response) {
                console.log(response);
            }
        });
    });
});

function editPhase(id) {
    $.get(`/phases/${id}`, function(data) {
        $('#phase_id').val(data.id);
        $('#phase_name').val(data.name);
        $('#add_phase_modal').modal('show');
    });
}

function deletePhase(id) {
    if (confirm('Are you sure you want to delete this phase?')) {
        $.ajax({
            url: `/phases/${id}`,
            type: 'DELETE',
            success: function(response) {
                showToast(response.message, response.type);
                $('#phases_table').DataTable().ajax.reload();
            },
            error: function(response) {
                console.log(response);
            }
        });
    }
}
</script>
@endpush
