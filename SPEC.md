# Roadbard — Project Technical Spec
### For Claude Code handoff

---

## 1. Project overview

**Roadbard** is a motovlog YouTube channel with a druidic/storytelling identity. The creator's online persona is **Radagast**. This repo contains the web presence for the project:

- A **landing page** at `theroadbard.com` — already built (see below)
- A **blog** at `blog.theroadbard.com` — to be built next

The landing page's sole purpose is directing visitors to social platforms. The blog is for occasional meta-writing about the project — behind-the-scenes, process notes, channel updates. It will not host video content or be a high-traffic destination.

---

## 2. Repository structure

```
roadbard.com/
├── index.php          ← landing page (currently index.html — rename when PHP is introduced)
├── style.css          ← landing page styles
├── includes/          ← shared PHP partials
│   ├── head.php       ← <head> block (meta, fonts, CSS links)
│   ├── header.php     ← site header/nav
│   └── footer.php     ← footer
├── blog/              ← blog subdirectory (maps to blog.theroadbard.com via server config)
│   ├── index.php      ← post index — auto-generated from posts/
│   ├── post.php       ← single post template
│   ├── style.css      ← blog styles (inherits tokens from shared, extends for reading layout)
│   ├── includes/
│   │   ├── head.php
│   │   ├── header.php
│   │   └── footer.php
│   └── posts/         ← flat-file post storage
│       └── YYYY-MM-DD-slug.php   ← each post is a PHP file with metadata + content
└── shared/
    └── tokens.css     ← design token variables shared across landing + blog
```

> **Note on subdomain routing:** `blog.theroadbard.com` can be pointed at the `/blog/` subdirectory via a subdomain addon in cPanel (or equivalent), or via `.htaccess` rewriting. Confirm with host. No separate server configuration should be needed on shared PHP hosting.

---

## 3. PHP architecture — flat-file blog

No database. No framework. No CMS. Posts are PHP files; the index page reads them dynamically.

### Post file format

Each post lives at `blog/posts/YYYY-MM-DD-slug.php`. The file begins with a PHP metadata block, followed by the HTML content:

```php
<?php
$meta = [
  'title'       => 'Post title here',
  'date'        => '2026-05-01',
  'slug'        => 'post-slug-here',
  'description' => 'One sentence for meta description and post index excerpt.',
  'status'      => 'published',   // or 'draft' — drafts are skipped by index
];
?>

<p>Post content goes here as HTML. This is the first paragraph.</p>

<p>Further paragraphs follow.</p>
```

### Index page logic (`blog/index.php`)

Reads all `.php` files in `posts/`, extracts `$meta`, filters to `status === 'published'`, sorts by date descending, renders a list. No manual index maintenance needed — publish a post by setting status to `published`.

### Single post template (`blog/post.php`)

Accepts a `?slug=post-slug-here` query parameter. Finds the matching post file, `include()`s it to get `$meta` and render the content inside the template wrapper.

### URL structure

```
blog.theroadbard.com/              → index.php (post list)
blog.theroadbard.com/?slug=foo     → post.php?slug=foo (single post)
```

Optionally add `.htaccess` rewriting for cleaner URLs:
```
blog.theroadbard.com/foo           → post.php?slug=foo
```

---

## 4. Design system

All visual decisions are locked. Do not deviate without being asked to.

### Color tokens

```css
--bg:            #0e0b06;   /* near-black background */
--bg-mid:        #1a1409;   /* slightly lighter bg for cards */
--bark:          #3d2e0f;   /* borders, heavy strokes */
--saddle:        #5c4a1e;   /* mid-weight UI elements */
--oak:           #8b7355;   /* secondary text, icons, rules */
--gold:          #c4a96d;   /* primary accent — taglines, highlights */
--gold-dim:      #9a7e4f;   /* dimmed gold for hover targets */
--parchment:     #f0e8d0;   /* primary text */
--parchment-dim: #c8b882;   /* secondary text */
--forest:        #4a6741;   /* ecological accent, used sparingly */
```

### Typography

