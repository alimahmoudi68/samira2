<?php
/**
 * Mega Menu Walker Class
 * Creates a 3-level mega menu structure for WordPress navigation
 */

class Mega_Menu_Walker extends Walker_Nav_Menu {
    
    private $mega_menu_started = false;
    private $current_category = '';
    private $subcategories = array();
    
    // Start the list before the elements are added
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        
        if ($depth == 0 && !$this->mega_menu_started) {
            // First level submenu - create mega menu structure
            $this->mega_menu_started = true;
            $output .= "\n$indent<div class=\"mega-menu hidden absolute top-full right-0 w-[800px] bg-white-100 border border-gray-200 rounded-lg shadow-lg z-50\">\n";
            $output .= "$indent\t<div class=\"flex\">\n";
            $output .= "$indent\t\t<div class=\"w-1/3 border-l border-gray-200 p-4\">\n";
            $output .= "$indent\t\t\t<h3 class=\"text-text-primary-100 font-bold text-lg mb-4\">دسته‌بندی‌ها</h3>\n";
            $output .= "$indent\t\t\t<ul class=\"space-y-2\">\n";
        } else if ($depth == 1) {
            // Second level submenu - categories (only show in right column)
            $output .= "\n$indent<ul class=\"space-y-2\">\n";
        } else if ($depth == 2) {
            // Third level submenu - subcategories (don't render here)
            // This will be handled in the left column
        }
    }
    
    // End the list after the elements are added
    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        
        if ($depth == 0 && $this->mega_menu_started) {
            // Close first level submenu
            $output .= "$indent\t\t\t</ul>\n";
            $output .= "$indent\t\t</div>\n";
            $output .= "$indent\t\t<div class=\"w-2/3 p-4\">\n";
            $output .= "$indent\t\t\t<h4 class=\"text-text-primary-100 font-semibold text-base mb-3 mega-subtitle\">زیرمجموعه‌ها</h4>\n";
            $output .= "$indent\t\t\t<div class=\"mega-subcategories\">\n";
            
            // Generate subcategory content for each category
            foreach ($this->subcategories as $category => $subcats) {
                $output .= "$indent\t\t\t\t<div class=\"mega-subcategory-content hidden\" data-category=\"{$category}\">\n";
                $output .= "$indent\t\t\t\t\t<ul class=\"space-y-2\">\n";
                foreach ($subcats as $subcat) {
                    $output .= "$indent\t\t\t\t\t\t<li class=\"text-text-primary-100 hover:text-primary-100 transition-colors block py-1\">\n";
                    $output .= "$indent\t\t\t\t\t\t\t<a href=\"{$subcat['url']}\">{$subcat['title']}</a>\n";
                    $output .= "$indent\t\t\t\t\t\t</li>\n";
                }
                $output .= "$indent\t\t\t\t\t</ul>\n";
                $output .= "$indent\t\t\t\t</div>\n";
            }
            
            $output .= "$indent\t\t\t</div>\n";
            $output .= "$indent\t\t</div>\n";
            $output .= "$indent\t</div>\n";
            $output .= "$indent</div>\n";
            $this->mega_menu_started = false;
        } else if ($depth == 1) {
            // Close second level submenu
            $output .= "$indent</ul>\n";
        } else if ($depth == 2) {
            // Third level submenu - don't close here
        }
    }
    
    // Start the element output
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Check if item has children
        $this->has_children = in_array('menu-item-has-children', $classes);
        
        // Add mega menu classes based on depth
        if ($depth == 0) {
            // First level - main menu items (only add group class for items with children)
            if ($this->has_children) {
                $classes[] = 'z-10';
                $classes[] = 'relative';
                $classes[] = 'inline-block';
                $classes[] = 'group';
            }
        } else if ($depth == 1) {
            // Second level - categories
            $classes[] = 'mega-category-item';
            $classes[] = 'cursor-pointer';
            $classes[] = 'p-2';
            $classes[] = 'rounded';
            $classes[] = 'hover:bg-gray-100';
            $classes[] = 'transition-colors';
        } else if ($depth == 2) {
            // Third level - subcategories (store for later use)
            $this->current_subcategory = array(
                'title' => $item->title,
                'url' => $item->url
            );
            return; // Don't render here
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        if ($depth == 0) {
            // First level items
            $output .= $indent . '<li' . $id . $class_names . '>';
            $output .= '<a href="' . $item->url . '" class="flex text-text-primary-100 font-medium items-center ml-[30px] relative h-[35px] transition-all hover:opacity-80 header-nav">' . $item->title . '</a>';
        } else if ($depth == 1) {
            // Second level items - categories
            $this->current_category = sanitize_title($item->title);
            $output .= $indent . '<li' . $id . $class_names . ' data-category="' . $this->current_category . '">';
            $output .= '<span class="text-text-primary-100 font-medium">' . $item->title . '</span>';
        }
    }
    
    // End the element output
    function end_el(&$output, $item, $depth = 0, $args = null) {
        if ($depth == 2) {
            // Third level items - store subcategory data
            if (!empty($this->current_category) && !empty($this->current_subcategory)) {
                if (!isset($this->subcategories[$this->current_category])) {
                    $this->subcategories[$this->current_category] = array();
                }
                $this->subcategories[$this->current_category][] = $this->current_subcategory;
            }
            return;
        }
        $output .= "</li>\n";
    }
}