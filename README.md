# Propress - Real Estate WordPress Theme

A modern and flexible Real Estate WordPress theme powered by the Google Maps API.  
This theme allows property geolocation, interactive map display, and a map-based search experience.

---

## ✨ Features

- Google Maps integration for property geolocation
- Interactive property map with custom markers
- Search view under map
- Custom Property post type
- Advanced custom metaboxes powered by CMB2
- Currency and price fields
- Image gallery fields
- Address autocomplete and map picker
- Responsive layout

---

## 🗺 Google Maps Integration

This theme uses the Google Maps JavaScript API to:

- Display properties on a dynamic map
- Add custom map markers
- Geocode property addresses
- Power the map-based search interface

### API Key Required

A valid Google Maps API key is required for map functionality.

### Required Google APIs

- Maps JavaScript API
- Geocoding API
- Places API (recommended for autocomplete)

### Setup Instructions

1. Go to: https://console.cloud.google.com/
2. Create or select a project
3. Enable the required APIs
4. Generate an API key
5. Add the API key in:

WordPress Admin → Theme Settings → Google Maps API Key

Without a valid API key, map features will not function.

---

## 🧩 CMB2 Integration

This theme bundles CMB2 directly inside the theme for portability and stability.

Official CMB2 Repository:  
https://github.com/CMB2/CMB2

CMB2 is used to generate and manage all custom metaboxes and structured property fields.

No external installation of CMB2 is required.

---

## 🔌 Included CMB2 Extensions

The theme integrates the following CMB2 extensions:

- CMB2_field_map
- CMB2-field-map
- CMB2-field-gallery
- CMB2-attached-posts
- CMB2-post-search-field
- CMB2-field-ajax-search
- CMB2-currency-price-field
- CMB2-Buttonset-Field
- CMB2-Image-Select-Field-Type
- CMB2-term-select
- CMB2-show-on
- CMB2-metatabs-options
- CMB2-grid

These extensions provide:

- Map and location picker fields
- AJAX-powered post search fields
- Currency and formatted price inputs
- Image selection and gallery management
- Attached related properties
- Tabbed admin metabox layouts
- Grid-based field organization
- Conditional field display logic

---

## 🏗 Property Management

The theme registers a custom **Property** post type.

Each property supports structured fields such as:

- Address
- Latitude
- Longitude
- Price
- Currency
- Property type
- Status (Sale / Rent)
- Gallery
- Related properties
- Taxonomies
- Additional metadata

All fields are powered by CMB2 and its extensions.

---

## 🔎 Map-Based Search View

The theme includes a dedicated search-under-map layout that allows users to:

- Browse properties directly on the map
- Filter results dynamically
- Click map markers to preview property details
- Navigate to individual property pages

The map and search interface are optimized for real estate browsing behavior.

---

## 📦 Installation

1. Upload the theme to `/wp-content/themes/`
2. Activate the theme from WordPress Admin
3. Add your Google Maps API key
4. Start adding properties

CMB2 and its extensions are bundled and require no additional setup.

---

## ⚙ Requirements

- WordPress 6.0+
- PHP 7.4+
- Google Maps API Key
- Enabled Google APIs (Maps + Geocoding)

---
