<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\PropFirm;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;


class AccountController extends Controller
{
    public function index() {
        $propFirms = PropFirm::all();
        return view('pages.accounts', compact('propFirms'));
    }

    public function getAccounts(Request $request) {
        $accounts = Account::with('propFirm');
        return DataTables::of($accounts)
            ->addIndexColumn()
            ->addColumn('prop_firm', fn($account) => $account->propFirm->name ?? 'N/A')
            ->addColumn('created_at', fn($account) => $account->created_at->format('D d M Y'))
            ->addColumn('action', function ($account) {
                return '<button class="btn btn-sm btn-warning edit-account" data-id="'.$account->id.'">Edit</button>
                        <button class="btn btn-sm btn-danger delete-account" data-id="'.$account->id.'">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'prop_firm_id' => 'nullable|exists:prop_firms,id',
            'account_number' => 'required|unique:accounts,account_number',
        ]);

        Account::create($request->all());
        return response()->json(['message' => 'Account added successfully!', 'type' => 'success']);
    }

    public function update(Request $request, $id) {
        $account = Account::findOrFail($id);
        $account->update($request->all());
        return response()->json(['message' => 'Account updated successfully!', 'type' => 'success']);
    }

    public function destroy($id) {
        Account::findOrFail($id)->delete();
        return response()->json(['message' => 'Account deleted successfully!', 'type' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        //
    }


}
