# Design QA - Armindo Perkasa Landing Page

## Source visual truth

- Latest hero concept: `C:/Users/aplap/AppData/Local/Temp/codex-clipboard-71d69ff4-c20f-47c4-9572-7835a77d6183.png`
- Required hero asset: `C:/xampp/htdocs/LaravelProject/Sales/WebSales/public/img/slider/armindo_background.jpeg`
- Previous full-page references remain the source of truth for the TCO, ready-unit, testimonial, and contact sections.

## Implementation evidence

- Desktop pass 1: `C:/xampp/htdocs/LaravelProject/Sales/WebSales/design-qa-assets/hero-desktop-pass1.png`
- Desktop post-fix capture: `C:/xampp/htdocs/LaravelProject/Sales/WebSales/design-qa-assets/hero-desktop-pass2.png`
- Mobile capture: `C:/xampp/htdocs/LaravelProject/Sales/WebSales/design-qa-assets/hero-mobile-final.png`
- Final side-by-side comparison: `C:/xampp/htdocs/LaravelProject/Sales/WebSales/design-qa-assets/hero-comparison-final.png`

## Capture conditions and normalization

- Route/state: `/`, top of page, production Vite build served by Laravel.
- Browser: Codex in-app browser.
- Source pixels: 562 x 421. The concept's inner design frame was cropped to 522 x 372 before comparison.
- Desktop CSS viewport: 1280 x 720, device pixel ratio 1.5. Browser content raster: 1265 x 712.
- Mobile CSS viewport: 390 x 844, device pixel ratio 1. Browser content raster: 375 x 812.
- The source crop was aspect-filled to 1265 x 712 only for the comparison sheet; the implementation was not rescaled.
- State matched: transparent desktop navigation, centered hero copy and CTAs, product focal point, and bottom trust/location strip.

## Full-view comparison evidence

`hero-comparison-final.png` places the reference and implementation in one image. Both use a full-bleed valley landscape, lightweight navigation over the sky, centered dark display copy, green primary CTA, white secondary CTA, a central product focal point, and a restrained bottom strip. The supplied HINO truck in `armindo_background.jpeg` intentionally replaces the payment-card object in the generic concept.

Focused-region comparison was not required because the final 2530 x 776 comparison keeps the navigation, display typography, CTA labels, truck asset, and branch labels legible at once.

## Required fidelity surfaces

- Fonts and typography: existing Outfit family retained; headline uses a heavy optical weight, compact leading, and two-line desktop hierarchy matching the concept. Mobile wrapping remains readable without clipping.
- Spacing and layout rhythm: navigation, headline, body copy, CTAs, truck focal point, and bottom locations occupy the same vertical sequence as the concept. No new card-heavy structure was introduced.
- Colors and tokens: existing HINO/Armindo green tokens retained. Dark navy-green headline and restrained translucent white surfaces preserve contrast over the photo.
- Image quality and asset fidelity: the exact requested JPEG is used as a full-bleed `object-fit: cover` image; no placeholder, CSS drawing, generated substitute, or stretched secondary truck asset is present.
- Copy and content: generic financial-product copy was replaced with concise dealer-specific content; branch names and CTA destinations are real project content.

## Comparison history

1. Pass 1 found one P2 layout issue: the previous `760px` minimum hero height exceeded a 720px desktop viewport, moving the branch strip below the visible fold.
2. Fix: changed the desktop hero to `height: 100svh` with a 680px safety minimum while keeping mobile at a 760px minimum.
3. Pass 2 evidence: `hero-desktop-pass2.png` shows all four branches within the hero; the side-by-side sheet confirms the final composition and hierarchy.

## Functional and accessibility checks

- No horizontal overflow at the 390px mobile viewport.
- No broken images and no browser console warnings or errors.
- Hero has one descriptive `h1`, a labelled section, meaningful background-image alternative text, and keyboard-visible CTA focus styles.
- Mobile menu opens and closes with its expanded state exposed to assistive technology.
- `Lihat Produk` was activated and correctly scrolled to `#models`.
- WhatsApp CTAs retain explicit destinations and safe external-link attributes.
- The existing client-side TCO calculator and all later sections remain intact.

final result: passed
