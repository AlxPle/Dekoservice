<template>
  <MainLayout
    title="Hochzeitsdekoration – Helena Kunz Dekoservice"
    description="Romantische Tischdekoration, Blumenbögen, Lichterketten und mehr – wir gestalten Ihren Hochzeitstag unvergesslich."
    :canonicalUrl="canonicalUrl"
  >

    <!-- Hero -->
    <section class="relative bg-forest text-ivory overflow-hidden">
      <div class="absolute inset-0 bg-linear-to-br from-forest via-forest/95 to-forest/80"></div>
      <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 flex flex-col items-center text-center gap-5">
        <p class="text-sand text-sm font-medium tracking-widest uppercase">Leistungen · Hochzeiten</p>
        <h1 class="font-serif text-4xl md:text-5xl font-bold leading-tight max-w-2xl">
          Ihr schönster Tag verdient die schönste Dekoration
        </h1>
        <p class="text-ivory/80 text-lg max-w-xl leading-relaxed">
          Von der ersten Idee bis zum letzten Blütenblatt — wir begleiten Sie und verwandeln Ihren Hochzeitstag in ein unvergessliches Erlebnis.
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
          <div class="space-y-4 text-forest/80 leading-relaxed">
            <h2 class="font-serif text-3xl font-semibold text-forest mb-4">Hochzeitsdekoration mit Herz</h2>
            <p>
              Eine Hochzeit ist mehr als ein Fest — sie ist der Beginn eines neuen Lebensabschnitts.
              Wir wissen, wie viel Liebe und Mühe in Ihrer Planung steckt, und nehmen diese Verantwortung sehr ernst.
            </p>
            <p>
              Mit einem Gespür für Stil, einem Auge für Details und einem reichen Fundus an hochwertigen
              Dekorationsartikeln gestalten wir eine Atmosphäre, die genau zu Ihnen und Ihrer Geschichte passt —
              ob romantisch-verspielt, modern-minimalistisch oder klassisch-elegant.
            </p>
            <p>
              Kein Wunsch ist zu groß, kein Detail zu klein. Wir sind von der Beratung bis zum Abbau an Ihrer Seite.
            </p>
          </div>
          <div class="bg-sand/30 rounded-2xl aspect-4/3 flex items-center justify-center text-7xl">
            💍
          </div>
        </div>
      </div>
    </section>

    <!-- Was wir bieten -->
    <section class="py-16 bg-sand/20">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="font-serif text-3xl font-semibold text-forest mb-3">Was wir für Sie bereitstellen</h2>
          <p class="text-forest/60 max-w-lg mx-auto">Ein Auszug aus unserem Verleih-Sortiment für Hochzeiten.</p>
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

    <!-- Ablauf -->
    <section class="py-16 bg-ivory">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="font-serif text-3xl font-semibold text-forest mb-3">So arbeiten wir zusammen</h2>
          <p class="text-forest/60 max-w-lg mx-auto">Einfach, persönlich und stressfrei — damit Sie sich ganz auf Ihren großen Tag freuen können.</p>
        </div>
        <div class="space-y-6">
          <div v-for="(step, i) in steps" :key="step.title" class="flex gap-5 items-start">
            <div class="w-10 h-10 shrink-0 rounded-full bg-forest text-ivory font-serif font-bold flex items-center justify-center">
              {{ i + 1 }}
            </div>
            <div>
              <h3 class="font-semibold text-forest mb-1">{{ step.title }}</h3>
              <p class="text-forest/60 text-sm leading-relaxed">{{ step.desc }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-berry text-ivory">
      <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-serif text-3xl font-bold mb-4">Bereit, Ihren Traum zu verwirklichen?</h2>
        <p class="text-ivory/80 mb-8 text-lg leading-relaxed">
          Schreiben Sie uns — wir erstellen Ihnen gerne ein unverbindliches Angebot
          und freuen uns darauf, Ihre Hochzeitsfeier gemeinsam mit Ihnen zu planen.
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
    icon: '🌸',
    title: 'Tischdekoration',
    desc: 'Traumhafte Tischgestaltungen mit Blumenarrangements, Kerzenhaltern, Tischläufern und stimmungsvoller Deko — individuell auf Ihr Farbkonzept abgestimmt.',
  },
  {
    icon: '🌿',
    title: 'Blumenbögen & Altäre',
    desc: 'Romantische Blumenbögen und Altar-Dekorationen als atemberaubender Hintergrund für Ihre Trauung — mit Kunst- oder Trockenblumen nach Ihrem Geschmack.',
  },
  {
    icon: '✨',
    title: 'Lichterketten & Beleuchtung',
    desc: 'Warmes Licht schafft Atmosphäre. Lichterketten, Lichtvorhänge und dekorative Leuchtbuchstaben setzen Ihren Festsaal in Szene.',
  },
  {
    icon: '🪑',
    title: 'Stuhlhussen & Tischdecken',
    desc: 'Hochwertige Stuhlhussen, elegante Tischdecken und Tischläufer in verschiedenen Farben und Stoffen — für ein stimmiges Gesamtbild.',
  },
  {
    icon: '🕊️',
    title: 'Raumgestaltung',
    desc: 'Eingangsbereich, Empfangstisch, Fotowand oder ganze Säle — wir denken die Dekoration als zusammenhängendes Erlebnis.',
  },
  {
    icon: '🎀',
    title: 'Sonder-Wünsche',
    desc: 'Personalisierte Details wie Namensschilder, Hochzeitszahlen, Monogramme oder thematische Accessoires — sprechen Sie uns einfach an.',
  },
]

const steps = [
  {
    title: 'Persönliche Beratung',
    desc: 'In einem ersten Gespräch — vor Ort oder telefonisch — lernen wir Ihre Vorstellungen, das Datum und die Location kennen.',
  },
  {
    title: 'Individuelles Angebot',
    desc: 'Auf Basis Ihrer Wünsche erstellen wir ein maßgeschneidertes Angebot mit konkreten Dekorations-Vorschlägen und Preisen.',
  },
  {
    title: 'Aufbau am Hochzeitstag',
    desc: 'Wir kommen rechtzeitig, bauen alles sorgfältig auf und sorgen dafür, dass alles perfekt sitzt — bevor die ersten Gäste eintreffen.',
  },
  {
    title: 'Abbau & Rückgabe',
    desc: 'Nach der Feier kümmern wir uns um den Abbau. Sie müssen sich um nichts sorgen — genießen Sie einfach Ihren Abend.',
  },
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
</style>
