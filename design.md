# Design Audit v2 — Structure & Page Improvement Plan: Dekoservice Kunz

Date: 2026-05-01
Target site: http://www.dekoservice-kunz.de/
Version: v2 (structure-focused, based on corrected screenshots)

## 1) Source screenshots (corrected set)

Primary set used for this update:

- screenshots/Screenshot 2026-05-01 at 19-57-03 Startseite.png
- screenshots/Screenshot 2026-05-01 at 19-57-20 Über uns.png
- screenshots/Screenshot 2026-05-01 at 19-57-42 Bildergalerie.png
- screenshots/Screenshot 2026-05-01 at 19-57-53 Kontakt.png
- screenshots/Screenshot 2026-05-01 at 19-58-03 Impressum.png

Note:

- Compared to the previous capture set, content now renders fully on Galerie/Kontakt/Impressum.
- Previous spinner-only artifacts are not treated as primary findings in this revision.

---

## 2) Page-by-page analysis (based on corrected screenshots)

### A) Startseite

Observed:

1. The header area is visually heavy and uses low-contrast navigation text.
2. Main headline typography is elegant but oversized and visually dominant over key actions.
3. No clear primary CTA above the fold (Anfrage, WhatsApp, Termin).
4. A duplicated navigation row appears around the hero area, increasing clutter.
5. Decorative background graphics compete with content legibility.

Impact:

1. Lower clarity of first message.
2. Slower path from landing to contact conversion.
3. Reduced modern premium perception.

### B) Über uns

Observed:

1. Strong amount of text in long paragraphs without visual chunking.
2. Low contrast between text and background in some zones.
3. Limited trust-formatting (no portrait block, no timeline/process, no credentials).

Impact:

1. Harder scanning on desktop and mobile.
2. Weaker emotional connection despite good personal story potential.

### C) Bildergalerie

Observed:

1. Gallery grid is clear and image quality is generally good.
2. Missing filters by style/event type/service category.
3. Missing conversion bridge from inspiration to inquiry.
4. No project metadata (location, style, setup scope, season, budget band).

Impact:

1. Gallery works as showcase but underperforms as lead-generation asset.
2. Users cannot quickly find relevant examples for their event.

### D) Kontakt

Observed:

1. Form is present and functional, but hierarchy is weak.
2. Primary action button has low visual prominence.
3. Label-input spacing is too wide, creating eye-travel friction.
4. No response-time promise near CTA.
5. No quick contact shortcuts near top (WhatsApp/click-to-call).

Impact:

1. Unnecessary friction in form completion.
2. Lower trust and urgency for user to submit.

### E) Impressum

Observed:

1. Legal content is complete and readable.
2. Very long text block with minimal typographic structure.
3. Could benefit from better section anchors and readability spacing.

Impact:

1. Legally sufficient but visually heavy.
2. Poor scanability for users looking for specific legal details.

---

## 3) Updated key findings (priority issues)

### Critical

1. No clear conversion-first UX on key screens (especially Startseite and Kontakt).
2. Visual hierarchy is led by decoration, not by user intent and actions.
3. Header/navigation contrast and clarity need modernization.

### High

1. Gallery lacks filtering and CTA bridge to inquiry.
2. Contact form needs a simpler, faster layout.
3. Long-form text blocks need stronger typography structure.

### Medium

1. Decorative motifs can be retained as brand accent but must be reduced.
2. Footer/social area can become more useful with contact shortcuts and legal links.

---

## 4) Competitor pattern check (what others do better)

From the analyzed DE competitors in Verleih/Dekoration/Event:

1. Early CTA capture in hero or first viewport.
2. Clear service split (Dekoverleih vs Full Service).
3. Process block in 3-4 steps.
4. Testimonials and trust snippets near conversion points.
5. FAQ around logistics (Abholung, Reinigung, Kaution, Timing).
6. Gallery that supports decisions (filters, themes, categories).

Actionable interpretation for Dekoservice Kunz:

1. Keep the emotional style, but simplify layout and increase contrast.
2. Add one primary and one secondary CTA in every key viewport.
3. Turn inspiration blocks into inquiry opportunities.

