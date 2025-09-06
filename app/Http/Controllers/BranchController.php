<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class BranchController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view branch', only: ['index']),
            new Middleware('permission:edit branch', only: ['edit']),
            new Middleware('permission:create branch', only: ['create','store']),
            new Middleware('permission:show branch', only: ['show']),
            new Middleware('permission:deactivate branch', only: ['toggleStatus']),
        ];
    }


    public function show(Branch $branch)
    {
        return view('branches.show', compact('branch'));
    }

    public function index(Request $request)
    {
        // $companies = Company::latest()->paginate(5);
        // return view('companies.list', compact('companies'));
            $query = Branch::with('company');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $branches = $query->orderBy('created_at', 'DESC')->paginate(10);

        // If AJAX request, return only the table partial
        if ($request->ajax()) {
            return view('branches.partials.table', compact('branches'))->render();
        }

        // Otherwise, return full page
        return view('branches.list', compact('branches'));
    }


    public function create()
    {
        $companies = Company::all();
        return view('branches.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name'       => 'required|string|max:255',
            'branch_id'  => 'required|string|max:100|unique:branches,branch_id',
            'email'      => 'required|email',
            'mobile_number' => 'required|string|max:20',
            'status'     => 'nullable|in:active,inactive',
        ]);

        Branch::create($request->all());

        return redirect()->route('branches.index')->with('success', 'Branch created successfully.');
    }

    public function edit(Branch $branch)
    {
        $companies = Company::all();
        return view('branches.edit', compact('branch','companies'));
    }


    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name'       => 'required|string|max:255',
            'branch_id'  => 'required|string|max:100|unique:branches,branch_id,'.$branch->id,
            'email'      => 'required|email',
            'mobile_number' => 'required|string|max:20',
        ]);

        $branch->update($request->all());

        return redirect()->route('branches.index')->with('success', 'Branch updated successfully.');
    }

    public function toggleStatus(Branch $branch)
    {
        $branch->status = $branch->status === 'active' ? 'inactive' : 'active';
        $branch->save();

        return redirect()->route('branches.index')
            ->with('success', 'Branch status updated successfully.');
    }

}
