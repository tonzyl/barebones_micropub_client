# barebones_micropub_client

This is a barebones micropub client script.\n
I use this to include in scripts that create the posts to be posted.\n
The script expects to receive a title (can be empty but not NULL, content, and some categories/tags (as array).\n
Title should be in $posttitel, content in $contentspul, the array of categories/tags in $cats \n
The default post status is draft, but you could turn that into a variable or set to publish \n
The post information is submitted to the endpoint in JSON, using file_get_contents \n
It requires getting a bearer token which is not handled in this script. Get one manually for your endpoint from https://www.jvt.me/posts/2021/03/06/tokens-pls/

