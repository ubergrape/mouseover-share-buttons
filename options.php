<?php // add the admin options page

  $defaults = array(
    'enabled' => '1',
    'position' => 'before'
  );

  add_action('admin_menu', 'plugin_admin_add_page');
  add_action('admin_init', 'plugin_admin_init');

  function plugin_admin_init(){
    register_setting( 'ngsb_options', 'ngsb_options', 'ngsb_options_validate' );
    add_settings_section('plugin_main', 'Main Settings', 'ngsb_section_text', 'ngsb_plugin');
    add_settings_field('ngsb_enabled', 'Enable Mouseover Sharebuttons', 'ngsb_enabled', 'ngsb_plugin', 'plugin_main');
    add_settings_field('ngsb_position', 'Use Newsgrape URL', 'ngsb_position', 'ngsb_plugin', 'plugin_main');
  }

  function plugin_admin_add_page() {
    add_options_page('Mouseover Sharebuttons Page', ' Mouseover Sharebuttons Menu', 'manage_options', 'ngsb_plugin', 'plugin_options_page');
  }

  function ngsb_enabled() {
    $options = ngsb_get_options();
    echo '<input name="ngsb_options[enabled]" id="ngsb_enabled" type="checkbox" value="1" class="code" ' . checked( 1, $options['enabled'], false ) . ' />';
  }

  function ngsb_position(){
    $options = ngsb_get_options();
    echo '<input type="radio" name="ngsb_options[position]" value="before"' . checked('before', $options['position'], false) . ' /> before content <br />';
    echo '<input type="radio" name="ngsb_options[position]" value="after"' . checked('after', $options['position'], false) . ' /> after content';
  }

  function ngsb_options_validate($input) {
    $newinput['enabled'] = trim($input['enabled']);
    $newinput['position'] = trim($input['position']);
    return $newinput;
  }

  function ngsb_get_options(){
    global $defaults;
    return wp_parse_args(get_option('ngsb_options'), $defaults);
  }

  function ngsb_section_text() {
    echo '';
  }

?>
<?php // display the admin options page
  function plugin_options_page() {

    $ngsb_img_path =plugins_url(basename(dirname(__FILE__)) ) . '/img/';

?>
  <div>
    <h2>Mouseover Share-Buttons Settings</h2>
    Options relating to the Mouseover Share-Buttons Plugin.
    <form action="options.php" method="post">
      <?php settings_fields('ngsb_options'); ?>
      <?php do_settings_sections('ngsb_plugin'); ?>

      <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
    </form>
  </div>

  <table>
    <tr>
    <td><a href="http://www.newsgrape.com/p/connect-with-wordpress/"><img width="100%" style="max-width:100%;border:none" src="<?php echo $ngsb_img_path; ?>check-newsgrape.jpg"></a></td>
     <td><a href="http://www.wpbeginner.com/"><img width="100%" style="max-width:100%;border:none" src="<?php echo $ngsb_img_path; ?>check-wp-beginner.jpg"></a></td>
    </tr>
  </table>
<?php
}?>