---

## 5) Updated redesign direction

Design goal:

- Elegant, romantic, modern, and conversion-focused.

Visual principles:

1. Keep floral DNA as subtle accent, not dominant background.
2. Use two-font system only: display serif + readable sans-serif.
3. Improve contrast and spacing rhythm for readability.
4. Keep large photography but pair with clear CTA and concise copy.

---

## 6) Updated implementation roadmap

### Phase 1: Conversion foundation (1-2 weeks)

1. Rebuild header with strong contrast and clear nav states.
2. Remove duplicated nav row behavior.
3. Add hero CTA pair:
   - Primary: Anfrage senden
   - Secondary: WhatsApp / Anrufen
4. Improve first-screen messaging (value proposition + region/service scope).

KPIs:

1. Higher CTA click-through rate from Startseite.
2. Reduced bounce on entry pages.

### Phase 2: Contact and trust (1-2 weeks)

1. Redesign contact form layout for faster scanning.
2. Promote submit button and add response-time promise.
3. Add trust modules:
   - 3-6 testimonials
   - short process steps
   - service commitments

KPIs:

1. More form starts and completions.
2. Better conversion from Startseite to Kontakt.

### Phase 3: Gallery as sales tool (2-3 weeks)

1. Add filters: event type, style, setup type.
2. Add project captions/metadata.
3. Add inline CTA blocks inside gallery flow.

KPIs:

1. More click-through from gallery to inquiry.
2. Better engagement time in gallery section.

### Phase 4: Content quality and legal UX (1 week)

1. Rewrite long blocks into scannable sub-sections.
2. Improve Impressum/Datenschutz structure with headings and spacing.
3. Align footer with practical links and contact shortcuts.

KPIs:

1. Better reading depth on About/Legal pages.
2. Lower abandonment after legal/contact navigation.

---

## 7) Concrete block specs (for design handoff)

### Header

1. Left: logo/brand, center: navigation, right: contact shortcut.
2. Sticky behavior after first scroll.
3. Contrast-safe active/hover states.

### Hero

1. One clear promise headline.
2. One concise subheadline with service scope.
3. Two CTAs (primary and secondary).
4. Optional small trust line under CTA (e.g. response time).

### Service block

1. Two top cards:
   - Dekoverleih
   - Full Service
2. One-line value proposition per card.

### Gallery block

1. Filter chips and masonry/grid.
2. Card metadata and CTA to contact.

### Contact block

1. Compact fields with reduced eye-travel.
2. Strong CTA button style.
3. WhatsApp and call shortcuts near form title.

---

## 8) Definition of done (updated)

1. Desktop and mobile wireframes approved for Startseite, Über uns, Bildergalerie, Kontakt, Impressum.
2. CTA hierarchy consistent across all pages.
3. Gallery includes filtering and conversion path.
4. Contact form is easy to complete and visually clear.
5. Accessibility baseline verified (contrast, labels, keyboard focus, tap targets).

---

## 9) Immediate next step

Build a low-fidelity wireframe set for 5 pages with final section order and CTA copy in German, then convert it to a reusable Laravel + Vue component structure.

---
---

# V2 — Site Structure & Per-Page Improvement Plan

---

## A) Current vs. proposed site structure

### Current structure (flat, 5 separate page loads)

```
/ (Startseite)
├── /Ueber-uns/
├── /Bildergalerie/
├── /Kontakt/
└── /Impressum/
```

Problems:
1. Every page is a full reload of the same heavy template.
2. Navigation appears twice on the same viewport (header row + floating nav).
3. No anchor-based scroll on the home page — each content topic forces a full page load.
4. No sitemap-friendly internal linking between pages.
5. Sidebar on Startseite uses a Facebook iframe widget that adds no conversion value.

### Proposed structure (Inertia SPA, anchor-scroll on home)

```
/ (Startseite)
│  ├── #leistungen   (services section)
│  ├── #galerie      (gallery preview)
│  ├── #ueber-uns    (about Helena snippet)
│  └── #kontakt      (contact CTA strip)
├── /galerie          (full gallery with filters)
├── /ueber-uns        (full about page)
├── /kontakt          (full contact page)
└── /impressum        (legal page)
```

