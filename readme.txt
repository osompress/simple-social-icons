=== Plugin Name ===
Contributors: studiopress, nathanrice, bgardner, dreamwhisper, laurenmancke, shannonsans, modernnerd, marksabbath, damiencarbery, helgatheviking, littlerchicken, tiagohillebrandt, wpmuguru, michaelbeil, norcross, rafaltomal, osompress, esther_sola, nahuai
Tags: social media, social networking, social profiles
Requires at least: 4.0
Tested up to: 6.9
Stable tag: 4.0.0

This plugin provides two ways to display social icons: a traditional widget (available on all WordPress versions) and block variations for the core Social Icons block (WordPress 6.9+).

== Description ==

Simple Social Icons is an easy to use, customizable way to display icons that link visitors to your various social profiles. You can choose which profiles to link to, customize the color and size of your icons, and align them to the left, center, or right.

**Two Ways to Use Social Icons:**

1. **Widget (WordPress 4.0+):** The traditional widget works on all supported WordPress versions. Simply drag the "Simple Social Icons" widget into any widget area and configure it from the widget form. All available icons are accessible through the widget.

2. **Block Variations (WordPress 6.9+):** On WordPress 6.9+, this plugin extends the core Social Icons block with additional icon variations. These icons automatically appear when adding a Social Icons block in the block editor. Block variations only add icons that are not already available in WordPress core, so you get the best of both worlds: core icons plus these additional options.

**Important:** If you're currently using the widget, nothing changes for you. The widget continues to work exactly as before on all WordPress versions. Block variations are an additional feature that only activates on WordPress 6.9+ and doesn't affect existing widget functionality.

*Note: The simple_social_default_glyphs filter has been deprecated from this plugin.

== Installation ==

1. Upload the entire simple-social-icons folder to the /wp-content/plugins/ directory
1. Activate the plugin through the 'Plugins' menu in WordPress

**Using the Widget:**
1. In your Widgets menu, drag the widget labeled "Simple Social Icons" into a widget area
1. Configure the widget by choosing a title, icon size and color, and the URLs to your various social profiles

**Using Block Variations (WordPress 6.9+):**
1. In the block editor, add a Social Icons block
1. Click the block and select from the available icon variations in the block settings
1. The plugin automatically adds additional icon options beyond what WordPress core provides

== Frequently Asked Questions ==

= What's the difference between the widget and block variations? =

The widget is the traditional way to add social icons and works on all WordPress versions (4.0+). It provides access to all available icons through a widget interface.

Block variations are a newer feature that extends the core Social Icons block (WordPress 6.9+). They only add icons that aren't already in WordPress core, so you get both core icons and additional options. Block variations are automatically available when you add a Social Icons block in the block editor.

Both methods work independently — you can use either one, or both, depending on your site's needs.

= Will updating break my existing widget setup? =

No. The widget functionality remains entirely unchanged. If you're using the widget, updating to version 4.0.0 will not affect your existing setup in any way. Block variations are an additional feature that activates only on WordPress 6.9+ and do not interfere with widget behavior.

= Which icons are available in widgets vs blocks? =

**Widget:** All icons are available, including those already included in WordPress core (such as Facebook, Twitter/X, Instagram, etc.), plus all additional icons provided by this plugin.

**Block Variations:** Only icons NOT included in WordPress core are added as variations. This means you retain all core icons (Facebook, Twitter/X, Instagram, LinkedIn, YouTube, etc.) and gain the extra icons from this plugin (AntennaPod, Bloglovin, Diaspora, IMDB, Ko-fi, Phone, PayPal, and many more). This results in full icon coverage when using the block editor.

= Can I use both widgets and blocks? =

Yes. You can use both methods simultaneously. For example, you might place the widget in a sidebar while using block variations within your page or post content. They operate independently and do not conflict with each other.

= Can I reorder the icons? =

Yes, icons can be reordered with the use of a filter. See: https://github.com/copyblogger/simple-social-icons/wiki/Reorder-icons-in-version-2.0

= Can I add an icon? =

Yes, icons can be added with the use of a filter. See: https://github.com/copyblogger/simple-social-icons/wiki/Add-an-additional-icon-in-version-2.0

= My icon styling changed after updating =

If your theme includes custom icon styling, you can try adding this line to your functions.php file:

`add_filter( 'simple_social_disable_custom_css', '__return_true' );`

This will remove icon styling options in the widget settings, and prevent Simple Social Icons from overriding custom theme styling.

= Which services are included? =

**Available in both Widgets and Blocks:**

* Amazon
* Behance
* Bloglovin
* Bluesky
* Diaspora
* Dribbble
* Email
* Etsy
* Facebook
* Flickr
* Github
* Goodreads
* Instagram
* LinkedIn
* Mastodon
* Medium
* Meetup
* Phone
* Pinterest
* Reddit
* RSS
* Snapchat
* Substack
* Telegram
* Threads
* TikTok
* Tripadvisor
* Tumblr
* X (Twitter)
* Vimeo
* WhatsApp
* Xing
* YouTube

**Available in Widgets only:**

