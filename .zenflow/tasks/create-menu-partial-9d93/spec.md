# Technical Specification: Menu Card Partials Design Consistency

## Task Overview
Improve the design and ensure consistency between two menu card partial templates:
- **V1**: `themes/workshop_v6_fixed_build 7/partials/sections/menu-card.htm` (Classic accordion layout)
- **V2**: `themes/workshop_v6_fixed_build 7/partials/sections/menu-card-v2.htm` (Modern Dribbble-inspired layout)

**Difficulty Level**: **Medium**  
The task requires careful attention to design tokens, component patterns, and maintaining functionality while improving visual consistency.

---

## Technical Context

### Technology Stack
- **Template Engine**: Twig (OctoberCMS)
- **CSS Framework**: Tailwind CSS
- **JavaScript**: Vanilla JS (V2 only - for filtering)
- **Font**: Open Sans (sans-serif body), serif for headings

### Data Structure
Both versions consume the same data:
```twig
this.theme.menu_menus        // Array of menu formulas
this.theme.menu_categories   // Array of dish categories
this.theme.menu_note         // Footer note text
```

---

## Current State Analysis

### V1 (Classic Accordion Layout)
**Strengths:**
- Sophisticated dark/light mode based on `block.background_color`
- Clean accordion UI for menu details ("Voir la formule")
- Responsive grid layout
- Good typography hierarchy

