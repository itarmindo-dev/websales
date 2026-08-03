# Design QA — Armindo Perkasa Landing Page

## Source of truth

- Hero: `C:/Users/aplap/AppData/Local/Temp/codex-clipboard-e314b70a-e869-42e3-8a57-3ace16d13fd2.jpg`
- TCO: `C:/Users/aplap/AppData/Local/Temp/codex-clipboard-8767ef50-2734-4d2f-b428-1c7ceb11e4ba.jpg`
- Ready unit: `C:/Users/aplap/AppData/Local/Temp/codex-clipboard-6b396ded-a526-41f6-b394-e483c1f08e05.jpg`
- Testimonials: `C:/Users/aplap/AppData/Local/Temp/codex-clipboard-ebcd1006-dd00-4faf-88de-d351a02c1393.jpg`
- Contact: `C:/Users/aplap/AppData/Local/Temp/codex-clipboard-19c50d52-02ac-4bab-a508-aa4956f2a014.jpg`
- Previous full-page implementation: `C:/Users/aplap/AppData/Local/Temp/codex-clipboard-60c01025-49e1-407c-8464-48f2456d3e76.png`

## Verified implementation evidence

- Desktop overview: `C:/Users/aplap/.codex/visualizations/2026/08/03/019fc6d7-730d-7cd2-bc3a-ab9426a92eac/verified-desktop-overview.png`
- Mobile overview: `C:/Users/aplap/.codex/visualizations/2026/08/03/019fc6d7-730d-7cd2-bc3a-ab9426a92eac/verified-mobile-overview.png`
- Mobile menu open: `C:/Users/aplap/.codex/visualizations/2026/08/03/019fc6d7-730d-7cd2-bc3a-ab9426a92eac/mobile-menu-open-final.png`
- TCO result state: `C:/Users/aplap/.codex/visualizations/2026/08/03/019fc6d7-730d-7cd2-bc3a-ab9426a92eac/desktop-tco-result-final.png`
- Desktop comparison sheets:
  - `verified-compare-hero.png`
  - `verified-compare-tco.png`
  - `verified-compare-models.png`
  - `verified-compare-testimonials.png`
  - `verified-compare-contact.png`

All comparison sheets are stored in `C:/Users/aplap/.codex/visualizations/2026/08/03/019fc6d7-730d-7cd2-bc3a-ab9426a92eac/` and place the 16:9 reference beside the implementation in one image.

## Capture conditions

- Desktop viewport: 1440 × 810 CSS pixels, 1× screenshot density.
- Mobile viewport: 390 × 844 CSS pixels, 1× screenshot density.
- State: production Vite build served by Laravel at the landing page route.
- Browser: Codex in-app browser.
- Full-view coverage: five desktop section captures and six mobile state/section captures.

## Findings and corrections

1. Initial desktop hero was taller than the reference, leaving the CTA too low in a 16:9 viewport. Reduced the hero height and rebalanced map, truck, copy, CTA, and credential positions.
2. Initial TCO heading wrapped to three lines. Adjusted its desktop scale so the hierarchy and line breaks follow the reference more closely.
3. Initial contact cutout left excessive empty space. Replaced it with the existing full dealer asset and a restrained readability overlay, then tightened the heading width and vertical rhythm.
4. Initial mobile hero placed credentials over the second CTA. Returned the credentials to normal document flow and reserved a separate area for the truck.
5. Full-page browser stitching repeated absolutely positioned hero content. This was treated as a capture-tool artifact, not accepted as QA evidence; all final judgments use viewport-aligned section captures and side-by-side comparison sheets.

## Functional and accessibility checks

- No horizontal overflow at desktop or mobile breakpoints.
- No broken images and no browser console warnings or errors.
- One `h1`, one `main`, and one primary `nav` landmark.
- Mobile navigation opens, closes, and scrolls to the selected section.
- Calculator invalid input produces field-level text feedback.
- Calculator completes all three steps, produces a detailed TCO result, and creates a WhatsApp URL containing the selected HINO unit and calculated total.
- Visible focus treatment, explicit form labels, meaningful image alternatives, and reduced-motion handling are present.
- Calculator data is processed client-side and is not persisted.

final result: passed
