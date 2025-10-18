<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
                // $groups = Company::latest()->paginate(5);
        // return view('groups.list', compact('groups'));
            $query = Group::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $groups = $query->orderBy('created_at', 'DESC')->paginate(10);

        // If AJAX request, return only the table partial
        if ($request->ajax()) {
            return view('groups.partials.table', compact('groups'))->render();
        }

        // Otherwise, return full page
        return view('groups.list', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       // return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:companies,email',
            'contact_number' => 'required|string|max:20',
            'address'        => 'required|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('groups', 'public');
        }

        if ($request->hasFile('login_background')) {
        $data['login_background'] = $request->file('login_background')->store('login_background', 'public');
        }

        Group::create($data);

        return redirect()->route('groups.index')->with('success', 'Group created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        return view('groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        return view('groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:companies,email,' . $group->id,
            'contact_number' => 'required|string|max:20',
            'address'        => 'required|string',
            'logo'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'login_background' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $data = $request->all();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($group->logo && file_exists(public_path('storage/' . $group->logo))) {
                unlink(public_path('storage/' . $group->logo));
            }
            $data['logo'] = $request->file('logo')->store('groups', 'public');
        }

        // Handle login background upload
        if ($request->hasFile('login_background')) {
            // Delete old background if exists
            if ($group->login_background && file_exists(public_path('storage/' . $group->login_background))) {
                unlink(public_path('storage/' . $group->login_background));
            }
            $data['login_background'] = $request->file('login_background')->store('login_background', 'public');
        }

        $group->update($data);

        return redirect()->route('groups.index')->with('success', 'Group updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }
}
