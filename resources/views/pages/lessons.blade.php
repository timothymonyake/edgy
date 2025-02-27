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

    <x-modal id="add_lesson_modal" size="modal-md" title="Add Lesson">
        <form id="add_lesson_form" action="{{ url('/lessons') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input name="title" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label>Priority</label>
                    <input name="priority" type="number" class="form-control" required>
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
    $('#lessons_table').DataTable({
        ajax: { url: '{{ route('lessons.all') }}', data: { draw: true } },
        columns: [
            { data: 'id' },
            { data: 'title' },
            { data: 'description' },
            { data: 'priority' },
            { data: 'created_at' },
            { data: 'action' }
        ]
    });

    $('#add_lesson_btn').click(function() {
        $('#add_lesson_modal').modal('show');
    });
});
</script>
@endpush
