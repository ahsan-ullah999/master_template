<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view company', only: ['index']),
            new Middleware('permission:edit company', only: ['edit']),
            new Middleware('permission:create company', only: ['create','store']),
            new Middleware('permission:show company', only: ['show']),
        ];
    }
    //for show company list
    public function index(Request $request)
    {
        // $companies = Company::latest()->paginate(5);
        // return view('companies.list', compact('companies'));
            $query = Company::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $companies = $query->orderBy('created_at', 'DESC')->paginate(10);

        // If AJAX request, return only the table partial
        if ($request->ajax()) {
            return view('companies.partials.table', compact('companies'))->render();
        }

        // Otherwise, return full page
        return view('companies.list', compact('companies'));
    }

    public function show(Company $company)
    {
        $company->load([
        'branches.buildings.floors.flats.rooms.seats'
        ]);
        return view('companies.show', compact('company'));
    }


    public function create()
    {
        return view('companies.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:companies,email',
            'contact_number' => 'required|string|max:20',
            'start_date'     => 'required|date',
            'address'        => 'required|string',
            'status'         => 'required|in:active,inactive',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Company::create($data);

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }


    public function edit($id){
        $company = Company::findOrFail($id);
        return view('companies.edit',[
            'company'=> $company
        ]);
    }


    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:companies,email,' . $company->id,
            'contact_number' => 'required|string|max:20',
            'start_date'     => 'required|date',
            'address'        => 'required|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $company->update($data);

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

}
