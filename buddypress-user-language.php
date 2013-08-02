<?php
/*
Plugin Name: Buddypress User Language
Description: Allows backend users to set the language displayed in the back-end and front-end of your buddypress site.
Version: 1.0
Author: webilop
Author URI: www.webilop.com
License: GPL2
*/

/*  Copyright 2013  webilop  (email : admin@webilop.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
// Exit if accessed directly
if (!defined('ABSPATH'))
  exit;

if (in_array('user-language-switch/user-language-switch.php', apply_filters('active_plugins', get_option('active_plugins')))){ //ULS plugin is activated

   /**
    * Add entries in menu sidebar in back end.
    */
   function register_bp_menu(){
     add_menu_page( __('Buddypress User Language','bp-user-language'), __('Buddypress User Language','bp-user-language'), 'read', 'bp-user-language-page', 'create_bp_user_language_page' );
   }
  /**
   * Add the menu in the hook
   */
  add_action( 'admin_menu', 'register_bp_menu' );
   /**
    * Create the HTML page to manage user language preferences.
    */
  function create_bp_user_language_page(){
    if ( !current_user_can( 'read' ) )  {
         wp_die( __( 'You do not have sufficient permissions to access this page.', 'user-language-switch' ) );
    } ?>
    <div class="about-webilop" style="width:50%;float: left;margin-top:20px;">
    <h3 class="hndle"><?php _e('About','user-language-switch');?></h3>
    <div class="inside">
    <p><strong>Buddypress User Language </strong><?php _e('was developed by ', 'user-language-switch');?> <a title="Webilop. web and mobile development" href="http://www.webilop.com">Webilop</a></p>
    <p><?php _e('Webilop is a company focused on web and mobile solutions. We develop custom mobile applications and templates and plugins for CMSs such as Wordpress and Joomla!.', 'user-language-switch');?></p>
   <div><h4><?php _e('Follow us', 'user-language-switch')?></h4><a title="Facebook" href="https://www.facebook.com/webilop" target="_blank"><img src="<?php echo WP_PLUGIN_URL;?>/user-language-switch/images/facebook.png"></a>
    <a title="LinkedIn" href="http://www.linkedin.com/company/webilop" target="_blank"><img src="<?php echo WP_PLUGIN_URL;?>/user-language-switch/images/linkedin.png"></a>
    <a title="Twitter" href="https://twitter.com/webilop" target="_blank"><img src="<?php echo WP_PLUGIN_URL;?>/user-language-switch/images/twitter.png"></a>
    <a title="Google Plus" href="https://plus.google.com/104606011635671696803" target="_blank" rel="publisher"><img src="<?php echo WP_PLUGIN_URL;?>/user-language-switch/images/gplus.png"></a></div>
   </div>
  <?php 
  }
       
  function my_bp_nav_adder()
  {
      bp_core_new_nav_item(
          array(
              'name' => __('Language', 'buddypress'),
              'slug' => 'user-language',
              'position' => 75,
              'show_for_displayed_user' => true,
              'screen_function' => 'all_conversations_link',
              'item_css_id' => 'all-conversations'
          ));
          print_r($wp_filter);
  }
  function all_conversations_link () {
      //add title and content here - last is to call the members plugin.php template
      add_action( 'bp_template_title', 'my_groups_page_function_to_show_screen_title' );
      add_action( 'bp_template_content', 'my_groups_page_function_to_show_screen_content' );
      bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
  }
  
  function my_groups_page_function_to_show_screen_title() {
      echo 'Language Settings';
  }
  function my_groups_page_function_to_show_screen_content() {
        $options = get_option('uls_settings');
        $default_backend_language = get_user_meta(get_current_user_id(), $options['backend_language_field_name'], true);
  
        if(empty($default_backend_language))
           $default_backend_language = $options['default_backend_language'];
        $default_frontend_language = get_user_meta(get_current_user_id(), $options['frontend_language_field_name'], true);
        if(empty($default_frontend_language))
           $default_frontend_language = $options['default_frontend_language'];
        if(isset($_GET['message'])){
          if( $_GET['message'] == 'save'){?>
            <div class="uls-notice updated"><p><strong><?php _e('Preferences saved.', 'user-language-switch'); ?></strong></p></div>
          <?php 
          }else{ ?>
            <div class="uls-error error"><p><strong><?php _e('Error saving preferences.', 'user-language-switch'); ?></strong></p></div>
          <?php
          } 
        }
        ?>
           <form id="uls_configuration_form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
           <?php if(function_exists("wp_nonce_field")): ?> 
              <?php wp_nonce_field('bp_user_language_preferences','uls_wpnonce'); ?>
           <?php endif; ?>
           <input type="hidden" name="action" value="bp_user_language_preferences" />
           <table class="form-table">
              <tbody>
                 <?php if($options['user_backend_configuration']): ?>
                 <tr valign="top">
                    <th scope="row"><?php _e('Displayed language in the admin side','user-language-switch'); ?></th>
                    <td>
                       <?php echo uls_language_selector_input($options['backend_language_field_name'],$options['backend_language_field_name'],$default_backend_language); ?>
                    </td>
                 </tr>
                 <?php endif; ?>
                 <?php if($options['user_frontend_configuration']): ?>
                 <tr valign="top">
                    <th scope="row"><?php _e('Displayed language in the front-end side','user-language-switch'); ?></th>
                    <td>
                       <?php echo uls_language_selector_input($options['frontend_language_field_name'],$options['frontend_language_field_name'],$default_frontend_language); ?>
                    </td>
                 </tr>
                 <?php endif; ?>
              </tbody>
           </table>
           <p class="submit">
              <input type="submit" class="button-primary" value="<?php _e('Save','user-language-switch'); ?>" />
           </p>
           </form>
  <?php
  }
  
     /**
      * Process and save the user language prefernces.
      */
     function set_user_language_preferences(){
        //check parameters
        if(empty($_POST) || !wp_verify_nonce($_POST['uls_wpnonce'],'bp_user_language_preferences' )){
          if(strpos($_SERVER['HTTP_REFERER'], 'message'))
           wp_redirect($_SERVER['HTTP_REFERER']);
          else 
            wp_redirect($_SERVER['HTTP_REFERER'].'?message=error');
          exit;
        }
  
        //save settings for the user
        $options = get_option('uls_settings');
        if(!empty($_POST[$options['backend_language_field_name']]))
           update_user_meta(get_current_user_id(), $options['backend_language_field_name'], $_POST[$options['backend_language_field_name']]);
        if(!empty($_POST[$options['frontend_language_field_name']]))
           update_user_meta(get_current_user_id(), $options['frontend_language_field_name'], $_POST[$options['frontend_language_field_name']]);
        
        if(strpos($_SERVER['HTTP_REFERER'], 'message') )  
          wp_redirect($_SERVER['HTTP_REFERER']);
        else 
          wp_redirect($_SERVER['HTTP_REFERER'].'?message=save');//wp_redirect(substr($_SERVER['HTTP_REFERER'],0,strpos($_SERVER['HTTP_REFERER'],"?")));
        exit;
     }
  /**
   * Add ajax action to save user language preferences.
   */
  add_action('wp_ajax_bp_user_language_preferences', 'set_user_language_preferences');
  add_action( 'bp_setup_nav', 'my_bp_nav_adder' );
}else{//ULS plugins is not installed

  function bp_user_language_error_notice() {
    global $current_screen;
    if ($current_screen->parent_base == 'plugins') {
      echo '<div class="error"><p>' . __('Buddypress User Language requires <a href="http://wordpress.org/plugins/user-language-switch/" target="_blank">User Language Switch</a> to be activated in order to work. Please install and activate <a href="' . admin_url('plugins.php?tab=search&type=term&s=User Language Switch') . '" target="_blank">User Language Switch</a> first.','user-language-switch') . '</p></div>';
    }
  } 
  add_action('admin_notices', 'bp_user_language_error_notice'); 
}
?>
