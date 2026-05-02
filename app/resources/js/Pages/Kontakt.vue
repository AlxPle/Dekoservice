<template>
  <MainLayout
    title="Kontakt & Anfrage – Helena Kunz Dekoservice"
    description="Kontaktieren Sie uns für Ihr Event. Kostenlose Beratung für Hochzeiten, Geburtstage und Firmenfeiern."
    :canonicalUrl="canonicalUrl"
  >

    <section class="py-16 bg-ivory">
      <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10">
          <h1 class="font-serif text-4xl font-semibold text-forest mb-3">Kontakt & Anfrage</h1>
          <p class="text-forest/60 max-w-lg mx-auto">
            Senden Sie uns Ihre Anfrage – wir melden uns innerhalb von 24 Stunden bei Ihnen.
          </p>
        </div>

        <!-- Success message -->
        <div v-if="$page.props.flash?.success" class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 text-sm">
          {{ $page.props.flash.success }}
        </div>

        <form @submit.prevent="submit" class="bg-white rounded-2xl shadow-sm border border-sand/20 p-8 space-y-5">

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
              <label class="form-label">Vorname *</label>
              <input v-model="form.first_name" type="text" class="form-input" :class="{ 'border-red-400': form.errors.first_name }" required />
              <p v-if="form.errors.first_name" class="form-error">{{ form.errors.first_name }}</p>
            </div>
            <div>
              <label class="form-label">Nachname *</label>
              <input v-model="form.last_name" type="text" class="form-input" :class="{ 'border-red-400': form.errors.last_name }" required />
              <p v-if="form.errors.last_name" class="form-error">{{ form.errors.last_name }}</p>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
              <label class="form-label">E-Mail *</label>
              <input v-model="form.email" type="email" class="form-input" :class="{ 'border-red-400': form.errors.email }" required />
              <p v-if="form.errors.email" class="form-error">{{ form.errors.email }}</p>
            </div>
            <div>
              <label class="form-label">Telefon</label>
              <input v-model="form.phone" type="tel" class="form-input" />
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
              <label class="form-label">Veranstaltungsart</label>
              <select v-model="form.event_type" class="form-input">
                <option value="">— bitte wählen —</option>
                <option value="wedding">Hochzeit</option>
                <option value="birthday">Geburtstag</option>
                <option value="corporate">Firmenevent</option>
                <option value="other">Sonstiges</option>
              </select>
            </div>
            <div>
              <label class="form-label">Veranstaltungsdatum</label>
              <input v-model="form.event_date" type="date" class="form-input" />
            </div>
          </div>

          <div>
            <label class="form-label">Nachricht</label>
            <textarea v-model="form.message" rows="5" class="form-input resize-none" placeholder="Erzählen Sie uns von Ihrer Veranstaltung…"></textarea>
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="w-full bg-forest text-ivory font-semibold py-3 rounded-full hover:bg-forest/90 transition-colors disabled:opacity-50"
          >
            {{ form.processing ? 'Wird gesendet…' : 'Anfrage senden' }}
          </button>

        </form>

        <!-- Alternative contact -->
        <div class="mt-10 text-center space-y-2 text-sm text-forest/60">
          <p>Oder direkt kontaktieren:</p>
          <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="https://wa.me/491705865783" target="_blank" rel="noopener noreferrer"
              class="inline-flex items-center gap-2 text-green-700 hover:text-green-800 font-medium">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
              </svg>
              +49 170 58 65 783
            </a>
            <a href="mailto:info@dekoservice-kunz.de" class="inline-flex items-center gap-1 hover:text-forest transition-colors">
              info@dekoservice-kunz.de
            </a>
          </div>
        </div>

      </div>
    </section>

    <!-- Map -->
    <section class="h-72 md:h-96 w-full">
      <div ref="mapEl" class="w-full h-full"></div>
    </section>

  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'
import 'leaflet/dist/leaflet.css'

const props = defineProps({
  canonicalUrl: { type: String, default: null },
})

const form = useForm({
  first_name: '',
  last_name: '',
  email: '',
  phone: '',
  event_type: '',
  event_date: '',
  message: '',
})

function submit() {
  form.post(route('kontakt.store'))
}

// Leaflet map — coordinates are placeholder, update with Helena's actual address
const mapEl = ref(null)
const LAT = 51.1657
const LNG = 10.4515
let map = null

onMounted(async () => {
  const L = (await import('leaflet')).default

  // Fix default marker icon path broken by bundlers
  delete L.Icon.Default.prototype._getIconUrl
  L.Icon.Default.mergeOptions({
    iconUrl: new URL('leaflet/dist/images/marker-icon.png', import.meta.url).href,
    iconRetinaUrl: new URL('leaflet/dist/images/marker-icon-2x.png', import.meta.url).href,
    shadowUrl: new URL('leaflet/dist/images/marker-shadow.png', import.meta.url).href,
  })

  map = L.map(mapEl.value, { scrollWheelZoom: false }).setView([LAT, LNG], 13)

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    maxZoom: 19,
  }).addTo(map)

  L.marker([LAT, LNG])
    .addTo(map)
    .bindPopup('<strong>Helena Kunz</strong><br>Dekoration & Event-Verleih')
    .openPopup()
})

onUnmounted(() => {
  map?.remove()
})
</script>

<style scoped>
.form-label {
  display: block;
  font-size: 0.875rem;
  font-weight: 500;
  color: #2d4a3e;
  margin-bottom: 0.25rem;
}
.form-input {
  width: 100%;
  border: 1px solid rgb(212 184 150 / 0.5);
  border-radius: 0.5rem;
  padding: 0.625rem 0.75rem;
  font-size: 0.875rem;
  color: #2d4a3e;
  background: white;
  outline: none;
  transition: border-color 0.15s, box-shadow 0.15s;
}
.form-input:focus {
  border-color: rgb(45 74 62 / 0.6);
  box-shadow: 0 0 0 3px rgb(45 74 62 / 0.1);
}
.form-error {
  color: #ef4444;
  font-size: 0.75rem;
  margin-top: 0.25rem;
}
</style>
