<?php

class JSON_API_Category_Sync_Data {
  
  var $id;          // Integer
  var $slug;        // String
  var $title;       // String
  
  function JSON_API_Category_Sync_Data($wp_category = null) {
    if ($wp_category) {
      $this->import_wp_object($wp_category);
    }
  }
  
  function import_wp_object($wp_category) {
    $this->set_value('id', (int) $wp_category->term_id);
    $this->set_value('slug', $wp_category->slug);
    $this->set_value('title', $wp_category->name);
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
