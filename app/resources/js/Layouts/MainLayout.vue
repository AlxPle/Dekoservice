<template>
  <Head>
    <title>{{ title }}</title>
    <meta v-if="description" name="description" :content="description" />
    <!-- Open Graph -->
    <meta property="og:title" :content="title" />
    <meta v-if="description" property="og:description" :content="description" />
    <meta property="og:type" content="website" />
    <meta v-if="canonicalUrl" property="og:url" :content="canonicalUrl" />
    <meta v-if="ogImage" property="og:image" :content="ogImage" />
    <meta property="og:locale" content="de_DE" />
    <meta property="og:site_name" content="Helena Kunz Dekoservice" />
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" :content="title" />
    <meta v-if="description" name="twitter:description" :content="description" />
    <meta v-if="ogImage" name="twitter:image" :content="ogImage" />
    <!-- Canonical -->
    <link v-if="canonicalUrl" rel="canonical" :href="canonicalUrl" />
  </Head>
  <div class="min-h-screen flex flex-col font-sans">
    <!-- Sticky Header -->
    <header
      ref="headerEl"
      class="sticky top-0 z-50 relative bg-ivory/95 backdrop-blur border-b border-sand/30 transition-shadow"
      :class="{ 'shadow-md': scrolled }"
    >
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <!-- Logo -->
          <Link href="/" class="flex items-center gap-2 group">
            <span class="text-xl font-serif font-semibold text-forest tracking-wide group-hover:text-forest/80 transition-colors">
              Helena Kunz
            </span>
            
          </Link>

          <!-- Desktop Nav -->
          <nav class="hidden md:flex items-center gap-6">
            <Link href="/#leistungen" class="nav-link">Leistungen</Link>
            <Link href="/galerie" class="nav-link">Galerie</Link>
            <Link href="/ueber-uns" class="nav-link">Über uns</Link>
            <Link href="/kontakt" class="nav-link">Kontakt</Link>
            <a
              href="https://wa.me/491705865783"
              target="_blank"
              rel="noopener noreferrer"
              class="btn-whatsapp"
            >
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
              </svg>
              WhatsApp
            </a>
          </nav>

          <!-- Mobile hamburger -->
          <button
            class="md:hidden p-2 rounded-lg text-forest hover:bg-sand/20 transition-colors"
            @click="mobileOpen = !mobileOpen"
            aria-label="Navigation öffnen"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path v-if="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
              <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

      </div>

      <!-- Mobile menu overlay -->
      <Transition name="slide">
        <nav v-if="mobileOpen" class="md:hidden absolute top-full left-0 right-0 bg-ivory/98 backdrop-blur border-b border-sand/30 shadow-lg py-3 flex flex-col gap-1 px-4 sm:px-6 z-40">
          <Link href="/#leistungen" class="mobile-link" @click="mobileOpen = false">Leistungen</Link>
          <Link href="/galerie" class="mobile-link" @click="mobileOpen = false">Galerie</Link>
          <Link href="/ueber-uns" class="mobile-link" @click="mobileOpen = false">Über uns</Link>
          <Link href="/kontakt" class="mobile-link" @click="mobileOpen = false">Kontakt</Link>
          <a
            href="https://wa.me/491705865783"
            target="_blank"
            rel="noopener noreferrer"
            class="mobile-link text-green-700 font-medium"
          >
            WhatsApp
          </a>
        </nav>
      </Transition>
    </header>

    <!-- Main content -->
    <main class="flex-1">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-forest text-ivory/90 py-10">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 mb-8">
          <div>
            <h3 class="font-serif text-lg font-semibold text-ivory mb-3">Helena Kunz</h3>
            <p class="text-sm text-ivory/70 leading-relaxed">
              Dekoration & Event-Verleih für Hochzeiten, Geburtstage und Firmenevents.
            </p>
          </div>
          <div>
            <h3 class="font-semibold text-ivory mb-3">Navigation</h3>
            <ul class="space-y-1 text-sm">
              <li><Link href="/#leistungen" class="footer-link">Leistungen</Link></li>
              <li><Link href="/galerie" class="footer-link">Galerie</Link></li>
              <li><Link href="/ueber-uns" class="footer-link">Über uns</Link></li>
              <li><Link href="/kontakt" class="footer-link">Kontakt</Link></li>
            </ul>
          </div>
          <div>
            <h3 class="font-semibold text-ivory mb-3">Kontakt</h3>
            <ul class="space-y-1 text-sm text-ivory/70">
              <li>
                <a href="https://wa.me/491705865783" target="_blank" rel="noopener noreferrer" class="footer-link">
                  +49 170 58 65 783
                </a>
              </li>
              <li>
                <a href="mailto:info@dekoservice-kunz.de" class="footer-link">info@dekoservice-kunz.de</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="border-t border-ivory/10 pt-6 flex flex-col sm:flex-row justify-between items-center gap-2 text-xs text-ivory/50">
          <span>© {{ new Date().getFullYear() }} Helena Kunz Dekoservice. Alle Rechte vorbehalten.</span>
          <Link href="/impressum" class="hover:text-ivory/80 transition-colors">Impressum</Link>
        </div>
      </div>
    </footer>

    <!-- Floating WhatsApp button -->
    <Transition name="wa-fade">
      <a
        v-if="scrolled"
        href="https://wa.me/491705865783"
        target="_blank"
        rel="noopener noreferrer"
        class="wa-float"
        aria-label="WhatsApp schreiben"
      >
        <svg viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
      </a>
    </Transition>
  </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'

