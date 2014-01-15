
== Installation ==
1. Upload 'somc-subpages-daffodilsoftwares' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the wordpress widget somc­-subpages­-daffodilsoftwares and drag it to the sidebar or you can use the short code ([somc­-subpages­-daffodilsoftwares]) to make it appear on frontend.


== Uses ==
1. It will display you the list of all subpages in a hierarchical way of the current page. If the current page is not having the subpages then it will not display anything on frontend.
2. You can click on the title and go the the page you want.
3. The accordion feature is working up to 3 level of subchild.


== Approach ==
1. We have used get get_pages() function to get the list of subpages and featured image. Because wp_list_page() function does not provide the featured image.
2. We assume that subpages accordion is up to 3rd level.
3. The sorting is working based on asending and desending ordering for the first level of the subpages listing.