Benefits:
1. Single template load, fast navigation with Inertia transitions.
2. Home page covers the full funnel in one scroll.
3. Each anchor section links to the deeper standalone page for users who want more.
4. Internal links guide users from gallery → contact, about → contact.

---

## B) Shared shell improvements (all pages)

### Navigation (sticky header)

Current state:
- Two navigation rows present simultaneously (top bar + floating nav).
- Nav text has low contrast on light/decorative backgrounds.
- No contact shortcut visible at a glance.

Proposed structure:
```
[ Logo / Brand name ]   [ Startseite  Galerie  Über uns  Kontakt ]   [ Anfrage senden ↗ ]
```

Rules:
1. Single navigation row only. Remove the duplicate.
2. Sticky after first scroll: background becomes solid white/ivory with box-shadow.
3. CTA button (Anfrage senden) always visible on desktop, collapsed to hamburger + sticky WhatsApp on mobile.
4. Active page state: underline or color accent.

### Footer

Current state:
- Minimal content, copyright line only, no helpful links or contact shortcuts.

Proposed structure:
```
[ Brand tagline ]   [ Nav links ]   [ Contact info ]   [ Social links ]
[ Legal links: Impressum · Datenschutz · AGB ]   [ © year ]
```

Additions:
1. Phone and WhatsApp clickable in footer.
2. Service area mention (region covered).
3. Instagram link and optional feed preview.

---

## C) Page 1: Startseite — structural blueprint

### Current structure (problems annotated)

```
Heavy ornamental header
  ↓
Duplicate navigation row               ← REMOVE
  ↓
Large hero image (no CTA overlay)      ← ADD CTA PAIR
  ↓
3-column layout: main text | sidebar   ← REMOVE SIDEBAR
  Main: generic welcome paragraphs     ← REWRITE TO SCANNABLE BLOCKS
  Sidebar: Facebook widget             ← REMOVE
  ↓
Footer (copyright only)
```

### Proposed structure (section by section)

```
SECTION 1 — HERO
────────────────
Fullscreen photo (real event by Helena)
Overlay: headline + subheadline + 2 CTAs
```

Hero content spec:
- Headline: outcome-first, e.g. "Dein Event. Unvergesslich dekoriert."
- Subheadline: service scope, e.g. "Dekoverleih & Full Service · Hochzeit · Geburtstag · Event"
- CTA 1 (primary): "Jetzt anfragen" → scrolls to #kontakt
- CTA 2 (secondary): "Galerie ansehen" → scrolls to #galerie
- Trust micro-line: "Kostenlose Erstberatung · Antwort innerhalb 24h"

```
SECTION 2 — LEISTUNGEN (services split)
────────────────────────────────────────
2 cards side by side
```

Card A — Dekoverleih:
- Icon or photo
- Title: "Dekoverleih"
- 3 bullet benefits (e.g. Artikel selbst zusammenstellen, Abholung oder Lieferung, nur zahlen was du nimmst)
- Link: "Mehr erfahren"

Card B — Full Service Dekoration:
- Icon or photo
- Title: "Full Service"
- 3 bullet benefits (e.g. komplettes Dekokonzept, Auf- und Abbau durch Helena, persönliche Beratung inklusive)
- Link: "Anfrage stellen"

```
SECTION 3 — WIE ES FUNKTIONIERT (process)
──────────────────────────────────────────
4 horizontal steps
```

Step 1: Kennenlernen — kostenfreies Erstgespräch
Step 2: Konzept — individuelle Dekoidee
Step 3: Vorbereitung — Artikel zusammenstellen & liefern
Step 4: Event — genießen, alles wird abgeholt

```
SECTION 4 — GALERIE-VORSCHAU
─────────────────────────────
6–9 curated photos in masonry grid
Filter chips: Hochzeit / Geburtstag / Firmenevent
CTA at bottom: "Alle Fotos ansehen →"
```

