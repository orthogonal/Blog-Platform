This is the readme for my blog page.
I wrote it in Vim just because I can.
I want to make a blog, but I don't want to use something someone else wrote like Blogger or Wordpress.  The idea of making my own is a lot more appealing.  

The basic structure is as follows:

MySQL database stores posts and comments linked to individual posts.
It should also store users since comments won't be anonymous.  Towards that end, there also needs to be a table of users.

Only the administrator can add new posts.  So if someone is logged in as an administrator, they will have a cookie in their machine that makes admin options appear.  Adding a new post will just be basic stuff for now, later on I'll upgrade it.  

Anyone can add comments, as long as they're logged in.  Anonymous users should be prompted to log in.

When the page loads, posts are grabbed from the database and arranged in order of descending timestamp.  The first ten posts will be displayed in full, and the rest will simply be linked to at the bottom.  Or maybe there will be an AJAX command to go to the next ten or previous ten posts by date/id.  

That's version 1.0, anyway.
