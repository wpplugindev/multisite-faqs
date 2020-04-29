=== Multisite FAQS ===
Contributors: wpplugindev
Tags: Multisite FAQs, FAQs, FAQ, FAQs list, accordion FAQs, toggle FAQs, filtered FAQs, grouped FAQs
Requires at least: 4.0
Tested up to: 5.4
Stable tag: 1.1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

An easy way to manage FAQs across wordpress multisite.  Global FAQs are available to all multisite blogs and are merged with the local blog FAQs.

== Description ==

This plugin provides an easy way to share FAQs across a wordpress multisite installation.  FAQs on the master blog can be made global so that they also show across all the blogs in the multisite network.  FAQ categories which exist both on the master blog and other blogs will combine the FAQs for that category.   FAQs are implemented using a custom post type.
Note: This plugin also allows the easy creation of FAQs for non-multisite installations.
FAQ lists are easily added to any blog page using shortcodes - see the documentation section below.

== Features ==

* Manage FAQs across a wordpress multisite installation. 
* Display FAQs in simple list style.
* Display FAQs in toggle ( independent form of accordion ) style.
* Network settings option ( for multisite installations ) to select the master blog.
* Custom CSS box in settings page to override default styles.
* Translation Ready ( Comes with related pot and po files )
* RTL ( Right to Left Language ) Support

== Documentation ==

* FAQs in simple list style.
	`[faqs]`

* FAQs in simple list style but separated by groups.
	`[faqs grouped='yes']`

* FAQs in simple list style but filtered by given group slug.
	`[faqs filter='group-slug']` or `[faqs filter='group-slug,another-group-slug']`

* FAQs in toggle style using following shortcode.
	`[faqs style='toggle']`

* FAQs in toggle style but separated by groups.
	`[faqs style='toggle' grouped='yes']`

* FAQs in toggle style but filtered by given group slug.
	`[faqs style='toggle' filter='group-slug']` or `[faqs style='toggle' filter='group-slug,another-group-slug']`

* Note -  `filter` can be used with any combination.
       -   faqs which are not in a group will only be displayed when using simple list style.


### Links

- [GitHub Repository](https://github.com/wpplugindev/multisite-faqs)

== Installation ==

1. Unzip the downloaded package
2. Upload `multisite-faqs` to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Select the main faq blog in the Network Settings Screen (for multisite only)

== Screenshots ==
1. Network Settings (for multisite)
2. Set FAQ in main blog to show on all sites
3. Add/Edit FAQ Page
4. Add/Edit FAQ Groups
5. Simple FAQ page ie: [faqs]
6. Grouped FAQ page ie: [faqs grouped="yes"]
7. Grouped and Toggled FAQ page ie: [faqs grouped="yes" style="toggle"]
8. Settings Page to edit styles

== Changelog ==

= 1.0.0 =
* Initial Release