defineProps({
  title: { type: String, default: 'Helena Kunz Dekoservice' },
  description: { type: String, default: null },
  canonicalUrl: { type: String, default: null },
  ogImage: { type: String, default: null },
})

const scrolled = ref(false)
const mobileOpen = ref(false)
const headerEl = ref(null)

function onScroll() {
  scrolled.value = window.scrollY > 10
}

function onClickOutside(e) {
  if (mobileOpen.value && headerEl.value && !headerEl.value.contains(e.target)) {
    mobileOpen.value = false
  }
}

onMounted(() => {
  window.addEventListener('scroll', onScroll, { passive: true })
  document.addEventListener('click', onClickOutside)
})
onUnmounted(() => {
  window.removeEventListener('scroll', onScroll)
  document.removeEventListener('click', onClickOutside)
})
</script>

<style scoped>
.nav-link {
  color: rgb(45 74 62 / 0.8);
  font-weight: 500;
  font-size: 0.875rem;
  transition: color 0.15s;
  position: relative;
}
.nav-link:hover {
  color: rgb(45 74 62);
}
.nav-link::after {
  content: '';
  position: absolute;
  bottom: -4px;
  left: 0; right: 0;
  height: 2px;
  background: #8b3a62;
  transform: scaleX(0);
  transition: transform 0.2s;
  transform-origin: left;
}
.nav-link:hover::after {
  transform: scaleX(1);
}
.btn-whatsapp {
  display: inline-flex;
  align-items: center;
  gap: 0.375rem;
  background: #16a34a;
  color: white;
  font-size: 0.875rem;
  font-weight: 500;
  padding: 0.375rem 0.75rem;
  border-radius: 9999px;
  transition: background 0.15s;
}
.btn-whatsapp:hover { background: #15803d; }
.mobile-link {
  display: block;
  padding: 0.5rem 0.75rem;
  border-radius: 0.5rem;
  color: #2d4a3e;
  font-size: 0.875rem;
  font-weight: 500;
  transition: background 0.15s;
}
.mobile-link:hover { background: rgb(212 184 150 / 0.3); }
.footer-link {
  color: rgb(250 247 242 / 0.7);
  transition: color 0.15s;
}
.footer-link:hover { color: #faf7f2; }
.slide-enter-active,
.slide-leave-active {
  transition: opacity 0.2s ease;
}
.slide-enter-from,
.slide-leave-to {
  opacity: 0;
}
.wa-float {
  position: fixed;
  bottom: 1.5rem;
  right: 1.5rem;
  z-index: 50;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 3.5rem;
  height: 3.5rem;
  border-radius: 9999px;
  background: #16a34a;
  color: white;
  box-shadow: 0 4px 14px rgb(0 0 0 / 0.25);
  transition: background 0.15s, transform 0.15s;
}
.wa-float:hover {
  background: #15803d;
  transform: scale(1.08);
}
.wa-fade-enter-active, .wa-fade-leave-active { transition: opacity 0.3s, transform 0.3s; }
.wa-fade-enter-from, .wa-fade-leave-to { opacity: 0; transform: translateY(12px); }
</style>
