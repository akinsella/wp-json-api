<?php

class JSON_API_Term {
  
  var $id;                // Integer
  var $name;              // String
  var $slug;              // String
  var $term_group;        // Integer
  var $term_order;        // Integer
  var $term_taxonomy_id;  // Integer
  var $taxonomy;          // String
  var $description;       // String
  var $parent;            // Integer
  var $term_count;        // Integer
  var $object_id;         // Integer
  
  function JSON_API_Term($wp_term = null) {
    if ($wp_term) {
      $this->import_wp_object($wp_term);
    }
  }
  
  function import_wp_object($wp_term) {
    $this->set_value('id', (int) $wp_term->term_id);
    $this->set_value('name', $wp_term->name);
    $this->set_value('slug', $wp_term->slug);
    $this->set_value('term_group', (int) $wp_term->term_group);
    $this->set_value('term_order', (int) $wp_term->term_order);
    $this->set_value('term_taxonomy_id', (int) $wp_term->term_taxonomy_id);
    $this->set_value('taxonomy', $wp_term->taxonomy);
    $this->set_value('description', $wp_term->description);
    $this->set_value('parent', (int) $wp_term->parent);
    $this->set_value('term_count', (int) $wp_term->count);
    $this->set_value('object_id', (int) $wp_term->object_id);
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
