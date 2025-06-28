<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;

class UserController extends Controller
{
    //index
public function index(Request $request)
{
    $companies = Company::all();

        $users = User::query()
        ->when($request->input('name'), function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
        ->when($request->input('companies_id'), function ($query, $companiesid) {
            $query->where('companies_id', $companiesid); // Pastikan kolomnya benar
        })
        ->when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        })
        ->orderBy('id', 'desc')
        ->paginate(10);

    // Kirim ke view
    return view('pages.users.index', compact('users', 'companies'));
}


    //create
    public function create()
    {
        return view('pages.users.create');
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'position' => $request->position,
            'department' => $request->department,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    //edit
    public function edit(User $user)
    {
        return view('pages.users.edit', compact('user'));
    }

        //update
        public function update(Request $request, User $user)
        {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
            ]);
    
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role,
                'position' => $request->position,
                'department' => $request->department,
            ]);
    
            //if password filled
            if ($request->password) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }
    
            return redirect()->route('users.index')->with('success', 'User updated successfully');
        }

            //destroy
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}