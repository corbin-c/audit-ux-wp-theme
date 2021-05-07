<?php
/**
 * Extends Walker_Nav_Menu to include categories full title &
 * description for top-level categories and wrap it inside a container element
 */
class Menu_With_Description extends Walker_Nav_Menu {
  function top_lvl_description($item, $depth) {
    if (depth > 0) {
      return array();
    }
    $category_name = get_category($item->object_id)->name;
    $category_description = $item->post_content;
    if (empty($category_name)
    || empty($category_description)
    || is_null($category_name)
    || ($category_description == " ")
    ) {
      return array();
    }
    return array(
      "name" => $category_name,
      "description" => $category_description
    );
  }
  function start_el(&$output, $item, $depth, $args) {
    parent::start_el($output, $item, $depth, $args);
    $full_description = $this->top_lvl_description($item, $depth);
    if (!empty($full_description)) {
      $output .= '<div><h2 class="menu-item-title">';
      $output .= esc_html($full_description["name"]);
      $output .= '</h2><p class="menu-item-description">';
      $output .= esc_html($full_description["description"]);
      $output .= '</p>';
    }
  }
  function end_el(&$output, $item, $depth, $args) {
    if (!empty($full_description)) {
      $output .= '</div>';
    }
    parent::end_el($output, $item, $depth, $args);
  }
}

