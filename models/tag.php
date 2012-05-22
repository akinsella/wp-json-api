<?php

class JSON_API_Tag {
  
  var $id;          // Integer
  var $slug;        // String
  var $title;       // String
  var $description; // String
  
  function JSON_API_Tag($wp_tag = null) {
    if ($wp_tag) {
      $this->import_wp_object($wp_tag);
    }
  }
  
  function import_wp_object($wp_tag) {
    $this->set_value('id', (int) $wp_tag->term_id);
    $this->set_value('slug', $wp_tag->slug);
    $this->set_value('title', $wp_tag->name);
    $this->set_value('description', $wp_tag->description);
    $this->set_value('post_count', (int) $wp_tag->count);
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
