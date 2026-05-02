<template>
  <MainLayout
    title="Impressum – Helena Kunz Dekoservice"
    description="Rechtliche Informationen und Impressum von Helena Kunz Dekoservice."
    :canonicalUrl="canonicalUrl"
  >

    <section class="py-16 bg-ivory">
      <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        <h1 class="font-serif text-3xl font-semibold text-forest mb-8">Impressum</h1>

        <div class="prose prose-sm max-w-none text-forest/80 space-y-6">

          <div>
            <h2 class="font-semibold text-forest text-base mb-1">Angaben gemäß § 5 TMG</h2>
            <p>
              Helena Kunz<br>
              Dekoservice Kunz<br>
              [Straße und Hausnummer]<br>
              [PLZ Ort]
            </p>
          </div>

          <div>
            <h2 class="font-semibold text-forest text-base mb-1">Kontakt</h2>
            <p>
              Telefon: +49 170 58 65 783<br>
              E-Mail: <a href="mailto:info@dekoservice-kunz.de" class="text-berry hover:underline">info@dekoservice-kunz.de</a>
            </p>
          </div>

          <div>
            <h2 class="font-semibold text-forest text-base mb-1">Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV</h2>
            <p>Helena Kunz (Anschrift wie oben)</p>
          </div>

          <div>
            <h2 class="font-semibold text-forest text-base mb-1">Haftungsausschluss</h2>
            <p>
              Die Inhalte dieser Website wurden mit größtmöglicher Sorgfalt erstellt. Für die Richtigkeit,
              Vollständigkeit und Aktualität der Inhalte kann jedoch keine Gewähr übernommen werden.
            </p>
          </div>

          <div>
            <h2 class="font-semibold text-forest text-base mb-1">Urheberrecht</h2>
            <p>
              Die durch den Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem
              deutschen Urheberrecht. Beiträge Dritter sind als solche gekennzeichnet.
            </p>
          </div>

        </div>

      </div>
    </section>

  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'

const props = defineProps({
  canonicalUrl: { type: String, default: null },
})
</script>
