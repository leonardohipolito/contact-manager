<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    protected function rules(Contact $contact): array
    {
        return [
            'name' => ['required', 'max:250'],
            'contact' => ['required', 'numeric', 'digits:9', Rule::unique('contacts')->ignore($contact->id)],
            'email' => ['required', 'max:250', 'email', Rule::unique('contacts')->ignore($contact->id)],
        ];
    }

    public function index(): View
    {
        $contacts = Contact::latest('id')->paginate();

        return view('contact.index', ['contacts' => $contacts]);
    }

    public function create(): View
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Contact::class);
        $data = $request->validate($this->rules(new Contact));
        Contact::create($data);

        return redirect()->route('home')->with('status', 'Contact created!');
    }

    public function show(Contact $contact)
    {

        return view('contact.show', ['contact' => $contact]);
    }

    public function edit(Contact $contact)
    {
        return view('contact.edit', ['contact' => $contact]);
    }

    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate($this->rules($contact));
        $contact->update($data);

        return redirect()->route('home')->with('status', 'Contact updated!');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->noContent();
    }
}
