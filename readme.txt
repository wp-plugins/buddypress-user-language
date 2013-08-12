=== Buddypress User Language ===
Contributors: webilop
Tags: buddypress user language, localization, buddypress language switcher, buddypress language
Requires at least: 3.0.1
Tested up to: 3.5.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==
Buddypress User Language is a Buddypress extension that allows users to set the language displayed in the back-end and front-end of your Buddypress site.
The available languages are taken from the current theme and the wordpress installation.
This plugin requires 'Buddypress' and 'User Language Switch' to be installed in order to work. 

= Localization =

*English (default).

*Spanish

= Documentation =

You can find the installation and configuration steps at: http://www.webilop.com/products/user-language-switch-wordpress-plugin/
Documentation in spanish is also available: http://www.webilop.com/productos/plugin-wordpress-user-language-switch/

== Installation ==

This section describes how to install the plugin and get it working.

1. Install the 'User Language Switch' plugin and follow the configuration steps available at: http://www.webilop.com/products/user-language-switch-wordpress-plugin/
2. Upload the `buddypress-user-language` folder to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Once you have activated the plugin, you will see in your member page in the frontend, a new tab called "Language". Click on the tab and select the language you want to be displayed in the frontend and backend.


== Frequently Asked Questions ==

= I only see English among the user language options =

If the only available option you see in the user language optons is English, it is because you don't have any other language available in your wordpress installation nor in your theme.
Make sure you create a 'languages' folder in your theme folder containing the .mo and .po files that correspond to the languages you will use in your blog.

== Screenshots ==

1. screenshot1.png illustrates the User Language options available in the frontend. It allows you to select the languages that will be used in the backend and the frontend as default for every buddypress member.