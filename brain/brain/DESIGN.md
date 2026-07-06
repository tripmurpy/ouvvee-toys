---
version: alpha
name: Ouvvee Toys
description: Collector-friendly toy storefront with a warm neutral shell, a single strong ink primary, a cool indigo support color, and occasional editorial showcase surfaces.
colors:
  primary: "#111827"
  secondary: "#4648D4"
  tertiary: "#EC4899"
  neutral: "#F8F9FA"
  surface: "#FFFFFF"
  surface-soft: "#F1F3F5"
  line: "#E1E4EA"
  muted: "#5F6674"
  success: "#0F9F6E"
  warning: "#B7791F"
  danger: "#BA1A1A"
  editorial: "#C2652A"
  brand-soft: "#E1E0FF"
typography:
  display-xl:
    fontFamily: "Bricolage Grotesque"
    fontSize: 72px
    fontWeight: 800
    lineHeight: 0.98
    letterSpacing: -0.02em
  display-lg:
    fontFamily: "Bricolage Grotesque"
    fontSize: 56px
    fontWeight: 800
    lineHeight: 0.98
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: "Bricolage Grotesque"
    fontSize: 40px
    fontWeight: 700
    lineHeight: 1
  headline-md:
    fontFamily: "Bricolage Grotesque"
    fontSize: 28px
    fontWeight: 700
    lineHeight: 1.05
  body-lg:
    fontFamily: "Manrope"
    fontSize: 18px
    fontWeight: 400
    lineHeight: 1.6
  body-md:
    fontFamily: "Manrope"
    fontSize: 16px
    fontWeight: 400
    lineHeight: 1.5
  body-sm:
    fontFamily: "Manrope"
    fontSize: 14px
    fontWeight: 400
    lineHeight: 1.45
  label-lg:
    fontFamily: "Inter"
    fontSize: 12px
    fontWeight: 800
    lineHeight: 1
    letterSpacing: 0.12em
  label-sm:
    fontFamily: "Inter"
    fontSize: 11px
    fontWeight: 700
    lineHeight: 1
    letterSpacing: 0.08em
rounded:
  sm: 10px
  md: 16px
  lg: 22px
  xl: 28px
  full: 9999px
spacing:
  xs: 4px
  sm: 8px
  md: 12px
  lg: 16px
  xl: 24px
  xxl: 32px
  xxxl: 48px
  huge: 64px
components:
  button-primary:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.surface}"
    rounded: "{rounded.sm}"
    padding: "10px 16px"
  button-secondary:
    backgroundColor: "{colors.secondary}"
    textColor: "{colors.surface}"
    rounded: "{rounded.sm}"
    padding: "10px 16px"
  button-ghost:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.primary}"
    rounded: "{rounded.sm}"
    padding: "10px 16px"
  badge-default:
    backgroundColor: "{colors.brand-soft}"
    textColor: "{colors.secondary}"
    rounded: "{rounded.full}"
    padding: "6px 10px"
  badge-ok:
    backgroundColor: "#DCFCE7"
    textColor: "#166534"
    rounded: "{rounded.full}"
    padding: "6px 10px"
  badge-warn:
    backgroundColor: "#FEF3C7"
    textColor: "#92400E"
    rounded: "{rounded.full}"
    padding: "6px 10px"
  badge-danger:
    backgroundColor: "#FEE2E2"
    textColor: "#991B1B"
    rounded: "{rounded.full}"
    padding: "6px 10px"
  card:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.primary}"
    rounded: "{rounded.lg}"
    padding: "{spacing.xl}"
  product-card:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.primary}"
    rounded: "{rounded.lg}"
    padding: "{spacing.xl}"
  input:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.primary}"
    rounded: "{rounded.sm}"
    padding: "12px 13px"
  hero-stage:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.primary}"
    rounded: "{rounded.xl}"
    padding: "{spacing.xxxl}"
  admin-shell:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.surface}"
    rounded: "{rounded.md}"
---

# DESIGN.md - Ouvvee Toys

## Overview

Ouvvee Toys is a toy store for parents, gift buyers, and collectors. The UI should feel curated, trustworthy, and a little theatrical without becoming childish or noisy.

Products must stay in focus. Decoration supports the product, never replaces it. The default storefront is warm and calm. Editorial and exhibition pages may become darker or more dramatic, but they still need to push users toward catalog, detail, cart, and checkout.

Admin is quieter and utilitarian. It should read like a control surface, not like the storefront with a sidebar pasted on top.

## Colors

The palette is built around warm neutrals and one strong ink color, with indigo and pink used sparingly for emphasis.

- **Primary ({colors.primary}):** Deep ink for the strongest CTA, core text, the brand mark, and the parts of the UI that need the most contrast.
- **Secondary ({colors.secondary}):** Electric indigo for links, secondary actions, active states, badges, and other low-friction emphasis.
- **Tertiary ({colors.tertiary}):** Playful pink for very small accents only. It should never compete with the main CTA.
- **Neutral ({colors.neutral}):** Warm page background that feels lighter than white and less sterile than pure gray.
- **Surface ({colors.surface}) and Surface Soft ({colors.surface-soft}):** The content plane for cards, summaries, forms, and tables.
- **Line ({colors.line}) and Muted ({colors.muted}):** Borders, dividers, captions, helper text, and metadata.
- **Editorial ({colors.editorial}):** Reserved for collection and exhibition moments where the page wants a more curated, gallery-like tone.
- **Status colors ({colors.success}, {colors.warning}, {colors.danger}):** Only for actual status meaning. Do not use them as decoration.

