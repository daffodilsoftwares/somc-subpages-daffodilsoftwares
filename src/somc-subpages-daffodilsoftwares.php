<?php
/*
  Plugin Name: somc-subpages-daffodilsoftwares
  Description: A simple plugin that list all subpages of the page it is placed on
  Version: 1.0
  Author: Daffodil
 */

class wp_my_plugin extends WP_Widget 
{
    
    /**
     * Constructor
     */
    public function __construct() 
    {
        parent::WP_Widget(false, $name = __('SubPages Accordion', 'wp_widget_plugin'));

        //set shortcode for calling the widget throught shortcode
        add_shortcode('somc-subpages-daffodilsoftwares', array($this, 'widget'));

        // Register site styles and scripts
        add_action('wp_enqueue_scripts', array($this, 'registerWidgetStyles'));
        add_action('wp_enqueue_scripts', array($this, 'registerWidgetScripts'));
    }


    /**
     * Method adds the stylesheet to the widget
     */
    public function registerWidgetStyles() 
    {
        //Add stylesheet to the widget
        wp_enqueue_style('wp_my_plugin-styles', plugins_url('somc-subpages-daffodilsoftwares/assets/css/widget.css'));
    }


    /**
     * Registers and enqueues widget-specific scripts.
     */
    public function registerWidgetScripts() 
    {
        // Add script to widget.
        wp_enqueue_script('wp_my_plugin_nested-script', plugins_url('somc-subpages-daffodilsoftwares/assets/js/jquery.nestedAccordion.js'), array('jquery'));
        wp_enqueue_script('wp_my_plugin-script', plugins_url('somc-subpages-daffodilsoftwares/assets/js/widget.js'), array('jquery'));
        
    }


    /**
     * Method to get the current page hierarchy.
     * @return String Returns the HTML string of the subpages list.
     */
    function listSubmenuByHierarchy() 
    {
        global $post; // get the current page data.
        $top_post = $post;
        
        $level = 0;
              
        return $this->getChildrenHierarchalSubmenu($top_post, $post);
    }

    
    /**
     * Method to get children pages of a page by get_pages method of wordpress, calling recursively 
     * to get hierarichal code.
     * @param Object parent page object.
     * @param Object current page object.
     * @return String Returns the HTML string of the subpages list.
     */
    function getChildrenHierarchalSubmenu($post, $current_page) 
    {
  
        // check whether the current page is same as post page
         if($post->ID == $current_page->ID){
                 $id = "acc3";
                 $classname = "accordion";
                
         }
    
        // Initialize the HTML variable as blank      
        $menu = '';
    
        // get the immediate children of the current page
        $children = get_pages('child_of=' . $post->ID . '&parent=' . $post->ID . '&sort_column=menu_order&sort_order=ASC');
    
        if ($children) {
            $menu = "\n<ul id='$id' class='$classname'>\n";
           
            // Traverse the children of the current page.
            foreach ($children as $child) {
                $image_width = '28';
                $image = wp_get_attachment_image_src(get_post_thumbnail_id($child->ID), array(28, 28)); // get featured img; 'large'
                $img_url = $image[0]; // get the src of the featured image
                $menu .= '<li><a href="#" class="arrow_trigger"></a><a href="' . get_permalink($child) . '" class="title-thumb">';
         
                if ($image) {
                    $menu .= '<img src="' . $img_url . '" width="' . $image_width . '" alt="' . esc_attr($child->post_title) . '" />';
                }
                    
               // Truncate the title using substr function of PHP
               $menu .= substr($child->post_title,0,20) . '</a>';
                
               // If the page has children and is the child page of one of its
               //  ancestors, get its children using recursive method
               if (count(get_pages("child_of=" . $child->ID)) > 0) {

                    $menu .= $this->getChildrenHierarchalSubmenu($child, $current_page);
               }
               
               $menu .= "</li>\n";
                
            }
            $menu .= "</ul>\n";
        }

        // Return output HTML to print the code
        return $menu;
    }

    
    /**
     * Build the widget's form
     * @param array $instance, An array of settings for this widget instance
     */
    function form($instance) 
    {
        // Check values 
        if ($instance) {
            $title = esc_attr($instance['title']);
        } else {
            $title = '';
        }
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
            <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

    <?php
    }

    
     /**
      * Outputs the HTML for this widget.
      *
      * @param array, An array of standard parameters for widgets in this theme 
      * @param array, An array of settings for this widget instance 
      * @return void Echoes it's output
      **/
    function widget($args, $instance) 
    {
	global $post;

        // these are the widget options set from admin section
        $title = apply_filters('widget_title', $instance['title']);
        $text = $instance['text'];
        $textarea = $instance['textarea'];

        echo $before_widget;

        // Check if title is set
        if ($title) {
            echo $before_title . $title . $after_title;
        }

        // Display the widget
	if (count(get_pages("child_of=" . $post->ID)) > 0) {
            echo '<div class="widget-text wp_widget_plugin_box">';
            echo '<div id="side">';
	    echo '<div class="sortby">';
            echo '<span>Sort By:</span>';
            echo "<a href='#' class='buttons link-sort-list desc'></a>";
            echo "<a href='#' class='buttons link-sort-list asc'></a>";            
            echo '</div>';
            echo $this->listSubmenuByHierarchy();
     
            echo '</div>';
            echo '</div>';
	}

        echo $after_widget;
    }
}

// register the widget
add_action('widgets_init', create_function('', 'return register_widget("wp_my_plugin");'));
?>
