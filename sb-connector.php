<?php
/**
 * Plugin Name: Speed Blogging Integration
 * Description: Speed Blogging Integration is a plugin that connects your blog with SpeedBlogging system and it enables
 * you to publish your blog post fast
 * Version: 1.0.7
 * Author: Internet Marketing Bar
 * Author URI: http://internetmarketingbar.com
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

 /* No direct access. */
if (!function_exists('add_action')) {
    exit(0);
}

add_action('admin_menu', 'sb_connector_admin_menu');
add_action('admin_enqueue_scripts', 'sb_connector_enqueue_script');
add_action('init', 'sb_init_options');
add_action('init', 'allow_script_content');

function sb_connector_admin_menu() {
    add_menu_page('SB Connector', 'SB Connector', 'activate_plugins', 'sbconnector', 'sb_connector_page');
}

function allow_script_content() {
	global $allowedposttags, $allowedtags;
	$allowedposttags['script'] = array(
		"src" => array(),
	);
	$allowedtags['script'] = array(
		"src" => array(),
	);
}

function sb_connector_enqueue_script()
{
    $plugin_url = plugin_dir_url(__FILE__);

    wp_enqueue_style('dashboard-css', $plugin_url . 'css/dashboard.css', array(), '1.0');
    wp_enqueue_style('nicer-settings-css', $plugin_url . 'css/nicer-settings.css', array(), '1.0');
    wp_enqueue_style('bootstrap-css', $plugin_url . 'css/bootstrap.css', array(), '1.0');
    wp_enqueue_script('bootstrap-js', $plugin_url . 'js/bootstrap.js', array('jquery'), '1.0', false);
    wp_enqueue_script( 'zeroclipboard-js', $plugin_url . 'js/zeroclipboard-min.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'speedblogging-js', $plugin_url . 'js/main.js', array( 'jquery', 'zeroclipboard-js' ), '1.0', true );
}

function sb_init_options()
{
    add_option('sbc_hash', sha1(md5(microtime())));
    add_option('sbc_connector', plugins_url( 'api/api.php', __FILE__ ) );
}
        

function sb_connector_page() {
	$plugin_url = plugin_dir_url(__FILE__);
    if (!is_admin()) {
        wp_die(__('You do not have admin rights to perform this action. Please contact administrator'));
    }
	$hash = get_option('sbc_hash', '');
	$api_url = get_option('sbc_connector', '');
   
    ?>
        <div class="wrap smart_only_area">
	<h1 class="page-header">SB Connector <small>version 1.0.7</small></h1>
	
	<div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
               <div class="form-group">
                   <label for="sb_key">
                       Your SB Connector Key<br/>
                       <small>Please add your blog with this key in SpeedBlogging to connect this blog with SpeedBlogging system</small>
                   </label>
                   <div class="input-group">
                       <input type="text" class="form-control input-lg" name="sb-key" id="sb-key"
                              value="<?php echo $hash; ?>"/>
                        <span class="input-group-btn">
                            <button class="btn btn-lg btn=default zclip" data-method="direct" data-copy-type="value"
                                    data-target="input[name=sb-key]" type="button"
                                    style="background-color: #fff; border: 1px solid #ccc;">Copy
                            </button>
                        </span>
                   </div>
               </div>
                <div class="form-group">
                    <label for="connector_url">
                        Your API Endpoint<br/>
                        <small>This is the API endpoint you will need to add your blog with</small>
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control input-lg" name="connector_url" id="connector_url"
                               value="<?php echo $api_url; ?>"/>
                        <span class="input-group-btn">
                            <button class="btn btn-lg btn=default zclip" data-method="direct" data-copy-type="value"
                                    data-target="input[name=connector_url]" type="button"
                                    style="background-color: #fff; border: 1px solid #ccc;">Copy
                            </button>
                        </span>
                    </div>
                </div> 
            </div>
        </div>
    </div>
	<?php
    
}

