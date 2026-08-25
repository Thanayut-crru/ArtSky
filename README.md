# ArtSky

Source code, research data, and reproducibility scripts for **ArtSky**, a geospatial decision-support system for stargazing suitability across an 11-station network in Chiang Rai Province, Thailand. This repository accompanies the paper *"ArtSky: An Independently Evaluated Geospatial Decision-Support System for Stargazing Suitability in Northern Thailand"* (manuscript, [author names/affiliation to be added]).

## Repository structure

- `app/` — ArtSky web application source (PHP). Requires a `.env` file (see `app/.env.example`) with your own API keys and database credentials — **never commit a real `.env` file**. Note: `app/app/plugins` (third-party PDF/mail libraries, ~116 MB) was removed from this repository to keep it lightweight; reinstall them separately (e.g., via Composer or by copying from the original project) if the PDF-export or mail features are needed.
- `database/schema.sql` — Database schema (table structure only). **Contains no data.** The full production database includes operator credentials and contact details and is not published here.
- `data/` — Research datasets used in the paper's analysis:
  - `AS_observed.csv` — Calibration-period sensor observations (n = 5,774; March-November 2024; 3 sensor-equipped stations).
  - `human_observed.csv` — Independent validation-period field observations (n = 583; December 2024-November 2025; all 11 stations).
  - `chiangrai_boundary.json` — Chiang Rai province administrative boundary (source: OpenStreetMap/Nominatim), used to render the station map figure.
- `scripts/` — PowerShell scripts used to derive and evaluate the suitability rule reported in the paper:
  - `decision_tree_train.ps1` — Trains the CART decision tree on `data/AS_observed.csv`.
  - `validate_against_field_observations.ps1` — Evaluates both the previous heuristic rule and the tree-derived rule against `data/human_observed.csv`.
  - `threshold_sensitivity_sweep.ps1` — Sensitivity analysis of the humidity/precipitation thresholds.
  - `render_station_map.ps1` / `render_drawio_to_png.ps1` — Regenerate the figures in `figures/`.
- `figures/` — Editable diagram sources (`.drawio`, open with [diagrams.net](https://app.diagrams.net)).

## Data and privacy notice

The datasets in `data/` contain only environmental sensor and weather-API readings (timestamps, coordinates, temperature, humidity, precipitation, weather condition, suitability labels). They contain **no personal data**. The production database (not published here) does contain operator account and contact information; see `database/schema.sql` for structure only.

## Known limitations (see paper, Section 5.1)

The reference-label generation methodology, human field-observation protocol, and several system-implementation details (API cost model, latency/uptime monitoring) are not fully documented in this repository at present. These are identified as open items in the accompanying paper.

## License

[To be added by the repository owner.]
