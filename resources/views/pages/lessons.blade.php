@extends('layouts.app')
@section('title', 'Lessons')
@section('content')
    <button id="add_lesson_btn" class="btn btn-primary">Add</button>
    <table id="lessons_table" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Priority</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

    <x-modal id="add_lesson_modal" size="modal-md" title="Add/Edit Lesson">
        <form id="lesson_form" method="post">
            @csrf
            <input type="hidden" id="lesson_id">
            <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input name="title" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="5" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label>Priority</label>
                    <select name="priority" class="form-control" required>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Notion Link</label>
                    <input name="notion_link" type="url" class="form-control">
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
    var table = $('#lessons_table').DataTable({
        ajax: { url: '{{ route('lessons.all') }}' },
        columns: [
            { data: 'id' },
            { data: 'title' },
            { data: 'description' },
            { data: 'priority' },
            { data: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    // Open Add Lesson Modal
    $('#add_lesson_btn').click(function() {
        $('#lesson_form')[0].reset();
        $('#lesson_id').val('');
        $('#add_lesson_modal').modal('show');
    });

    // Add/Edit Lesson
    $('#lesson_form').submit(function(e) {
        e.preventDefault();
        let id = $('#lesson_id').val();
        let url = id ? `{{url('/lessons')}}/${id}` : `{{url('/lessons')}}`;
        let method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: $(this).serialize(),
            success: function(response) {
                $('#add_lesson_modal').modal('hide');
                showToast(response.message, response.type);
                table.ajax.reload();
            },
            error: function(response) {
                console.log(response);
            }
        });
    });

    // Edit Lesson
    $('#lessons_table').on('click', '.edit-lesson', function() {
        let id = $(this).data('id');
        $.get(`{{url('/lessons')}}/${id}`, function(data) {
            $('#lesson_id').val(data.id);
            $('input[name="title"]').val(data.title);
            $('textarea[name="description"]').val(data.description);
            $('input[name="priority"]').val(data.priority);
            $('input[name="notion_link"]').val(data.notion_link);
            $('#add_lesson_modal').modal('show');
        });
    });

    // Delete Lesson
    $('#lessons_table').on('click', '.delete-lesson', function() {
        let id = $(this).data('id');
        if (confirm('Are you sure you want to delete this lesson?')) {
            $.ajax({
                url: `{{url('/lessons')}}/${id}`,
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
