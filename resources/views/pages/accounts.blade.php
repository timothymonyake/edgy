@extends('layouts.app')
@section('title', 'Accounts')
@section('content')
    <button id="add_account_btn" class="btn btn-primary">Add</button>
    <table id="accounts_table" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Prop Firm</th>
                <th>Account Number</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

    <x-modal id="add_account_modal" size="modal-md" title="Add/Edit Account">
        <form id="account_form" method="post">
            @csrf
            <input type="hidden" id="account_id">
            <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <input name="name" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Prop Firm</label>
                    <select name="prop_firm_id" class="form-control">
                        <option value="">None</option>
                        @foreach($propFirms as $firm)
                            <option value="{{ $firm->id }}">{{ $firm->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Account Number</label>
                    <input name="account_number" type="text" class="form-control" required>
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
    var table = $('#accounts_table').DataTable({
        ajax: { url: '{{ route('accounts.all') }}' },
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'prop_firm' },
            { data: 'account_number' },
            { data: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    // Open Add Account Modal
    $('#add_account_btn').click(function() {
        $('#account_form')[0].reset();
        $('#account_id').val('');
        $('#add_account_modal').modal('show');
    });

    // Add/Edit Account
    $('#account_form').submit(function(e) {
        e.preventDefault();
        let id = $('#account_id').val();
        let url = id ? `{{url('/accounts')}}/${id}` : `/accounts`;
        let method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: $(this).serialize(),
            success: function(response) {
                $('#add_account_modal').modal('hide');
                showToast(response.message, response.type);
                table.ajax.reload();
            },
            error: function(response) {
                console.log(response);
            }
        });
    });

    // Edit Account
    $('#accounts_table').on('click', '.edit-account', function() {
        let id = $(this).data('id');
        $.get(`{{url('/accounts')}}/${id}`, function(data) {
            $('#account_id').val(data.id);
            $('input[name="name"]').val(data.name);
            $('select[name="prop_firm_id"]').val(data.prop_firm_id);
            $('input[name="account_number"]').val(data.account_number);
            $('#add_account_modal').modal('show');
        });
    });

    // Delete Account
    $('#accounts_table').on('click', '.delete-account', function() {
        let id = $(this).data('id');
        if (confirm('Are you sure you want to delete this account?')) {
            $.ajax({
                url: `/{{url('/accounts')}}/${id}`,
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
