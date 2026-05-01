<template>
  <MainLayout
    title="Galerie – Helena Kunz Dekoservice"
    description="Inspiration und Beispiele unserer Dekorationen für Hochzeiten, Geburtstage und Firmenevents."
  >

    <section class="py-16 bg-ivory">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10">
          <h1 class="font-serif text-4xl font-semibold text-forest mb-3">Unsere Galerie</h1>
          <p class="text-forest/60 max-w-lg mx-auto">Einblicke in unsere Arbeiten – von Hochzeiten bis Firmenevents.</p>
        </div>

        <!-- Filter Chips -->
        <div class="flex flex-wrap justify-center gap-2 mb-10">
          <button
            v-for="cat in categories"
            :key="cat.value"
            @click="activeCategory = cat.value"
            :class="[
              'px-4 py-1.5 rounded-full text-sm font-medium transition-colors border',
              activeCategory === cat.value
                ? 'bg-forest text-ivory border-forest'
                : 'bg-white text-forest/70 border-sand/40 hover:border-forest/40'
            ]"
          >
            {{ cat.label }}
          </button>
        </div>

        <!-- Grid -->
        <div v-if="filteredImages.length" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
          <button
            v-for="image in filteredImages"
            :key="image.id"
            @click="openLightbox(image)"
            class="aspect-square overflow-hidden rounded-xl bg-sand/20 group"
          >
            <img
              :src="imageUrl(image.filename)"
              :alt="image.alt_text || 'Dekoration'"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
              loading="lazy"
              decoding="async"
            />
          </button>
        </div>
        <div v-else class="text-center py-20 text-forest/40">
          Noch keine Bilder in dieser Kategorie.
        </div>

      </div>
    </section>

    <!-- Lightbox -->
    <Teleport to="body">
      <Transition name="fade">
        <div
          v-if="lightboxImage"
          class="fixed inset-0 z-50 bg-black/80 flex items-center justify-center p-4"
          @click.self="closeLightbox"
        >
          <div class="relative max-w-3xl w-full">
            <button
              @click="closeLightbox"
              class="absolute -top-10 right-0 text-white/70 hover:text-white text-sm flex items-center gap-1"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
              Schließen
            </button>
            <img
              :src="imageUrl(lightboxImage.filename)"
              :alt="lightboxImage.alt_text || 'Dekoration'"
              class="w-full max-h-[80vh] object-contain rounded-xl"
            />
            <p v-if="lightboxImage.alt_text" class="text-white/70 text-sm text-center mt-3">
              {{ lightboxImage.alt_text }}
            </p>
          </div>
        </div>
      </Transition>
    </Teleport>

  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { ref, computed, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  images: { type: Array, default: () => [] },
})

const categories = [
  { value: 'all', label: 'Alle' },
  { value: 'wedding', label: 'Hochzeiten' },
  { value: 'birthday', label: 'Geburtstage' },
  { value: 'corporate', label: 'Firmenevents' },
  { value: 'other', label: 'Sonstiges' },
]

const activeCategory = ref('all')
const lightboxImage = ref(null)

const filteredImages = computed(() =>
  activeCategory.value === 'all'
    ? props.images
    : props.images.filter(img => img.category === activeCategory.value)
)

function openLightbox(image) {
  lightboxImage.value = image
  document.body.style.overflow = 'hidden'
}

function closeLightbox() {
  lightboxImage.value = null
  document.body.style.overflow = ''
}

function onKeydown(e) {
  if (e.key === 'Escape') closeLightbox()
}

function imageUrl(filename) {
  if (!filename) return ''
  return filename.startsWith('gallery/')
    ? `/storage/${filename}`
    : `/storage/gallery/${filename}`
}

onMounted(() => window.addEventListener('keydown', onKeydown))
onUnmounted(() => window.removeEventListener('keydown', onKeydown))
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
