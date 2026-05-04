<?php

use App\Mail\ContactMail;
use App\Models\ContactRequest;
use Illuminate\Mail\Mailables\Envelope;

test('contact mail has correct subject', function () {
    $contact = new ContactRequest([
        'first_name' => 'Maria',
        'last_name'  => 'Müller',
    ]);

    $mail = new ContactMail($contact);
    $envelope = $mail->envelope();

    expect($envelope)->toBeInstanceOf(Envelope::class);
    expect($envelope->subject)->toBe('Neue Anfrage von Maria Müller');
});

test('contact mail uses markdown template', function () {
    $contact = new ContactRequest(['first_name' => 'Test', 'last_name' => 'User']);
    $mail = new ContactMail($contact);
    $content = $mail->content();

    expect($content->markdown)->toBe('emails.contact');
});

test('contact mail exposes contact request publicly', function () {
    $contact = new ContactRequest(['email' => 'test@example.com', 'first_name' => 'A', 'last_name' => 'B']);
    $mail = new ContactMail($contact);

    expect($mail->contactRequest->email)->toBe('test@example.com');
});
