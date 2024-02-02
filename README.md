# barebones_micropub_client

This is a barebones micropub client script.

I use the micropub posting part, jsonfilegetcontents.php, of this to include in scripts that create the posts to be posted.

That script expects to receive a title (can be empty but not NULL, content, and some categories/tags (as array).
Title should be in $posttitel, content in $contentspul, the array of categories/tags in $cats 
The default post status is draft, but you could turn that into a variable or set to publish 
The post information is submitted to the endpoint in JSON, using file_get_contents 

It requires getting a bearer token which is not handled in this script. Get one manually for your endpoint through the back-end of your CMS (e.g. WordPress with the IndieWeb micropub plugin, or from https://www.jvt.me/posts/2021/03/06/tokens-pls/

The other script, mdtohtml.php is an example that creates a post to be posted through micropub from local markdown files.

It looks in a specific folder to see if any recently created files are in there. If so it will check if the first line is 'status:: draft'.
Drafts that are detected will be read, and saved with status changed to published.
From the markdown file things like file title, listed categories are read. The file is transformed from markdown to html using Parsedown (https://github.com/erusev/parsedown). Thus the things the posting script expects to receive are created and passed on to jsonfilegetcontents.php.

WARNING: these files are to be run locally on your laptop's webserver. It has no safety precautions because it was created for a personal use case (and I am predictable to myself) and to be run locally. No checks on the validity of content etc. Running this exposed on the web would be a bad idea. It's meant as an example of tinkering.
