<template>
  <MainLayout
    title="Firmenevents – Helena Kunz Dekoservice"
    description="Professionelle Raumgestaltung für Messen, Konferenzen und Firmenveranstaltungen – stilsicher, zuverlässig und auf Ihre Marke abgestimmt."
    :canonicalUrl="canonicalUrl"
  >

    <!-- Hero -->
    <section class="relative bg-forest text-ivory overflow-hidden">
      <div class="absolute inset-0 bg-linear-to-br from-forest via-forest/95 to-forest/80"></div>
      <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 flex flex-col items-center text-center gap-5">
        <p class="text-sand text-sm font-medium tracking-widest uppercase">Leistungen · Firmenevents</p>
        <h1 class="font-serif text-4xl md:text-5xl font-bold leading-tight max-w-2xl">
          Professionelle Raumgestaltung für Ihren Unternehmensauftritt
        </h1>
        <p class="text-ivory/80 text-lg max-w-xl leading-relaxed">
          Ob Firmenjubiläum, Messe oder Weihnachtsfeier — wir gestalten Räume, die Eindruck hinterlassen und Ihre Unternehmenskultur widerspiegeln.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 mt-2">
          <Link href="/kontakt" class="btn-primary">Angebot anfragen</Link>
          <Link href="/galerie" class="btn-outline-light">Galerie ansehen</Link>
        </div>
      </div>
    </section>

    <!-- Intro -->
    <section class="py-16 bg-ivory">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
          <div class="space-y-4 text-forest/80 leading-relaxed">
            <h2 class="font-serif text-3xl font-semibold text-forest mb-4">Wenn Stil auf Professionalität trifft</h2>
            <p>
              Der erste Eindruck zählt — gerade bei Firmenveranstaltungen.
              Eine durchdachte, stimmungsvolle Raumdekoration signalisiert Ihren Gästen, Partnern und
              Mitarbeitern: Hier wurde an alles gedacht.
            </p>
            <p>
              Wir sind erfahren im Umgang mit Unternehmen jeder Größe und wissen, wie wichtig
              Termintreue, Diskretion und ein reibungsloser Ablauf sind. Von der Konzeptidee bis zum
              Abbau nach der Veranstaltung begleiten wir Sie zuverlässig.
            </p>
            <p>
              Auf Wunsch stimmen wir Farbwelt und Stil auf Ihre Corporate Identity ab —
              für einen stimmigen Gesamtauftritt.
            </p>
          </div>
          <div class="bg-sand/30 rounded-2xl aspect-[4/3] flex items-center justify-center text-7xl">
            🏢
          </div>
        </div>
      </div>
    </section>

    <!-- Was wir bieten -->
    <section class="py-16 bg-sand/20">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="font-serif text-3xl font-semibold text-forest mb-3">Unser Leistungsumfang für Unternehmen</h2>
          <p class="text-forest/60 max-w-lg mx-auto">Dezent und hochwertiger Stil, der Ihre Botschaft unterstreicht.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="item in offerings" :key="item.title"
            class="bg-white rounded-2xl border border-sand/20 shadow-sm p-6">
            <div class="text-3xl mb-3">{{ item.icon }}</div>
            <h3 class="font-serif font-semibold text-forest mb-2">{{ item.title }}</h3>
            <p class="text-forest/60 text-sm leading-relaxed">{{ item.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Anlässe -->
    <section class="py-16 bg-ivory">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
          <h2 class="font-serif text-3xl font-semibold text-forest mb-3">Für welche Events wir buchen</h2>
          <p class="text-forest/60 max-w-lg mx-auto">Von der kleinen Teamfeier bis zur großen Gala.</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
          <div v-for="occasion in occasions" :key="occasion"
            class="bg-sand/20 rounded-xl px-4 py-3 text-center text-sm font-medium text-forest/80">
            {{ occasion }}
          </div>
        </div>
      </div>
    </section>

    <!-- Warum wir -->
    <section class="py-16 bg-sand/20">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
          <h2 class="font-serif text-3xl font-semibold text-forest mb-3">Warum Unternehmen auf uns setzen</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
          <div v-for="reason in reasons" :key="reason.title"
            class="text-center p-6 bg-white rounded-2xl border border-sand/20 shadow-sm">
            <div class="text-3xl mb-3">{{ reason.icon }}</div>
            <h3 class="font-serif font-semibold text-forest mb-2">{{ reason.title }}</h3>
            <p class="text-forest/60 text-sm leading-relaxed">{{ reason.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-berry text-ivory">
      <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-serif text-3xl font-bold mb-4">Planen Sie Ihr nächstes Firmenevent?</h2>
        <p class="text-ivory/80 mb-8 text-lg leading-relaxed">
          Teilen Sie uns Anlass, Datum, Ort und Ihre Vorstellungen mit —
          wir melden uns zeitnah mit einem individuellen Angebot.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
          <Link href="/kontakt"
            class="bg-ivory text-berry font-semibold px-6 py-3 rounded-full hover:bg-ivory/90 transition-colors">
            Angebot anfragen
          </Link>
          <Link href="/galerie"
            class="border border-ivory/50 text-ivory font-semibold px-6 py-3 rounded-full hover:bg-ivory/10 transition-colors">
            Galerie ansehen
          </Link>
        </div>
      </div>
    </section>

  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({
  canonicalUrl: { type: String, default: null },
})

const offerings = [
  {
    icon: '🌿',
    title: 'Eingangs- & Begrüßungsbereich',
    desc: 'Der erste Eindruck zählt: Ein einladend gestalteter Empfangsbereich mit Blumen, Firmenelementen oder Willkommensschildern setzt den richtigen Ton.',
  },
  {
    icon: '🪑',
    title: 'Tisch- & Saalgestaltung',
    desc: 'Elegante Tischdekorationen, Tischkarten-Aufsteller, Mittelstücke und Saalgestaltung — dezent und hochwertig, passend zu Ihrer Veranstaltung.',
  },
  {
    icon: '✨',
    title: 'Beleuchtung & Ambiente',
    desc: 'Stimmungsvolle Lichtkonzepte mit Lichterketten, Kerzen und LED-Elementen schaffen eine einladende Atmosphäre — egal ob tagsüber oder abends.',
  },
  {
    icon: '📸',
    title: 'Foto-Wände & Backdrops',
    desc: 'Professionelle Fotowände mit Ihrem Logo, Firmenfarben oder thematischen Elementen — perfekt für Social-Media-Fotos und Pressetermine.',
  },
  {
    icon: '🎯',
    title: 'Corporate Identity',
    desc: 'Auf Wunsch stimmen wir Farben, Schriften und Materialien auf Ihr CI ab — für einen konsistenten, professionellen Gesamtauftritt.',
  },
  {
    icon: '🔧',
    title: 'Aufbau & Abbau',
    desc: 'Pünktlicher Aufbau vor Veranstaltungsbeginn und diskreter Abbau nach dem Ende — ohne Stress für Ihr Team.',
  },
]

const occasions = [
  'Firmenjubiläum',
  'Weihnachtsfeier',
  'Sommerfest',
  'Produktpräsentation',
  'Messe & Ausstellung',
  'Konferenz & Tagung',
  'Gala-Abend',
  'Teambuilding-Event',
  'Eröffnungsfeier',
]

const reasons = [
  {
    icon: '⏱️',
    title: 'Zuverlässigkeit',
    desc: 'Termine werden eingehalten, Absprachen verbindlich umgesetzt — damit Ihr Event reibungslos verläuft.',
  },
  {
    icon: '🎨',
    title: 'Individualität',
    desc: 'Kein vorgefertigtes Paket, sondern ein Konzept, das genau zu Ihrem Unternehmen und Anlass passt.',
  },
  {
    icon: '🤝',
    title: 'Persönlicher Kontakt',
    desc: 'Sie haben immer eine direkte Ansprechperson — von der ersten Anfrage bis nach der Veranstaltung.',
  },
]
</script>
