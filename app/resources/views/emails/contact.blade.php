<x-mail::message>
    # Neue Kontaktanfrage

    Sie haben eine neue Anfrage über die Website erhalten.

    ---

    **Name:** {{ $contactRequest->first_name }} {{ $contactRequest->last_name }}
    **E-Mail:** {{ $contactRequest->email }}
    @if($contactRequest->phone)
    **Telefon:** {{ $contactRequest->phone }}
    @endif
    @if($contactRequest->event_type)
    **Veranstaltungsart:** {{ match($contactRequest->event_type) {
    'wedding' => 'Hochzeit',
    'birthday' => 'Geburtstag',
    'corporate' => 'Firmenevent',
    default => 'Sonstiges',
} }}
    @endif
    @if($contactRequest->event_date)
    **Veranstaltungsdatum:** {{ $contactRequest->event_date->format('d.m.Y') }}
    @endif
    @if($contactRequest->message)

    **Nachricht:**
    {{ $contactRequest->message }}
    @endif

    ---

    <x-mail::button :url="config('app.url') . '/admin/contact-requests'">
        Im Admin-Panel ansehen
    </x-mail::button>

    Mit freundlichen Grüßen,
    Ihr Website-System
</x-mail::message>