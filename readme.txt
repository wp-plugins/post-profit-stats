=== Post Profit Stats ===
Contributors: slickremix
Tags:  Posts, Profit, Sales, Post Count, Stats, Statistics, WordPress Stats, Views, plugin, pages, posts, page, user, authors, author, wp stats, page views, track, tracking, jetpack, jetpack stats, profit, news, co authors, multiple authors, pay, money
Requires at least: 3.5.0
Tested up to: 3.9.1
Stable tag: 1.0.9
License: GPLv2 or later

Do you pay authors for page views? Let our plugin calculate the amount per post view and give you totals by date.

== Description ==
See the total number of post views per author with detailed totals and grand totals. You can also sort by date.

NEW! View stats from browser and device types. And now by using the Co-Authors Plus plugin you can now assign and track multiple authors per post.

Setting this up could not be easier. Simply add the amount per view you are paying your authors or whomever, and that’s it! Our system will calculate the total number of views your webpage has received and multiply that by the amount you entered. [Read more](http://www.slickremix.com/2013/07/30/why-use-post-profits-stats/) about how you can really make money with this plugin! 

= The FREE version =
  1. Track up to 10 Authors.
  2. ONLY allows you to set ONE amount of money for ALL Authors per view.
  3. If you are logged in and viewing your posts they will not be counted. Only if you are logged out. (Authors proof-reading their posts don't get counted)
  4. Change the Sales Figures & Total Sales colors.
  5. Author's can login to view their details stats.
  6. Views get counted even with caching plugins. That’s right it will work!
  7. The information is recorded to your database.

= The Pro Extension =
  1. Track UNLIMTED Authors.
  2. Allows you to set an amount of money paid to EACH individual Author per view.
  3. You can change the name ‘Post Profit Stats’ in the menu and main page header to your company name.
  4. The slickremix logo can be removed from the footer of our plugin pages.

= The Enterprise Extension =
  1. Track all Post Views in a SEPERATE DATABASE from your WordPress install. The advantage of a separate database is that you do not take up a lot of space in the database counting views and slowing down your website. We have made it so easy that all you have to do is add a database to your server and fill in the connection info in the settings panel of the setting page! The extension does the rest of the leg work. Yup, It’s that easy! This extension also lets you set a different payment amount per post view to each individual author on the user profile page.
  2. Take a look here for [Enterprise Extension](http://www.slickremix.com/product/post-profit-stats-enterprise-extension/). Note: You must have the Pro version installed before upgrading to the Enterprise version.

= Tests =
We've also done the following tests to make sure the view counts are as accurate as possible. Here are a few. Again even if you have a caching plugin installed this plugin will still track views, similar to google.

Made external link to post
Result: jetpack counted the same as our plugin

Clicked: from internal link on website || Result: jetpack counted the same as our plugin

Clicked: from external link on Facebook || Result: jetpack counted the same as our plugin

Clicked: from external mail link || Result: jetpack counted the same as our plugin

Clicked: while logged into wordpress || Result: jetpack counted and our plugin did not count || Note: This seems proper to us. Why would you want stats on your logged in Authors for view counts? Another advantage of our plugin.

Additional Note: Our plugin only multiplies the amount by page views, not by comment counts. We just added the comments count as a bonus to see the activity happening per post.

Technical Note: This plugin has been tested and works with bbpress.

== Installation ==

= Install from WordPress Dashboard =
  * Log into WordPress dashboard then click **Plugins** > **Add new** > Then under the title "Install Plugins" click **Upload** > **choose the zip** > **Activate the plugin!**

= Install from FTP =
  * Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page. 

== Changelog ==
= Version 1.0.9 Thurdsay June 5th, 2014 =
 * FIXED: License Manager. If you don't have a premium version for this plugin then you don't need to worry about updating to this version.
 
= Version 1.0.8 May 22nd, 2014 =
 * ADDED: Editors and Contributors can now view the Author Detail stats page too.
 
= Version 1.0.7 April 9th, 2014 =
 * FATAL ERROR FIX: Added check to see if co-author plus plugin is installed. Sorry to everyone who experienced problems.
 * NOTE: NO Browser Stats were recorded in version 1.0.5 or earlier. Users who decide to upgrade there existing database please note. When you update the database your old total hit count will be added to the ??? (unknown browser) and desktop device to keep future stats accurate. If you don't like this, simply do not update the database just delete the old one and you will start over fresh.
 * PRO Verions Note: You must update the FREE version before updating the PRO version.
 * ENTERPRISE Verions Note: Update FREE version first. Then update the Enterprise version. Then you will need to re-enter your database name, user and password again before upgrading the database.
 
= Version 1.0.6 April 8th, 2014 =
 * NOTE: NO Browser Stats were recorded in version 1.0.5 or earlier. Users who decide to upgrade there existing database please note. When you update the database your old total hit count will be added to the ??? (unknown browser) and desktop device to keep future stats accurate. If you don't like this, simply do not update the database just delete the old one and you will start over fresh.
 * NEW: Our plugin now creates one row per day for a user's post in the database and updates the hit counts instead of creating a row for each hit making the database size decrease dramatically.
 * NEW: jQuery Mobile 1.4.2 update for UI and more.
 * NEW: View Browsers Stats for Safari, Firefox, Chrome, IE, Opera. You can also view the stats from the devices that the views are coming from like mobile, tablet, video game consoles and desktop computers.
 * NEW: By installing the co authors plus plugin you can now add and track multiple authors to your posts. When you do so, go to your post page and you will now see instructions on how it works. This method is a way for owners to get multiple authors to help promote posts and track their stats.
 * NEW: Option to hide the browser stats for authors.
 * NEW: Option to hide the POST ID edit link for authors when they are looking at the detailed stats.
 * NEW: Option to show a note to all authors on the author detail stats page.
 * NOTICE: We said it before and we'll say it again... Our plugin works with cache plugins!
 * PRO Verions Note: You must update the FREE version before updating the PRO version.
 * ENTERPRISE Verions Note: Update FREE version first. Then update the Enterprise version... you will need to re-enter your database name, user and password before upgrading the database.
 
= Version 1.0.5 February 10th, 2014 =
 * FIXED: Count issue when site has Recent Posts on page too.
 
= Version 1.0.4 February 6th, 2014 =
 * FIXED: Totals now reflect proper if users are changed on a post.
 * FIXED: Subscribers and other users besides the admin, and author will not see the menu in the admin area.
 * FIXED: Authors cannot edit settings or view other authors stats.
 * PRO Verion Note: Site Licenses are now required for the 1.0.3 update.
 * ENTERPRISE Verion Note: Site Licenses are now required for the 1.0.2 update.
 
= Version 1.0.3 January 9th, 2013 =
 * CHANGED: New UI for Wordpress 3.8 update
 * ADDED: Plugin activation page now has settings link, support forum link, review link and more.
 * ADDED: Plugin Activation Tour.
 * PRO Verions Note: Setting option to rename the menu and page title 'Post Profit Stats', plus it removes the logo in the footer of our pages.
 * PRO Verions Note: Authors are not limited to 50 anymore, now it is Unlimited.

= Version 1.0.2 September 13th, 2013 =
 * CHANGED: New version DOES NOT require Monthly or Yearly subscriptions anymore but only a 1 time payment (includes FREE updates for lifetime of plugin)

= Version 1.0.1 July 30th, 2013 =
 * FIXED: Timestamp of post view is equal to the Current Local Time set in the wordpress settings area.
 * IMPROVED: Database Table revamp to speed things up.
 * ADDED: Author's can login to view their details stats as a BONUS.

= Version 1.0.0 July 25th, 2013 =
 * Initial Release

== Frequently Asked Questions ==
You can find answers to your questions or just drop us a line at our [Support Forum](http://www.slickremix.com/support-forum).

= Are there Extensions for this plugin? =

YES, When you purchase the [PRO Extension](http://www.slickremix.com/product/post-profit-stats-pro-extension/) it will become available for download on your "My Account" Page.

== Screenshots ==
1. Author Total Stats tour notes.
2. More details popup in the settings panel.
3. The setting available for this plugin. Amount per view and how many users to display per page. Also color options for the stats numbers and usernames.
4. Author Total Stats area which allows you to sort by date. You can also click on any username to show the Author Details Stats.
5. Admin view for Authors detailed stats showing the breakdown of post views for an author.
6. The Detailed Stats view for Authors who login. They can only view their stats, no one else’s.
7. The Help/System Info Page. You can also retake the tour as well.
8. Pro Version - New settings
9. Pro Version - Add your company name to change the main menu title, page titles and removes the slickremix logo.
10. Pro Version - Shows new titles and slickremix logo removed from the footer of page.
11. Pro Version - Now you can give each author a custom amount per view.
12. Pro Version - Authors view of their stats. Notice the custom name and how the slickremix logo is gone.
13. Enterprise Version - Connect to separate database settings.