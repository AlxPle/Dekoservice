<template>
  <MainLayout
    title="Geburtstage & Partys – Helena Kunz Dekoservice"
    description="Luftballons, Thementische, Dekosäulen und mehr – wir zaubern die perfekte Atmosphäre für jeden Geburtstag und jede Party."
    :canonicalUrl="canonicalUrl"
  >

    <!-- Hero -->
    <section class="relative bg-forest text-ivory overflow-hidden">
      <div class="absolute inset-0 bg-linear-to-br from-forest via-forest/95 to-forest/80"></div>
      <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 flex flex-col items-center text-center gap-5">
        <p class="text-sand text-sm font-medium tracking-widest uppercase">Leistungen · Geburtstage & Partys</p>
        <h1 class="font-serif text-4xl md:text-5xl font-bold leading-tight max-w-2xl">
          Feiern, die man so schnell nicht vergisst
        </h1>
        <p class="text-ivory/80 text-lg max-w-xl leading-relaxed">
          Ob runder Geburtstag, Kinderparty oder spontanes Fest mit Freunden — wir sorgen dafür, dass Ihre Feier genau die Atmosphäre bekommt, die sie verdient.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 mt-2">
          <Link href="/kontakt" class="btn-primary">Jetzt anfragen</Link>
          <Link href="/galerie" class="btn-outline-light">Galerie ansehen</Link>
        </div>
      </div>
    </section>

    <!-- Intro -->
    <section class="py-16 bg-ivory">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
          <div class="bg-sand/30 rounded-2xl aspect-4/3 flex items-center justify-center text-7xl order-2 md:order-1">
            🎂
          </div>
          <div class="space-y-4 text-forest/80 leading-relaxed order-1 md:order-2">
            <h2 class="font-serif text-3xl font-semibold text-forest mb-4">Jede Feier hat ihre eigene Stimmung</h2>
            <p>
              Ein 18. Geburtstag fühlt sich anders an als ein 50. Jubiläum — und eine Kinderparty braucht
              eine ganz andere Energie als ein elegantes Abendessen mit engen Freunden.
              Wir verstehen das, und genau deshalb gestalten wir jede Dekoration individuell.
            </p>
            <p>
              Mit einem breiten Sortiment an Ballons, Tischdekorationen, Themenelementen und
              stimmungsvoller Beleuchtung verwandeln wir jeden Raum in eine Festkulisse — farbenfroh,
              gemütlich oder glamourös, ganz nach Ihrem Wunsch.
            </p>
            <p>
              Sagen Sie uns einfach, was Sie sich vorstellen — den Rest übernehmen wir.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Was wir bieten -->
    <section class="py-16 bg-sand/20">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="font-serif text-3xl font-semibold text-forest mb-3">Unser Angebot für Ihre Feier</h2>
          <p class="text-forest/60 max-w-lg mx-auto">Von kleinen Akzenten bis zur kompletten Raumgestaltung.</p>
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
          <h2 class="font-serif text-3xl font-semibold text-forest mb-3">Für jeden Anlass</h2>
          <p class="text-forest/60 max-w-lg mx-auto">Wir dekorieren für alle Arten von Feiern — groß und klein.</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
          <div v-for="occasion in occasions" :key="occasion"
            class="bg-sand/20 rounded-xl px-4 py-3 text-center text-sm font-medium text-forest/80">
            {{ occasion }}
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-berry text-ivory">
      <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-serif text-3xl font-bold mb-4">Lassen Sie uns gemeinsam feiern!</h2>
        <p class="text-ivory/80 mb-8 text-lg leading-relaxed">
          Kontaktieren Sie uns mit Datum, Anlass und Ihren Ideen —
          wir melden uns schnell mit konkreten Vorschlägen und einem unverbindlichen Angebot.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
          <Link href="/kontakt"
            class="bg-ivory text-berry font-semibold px-6 py-3 rounded-full hover:bg-ivory/90 transition-colors">
            Anfrage senden
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
    icon: '🎈',
    title: 'Ballondekoration',
    desc: 'Luftballon-Säulen, Ballon-Bögen, Ballonwände und individuelle Zahlen-Ballons — bunt, elegant oder in Ihren Wunschfarben.',
  },
  {
    icon: '🌟',
    title: 'Themen-Tische',
    desc: 'Abgestimmte Tischdekorationen mit Tischläufern, Kerzen, Blumen und persönlichen Details — passend zum Motto Ihrer Feier.',
  },
  {
    icon: '📸',
    title: 'Foto-Wände & Backdrops',
    desc: 'Stimmungsvolle Hintergründe für Ihre Erinnerungsfotos — mit Blumen, Lichterketten oder personalisierten Elementen.',
  },
  {
    icon: '✨',
    title: 'Licht & Stimmung',
    desc: 'Lichterketten, LED-Kerzen und dekorative Leuchtbuchstaben schaffen die richtige Atmosphäre — von verspielt bis glamourös.',
  },
  {
    icon: '🎁',
    title: 'Empfangs- & Geschenktisch',
    desc: 'Ein schön dekorierter Empfangs- oder Geschenktisch ist die erste Visitenkarte Ihrer Feier — wir gestalten ihn einladend und stilvoll.',
  },
  {
    icon: '🎉',
    title: 'Sonder-Wünsche',
    desc: 'Personalisierte Schilder, Namensbanner, Alterskacheln oder Themen-Accessoires — sprechen Sie uns einfach an.',
  },
]

const occasions = [
  'Kindergeburtstag',
  'Jugendfeier / 18.',
  'Runder Geburtstag',
  'Babyparty',
  'Verlobungsfeier',
  'Jubiläum',
  'Gartenparty',
  'Abschlussfeier',
  'Taufe & Kommunion',
]
</script>
