<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    // Index: List all companies (untuk admin)
    public function index(Request $request)
    {
        $query = Company::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $companies = $query->paginate(10);

        return view('pages.companies.index', compact('companies'));
    }

    // Show: Show company profile (user's company)
    public function show()
    {
        $company = Company::find(Auth::user()->company_id);

        if (!$company) {
            abort(404, 'Company not found.');
        }

        return view('pages.companies.show', compact('company'));
    }

    // Edit: Edit user's company
    public function edit()
    {
        $company = Company::find(Auth::user()->company_id);

        if (!$company) {
            abort(404, 'Company not found.');
        }

        return view('pages.companies.edit', compact('company'));
    }

    // Update: Update user's company
    public function update(Request $request)
    {
        $company = Company::find(Auth::user()->company_id);

        if (!$company) {
            abort(404, 'Company not found.');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'radius_km' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',
        ]);

        $company->update($request->only([
            'name', 'email', 'address', 'latitude', 'longitude',
            'radius_km', 'time_in', 'time_out'
        ]));

        return redirect()->route('companies.show')->with('success', 'Company updated successfully');
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }
     public function create()
    {
        return view('pages.companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius_km' => 'required|numeric',
            'time_in' => 'required',
            'time_out' => 'required',
        ]);

        $company = Company::create($request->only([
            'name', 'email', 'address', 'latitude', 'longitude',
            'radius_km', 'time_in', 'time_out'
        ]));

        // Jika ingin assign company ke user:
        $user = Auth::user();
        $user->companies_id = $company->id;
        $user->save();

        return redirect()->route('companies.show')->with('success', 'Company created successfully');
    }

}