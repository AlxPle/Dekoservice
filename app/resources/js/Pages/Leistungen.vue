<template>
  <MainLayout
    title="Unsere Leistungen – Helena Kunz Dekoservice"
    description="Entdecken Sie unsere Leistungen für Hochzeiten, Geburtstage und Firmenevents."
    :canonicalUrl="canonicalUrl"
  >
    <section class="py-16 bg-ivory">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h1 class="font-serif text-4xl font-semibold text-forest mb-3">Unsere Leistungen</h1>
          <p class="text-forest/60 max-w-2xl mx-auto">
            Von der ersten Idee bis zur finalen Dekoration begleiten wir Sie mit Erfahrung,
            Kreativität und einem Blick fuers Detail.
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
.btn-primary {
  @apply bg-forest text-ivory font-semibold px-6 py-3 rounded-full hover:bg-forest/90 transition-colors;
}
.service-card {
  @apply bg-white rounded-2xl p-8 shadow-sm border border-sand/20;
}
</style>