Use one saturated accent per screen when possible. If a page is already dramatic, keep the rest of the palette quiet so the product remains readable.

## Typography

Bricolage Grotesque carries the voice of the brand. It is the display family for hero headlines, section titles, and product-first editorial moments.

Manrope handles the body copy. It should stay calm, legible, and comfortable at 16px to 18px.

Inter is reserved for labels, metadata, prices, table headers, and admin detail where density matters more than personality.

- **Display levels:** Short, bold, and tight. Use them for home hero headlines and showcase pages.
- **Headlines:** Clear hierarchy, strong weight, and controlled line length. Do not turn every label into a headline.
- **Body:** Readable first. Keep paragraphs short and avoid long line lengths.
- **Labels and metadata:** Uppercase or near-uppercase, compact, and spaced enough to separate them from body text.

Limit each screen to a small number of font weights. The point is clarity, not typographic gymnastics.

## Layout

The storefront uses a fluid grid with a comfortable max width. Most content should sit around 1180px wide, with wider editorial moments allowed up to about 1280px to 1440px when media needs breathing room.

The structure should always feel linear:

1. Discover.
2. Inspect.
3. Decide.
4. Checkout.

That means the page must always offer one obvious next step. If a screen has too many competing actions, it is too busy.

Spacing follows a simple rhythm with small steps for form controls and larger jumps for sections and page breaks. Keep related information in the same container instead of scattering it across the page.

Desktop favors 2 to 4 column product grids, card-based summaries, and a stable header. Mobile collapses to one column, keeps the header compact, and preserves the primary CTA without making the user hunt for it.

Admin layout uses a fixed sidebar and a content area that is denser than the storefront. Metrics and tables should be easy to scan, not visually loud.

## Elevation & Depth

Use borders first and shadow second.

The UI should feel tangible, not floaty. Cards can lift subtly on hover, hero panels can use soft layering, and product media can sit in a contained stage. But heavy shadows, deep blur, and glowing effects should stay rare.

The 3D viewer, when present, is a premium support element. It should live inside a calm frame and always have a static fallback. If the asset is missing or slow, the layout must still work.

Editorial showcase pages may use a darker atmosphere or a soft gradient wash, but that treatment should stay localized to that page family.

## Shapes

The default shape language is soft and rounded.

- Buttons: compact corners, easy to tap.
- Cards and panels: medium rounding so they feel friendly but still structured.
- Pills and badges: fully rounded.
- Large media surfaces: more generous rounding, especially for hero or product showcase areas.

Do not mix sharp and soft corners inside the same view unless the entire page is intentionally using a sharper editorial style. If a page chooses that style, keep it consistent across all of its surfaces.

## Components

### Buttons

Primary buttons are the highest-emphasis actions and should appear only once per screen when possible. Secondary buttons support navigation or the next-most-important action. Ghost buttons are for low-priority actions or secondary navigation.

Buttons must have clear hover, focus, and disabled states. Disabled should look disabled, not merely faded.

### Header

The storefront header is compact, sticky, and search-friendly. It should point to catalog, wishlist, cart, and order status without stealing attention from the product.

### Product Cards

Product cards are the core commerce component. They should always show:

- image or 3D preview
- brand or source
- product name
- category and age
- rating when available
- price
- stock state

Sold-out cards must be obvious. Desaturate or soften the media, show the state explicitly, and disable the purchase action.

### Forms

Labels stay visible. Errors stay near the field. Focus rings are always obvious.

Forms should feel calm and low-friction. Do not over-decorate them. Use whitespace, borders, and clear helper text instead.

### Badges and Chips

Badges and chips are short, semantic, and compact. They are for stock, status, and filters. They should not become tiny paragraphs.

### Cart and Order Summary

Quantities, subtotals, shipping, and totals must be easy to read in one pass. The total line gets the strongest emphasis in the panel.

### Empty States

Empty states should be short and useful. One sentence, one reason, one clear next action. No filler copy.

### Admin Cards and Tables

Admin surfaces should stay monochrome or near-monochrome. Use status badges sparingly. Tables need strong headers, stable row spacing, and minimal ornament.

### 3D Viewer

The 3D viewer is optional and never blocking. It is there to enhance product inspection, not to delay the page. If the model is absent, the fallback should preserve layout and intent.

## Do's and Don'ts

- Do make price, stock, age, and safety notes easy to find.
- Do keep one primary CTA per screen whenever possible.
- Do preserve visible focus, clear labels, and meaningful alt text.
- Do keep the storefront playful but credible.
- Do let editorial pages feel more dramatic, but never at the expense of checkout clarity.
- Do keep admin quieter than the storefront.
- Don't use neon gradients, confetti, mascot clutter, or busy texture.
- Don't let multiple saturated accents fight each other on the same screen.
- Don't hide commerce details behind hover-only interactions, tabs, or modals.
- Don't make admin feel like the storefront or the storefront feel like a dashboard.
