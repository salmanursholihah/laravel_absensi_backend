<?php
namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
public function showForm()
{
return view('public.contact.contact');
}

public function store(Request $request)
{
$request->validate([
'name' => 'required|string|max:255',
'email' => 'required|email',
'message' => 'required|string',
]);

Contact::create($request->only('name', 'email', 'message'));

return redirect()->back()->with('success', 'Pesan berhasil dikirim!');
}

public function index()
{
$contacts = Contact::latest()->paginate(10);
return view('admin.contacts.index', compact('contacts'));
}
}