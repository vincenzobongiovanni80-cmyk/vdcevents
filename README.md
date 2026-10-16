# VDC Events & Consulting — vdcevents.com

Sito one-page statico (Astro) per VDC Events & Consulting, Torino.

## Sezioni
Hero · Metodo · Servizi chiavi in mano · Marketing (servizi digitali, senza prezzi pubblici) · Contatti (form via `public/contact.php` su hosting SiteGround)

## Sviluppo
```bash
bun install                      # oppure: npm install
bunx astro dev                   # dev server
ASTRO_TELEMETRY_DISABLED=1 bunx astro build   # build in dist/
```

## Deploy (SiteGround)
1. `ASTRO_TELEMETRY_DISABLED=1 bunx astro build`
2. Zippare il CONTENUTO di `dist/`
3. SiteGround → Site Tools → File Manager → `public_html` → caricare lo ZIP → Extract

Il form contatti richiede PHP (incluso in SiteGround): invia a valerio.dichirico@vdcevents.com.
