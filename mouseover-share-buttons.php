<?php
/**
 * Plugin Name: Mouseover Share-Buttons by Newsgrape
 * Plugin URI: 
 * Description: Mouseover Share-Buttons integration for Wordpress
 * Version: 0.1
 * Author: Newsgrape
 * Author URI: https://www.newsgrape.com
 */



$plugin_dir = dirname(__FILE__);

@require_once "$plugin_dir/options.php";

function ngsb_sharebuttons_init(){
  wp_register_script('ajax-share-buttons', plugins_url(basename(dirname(__FILE__))) . '/js/ajax-widgets.js', array(
    'jquery',
  ));
  wp_enqueue_script('ajax-share-buttons');
}

function ngsb_head() {
  $ngsb_img_path =plugins_url(basename(dirname(__FILE__)) ) . '/img/ngsb_button_row.png';
  $ngsb_css = '
    .lazy-share-widget {
      font-size:11px;
      font-style:normal;
      font-weight:bold;
      min-width:211px;
      height:20px;
      margin-top:12px;
      background:#fff url('.$ngsb_img_path.') 0 0 no-repeat;
      float:left;
    }
    .lazy-share-widget .platform {
      height:20px;
      float:left;
      display:inline;
    }
  ';
  echo '<style type="text/css">'.$ngsb_css.'</style>';
  echo ngsb_opengraph_tags();
}

function ngsb_generate_html($post){

  $post_id = $post->ID;

  $url = ngsb_get_permalink($post_id);

  $html = '
    <div class="lazy-share-widget" id="sharing-'.$post_id.'">
      <div class="platform facebook" id="fb-newshare-'.$post_id.'"></div>
      <div class="platform twitter" id="tweet-newshare-'.$post_id.'"></div>
      <div class="platform gplus"><span id="gplus-newshare-'.$post_id.'"></span></div>
      <div class="platform linkedin" id="pinterest-newshare-'.$post_id.'"></div>
      <div class="ngsb-post-title" style="display:none;">'.$post->post_title.'</div>
      <div class="ngsb-post-url" style="display:none;">'.$url.'</div>
    </div>    
  ';

  return $html;
}

function ngsb_share_buttons_before($title){
  global $post;
  
  if(!in_the_loop() or !(is_front_page() or is_category() or is_archive())) {
    return $title;
  }
  $options = ngsb_get_options();

  if($options['enabled'] && $options['position'] == 'before'){
    $button = ngsb_generate_html($post);
    return $title . '<br />' . $button . '<br />';
  }else{
    return $title;
  }
}

function ngsb_share_buttons_after($tags){
  global $post;

   if(!in_the_loop() or !(is_front_page() or is_category() or is_archive())) {
    return $tags;
  }
 
  $options = ngsb_get_options();

  if($options['enabled'] && $options['position'] == 'after'){
    $button = ngsb_generate_html($post);
    return $tags . '<br />' . $button . '<br />';
  }else{
    return $tags;
  }
}

function ngsb_get_article_thumbnail(){

  global $post;

  $images = '';

  if(function_exists('get_post_thumbnail_id')) {
    $images = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID));
  }

  if(is_array($images)) {
    $thumbnail = $images['0'];
  } else {
    $default_thumbnail = '';
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

    if($output > 0) {
      $thumbnail = $matches[1][0];
    } else {
        $thumbnail = false;
      }
    }
  return $thumbnail;
}

function ngsb_get_permalink($post_id){
  return get_permalink($post_id);
}

function ngsb_opengraph_tags() {
  global $post;
  $options = ngsb_get_options();
  // only single article
  if(is_feed() || is_trackback() || !is_singular()) {
    return;
  }

  $thumbnail = ngsb_get_article_thumbnail();

  echo "\n" . '<!-- Facebook Like Thumbnail -->' . "\n";
  if($thumbnail) {
    echo sprintf('<link href="%s" rel="image_src" />%s', esc_url($thumbnail), "\n");
  }

  /**
   * Open:Graph-Tags for FB-Like
   */
  echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '"/>' . "\n";
  echo '<meta property="og:type" content="article"/>' . "\n";
  echo '<meta property="og:title" content="' . strip_tags(get_the_title()) . '"/>' . "\n";

  $url = ngsb_get_permalink($post->ID);
  echo '<meta property="og:url" content="' . esc_url($url) . '"/>' . "\n";
  if($thumbnail) {
    echo '<meta property="og:image" content="' . esc_url($thumbnail) . '"/>' . "\n";
  }
    
}

add_action('init', 'ngsb_sharebuttons_init');
add_action('wp_head', 'ngsb_head');
add_filter('the_title', 'ngsb_share_buttons_before');
add_filter('the_tags', 'ngsb_share_buttons_after');


?>
