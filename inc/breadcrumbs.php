<?php
/**
 * Minimal breadcrumbs function:
 *  hidden on home page
 *  displays an ordered list with embedded microdata
 *  @link https://schema.org/BreadcrumbList
 *  shows a back link to home
 *  shows only the direct parent category (not the full breadcrumbs path)
 *  category description is shown instead of category name if available
 *  title of the current page is retrieved from the navigation menu
**/

/**
 * get_item_name_in_menu retrieves the name of a given wp_post inside of a given menu
 * 
 * @param string $menu
 *      title of the menu to use for name lookup
 * @param int $id
 *      id of the post to lookup
 * @return string
 *      found name
**/
function get_item_name_in_menu($menu,$id) {
  $items = wp_get_nav_menu_items($menu);
  foreach ($items as $item) {
    if ($item->object_id == $id) {
      $name = $item->title;
      break;
    }
  }
  return esc_html($name);
}
/**
 * builds the breadcrumbs element
**/
function breadcrumbs() {
  if (is_home() || is_front_page()) {
    return; /* hide breadcrumbs on home page */
  }
  $breadcrumbs = '<ol id="crumbs" itemscope itemtype="http://schema.org/BreadcrumbList">'; /* use microdata to improve machine readability */
  $breadcrumbs .= '<li itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a itemprop="item" title="Retour à l’accueil" href="' . esc_url(home_url( '/' )) . '">Accueil</a><meta itemprop="name" content="' . get_bloginfo( 'name' ) . '" /><meta itemprop="position" content="1" /></li>';
  $position = 2;
  if (is_category()) {
    $category = get_queried_object('cat');
    $parent = $category->category_parent;
    if ($parent !== 0) {
      $parent_category = get_category($parent);
      $breadcrumbs .= '<li itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a itemprop="item" title="Accéder au contenu de la catégorie : ' . $parent_category->name . '" href="' . esc_url(get_category_link($parent_category->term_id)) . '">' . get_item_name_in_menu("menu-1",$parent_category->term_id) . '</a><meta itemprop="name" content="' . get_item_name_in_menu("menu-1",$parent_category->term_id) . '" /><meta itemprop="position" content="' . $position . '" /></li>';
      $position++;
    }
    $breadcrumbs .= '<li itemprop="itemListElement" class="current" itemtype="http://schema.org/ListItem">' . get_item_name_in_menu("menu-1",$category->term_id) . '<meta itemprop="item" content="' . get_permalink($category->term_id) . '" /><meta itemprop="name" content="' . get_item_name_in_menu("menu-1",$category->term_id) . '" /><meta itemprop="position" content="' . $position . '" /></li>';
  } else {
    global $post;
    $category = get_the_category($post->ID);
    if (!empty($category)) { /* check if the current post has a parent category */
      $category = $category[0];
      $category_name = get_item_name_in_menu("menu-1",$category->term_id);
      $breadcrumbs .= '<li itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a itemprop="item" title="Accéder au contenu de la catégorie : ' . $category->name . '" href="' . esc_url(get_category_link($category->term_id)) . '">' . $category_name . '</a><meta itemprop="name" content="' . $category_name . '" /><meta itemprop="position" content="' . $position . '" /></li>';
      $position++;
    }
    $breadcrumbs .= '<li itemprop="itemListElement" class="current" itemtype="http://schema.org/ListItem">' . get_item_name_in_menu("menu-1",$post->ID) . '<meta itemprop="item" content="' . get_permalink($post->ID) . '" /><meta itemprop="name" content="' . $post->post_title . '" /><meta itemprop="position" content="' . $position . '" /></li>';
  }
  $breadcrumbs .= '</ol>';
  echo $breadcrumbs;
}
