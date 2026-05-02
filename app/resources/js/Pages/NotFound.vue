<template>
  <Head>
    <meta name="robots" content="noindex, nofollow" />
  </Head>
  <MainLayout
    title="404 – Seite nicht gefunden"
    description="Diese Seite gibt es leider nicht. Zurück zur Startseite von Helena Kunz Dekoservice."
    :canonicalUrl="canonicalUrl"
  >
    <section class="relative overflow-hidden bg-ivory py-24 md:py-32">
      <div class="decor decor-1"></div>
      <div class="decor decor-2"></div>
      <div class="decor decor-3"></div>
      <div class="decor decor-4"></div>

      <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-berry/80 font-semibold tracking-widest uppercase text-sm mb-4">Oops, verflixt</p>

        <div class="inline-flex items-end gap-2 md:gap-4 mb-6">
          <span class="number">4</span>
          <span class="number number-main">0</span>
          <span class="number">4</span>
        </div>

        <h1 class="font-serif text-3xl md:text-5xl text-forest font-bold mb-4">
          Diese Seite hat sich wohl versteckt
        </h1>
        <p class="text-forest/70 text-lg max-w-2xl mx-auto leading-relaxed mb-10">
          Keine Sorge, wir bringen Sie schnell wieder zurück.
          Vielleicht starten wir am besten auf der Hauptseite und schauen uns von dort gemeinsam um.
        </p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
          <Link href="/" class="btn-primary px-8 py-3 rounded-full">
            Zur Startseite
          </Link>
          <Link href="/galerie" class="btn-secondary px-8 py-3 rounded-full">
            Zur Galerie
          </Link>
          <Link href="/kontakt" class="btn-secondary px-8 py-3 rounded-full">
            Kontakt
          </Link>
        </div>
      </div>
    </section>
  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { Link, Head } from '@inertiajs/vue3'

defineProps({
  canonicalUrl: { type: String, default: null },
})
</script>

<style scoped>
.number {
  font-family: Georgia, 'Times New Roman', serif;
  font-size: clamp(4rem, 14vw, 8rem);
  line-height: 1;
  font-weight: 700;
  color: #8b3a62;
  text-shadow: 0 8px 24px rgb(139 58 98 / 0.2);
}

.number-main {
  color: #2d4a3e;
  transform: translateY(6px) rotate(-5deg);
}

.decor {
  position: absolute;
  border-radius: 9999px;
  opacity: 0.3;
  animation: float 8s ease-in-out infinite;
}

.decor-1 {
  width: 110px;
  height: 110px;
  background: #e7d8c9;
  top: 10%;
  left: 8%;
}

.decor-2 {
  width: 80px;
  height: 80px;
  background: #8b3a62;
  top: 18%;
  right: 12%;
  animation-delay: 1s;
}

.decor-3 {
  width: 140px;
  height: 140px;
  background: #2d4a3e;
  bottom: 8%;
  left: 12%;
  animation-delay: 2s;
}

.decor-4 {
  width: 90px;
  height: 90px;
  background: #e7d8c9;
  bottom: 14%;
  right: 10%;
  animation-delay: 0.5s;
}

.btn-secondary {
  border: 1px solid rgb(45 74 62 / 0.25);
  color: rgb(45 74 62 / 0.9);
  font-weight: 600;
  transition: all 0.2s ease;
}

.btn-secondary:hover {
  background: rgb(45 74 62 / 0.06);
  border-color: rgb(45 74 62 / 0.4);
}

@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}
</style>
