<template>
  <MainLayout
    title="Helena Kunz – Dekoration & Event-Verleih"
    description="Hochwertiger Deko-Verleih für Hochzeiten, Geburtstage und Firmenevents. Jetzt Angebot anfragen!"
    :canonicalUrl="canonicalUrl"
  >

    <!-- Hero -->
    <section class="relative bg-forest text-ivory overflow-hidden">
      <div class="absolute inset-0 bg-linear-to-br from-forest via-forest/95 to-forest/80"></div>
      <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-28 md:py-36 flex flex-col items-center text-center gap-6">
        <p class="text-sand text-sm font-medium tracking-widest uppercase">Hochzeiten · Geburtstage · Firmenevents</p>
        <h1 class="font-serif text-4xl md:text-6xl font-bold leading-tight max-w-3xl">
          Jeder Moment verdient einen unvergesslichen Rahmen
        </h1>
        <p class="text-ivory/80 text-lg max-w-xl leading-relaxed">
          Hochwertiger Deko-Verleih und professionelle Eventgestaltung in Ihrer Region — persönlich, kreativ, zuverlässig.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 mt-2">
          <Link href="/kontakt" class="btn-primary">Jetzt anfragen</Link>
          <Link href="/galerie" class="btn-outline-light">Galerie ansehen</Link>
        </div>
      </div>
    </section>

    <!-- Services -->
    <section id="leistungen" class="py-20 bg-ivory">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
          <h2 class="font-serif text-3xl md:text-4xl font-semibold text-forest mb-3">Unsere Leistungen</h2>
          <p class="text-forest/60 max-w-xl mx-auto">Von der Idee bis zur perfekten Dekoration — wir begleiten Sie auf jedem Schritt.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <Link v-for="service in services" :key="service.title" :href="service.href" class="service-card hover:shadow-md transition-shadow">
            <div class="text-berry mb-4 text-4xl">{{ service.icon }}</div>
            <h3 class="font-serif text-xl font-semibold text-forest mb-2">{{ service.title }}</h3>
            <p class="text-forest/70 text-sm leading-relaxed">{{ service.desc }}</p>
            <span class="inline-block mt-4 text-sm font-medium text-berry/80 hover:text-berry">Mehr erfahren →</span>
          </Link>
        </div>
      </div>
    </section>

    <!-- Process Steps -->
    <section class="py-20 bg-sand/20">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
          <h2 class="font-serif text-3xl md:text-4xl font-semibold text-forest mb-3">So einfach geht's</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
          <div v-for="(step, i) in steps" :key="step.label" class="flex flex-col items-center text-center gap-3">
            <div class="w-12 h-12 rounded-full bg-forest text-ivory font-serif font-bold text-lg flex items-center justify-center">
              {{ i + 1 }}
            </div>
            <h3 class="font-semibold text-forest">{{ step.label }}</h3>
            <p class="text-forest/60 text-sm leading-relaxed">{{ step.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Gallery Teaser -->
    <section id="galerie" class="py-20 bg-ivory">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-serif text-3xl md:text-4xl font-semibold text-forest mb-4">Unsere Arbeiten</h2>
        <p class="text-forest/60 mb-8 max-w-lg mx-auto">Schauen Sie sich an, wie wir Events in unvergessliche Erlebnisse verwandeln.</p>
        <Link href="/galerie" class="btn-primary">Zur Galerie</Link>
      </div>
    </section>

    <!-- Contact CTA -->
    <section id="kontakt" class="py-20 bg-berry text-ivory">
      <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-serif text-3xl md:text-4xl font-bold mb-4">Ihr nächstes Event wartet</h2>
        <p class="text-ivory/80 mb-8 text-lg leading-relaxed">
          Kontaktieren Sie uns für ein unverbindliches Beratungsgespräch. Wir freuen uns auf Ihre Anfrage!
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
          <Link href="/kontakt" class="bg-ivory text-berry font-semibold px-6 py-3 rounded-full hover:bg-ivory/90 transition-colors">
            Anfrage senden
          </Link>
          <a href="https://wa.me/491705865783" target="_blank" rel="noopener noreferrer"
            class="flex items-center gap-2 justify-center border border-ivory/50 text-ivory font-semibold px-6 py-3 rounded-full hover:bg-ivory/10 transition-colors">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            WhatsApp schreiben
          </a>
        </div>
      </div>
    </section>

  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  canonicalUrl: { type: String, default: null },
})

const services = [
  {
    icon: '💍',
    title: 'Hochzeiten',
    href: '/leistungen/hochzeiten',
    desc: 'Romantische Tischdekoration, Blumenarrangements, Lichterketten, Bögen und mehr – für Ihren unvergesslichsten Tag.',
  },
  {
    icon: '🎂',
    title: 'Geburtstage & Partys',
    href: '/leistungen/geburtstage',
    desc: 'Luftballons, Dekosäulen, Thementische – wir zaubern die perfekte Atmosphäre für jede Feier.',
  },
  {
    icon: '🏢',
    title: 'Firmenevents',
    href: '/leistungen/firmenevents',
    desc: 'Professionelle Raumgestaltung für Messen, Konferenzen und Firmenveranstaltungen – mit klarem Stil.',
  },
]

const steps = [
  { label: 'Anfrage senden', desc: 'Kontaktieren Sie uns per Formular, E-Mail oder WhatsApp.' },
  { label: 'Beratungsgespräch', desc: 'Wir besprechen Ihre Ideen, den Ablauf und den Rahmen.' },
  { label: 'Planung & Auswahl', desc: 'Gemeinsam stellen wir Ihr Dekopaket zusammen.' },
  { label: 'Aufbau & Abbau', desc: 'Wir liefern, bauen auf und räumen nach dem Event wieder ab.' },
]
</script>

<style scoped>
@reference "../../css/app.css";
.btn-primary {
  @apply bg-sand text-forest font-semibold px-6 py-3 rounded-full hover:bg-sand/80 transition-colors;
}
.btn-outline-light {
  @apply border border-ivory/50 text-ivory font-semibold px-6 py-3 rounded-full hover:bg-ivory/10 transition-colors;
}
.service-card {
  @apply bg-white rounded-2xl p-8 shadow-sm border border-sand/20 hover:shadow-md transition-shadow;
}
</style>
