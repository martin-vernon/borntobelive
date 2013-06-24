=== Stop CF7 Multiclick ===
Contributors: zaus
Donate link: http://drzaus.com
Tags: prevent multiple submissions, prevent multiple submit, multisubmit, onsubmit, contact form 7, cf7
Requires at least: 3.0
Tested up to: 3.2.1
Stable tag: trunk
License: GPLv2 or later

Prevent multiple Contact Form 7 submissions due to repeated clicks and itchy trigger fingers.

== Description ==

Prevent multiple Contact Form 7 submissions due to repeated clicks and itchy trigger fingers.

= Why =

Because users are sometimes impatient, and due to styling issues it's not always apparent that Contact Form 7 is in the process of submitting via ajax.

== Installation ==

1. Upload plugin folder `stop-cf7-multiclick` to your plugins directory (`/wp-content/plugins/`)
2. Activate plugin
3. Add the following shortcode immediately after your contact form shortcode: `[cf7multiclick]` or `[cf7multiclick selector=".wpcf7-submit"]`
4. In the _"Additional Settings"_ section of the specific form, add the following on a single line: `on_submit: window.cf7multiclick.reactivate('.wpcf7-submit');`
5. Optionally, add a better visual indicator to your form (i.e. gray out) when it's in the middle of submitting using the provided CSS class `.cf7-pending`


== Frequently Asked Questions ==

= How do I use the plugin? =

1. Add the following shortcode on the same WP page as you placed the CF7 form shortcode:  `[cf7multiclick]`.  This will "pause" interaction with the submit button, preventing clicks until the form has finished submitting.
2. Add the following callback to the _additional settings_ of the CF7 form itself: `on_submit: window.cf7multiclick.reactivate();`

By default, both intercepts target the submit button using the selector `.wpcf7-submit` by default, which is the default CF7 class on the submit button, but if you have multiple forms or different classes/ids/etc, you can specify the selector like:

    [cf7multiclick selector=".wpcf7-submit"]
    on_submit: window.cf7multiclick.reactivate('.wpcf7-submit');

= How do I style the "in-process" form? =

You can provide a better visual indication that your form is in the process of submitting by using the "temporary" form class of `.cf7-pending`, like:

        <style>
        	.cf7-pending { opacity:0.5; }
        </style>

= My form is still triggering multiple times, what do I do? =

First of all, inspect the submit button to discern what selector you should use to specify it.  You can use your browser developer tools, or if you customized it via the CF7 interface you can look in the form admin.  If you have an `id` on the button like _my-submit_, you can use that in the shortcode as well as the reactivate function like:

        [cf7multiclick selector="#my-submit"]
        on_submit: window.cf7multiclick.reactivate('#my-submit');

This really is only relevant if you've manually entered the HTML for the button -- the CF7-generated "shortcode" should have the expected default class of `.wpcf7-submit` already, in which case you wouldn't need to specify the selectors for the callbacks.

= What if it it breaks other jQuery plugins, like easing? =

I came across an instance where the shortcode was being called in a modal popup, which loaded content via ajax.  Since it was in a new request, the plugin script's dependency on jQuery caused it to load jQuery (as it should), but because this happened after the rest of the page was already loaded it injected jQuery again, thus overwriting the jQuery object and breaking other jQuery plugins.

The solution is to tell the shortcode which script to load or use, and then call the shortcode in two separate places.

First, tell the shortcode to not use the script function (only loading the plugin script).  Put this in the regular page:

        [cf7multiclick use_script="false"]

Then, tell the shortcode to not load the script (and thus dependencies).  Put this in the modal:

        [cf7multiclick load_script="false"]

= How do I do XYZ? =

Coming soon! 

== Changelog ==

= 0.1 =
* inception!

= 0.2 =
plugin + javascript

= 0.3 =
live testing, readme

= 0.4 =
shortcode attributes to conditionally load/use scripts

== Upgrade Notice ==

= 0.1 =
Starting plugin

= 0.2 =
Private release

= 0.3 =
Beta testing release successful, ready for public consumption

= 0.4 =
Fixes modal usage conflicts by allowing conditional script usage via shortcode attributes.

== About zaus ==

As seen on [Wordpress Profile: Zaus][] and author homepage [drzaus.com][].

[Wordpress Profile: Zaus]: http://profiles.wordpress.org/zaus/ "Zaus Wordpress Profile"
[drzaus.com]: http://drzaus.com/about "About: Drzaus.com"