<?php

class JSON_API_Category {
  
  var $id;          // Integer
  var $slug;        // String
  var $title;       // String
  var $description; // String
  var $parent;      // Integer
  var $post_count;  // Integer
  
  function JSON_API_Category($wp_category = null) {
    if ($wp_category) {
      $this->import_wp_object($wp_category);
    }
  }
  
  function import_wp_object($wp_category) {
    $this->set_value('id', (int) $wp_category->term_id);
    $this->set_value('slug', $wp_category->slug);
    $this->set_value('title', $wp_category->name);
    $this->set_value('description', $wp_category->description);
    $this->set_value('parent', (int) $wp_category->parent);
    $this->set_value('post_count', (int) $wp_category->count);
  }

  
  function set_value($key, $value) {
    global $json_api;
    if ($json_api->include_value($key)) {
      $this->$key = $value;
    } else {
      unset($this->$key);
    }
  }
    
  
}

?>
