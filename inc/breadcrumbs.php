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
  return $name;
}
/**
 * builds the breadcrumbs element
**/
function breadcrumbs() {
  if (is_home() || is_front_page()) {
    return; /* hide breadcrumbs on home page */
  }
  global $post;
  $breadcrumbs = '<ol id="crumbs" itemscope itemtype="http://schema.org/BreadcrumbList">'; /* use microdata to improve machine readability */
  $breadcrumbs .= '<li itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a title="Retour à l’accueil" href="' . esc_url(home_url( '/' )) . '">Accueil</a></li>';
  $category = get_the_category($post->ID);
  if (!empty($category)) { /* check if the current post has a parent category */
    $category = $category[0];
    $category_name = $category->description;
    if (empty($category_name)) {
      $category_name = $category->name;
    }
    $breadcrumbs .= '<li itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a title="Accéder au contenu de la catégorie : ' . $category->name . '" href="' . esc_url(get_category_link($category->term_id)) . '">' . $category_name . '</a></li>';
  }
  $breadcrumbs .= '<li itemprop="itemListElement" class="current" itemtype="http://schema.org/ListItem">' . get_item_name_in_menu("menu-1",$post->ID) . '</li>';
  $breadcrumbs .= '</ol>';
  echo $breadcrumbs;
}
?>
