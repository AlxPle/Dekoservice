<template>
  <MainLayout
    title="Unsere Leistungen – Helena Kunz Dekoservice"
    description="Entdecken Sie unsere Leistungen für Hochzeiten, Geburtstage und Firmenevents."
    :canonicalUrl="canonicalUrl"
  >
    <!-- Hero -->
    <section class="relative bg-forest text-ivory overflow-hidden">
      <div class="absolute inset-0 bg-linear-to-br from-forest via-forest/95 to-forest/80"></div>
      <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 flex flex-col items-center text-center gap-5">
        <p class="text-sand text-sm font-medium tracking-widest uppercase">Leistungen</p>
        <h1 class="font-serif text-4xl md:text-5xl font-bold leading-tight max-w-2xl">Unsere Leistungen</h1>
        <p class="text-ivory/80 text-lg max-w-xl leading-relaxed">
          Von der ersten Idee bis zur finalen Dekoration begleiten wir Sie mit Erfahrung,
          Kreativität und einem Blick fuers Detail.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 mt-2">
          <Link href="/kontakt" class="btn-primary-hero">Unverbindlich anfragen</Link>
          <Link href="/galerie" class="btn-outline-light">Galerie ansehen</Link>
        </div>
      </div>
    </section>

    <section class="py-16 bg-ivory">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="font-serif text-4xl font-semibold text-forest mb-3">Unsere Leistungsbereiche</h2>
          <p class="text-forest/60 max-w-2xl mx-auto">
            Wählen Sie den Bereich, der zu Ihrem Anlass passt.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <Link
            v-for="service in services"
            :key="service.title"
            :href="service.href"
            class="service-card hover:shadow-md transition-shadow"
          >
            <div class="text-berry mb-4 text-4xl">{{ service.icon }}</div>
            <h2 class="font-serif text-xl font-semibold text-forest mb-2">{{ service.title }}</h2>
            <p class="text-forest/70 text-sm leading-relaxed">{{ service.desc }}</p>
            <span class="inline-block mt-4 text-sm font-medium text-berry/80 hover:text-berry">Mehr erfahren →</span>
          </Link>
        </div>

        <div class="text-center mt-12">
          <Link href="/kontakt" class="btn-primary">Unverbindlich anfragen</Link>
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
  leistungen: { type: Array, default: () => [] },
})

const services = props.leistungen
</script>

<style scoped>
@reference "../../css/app.css";
.btn-primary-hero {
  @apply bg-sand text-forest font-semibold px-6 py-3 rounded-full hover:bg-sand/80 transition-colors;
}
.btn-primary {
  @apply bg-forest text-ivory font-semibold px-6 py-3 rounded-full hover:bg-forest/90 transition-colors;
}
.btn-outline-light {
  @apply border border-ivory/50 text-ivory font-semibold px-6 py-3 rounded-full hover:bg-ivory/10 transition-colors;
}
.service-card {
  @apply bg-white rounded-2xl p-8 shadow-sm border border-sand/20;
}
</style>
