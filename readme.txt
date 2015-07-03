=== Report Content ===
Contributors: khaxan
Tags: report content, report posts, broken links, website errors, error reporting, notify, notification, email notifications, email, spam content
Donate link: http://wpgurus.net/
Requires at least: 3.0
Tested up to: 4.2
Stable tag: 1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Inserts a secure form on specified pages so that your readers can report bugs, spam content and other problems.

== Description ==
This plugin allows you to add a simple Ajax powered form to the posts (and optionally pages) of your website so that your visitors can report inappropriate content, broken links and bugs. If you manage a huge website with tons of user-submitted content then Report Content can make your life easier and ultimately increase the quality of your content.

**Features:**

**Customization:** Report Content gives you full control over every aspect of the reporting process. You can deactivate fields, change position of form, switch to manual integration, decide who can view reports and so on.

**Security:** All submitted reports are passed through Akismet so you don't have to worry about spam. For an additional layer of security you can disallow anonymous users from using the submission form.

**Email notifications:** Whenever a report is added to the system the plugin will send you (and optionally the post author) an email with the details of the report. You can change the content of the email or disable this feature completely.

== Installation ==
1. Use WordPress' plugin installer to set up the plugin.
2. Adjust plugin settings using the control panel at Reports > Settings in your site\'s admin area.
3. If you don't want the submission form to be added automatically to your site place the template tag  in your theme files.

== Frequently Asked Questions ==
= How can I minimize spam reports? =
By default the plugin passes all the submitted reports through Akismet to reduce spam. All you have to do is make sure you have Akismet plugin installed on your site.

= Can I change the appearance of the form? =
From the control panel you can change the color scheme of the form. Alternatively you can just override the CSS included with the plugin.

= What if I just need the reports to be emailed to me? =
If you don't want the plugin to store the reports in your Wordpress database just go to the control panel and disable the database feature. It is located under Other Settings.

== Changelog ==
= 1.0 =
* Initial release.
= 1.1 =
* Added post URLs to the emails.