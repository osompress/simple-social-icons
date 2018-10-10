=== Plugin Name ===
Contributors: studiopress, nathanrice, bgardner, dreamwhisper, laurenmancke, shannonsans, modernnerd, marksabbath, damiencarbery, helgatheviking, littlerchicken, tiagohillebrandt, wpmuguru, michaelbeil, norcross, rafaltomal
Tags: social media, social networking, social profiles
Requires at least: 4.0
Tested up to: 4.9
Stable tag: 3.0.0

This plugin allows you to insert social icons in any widget area.

== Description ==

Simple Social Icons is an easy to use, customizable way to display icons that link visitors to your various social profiles. With it, you can easily choose which profiles to link to, customize the color and size of your icons, as well as align them to the left, center, or right, all from the widget form (no settings page necessary!).

*Note: The simple_social_default_glyphs filter has been deprecated from this plugin.

== Installation ==

1. Upload the entire simple-social-icons folder to the /wp-content/plugins/ directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. In your Widgets menu, simply drag the widget labeled "Simple Social Icons" into a widget area.
1. Configure the widget by choosing a title, icon size and color, and the URLs to your various social profiles.

== Frequently Asked Questions ==

= Can I reorder the icons? =

Yes, icons can be reordered with the use of a filter. See: https://github.com/copyblogger/simple-social-icons/wiki/Reorder-icons-in-version-2.0

= Can I add an icon? =

Yes, icons can be added with the use of a filter. See: https://github.com/copyblogger/simple-social-icons/wiki/Add-an-additional-icon-in-version-2.0

= My icon styling changed after updating =

If your theme includes custom icon styling, you can try adding this line to your functions.php file:

`add_filter( 'simple_social_disable_custom_css', '__return_true' );`

This will remove icon styling options in the widget settings, and prevent Simple Social Icons from overriding custom theme styling.

= Which services are included? =

* Behance
* Bloglovin
* Dribbble
* Email
* Facebook
* Flickr
* Github
* Google+
* Instagram
* LinkedIn
* Medium
* Periscope
* Phone
* Pinterest
* RSS
* Snapchat
* StumbleUpon
* Tumblr
* Twitter
* Vimeo
* Xing
* YouTube

NOTE - The rights to each pictogram in the social extension are either trademarked or copyrighted by the respective company.

== Changelog ==

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
