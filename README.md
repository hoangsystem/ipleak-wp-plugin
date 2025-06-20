# IP Leak WP Plugin

**IP Leak WP Plugin** is a lightweight and privacy-respecting WordPress plugin that helps users check for potential IP, DNS, and WebRTC leaks directly from the frontend of your website. Inspired by [ipleak.net](https://ipleak.net), this plugin works entirely in the browser and stores no data.

## 🔐 Features

- Detects and displays the following client-side information:
  - Public IP address
  - WebRTC IP leaks
  - DNS Resolver and ISP
  - Location (City, Region, Country)
  - Timezone
  - Connection Info (ASN, ORG, ISP, Domain)
  - Operating System
  - Browser
  - Device Type (Desktop or Mobile)
- Responsive layout (mobile & desktop friendly)
- Re-check button to refresh data without reloading the page
- Gutenberg Block support
- Shortcode support: `[ipleak_info]`
- Lightweight: no settings page, no data saved in DB
- Multilingual-ready: English + Vietnamese built-in, auto-detects site language

## 🧩 Installation

1. Upload the plugin ZIP file to your WordPress site via **Plugins → Add New → Upload Plugin**.
2. Or extract the ZIP and upload the folder `ipleak-wp-plugin` into `/wp-content/plugins/`.
3. Activate the plugin via the **Plugins** menu.

## 🚀 Usage

Use the shortcode directly in posts, pages, or widgets:

```plaintext
[ipleak_info]
