<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::all();
        return view('addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('addresses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:usuarios,id',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
        ]);

        Address::create($request->all());

        return redirect()->route('addresses.index')->with('success', 'Address created successfully.');
    }

    public function edit(Address $address)
    {
        return view('addresses.edit', compact('address'));
    }

    public function update(Request $request, Address $address)
    {
        $request->validate([
            'user_id' => 'required|exists:usuarios,id',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
        ]);

        $address->update($request->all());

        return redirect()->route('addresses.index')->with('success', 'Address updated successfully.');
    }

    public function destroy(Address $address)
    {
        $address->delete();

        return redirect()->route('addresses.index')->with('success', 'Address deleted successfully.');
    }
}