```
SECTION 5 — ÜBER HELENA (snippet)
───────────────────────────────────
Left: photo of Helena
Right: short personal statement (3–4 sentences max)
Link: "Mehr über uns →"
```

```
SECTION 6 — KUNDENSTIMMEN (testimonials)
─────────────────────────────────────────
3 testimonial cards: quote · name · event type · year
```

```
SECTION 7 — FAQ (collapsible)
──────────────────────────────
5 most common questions, collapsible accordion
```

Suggested questions:
1. Was ist der Unterschied zwischen Verleih und Full Service?
2. Wie früh sollte ich anfragen?
3. Kann ich Artikel auch liefern lassen?
4. Was passiert bei Beschädigungen?
5. In welchen Regionen seid ihr tätig?

```
SECTION 8 — KONTAKT-CTA STRIP
───────────────────────────────
Full-width band with background photo
Headline: "Bereit für euer Event?"
CTA: "Kostenlose Anfrage stellen"
Secondary: WhatsApp icon + Telefonnummer
```

---

## D) Page 2: Über uns — structural blueprint

### Current structure (problems annotated)

```
Header
  ↓
Header/banner image
  ↓
Long unstructured text (4+ paragraphs, no subheadings)   ← RESTRUCTURE
  ↓
Footer
```

Problems:
1. No portrait of Helena anywhere on the page — biggest missed trust signal.
2. Text is written as a single wall without visual rhythm.
3. No service commitment or values section.
4. No CTA at the end of a trust-building page.

### Proposed structure

```
SECTION 1 — PORTRAIT HERO
──────────────────────────
Left: large photo of Helena at work
Right:
  - Headline: "Ich bin Helena. Ich mache Events unvergesslich."
  - 3–4 sentence intro (personal, warm)
  - CTA: "Schreib mir"
```

```
SECTION 2 — MEINE GESCHICHTE
──────────────────────────────
Scannable story in short paragraphs (max 3 lines each)
Subheadings guide the eye:
  - Wie alles begann
  - Was mich antreibt
  - Mein Anspruch an jede Dekoration
```

```
SECTION 3 — MEINE WERTE (3 tiles)
───────────────────────────────────
Tile 1: Persönlichkeit — jedes Event ist einzigartig
Tile 2: Qualität — hochwertige Materialien & liebevolle Details
Tile 3: Verlässlichkeit — pünktlich, klar, transparent
```

```
SECTION 4 — WAS ICH ANBIETE (service list)
────────────────────────────────────────────
Quick horizontal list of service categories:
Hochzeitsdeko · Geburtstagsdeko · Firmenevent · Leihservice
```

```
SECTION 5 — CTA
────────────────
"Lass uns gemeinsam dein Event planen."
Button: "Anfrage senden"
```

---

## E) Page 3: Bildergalerie — structural blueprint

### Current structure (problems annotated)

```
Header
  ↓
Image grid (unfiltered, no captions)   ← ADD FILTERS + METADATA
  ↓
Footer
```

Problems:
1. No way to browse by event type or style.
2. Photos shown without context (what occasion, what style, what service level).
3. Gallery is a visual dead-end — no next step after viewing.

### Proposed structure

```
SECTION 1 — GALLERY INTRO
──────────────────────────
Short headline: "Unsere Arbeiten"
Sub: "Eindrücke aus Hochzeiten, Geburtstagen und Events"
Filter chips: [ Alle ] [ Hochzeit ] [ Geburtstag ] [ Firmenevent ] [ Boho ] [ Elegant ] [ Klassisch ]
```

```
SECTION 2 — MASONRY GRID
─────────────────────────
Responsive masonry (3 col desktop / 2 col tablet / 1 col mobile)
Each card:
  - Photo (consistent ratio for grid stability)
  - On hover: event type tag + optional short caption
  - Lightbox on click
```

Metadata per image (stored in DB, shown in lightbox):
- Event type
- Style tag
- Season / year
- Short description (optional)

```
SECTION 3 — MID-GALLERY CTA BANNER
─────────────────────────────────────
After every 9–12 images:
"Gefällt euch was ihr seht? Fragt jetzt unverbindlich an."
Button: "Anfrage stellen"
```

