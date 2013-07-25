<?php

class JSON_API_Author_Sync_Data {
  
  var $id;          // Integer
  var $slug;        // String
  var $name;        // String
  var $first_name;  // String
  var $last_name;   // String
  var $nickname;    // String
  
  // Note:
  //   JSON_API_Author objects can include additional values by using the
  //   author_meta query var.
  
  function JSON_API_Author_Sync_Data($id = null) {
    if ($id) {
      $this->id = (int) $id;
    } else {
      $this->id = (int) get_the_author_meta('ID');
    }
    $this->set_value('slug', 'user_nicename');
    $this->set_value('name', 'display_name');
    $this->set_value('first_name', 'first_name');
    $this->set_value('last_name', 'last_name');
    $this->set_value('nickname', 'nickname');
  }
  
  function set_value($key, $wp_key = false) {
    global $json_api;

    if (!$wp_key) {
      $wp_key = $key;
    }

    if ($json_api->include_value($key)) {
      $this->$key = get_the_author_meta($wp_key, $this->id);
//      $this->$key = htmlspecialchars(get_the_author_meta($wp_key, $this->id), ENT_QUOTES);
    } else {
      unset($this->$key);
    }
  }
  
}

?>