**Issues:**
- Inconsistent color scheme (`#7b1e1e` accent vs V2's pastel)
- Price display style differs from V2
- Tag styling differs significantly
- Separator design is basic
- No image support for dishes

### V2 (Modern Dribbble Layout)
**Strengths:**
- Modern card-based design with pastel backgrounds
- Vertical navigation with JavaScript filtering
- Support for "popular" dishes
- Image support for dishes
- Clean, contemporary aesthetic

**Issues:**
- No dark mode support (fixed light background)
- Pastel colors not coordinated with V1
- Typography less refined than V1
- No accordion for menus (always shows full details)
- JavaScript inline in template (not separated)

---

## Identified Inconsistencies

### 1. **Color System**
| Element | V1 | V2 | Issue |
|---------|----|----|-------|
| Accent color | `#7b1e1e` (burgundy) | Pastel array | No shared palette |
| Background | Configurable + dark mode | Fixed `#F5F5F5` | V2 ignores block setting |
| Card backgrounds | `bg-white/95` | `bg-white` | Opacity inconsistency |

### 2. **Typography**
| Element | V1 | V2 | Issue |
|---------|----|----|-------|
| Section title | `text-3xl md:text-4xl font-serif` | N/A | Missing in V2 |
| Card title | `text-lg font-semibold` | `text-lg font-bold` | Weight difference |
| Category headers | `text-xl font-serif` | Inline in card | Different approach |

### 3. **Component Styling**

#### Tags
- **V1**: `border border-[#7b1e1e]/30 bg-[#7b1e1e]/5 text-[#7b1e1e]`
- **V2**: `text-neutral-700` (no border, no background)
- **Impact**: Tags look completely different

#### Price Display
- **V1**: `rounded-xl bg-neutral-900 px-3 py-1.5 text-white` (badge style)
- **V2**: Inline `font-bold text-neutral-900` (plain text)
- **Impact**: V1 emphasizes price more

#### Allergens
- **V1**: `border border-neutral-200 bg-neutral-50` badges
- **V2**: `bg-neutral-100` badges
- **Impact**: Subtle but inconsistent

### 4. **Layout & Spacing**
- **Border radius**: V1 uses `rounded-2xl`, V2 mixes `rounded-2xl` and `rounded-3xl`
- **Card padding**: V1 uses `p-6`, V2 uses `px-6 py-5` and `px-6 py-6`
- **Grid gaps**: V1 uses `gap-6`, V2 uses `gap-8`

### 5. **Functional Differences**
- V1 has accordion for menu details, V2 shows all details
- V2 has filtering navigation, V1 doesn't
- V2 supports images and "popular" flag, V1 doesn't
- V1 has dark mode support, V2 doesn't

---

## Implementation Approach

### Design System Tokens (Shared)
Create consistent design tokens to be used in both versions:

```twig
{# Shared color palette #}
{% set brandPrimary = '#7b1e1e' %}
{% set brandPrimaryLight = 'rgba(123, 30, 30, 0.05)' %}
{% set brandPrimaryBorder = 'rgba(123, 30, 30, 0.3)' %}

{# Pastel backgrounds for cards (harmonized with brand) #}
{% set pastelColors = [
  '#F7E6CC',  // Warm beige
  '#F3D6A8',  // Light peach
  '#F1E3B8',  // Soft yellow
  '#E7EEF7',  // Light blue
  '#F4E6E6',  // Light burgundy (brand-aligned)
  '#E6F4EA',  // Mint green
  '#EDE7F6'   // Lavender
] %}

{# Typography scales #}
{% set titleClass = 'font-serif text-3xl md:text-4xl' %}
{% set subtitleClass = 'font-serif text-2xl md:text-3xl' %}
{% set cardTitleClass = 'font-semibold text-lg' %}
{% set bodyClass = 'text-base' %}
{% set smallClass = 'text-sm' %}
{% set tinyClass = 'text-xs' %}

{# Spacing #}
{% set cardPadding = 'p-6' %}
{% set cardRadius = 'rounded-2xl' %}
{% set gridGap = 'gap-6' %}
```

### Changes to V1 (`menu-card.htm`)

**1. Update Color Scheme**
- ✅ Keep existing `#7b1e1e` as primary accent
- ✅ Keep dark mode support
- ✅ Harmonize with V2's pastel array (add light burgundy)

**2. Enhance Card Styling**
- Add optional pastel backgrounds to formula cards (matching V2)
- Maintain accordion functionality
- Add image support to dish cards (like V2)
- Unify tag styling across both versions

**3. Typography Refinements**
- Ensure consistent font weights (`font-semibold` instead of mixing with `font-bold`)
- Standardize heading sizes
- Align spacing between elements

**4. Component Updates**
- **Price badges**: Keep V1 style but make optional (add variant support)
- **Allergen tags**: Standardize background to `bg-neutral-100`
- **Separators**: Enhance with better visual weight

**5. Add Features from V2**
- Support for `dish.popular` flag (display badge)
- Support for `dish.image` field (optional)

### Changes to V2 (`menu-card-v2.htm`)

**1. Add Dark Mode Support**
- Import dark mode detection logic from V1
- Apply to navigation panel and cards
- Adjust pastel colors for dark backgrounds

**2. Update Color System**
- Replace random pastel selection with brand-aligned palette
- Add burgundy accent color (`#7b1e1e`) for category headers
- Use consistent tag styling from V1

**3. Typography Refinements**
- Change `font-bold` to `font-semibold` for consistency
- Add section title/lead support (like V1)
- Standardize text sizes

**4. Component Updates**
- **Price display**: Option to use V1 badge style or keep inline
- **Tags**: Apply V1 border/background style
- **Allergen badges**: Use `bg-neutral-100` (match V1)

**5. Layout Improvements**
- Standardize border radius to `rounded-2xl`
- Unify padding to `p-6`
- Adjust grid gap to `gap-6`

**6. JavaScript Enhancement**
- Move inline script to external file or at least to bottom with better formatting
- Add comments for maintainability

---

## Source Code Changes

### Files to Modify
1. `themes/workshop_v6_fixed_build 7/partials/sections/menu-card.htm`
2. `themes/workshop_v6_fixed_build 7/partials/sections/menu-card-v2.htm`

### No New Files Required
All changes will be made in existing templates.

---

## Detailed Component Specifications

### 1. Tag Component (Unified)
```twig
{% if item.tag %}
  <span class="inline-flex mt-2 items-center rounded-full border border-[#7b1e1e]/30 bg-[#7b1e1e]/5 px-2.5 py-1 text-xs uppercase tracking-widest text-[#7b1e1e]">
    {{ item.tag }}
  </span>
{% endif %}
```

### 2. Price Display (Two Variants)

**Badge Style (V1 default)**
```twig
<span class="inline-flex items-center rounded-xl bg-neutral-900 px-3 py-1.5 text-sm font-semibold text-white whitespace-nowrap">
  {{ price }}{% if '€' not in price %} €{% endif %}
</span>
```

**Inline Style (V2 default)**
```twig
<span class="font-semibold text-neutral-900 whitespace-nowrap">
  {{ price }}{% if '€' not in price %} €{% endif %}
</span>
```

### 3. Allergen Display (Unified)
```twig
{% set allergens = item.allergens ?: [] %}
{% if allergens %}
  <details class="mt-2">
    <summary class="cursor-pointer select-none inline-flex items-center gap-2 text-[11px] tracking-widest uppercase text-neutral-500 hover:text-neutral-800 transition-colors">
      <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-white border border-neutral-200 text-neutral-700 text-[10px]">i</span>
      Allergènes
    </summary>
    <div class="mt-3 flex flex-wrap gap-2">
      {% for a in allergens %}
        <span class="text-[11px] px-2.5 py-1 rounded-full bg-neutral-100 text-neutral-700" title="{{ a|upper }}">
          {{ a }}
        </span>
      {% endfor %}
    </div>
  </details>
{% endif %}
```

### 4. Card Styling (Unified Base)
```twig
<article class="h-full bg-white/95 rounded-2xl p-6 border border-neutral-200 shadow-sm">
  {# Card content #}
</article>
```

### 5. Tab Navigation (Unified)
```twig
<div class="flex justify-center mb-10">
  <ul class="flex gap-8 text-xs uppercase tracking-[0.25em]">
    <li>
      <a href="?service=midi"
         class="pb-2 border-b-2 transition {{ current == 'midi'
           ? (tabActiveBorderClass ~ ' font-semibold ' ~ tabActiveTextClass)
           : ('border-transparent ' ~ tabInactiveTextClass ~ ' hover:' ~ tabActiveTextClass) }}">
        Midi
      </a>
    </li>
    <li>
      <a href="?service=soir"
         class="pb-2 border-b-2 transition {{ current == 'soir'
           ? (tabActiveBorderClass ~ ' font-semibold ' ~ tabActiveTextClass)
           : ('border-transparent ' ~ tabInactiveTextClass ~ ' hover:' ~ tabActiveTextClass) }}">
        Soir
      </a>
    </li>
  </ul>
</div>
```

---

## Verification Approach

### Visual Testing
1. Test both versions with:
   - Light background (`#f4eee3`)
   - Dark background (`#1a1a1a`)
   - Default background (none specified)

2. Verify responsive behavior:
   - Mobile (< 768px)
   - Tablet (768px - 1024px)
   - Desktop (> 1024px)

3. Check component consistency:
   - Tags appear identical in both versions
   - Allergen badges match exactly
   - Typography scales are harmonious
   - Color palette is cohesive

### Functional Testing
1. **V1**: Accordion open/close behavior
2. **V2**: Navigation filtering works correctly
3. Both: Midi/Soir tab switching
4. Both: Service-specific items display correctly
5. Both: Popular items show correctly (V2 has filter, V1 should show badge)

### Browser Testing
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile Safari (iOS)

### Accessibility Checks
- Color contrast meets WCAG AA (especially for dark mode)
- Keyboard navigation works for accordions and tabs
- Screen reader friendly (semantic HTML)

---

## Risk Assessment

### Low Risk
- Typography updates (mostly class changes)
- Color token standardization
- Spacing adjustments

### Medium Risk
- Dark mode integration in V2 (requires careful testing)
- Pastel color array changes (visual impact)
- JavaScript refactoring (V2)

### Mitigation
- Test incrementally after each major change
- Keep backups of original files
- Verify with real data in different service modes

---

## Success Criteria

1. ✅ Both versions use consistent color palette
2. ✅ Typography is harmonious across versions
3. ✅ Components (tags, allergens, prices) are visually aligned
4. ✅ Both versions maintain their unique layouts (accordion vs. grid)
5. ✅ Dark mode works in both versions
6. ✅ All existing functionality preserved
7. ✅ Code is cleaner and more maintainable
8. ✅ No visual regressions on any viewport size

---

## Implementation Order

1. **Define shared design tokens** (color palette, typography, spacing)
2. **Update V1** (color harmonization, add image support, add popular badge)
3. **Update V2** (add dark mode, color system, typography, component styling)
4. **Cross-verify** both versions for consistency
5. **Test** all scenarios (light/dark, midi/soir, responsive)
6. **Document** changes in report.md

---

## Notes

- Both versions maintain their unique layout approaches (V1 = list with accordions, V2 = grid with filtering)
- The goal is **visual consistency**, not identical layouts
- Dark mode support is critical for V1, should be added to V2
- The brand color `#7b1e1e` (burgundy) is the primary accent and should be used consistently
- Pastel backgrounds in V2 should include a light burgundy variant for brand alignment
