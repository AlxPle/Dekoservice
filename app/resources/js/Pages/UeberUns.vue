<template>
  <MainLayout
    title="Über uns – Helena Kunz Dekoservice"
    description="Helena Kunz – Leidenschaft für Dekoration und Eventgestaltung. Persönlich, kreativ und zuverlässig."
  >

    <section class="py-16 bg-ivory">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
          <h1 class="font-serif text-4xl font-semibold text-forest mb-3">Über uns</h1>
          <p class="text-forest/60 max-w-lg mx-auto">
            Leidenschaft für schöne Momente – das ist unser Antrieb.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-16">
          <div class="space-y-4 text-forest/80 leading-relaxed">
            <p>
              Mein Name ist <strong class="text-forest">Helena Kunz</strong>, und ich bin leidenschaftliche Dekorateurin
              mit einem Gespür für Stil, Details und Atmosphäre. Seit über 10 Jahren begleite ich Paare,
              Familien und Unternehmen bei der Gestaltung ihrer besonderen Momente.
            </p>
            <p>
              Was als kleines Herzensprojekt begann, ist heute ein vollständiger Deko-Verleih-Service mit
              einem vielfältigen Fundus an Dekorationselementen – von romantischen Lichterketten über
              elegante Tischdekoration bis hin zu stimmungsvollen Raumdekorationen.
            </p>
            <p>
              Jedes Event ist einzigartig, und genau das liebe ich an meiner Arbeit: Ihre Ideen und Vorstellungen
              in etwas Unvergessliches zu verwandeln.
            </p>
          </div>
          <div class="bg-sand/30 rounded-2xl aspect-[4/5] flex items-center justify-center text-forest/20 text-6xl">
            🌸
          </div>
        </div>

        <!-- Values -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-16">
          <div v-for="val in values" :key="val.title" class="text-center p-6 bg-white rounded-2xl border border-sand/20 shadow-sm">
            <div class="text-3xl mb-3">{{ val.icon }}</div>
            <h3 class="font-serif font-semibold text-forest mb-2">{{ val.title }}</h3>
            <p class="text-forest/60 text-sm leading-relaxed">{{ val.desc }}</p>
          </div>
        </div>

        <!-- CTA -->
        <div class="text-center">
          <p class="text-forest/60 mb-4">Bereit für Ihr Event?</p>
          <Link href="/kontakt" class="inline-block bg-forest text-ivory font-semibold px-8 py-3 rounded-full hover:bg-forest/90 transition-colors">
            Jetzt Anfrage senden
          </Link>
        </div>

      </div>
    </section>

  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { Link } from '@inertiajs/vue3'

const values = [
  {
    icon: '✨',
    title: 'Kreativität',
    desc: 'Jede Dekoration entsteht mit einem frischen Blick und einem Gespür für aktuelle Trends.',
  },
  {
    icon: '🤝',
    title: 'Verlässlichkeit',
    desc: 'Pünktlicher Aufbau, sorgfältiger Abbau – damit Sie sich ganz auf Ihr Event konzentrieren können.',
  },
  {
    icon: '💚',
    title: 'Herzlichkeit',
    desc: 'Persönliche Beratung und Begleitung vom ersten Gespräch bis zum letzten Dekodetail.',
  },
]
</script>