* Periscope (service no longer exists, kept for backward compatibility)

**Available in Blocks only (WordPress 6.9+):**

* IMDB
* Ko-fi
* Letterboxd
* Signal
* YouTube Music
* Pixelfed
* Matrix
* ProtonMail
* PayPal
* AntennaPod
* Fedora
* Google Photos
* Google Scholar
* Mendeley
* Notion
* Overcast
* Pexels
* Pocket Casts
* Strava
* WeChat
* Zulip
* Apple Podcasts
* Podcast Addict
* iVoox

**Note:** Blocks also include all WordPress core social icons (Amazon, Behance, Bluesky, Dribbble, Etsy, Facebook, Flickr, GitHub, Goodreads, Instagram, LinkedIn, Mastodon, Meetup, Medium, Pinterest, Reddit, Snapchat, Telegram, Threads, TikTok, Tumblr, X/Twitter, Vimeo, WhatsApp, YouTube, Email/Mail, RSS/Feed) plus the additional icons listed above. Widgets provide access to all icons listed in the "Available in both" section above.

NOTE - The rights to each pictogram in the social extension are either trademarked or copyrighted by the respective company.

== Changelog ==

= 4.0.0 =
* Added block variations support for WordPress 6.9+
* Extends core Social Icons block with 31 additional icons: AntennaPod, Apple Podcasts, Bloglovin, Diaspora, Fedora, Google Photos, Google Scholar, IMDB, iVoox, Ko-fi, Letterboxd, Matrix, Mendeley, Notion, Overcast, PayPal, Pexels, Phone, Pixelfed, Pocket Casts, Podcast Addict, ProtonMail, Signal, Strava, Substack, Tripadvisor, WeChat, Xing, YouTube Music, and Zulip
* Block variations only add icons not already in WordPress core, so you get both core icons and these additional options
* Block variations automatically appear in the block editor when adding Social Icons blocks
* Widget functionality remains completely unchanged and works on WordPress 4.0+
* Block features are automatically enabled on WordPress 6.9+ and gracefully disabled on older versions

= 3.2.5 =
* Added Diaspora icon

= 3.2.4 =
* Improve Bluesky icon alignment

= 3.2.3 =
* Added Bluesky icon

= 3.2.2 =
* Added Etsy, Substack and Telegram icons

= 3.2.1 =
* Fixed issue with new icons

= 3.2 =
* Added Threads and Mastodon icons
* Updated X / Twitter icon

= 3.1.2 =
* Changed ownership from StudioPress to OsomPress. You can read more details about it in https://osompress.com/4-new-plugins-join-osompress-family/.

= 3.1.1 =
* Added Amazon, Goodreads, Meetup, Reddit, TikTok, Tripadvisor, and WhatsApp icons
* Updated GitHub icon
* Removed Google+ and StumbleUpon icons

= 3.1.0 =
* Add escaping to output
* Remove the svgxuse.js script

= 3.0.2 =
* Fixed issue where icons can fail if there is a space anywhere in its URL.

= 3.0.1 =
* Remove Grunt
* Fix AMP compatibility

= 3.0.0 =
* Obfuscate email address from spambots
* Prevent email links to open in new window if option selected
* Fix saving email by removing http:// from it
* Allow icons to accept transparent color on border and background
* Fix phone by removing http:// from it
* Updated Medium logo
* Added a proper uninstall hook
* Added a filter to disable the CSS
* Added filter to update the HTML markup

= 2.0.1 =
* Fixed typo in Snapchat icon markup
* Made CSS selectors more specific
* Added classes to each icon
* Added plugin version to enqueued CSS
* Updated Google + icon

= 2.0.0 =
* Added Behance, Medium, Periscope, Phone, Snapchat, and Xing icons
* Switched to svg, rather than icon font

= 1.0.14 =
* Accessibility improvements: change icon color on focus as well as on hover, add text description for assistive technologies

= 1.0.13 =
* Add textdomain loader

= 1.0.12 =
* Prevent ModSecurity blocking fonts from loading

= 1.0.11 =
* Update enqueue version for stylesheet, for cache busting

= 1.0.10 =
* Update textdomain, generate POT

= 1.0.9 =
* PHP7 compatibility

= 1.0.8 =
* Added border options

= 1.0.7 =
* Added Bloglovin icon

= 1.0.6 =
* Added filters

= 1.0.5 =
* Updated LICENSE.txt file to include social extension

= 1.0.4 =
* Updated version in enqueue script function

= 1.0.3 =
* Added Tumblr icon

= 1.0.2 =
* More specific in the CSS to avoid conflicts

= 1.0.1 =
* Made color and background color more specific in the CSS to avoid conflicts

= 1.0.0 =
* Switched to icon fonts, rather than images

= 0.9.5 =
* Added Instagram icon

= 0.9.4 =
* Added YouTube icon
* Added bottom margin to icons

= 0.9.3 =
* Fixed CSS conflict in some themes

= 0.9.2 =
* Added new profile options
* Changed default border radius to 3px

= 0.9.1 =
* Fixed some styling issues

= 0.9.0 =
* Initial Beta Release
