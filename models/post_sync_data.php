<?php

class JSON_API_Post_Sync_Data {
  
  // Note:
  //   JSON_API_Post objects must be instantiated within The Loop.
  
  var $id;              // Integer
  var $slug;            // String
  var $url;             // String
  var $title;           // String
  var $date;            // String (modified by date_format query var)
  var $modified;        // String (modified by date_format query var)
  var $comment_count;   // Integer

  function JSON_API_Post_Sync_Data($wp_post = null) {
    if (!empty($wp_post)) {
      $this->import_wp_object($wp_post);
    }
  }
  
  function import_wp_object($wp_post) {
    global $json_api, $post;
    $date_format = $json_api->query->date_format;
    $this->id = (int) $wp_post->ID;
    setup_postdata($wp_post);
    $this->set_value('slug', $wp_post->post_name);

    $this->set_value('url', get_permalink($this->id));
    $this->set_value('title', strip_tags(htmlspecialchars($wp_post->post_title)));
    $this->set_value('date', get_the_time($date_format));
    $this->set_value('modified', date($date_format, strtotime($wp_post->post_modified)));

    $this->set_categories_value();
    $this->set_tags_value();
    $this->set_author_value($wp_post->post_author);
  }  

  function set_value($key, $value) {
    global $json_api;
    if ($json_api->include_value($key)) {
      $this->$key = $value;
    } else {
      unset($this->$key);
    }
  }

  
  function set_categories_value() {
    global $json_api;
    if ($json_api->include_value('categories')) {
      $this->categories = array();
      if ($wp_categories = get_the_category($this->id)) {
        foreach ($wp_categories as $wp_category) {
          $category = new JSON_API_Category_Sync_Data($wp_category);
          if ($category->id == 1 && $category->slug == 'uncategorized') {
            // Skip the 'uncategorized' category
            continue;
          }
          $this->categories[] = $category;
        }
      }
    } else {
      unset($this->categories);
    }
  }
  
  function set_tags_value() {
    global $json_api;
    if ($json_api->include_value('tags')) {
      $this->tags = array();
      if ($wp_tags = get_the_tags($this->id)) {
        foreach ($wp_tags as $wp_tag) {
          $this->tags[] = new JSON_API_Tag_Sync_Data($wp_tag);
        }
      }
    } else {
      unset($this->tags);
    }
  }
  
  function set_author_value($author_id) {
    global $json_api;
    if ($json_api->include_value('author')) {
      $this->author = new JSON_API_Author_Sync_Data($author_id);
    } else {
      unset($this->author);
    }
  }
  
/*
  function set_categories_value() {
    global $json_api;
    if ($json_api->include_value('categories')) {
      $this->categories = array();
      if ($wp_categories = get_the_category($this->id)) {
        foreach ($wp_categories as $wp_category) {
          if ($wp_category->term_id == 1 && $wp_category->slug == 'uncategorized') {
            // Skip the 'uncategorized' category
            continue;
          }
          $this->categories[] = (int)$wp_category->term_id;
        }
      }
    } else {
      unset($this->categories);
    }
  }
  
  function set_tags_value() {
    global $json_api;
    if ($json_api->include_value('tags')) {
      $this->tags = array();
      if ($wp_tags = get_the_tags($this->id)) {
        foreach ($wp_tags as $wp_tag) {
          $this->tags[] = (int)$wp_tag->term_id;
        }
      }
    } else {
      unset($this->tags);
    }
  }
  
  function set_author_value($author_id) {
    global $json_api;
    if ($json_api->include_value('author')) {
      $this->author = (int)$author_id;
    } else {
      unset($this->author);
    }
  }
*/

}

?>