```css
--font-display: 'Cinzel', 'Palatino Linotype', 'Book Antiqua', Palatino, serif;
--font-body:    'IM Fell English', 'Palatino Linotype', Georgia, serif;
```

Both loaded from Google Fonts:
```html
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=IM+Fell+English:ital@0;1&display=swap" rel="stylesheet">
```

**Usage:**
- `--font-display`: headings, wordmark, nav labels, section labels — tracked, uppercase where appropriate
- `--font-body`: all body copy, post content, taglines, italics — this is the reading font

### Tone markers
- Grain overlay on all pages: fixed, `opacity: 0.045`, SVG fractalNoise texture
- Ornamental rules: thin lines with centered diamond `◆` divider
- Awen mark: three dots `● ● ●` used as a decorative motif above headings
- Animation: `fade-up` on page load, staggered with `animation-delay`; always include `prefers-reduced-motion` override

### What the blog style needs beyond the landing page
- Comfortable long-form reading width: `max-width: 68ch` on article body
- Generous line-height: `1.85` for post body paragraphs
- Post header: title in `--font-display`, date in small-caps `--font-body` `--oak`
- `<blockquote>`: left border in `--gold-dim`, italic, slightly indented
- `<code>` / `<pre>`: monospaced, `--bg-mid` background, `--gold` text — unlikely to be used often but should exist
- Back-to-index link at top and bottom of post

---

## 5. Landing page — existing implementation

Already built. Files: `index.html` (rename to `index.php` when PHP includes are added), `style.css`.

**What it contains:**
- Hero section: Awen dots, wordmark "Roadbard" with raised caps on R and D (1.25em, top-aligned via flexbox), ornamental rule, tagline, persona, lede
- Social links grid: YouTube, Instagram, TikTok, Bluesky (@theroadbard on all)
- Blog crosslink: left-border card pointing to `blog.theroadbard.com`
- Footer: copyright (JS auto-year), email `radagast@theroadbard.com`

**External dependencies (CDN — no npm, no build step):**
- Google Fonts: Cinzel + IM Fell English
- Font Awesome 6.5.1 (Cloudflare CDN) — for social icons
- Bluesky icon is inline SVG (not yet in FA6 free)

**When converting to PHP:** extract `<head>` contents and `<footer>` into `includes/head.php` and `includes/footer.php`. Replace with `<?php include '../includes/head.php'; ?>`. Keep the landing page logic in `index.php` itself.

---

## 6. Brand rules — non-negotiable

These are settled decisions. Do not suggest revisiting them.

- **Channel name:** Roadbard (one word, title case in prose; `ROADBARD` tracked caps in display/logo contexts)
- **Handle:** `@theroadbard` on all platforms
- **Persona/sign-off:** Radagast
- **Tagline:** *Tales from the long path.*
- **Full sign-off:** *— Radagast, a wandering druid on two wheels.*
- **Druidry and Awen** are authentic lived practice, not aesthetic decoration — treat references accordingly
- Do not introduce motorcycle imagery as a primary visual element — the channel is about the story, not the bike
- Do not use bold geometric sans-serif fonts anywhere in this project
- Earth tones only — nothing bright, nothing digital-primary

---

## 7. Hosting context

- Shared PHP hosting (cPanel-style)
- PHP available — no Node, no Python, no build pipeline
- Deployment: FTP or `git push` to server (depending on host's git support)
- No database — flat files only
- `blog.theroadbard.com` subdomain to be pointed at `/blog/` subdirectory

---

## 8. What to build next

Start here in the first Claude Code session:

1. Convert `index.html` → `index.php` with extracted PHP includes (`includes/head.php`, `includes/footer.php`)
2. Scaffold the `blog/` directory structure as defined in §3
3. Build `blog/index.php` — post list page with dynamic reading from `posts/`
4. Build `blog/post.php` — single post template
5. Build `blog/style.css` — inheriting tokens, adding reading layout
6. Write one placeholder draft post to verify the full pipeline works end-to-end

Do not add features beyond this scope without being asked.
