<template>
  <MainLayout
    title="Galerie – Helena Kunz Dekoservice"
    description="Inspiration und Beispiele unserer Dekorationen für Hochzeiten, Geburtstage und Firmenevents."
    :canonicalUrl="canonicalUrl"
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
            @mouseenter="preloadFull(image)"
            @focusin="preloadFull(image)"
            class="aspect-square overflow-hidden rounded-xl bg-sand/20 group"
          >
            <img
              :src="gridImageSrc(image)"
              :srcset="gridImageSrcSet(image)"
              sizes="(max-width: 640px) 46vw, (max-width: 768px) 30vw, (max-width: 1024px) 22vw, 276px"
              :alt="image.alt_text || 'Dekoration'"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
              loading="lazy"
              decoding="async"
              @error="onGridImageError($event, image)"
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
          v-if="lightboxIndex !== null"
          class="fixed inset-0 z-50 bg-black/85 flex items-center justify-center p-4"
          @click.self="closeLightbox"
        >
          <div class="relative max-w-3xl w-full">
            <!-- Close -->
            <button
              @click="closeLightbox"
              class="absolute -top-10 right-0 text-white/70 hover:text-white text-sm flex items-center gap-1"
              aria-label="Schließen"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
              Schließen
            </button>

            <!-- Counter -->
            <span class="absolute -top-10 left-0 text-white/50 text-sm">
              {{ lightboxIndex + 1 }} / {{ filteredImages.length }}
            </span>

            <!-- Prev -->
            <button
              v-if="filteredImages.length > 1"
              @click="prevImage"
              class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-12 text-white/70 hover:text-white p-2 transition-colors"
              aria-label="Vorheriges Bild"
            >
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
              </svg>
            </button>

            <!-- Image -->
            <img
              :src="fullImageUrl(filteredImages[lightboxIndex])"
              :alt="filteredImages[lightboxIndex].alt_text || 'Dekoration'"
              class="w-full max-h-[80vh] object-contain rounded-xl"
            />

            <!-- Next -->
            <button
              v-if="filteredImages.length > 1"
              @click="nextImage"
              class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-12 text-white/70 hover:text-white p-2 transition-colors"
              aria-label="Nächstes Bild"
            >
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
            </button>

            <p v-if="filteredImages[lightboxIndex].alt_text" class="text-white/70 text-sm text-center mt-3">
              {{ filteredImages[lightboxIndex].alt_text }}
            </p>
          </div>
        </div>
      </Transition>
    </Teleport>

  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'

const props = defineProps({
  images: { type: Array, default: () => [] },
  canonicalUrl: { type: String, default: null },
})

const categories = [
  { value: 'all', label: 'Alle' },
  { value: 'wedding', label: 'Hochzeiten' },
  { value: 'birthday', label: 'Geburtstage' },
  { value: 'corporate', label: 'Firmenevents' },
  { value: 'other', label: 'Sonstiges' },
]

const activeCategory = ref('all')
const lightboxIndex = ref(null)
const loadedFull = ref({})
const preloading = new Set()

const filteredImages = computed(() =>
  activeCategory.value === 'all'
    ? props.images
    : props.images.filter(img => img.category === activeCategory.value)
)

function openLightbox(image) {
  preloadFull(image)
  lightboxIndex.value = filteredImages.value.indexOf(image)
  document.body.style.overflow = 'hidden'
}

function closeLightbox() {
  lightboxIndex.value = null
  document.body.style.overflow = ''
}

function prevImage() {
  const len = filteredImages.value.length
  lightboxIndex.value = (lightboxIndex.value - 1 + len) % len
}

function nextImage() {
  lightboxIndex.value = (lightboxIndex.value + 1) % filteredImages.value.length
}

function onKeydown(e) {
  if (e.key === 'Escape') closeLightbox()
  if (e.key === 'ArrowLeft') prevImage()
  if (e.key === 'ArrowRight') nextImage()
}

function fallbackImageUrl(filename) {
  if (!filename) return ''

  return filename.startsWith('gallery/')
    ? `/storage/${filename}`
    : `/storage/gallery/${filename}`
}

function thumbImageUrl(image) {
  return image.thumb_url || fallbackImageUrl(image.filename)
}

function fullImageUrl(image) {
  return image.full_url || image.url || fallbackImageUrl(image.filename)
}

function gridImageSrc(image) {
  return loadedFull.value[image.id]
    ? fullImageUrl(image)
    : thumbImageUrl(image)
}

function gridImageSrcSet(image) {
  if (loadedFull.value[image.id]) {
    return ''
  }

  return image.thumb_srcset || ''
}

function onGridImageError(event, image) {
  event.target.src = fullImageUrl(image)
}

function preloadFull(image) {
  if (!image?.id || loadedFull.value[image.id] || preloading.has(image.id)) {
    return
  }

  preloading.add(image.id)

  const full = new Image()
  full.decoding = 'async'
  full.onload = () => {
    loadedFull.value = {
      ...loadedFull.value,
      [image.id]: true,
    }
    preloading.delete(image.id)
  }
  full.onerror = () => {
    preloading.delete(image.id)
  }
  full.src = fullImageUrl(image)
}

function preloadVisibleBatch(images) {
  images.slice(0, 12).forEach((image, index) => {
    setTimeout(() => preloadFull(image), index * 90)
  })
}

watch(filteredImages, (images) => {
  if (!images.length) return
  preloadVisibleBatch(images)
}, { immediate: true })

onMounted(() => window.addEventListener('keydown', onKeydown))
onUnmounted(() => window.removeEventListener('keydown', onKeydown))
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
