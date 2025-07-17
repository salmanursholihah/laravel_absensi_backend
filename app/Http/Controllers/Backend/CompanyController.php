<?php
namespace App\Http\Controllers\Backend;
 use App\Http\Controllers\Controller; 
 use App\Models\Company; 
 use Illuminate\Http\Request; 
 use Illuminate\Support\Facades\Auth;
 class CompanyController extends Controller { 
    public function index(Request $request) { $query=Company::query(); if ($request->has('name')) {
    $query->where('name', 'like', '%' . $request->name . '%');
    }

    $companies = $query->paginate(10);

    return view('pages.companies.index', compact('companies'));
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

    // Contoh assign ke user
    $user = Auth::user();
    $user->companies_id = $company->id; // FIX typo `companies_id`
    $user->save();

    return redirect()->route('companies.show', $company->id)
    ->with('success', 'Company created successfully');
    }

    public function show(Company $company)
    {
    return view('pages.companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
    return view('pages.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
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

    return redirect()->route('companies.show', $company->id)
    ->with('success', 'Company updated successfully');
    }

    public function destroy(Company $company)
    {
    $company->delete();
    return redirect()->route('pages.companies.index')
    ->with('success', 'Company deleted successfully.');
    }
    }