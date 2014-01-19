WP Robots Txt
=============

This is a *single serving* plugin that adds a field on the Settings->Reading WordPress admin page which allows you to edit your `robots.txt` file contents.

![WP Robots Txt](WP-Robots-Txt/raw/master/screenshot-1.png)

Limitations
-----------

If you have a `robots.txt` file on your server, this plugin will be ignored.  WordPress, in the server configuration it suggests by default, never overrides URLs that exist on your server.  In other words, if `robots.txt` is on your server, WP will never even load -- Apache (or nginx or IIS) will serve that file directly.

Also, this plugin does not help you write a valid `robots.txt` file, nor will it alert you when you've written one that is invalid. That part is up to you.

FAQ
---

**I totally screwed up my `robots.txt` file. How can I restore the default version?**

Delete all the content from the *Robots.txt Content* field and click the Save Changes button.

**Could I accidently block all search bots with this?**

Yes.  Be careful! That said, `robots.txt` files are suggestions. They don't really *block* bots as much as they *suggest* that bots don't crawl portions of a site.  That's why the options on the Privacy Settings page say "Ask search engines not to index this site."

**Where can I learn more about `robots.txt` files?**

[Here](https://developers.google.com/webmasters/control-crawl-index/docs/robots_txt).

Changelog
---------

**1.0**

- Initial version

**1.1**

- Cleaned up code
- Moved to the settings field to the reading area

**1.2**
- Don't overwrite the discourage search engines flag anymore
- When clearing the content from the *Robots.txt Content* field, you will be prompted to save the reloaded defaults.
- Shows an iFrame of your most current Robots.txt file below the edited content.
- Allows for a moved wp-content folder and a moved media uploads folder now.
