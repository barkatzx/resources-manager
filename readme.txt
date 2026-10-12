=== Qodeax Resources Manager ===
Contributors: qodeax
Tags: resources, shortcode, elementor
Requires at least: 6.0
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPL-2.0-or-later

Manage an unlimited number of independent resources and display published resources in a responsive grid.

== Installation ==

1. In WordPress, go to Plugins > Add New Plugin > Upload Plugin.
2. Upload qodeax-resources-manager.zip and select Install Now.
3. Activate Qodeax Resources Manager.
4. Open Resources in the dashboard and add a resource.

== Usage ==

Enter the resource title in the post title field and its formatted description in the main editor. Configure either or both buttons in the Resource Buttons and Display Order panel. Publish the resource to include it in the public listing.

Add [qodeax_resources] to a page. In Elementor Free, use its Shortcode widget and enter the shortcode there. Newly published resources appear automatically.

Shortcode option:

* [qodeax_resources limit="6"] — show up to six resources. By default all published resources are shown.

The grid uses three columns on desktop, two on tablet, and one on mobile. Invalid or zero limits use the default of all published resources. Resources sort by ascending Display Order, then publication date, then title.

== Polylang ==

When Polylang is active, this plugin registers Resources as translatable and filters the listing to the current page language. Create a separate resource for each language, then use Polylang's translation controls to link the English and Russian resources as translations. Enter each translation's title, description, and button labels in that language. A shortcode on an English page shows English resources; a shortcode on a Russian page shows Russian resources.

== Features ==

* Uses the native WordPress post editor and permission checks.
* Supports unlimited resources with independent titles, descriptions, and two optional buttons.
* Validates and escapes saved content and URLs; button links open safely in a new tab.
* Responsive three/two/one-column grid with scoped styles and language-aware Polylang filtering.
* No ACF, Elementor Pro, external libraries, or third-party services required.

== Testing ==

On a staging WordPress site, activate the plugin, publish sample resources with different display orders and optional buttons, then add the shortcode to a page or Elementor Free Shortcode widget. Check the default listing, columns and limit attributes, unpublished-resource visibility, and mobile/tablet layouts.

== Limitations ==

The shortcode intentionally displays only published resources. The limit is capped at 1,000 per request for a practical upper bound; leave it unset to show all resources. Resource content is edited with the standard WordPress editor.
