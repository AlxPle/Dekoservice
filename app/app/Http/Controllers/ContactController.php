<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactMail;
use App\Models\ContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(ContactFormRequest $request): RedirectResponse
    {
        $contact = ContactRequest::create($request->validated());

        $adminEmail = config('mail.admin_email', config('mail.from.address'));
        if ($adminEmail) {
            Mail::to($adminEmail)->queue(new ContactMail($contact));
        }

        return redirect()->route('kontakt')
            ->with('success', 'Vielen Dank! Ihre Anfrage wurde erfolgreich gesendet. Wir melden uns bald bei Ihnen.');
    }
}
