WP Robots Txt
=============

This is a *single serving* plugin that adds a field on the Privacy Settings WordPress admin page which allows you to edit your `robots.txt` file contents.

![WP Robots Txt](https://github.com/chrisguitarguy/WP-Robots-Txt/raw/master/screenshot-1.png)

Limitations
-----------

If you have a `robots.txt` file on your server, this plugins won't work.  WordPress, in the server configuration it suggests by default, never overrides URLs that exist on your server.  In other words, if `robots.txt` is on your server, WP will never even load -- Apache (or nginx or IIS) will serve that file directly.

Also, this plugin does not help you write valid a `robots.txt` file, nor will it alert you when you've written one that is invalid. That part is up to you.

FAQ
---

**I totally screwed up my `robots.txt` file. How can I restore the default version?**

Delete all the content from the *Robots.txt Content* field and save the privacy options.

**Could I accidently block all search bots with this?**

Yes.  Be careful! That said, `robots.txt` files are suggestions. They don't really *block* bots as much as they *suggest* that bots don't crawl portions of a site.  That's why the options on the Privacy Settings page say "Ask search engines not to index this site."

**Where can I learn more about `robots.txt` files?**

[Here](https://developers.google.com/webmasters/control-crawl-index/docs/robots_txt).

Changelog
---------

**1.0**

- Initial version