```
SECTION 4 — CLOSING CTA
─────────────────────────
"Euer Event könnte hier stehen."
Button: "Kontakt aufnehmen"
```

---

## F) Page 4: Kontakt — structural blueprint

### Current structure (problems annotated)

```
Header
  ↓
Form (wide spacing, weak button, no shortcuts at top)   ← REDESIGN
  ↓
Footer
```

Problems:
1. No quick contact options visible before scrolling to form.
2. Form fields are spaced too far apart, increasing scanning effort.
3. Submit button lacks visual weight and urgency.
4. No map or service area context.

### Proposed structure

```
SECTION 1 — QUICK CONTACT STRIP
──────────────────────────────────
3 contact tiles in a row:
  📱 WhatsApp: +49 170 58 65 783
  📞 Anruf:   +49 170 58 65 783
  ✉️ E-Mail:  [email address]
Each tile is a clickable link (tel:, https://wa.me/, mailto:)
Sub-line: "Ich antworte innerhalb von 24 Stunden"
```

```
SECTION 2 — CONTACT FORM (compact)
────────────────────────────────────
Two-column layout on desktop, single column on mobile

Row 1: [ Vorname* ]  [ Nachname* ]
Row 2: [ E-Mail* ]   [ Telefon ]
Row 3: [ Art des Events ]  (select: Hochzeit / Geburtstag / Firmenevent / Sonstiges)
Row 4: [ Gewünschtes Datum ]
Row 5: [ Nachricht ] (textarea, 3 rows)
Row 6: [ Datenschutz-Checkbox ]
Row 7: [ Anfrage senden ▶ ]  (full-width, high contrast)
```

```
SECTION 3 — LOCATION / SERVICE AREA
──────────────────────────────────────
Map embed (OpenStreetMap via Leaflet, no Google tracking)
Text: served region mention
```

---

## G) Page 5: Impressum — structural blueprint

### Current structure (problems annotated)

```
Header
  ↓
Unbroken wall of legal text   ← ADD STRUCTURE
  ↓
Footer
```

### Proposed structure

```
SECTION 1 — PAGE HEADER
─────────────────────────
Title: "Impressum"
Anchor jump links:
  [Angaben zum Unternehmen] [Haftungsausschluss] [Urheberrecht] [Datenschutz]
```

```
SECTION 2 — LEGAL SECTIONS (anchored)
───────────────────────────────────────
Each section:
  - H2 heading with id anchor
  - Compact prose, max 4–6 lines per block
  - Clear visual separation between sections
```

---

## H) Component reuse map

These components are shared across pages and built once:

| Component            | Used on                                  |
|----------------------|------------------------------------------|
| StickyHeader         | All pages                                |
| HeroSection          | Startseite, Über uns                     |
| ServiceCards         | Startseite                               |
| ProcessSteps         | Startseite                               |
| GalleryGrid          | Startseite (preview), Bildergalerie      |
| FilterChips          | Bildergalerie                            |
| LightboxModal        | Bildergalerie                            |
| TestimonialsRow      | Startseite                               |
| FaqAccordion         | Startseite                               |
| CtaStrip             | Startseite, Über uns, Bildergalerie      |
| QuickContactTiles    | Kontakt                                  |
| ContactForm          | Startseite (#kontakt), Kontakt           |
| WhatsAppButton       | All pages (floating, bottom-right)       |
| Footer               | All pages                                |

---

## I) Priority order for implementation

1. StickyHeader + Footer (shell, required for all pages)
2. Startseite: Hero + CTA (highest traffic, highest impact)
3. Startseite: ServiceCards + ProcessSteps (fast to build, high clarity value)
4. ContactForm (needed on Startseite and Kontakt)
5. GalleryGrid + FilterChips + LightboxModal (core functionality)
6. TestimonialsRow + FaqAccordion (trust, Phase 2)
7. Über uns page structure (personal, Phase 2)
8. Kontakt page: QuickContactTiles + full form layout
9. Impressum restructure (low effort, Phase 4)
