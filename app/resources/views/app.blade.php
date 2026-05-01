<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Helena Kunz Dekoservice') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:400,600,700|lato:400,500,600&display=swap" rel="stylesheet" />

        <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "LocalBusiness",
            "name": "Helena Kunz Dekoservice",
            "description": "Hochwertiger Deko-Verleih und professionelle Eventgestaltung fuer Hochzeiten, Geburtstage und Firmenevents.",
            "url": "{{ config('app.url') }}",
            "telephone": "+491705865783",
            "email": "info@dekoservice-kunz.de",
            "priceRange": "EUR",
            "areaServed": "DE"
        }
        </script>

        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
