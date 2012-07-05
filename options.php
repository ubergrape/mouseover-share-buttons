<?php // add the admin options page
  add_action('admin_menu', 'plugin_admin_add_page');
  add_action('admin_init', 'plugin_admin_init');
  
  function plugin_admin_init(){
    register_setting( 'ngsb_options', 'ngsb_options', 'ngsb_options_validate' );
    add_settings_section('plugin_main', 'Main Settings', 'plugin_section_text', 'ngsb_plugin');
    add_settings_field('ngsb_enabled', 'Enable Mouseover Sharebuttons', 'ngsb_enabled', 'ngsb_plugin', 'plugin_main');
  }
  function plugin_admin_add_page() {
    add_options_page('Mouseover Sharebuttons Page', ' Mouseover Sharebuttons Menu', 'manage_options', 'ngsb_plugin', 'plugin_options_page');
  }

  function ngsb_enabled() {
    $options = get_option('ngsb_options');
    echo '<input name="ngsb_options[enabled]" id="ngsb_enabled" type="checkbox" value="1" class="code" ' . checked( 1, $options['enabled'], false ) . ' />';
  }

  function ngsb_options_validate($input) {
    $newinput['enabled'] = trim($input['enabled']);
    echo $newinput['enabled'];
    return $newinput;
  }
?>
<?php // display the admin options page
  function plugin_options_page() {
?>
  <div>
    <h2>My custom plugin</h2>
    Options relating to the Custom Plugin.
    <form action="options.php" method="post">
      <?php settings_fields('ngsb_options'); ?>
      <?php do_settings_sections('ngsb_plugin'); ?>

      <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
    </form>
  </div>

<?php
}?>
