<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/evgeniifeelter
 * @since      1.0.0
 *
 * @package    Feelter_wp
 * @subpackage Feelter_wp/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Feelter_wp
 * @subpackage Feelter_wp/admin
 * @author     Evgenii <evgenii@feelter.com>
 */ 

class Feelter_wp_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Feelter_wp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Feelter_wp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_register_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/feelter_wp-admin.css', array(), $this->version, 'all');
		wp_register_style('style2', plugin_dir_url(__FILE__) . 'css/feelter_wp-admin2.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Feelter_wp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Feelter_wp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/feelter_wp-admin.js', array('jquery'), $this->version, true);
	}

	function register_settings_page()
	{
		
	    $hook = add_menu_page('Feelter WP', 'Feelter_WP', 'manage_options', $this->plugin_name, array($this, 'display_settings_page'), 'dashicons-chart-area', 26);
		add_submenu_page(
			$this->plugin_name,                             // parent slug
		__( 'Templates' ),      // page title
		__( 'Templates' ),      // menu title
		'manage_options',                        // capability
		'templates',                           // menu_slug
		array( $this, '' )  // callable function
	);
	   
	  // remove the "main" submenue page
	//   remove_submenu_page($this->plugin_name, $this->plugin_name);
	  // tell `_wp_menu_output` not to use the submenu item as its link
	//   add_filter("submenu_as_parent_{$hook}", '__return_true');
	}

	public function display_settings_page()
	{

		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/feelter_wp-admin-display.php';
	}

	/**
	 * Register the settings for our settings page.
	 *
	 * @since    1.0.0
	 */
	public function register_settings()
	{

		$widget_settings = get_option( 'feelter_wp-settings' );
		$lang = $widget_settings['languages'];
		include(plugin_dir_path(dirname( __DIR__ )) . 'feelter_wp/languages/' . $lang . '.php');
		
		register_setting(
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings',
			array($this, 'sandbox_register_setting')
		);

		add_settings_section(
			$this->plugin_name . '-settings-section',
			__('', 'feelter_wp'),
			array($this, 'sandbox_add_settings_section'),
			$this->plugin_name . '-settings'
		);
		add_settings_field(
			'languages',
			__($langArray[''], 'feelter_wp'),
			array($this, 'sandbox_add_languages'),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'languages',
				'default'   => __('Select language', 'feelter_wp'),
				'description' => __('Select language', 'feelter_wp'),
				'choices' => get_option('feelter_wp_languages')	
			)
		);
		add_settings_field(
			'toggle-content-override',
			__($langArray['Show widget'], 'feelter_wp'),
			array($this, 'sandbox_add_settings_field_single_checkbox'),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'toggle-content-override',
				'description' => __($langArray['This toggle hiding or showing all plugin functionality on the page'], 'feelter_wp')
			)
		);
		add_settings_field(
			'select_widget_location',
			__($langArray['Select widget location'], 'feelter_wp'),
			array($this, 'sandbox_add_settings_field_dropdown'),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'select_widget_location',
				'default'   => __($langArray['Select location'], 'feelter_wp'),
				'description' => __($langArray['Choose widget location'], 'feelter_wp'),
				'choices' => get_option('feelter_wp_hooks')
			)
		);
		add_settings_field(
			'select_anchor_location',
			__($langArray['Select anchor location'], 'feelter_wp'),
			array($this, 'sandbox_add_settings_field_dropdown'),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'select_anchor_location',
				'default'   => __($langArray['Select location'], 'feelter_wp'),
				'description' => __($langArray['Choose anchor location'], 'feelter_wp'),
				'choices' => get_option('feelter_wp_anchor_hooks')
			)
		);
		add_settings_field(
			'widget_type',
			__($langArray['Select type of the widget'], 'feelter_wp'),
			array($this, 'sandbox_add_settings_field_dropdown'),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'widget_type',
				'default'   => __($langArray['Select type of the widget'], 'feelter_wp'),
				'description' => __($langArray['Select type of the widget'], 'feelter_wp'),
				'choices' => get_option('feelter_wp_types'),
				'class' => true
			)
		);
		add_settings_field(
			'widget_type_templates',
			__($langArray['Select template'], 'feelter_wp'),
			array($this, 'sandbox_add_settings_field_template_dropdown'),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'widget_type_templates',
				'default'   => __($langArray['Select type of the widget'], 'feelter_wp'),
				'description' => __($langArray['Select type of the widget'], 'feelter_wp'),
				'types' => get_option('feelter_wp_types'),
				'target' => 'widget_type_templates'
			)
		);		
	}

	/**
	 * Sandbox our section for the settings.
	 *
	 * @since    1.0.0
	 */
	public function sandbox_add_settings_section()
	{
		return;
	}

	// 
	/**
	 * Sandbox our single checkboxes.
	 *
	 * @since    1.0.0
	 */
	public function sandbox_add_languages($args)
	{		
		$widget_settings = get_option( 'feelter_wp-settings' );
		$lang = $widget_settings['languages'];
		include(plugin_dir_path(dirname( __DIR__ )) . 'feelter_wp/languages/' . $lang . '.php');

		$field_id = $args['label_for'];
		$field_default = $args['default'];
		$options = get_option($this->plugin_name . '-settings');
		$items = $args['choices'];
	?>	
		<div id='storefront'>
		<h2 id='controls'> <?php  
		echo $langArray['Storefront Controls']; ?> </h2>
		<p style='color:#6e6d7a;margin-top:45px;margin-left:-60px;'><?php echo $langArray['Change settings that will be displayed on your store']; ?></p>
		</div>
		<select id="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" name="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" disabled="true">
			<?php foreach ($items as $item) {
				$selected = ($options[$field_id] === $item->name) ? 'selected="selected"' : '';
				echo "<option value='$item->name'  data-class='$item->name' $selected>$item->display_name</option>";
			}
			?> </select>  
			
	<?php
	}
	 
	public function sandbox_add_settings_field_single_checkbox($args)
	{
		$field_id = $args['label_for'];
		$field_description = $args['description'];
		$options = get_option($this->plugin_name . '-settings');
		$Feelter_wp_status = get_option('Feelter_wp_status');
		$onOff = $options['toggle-content-override'];	

	?>
	<div class='switch-toggle'>
                <input type='checkbox' id='show' name="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" value='1' <?php checked($onOff, true); ?> value="<?php
																	if ($Feelter_wp_status === 'Not Connected' ) {echo 0;} else 
																	{echo  1;}
																	?>">
                <label for='show'
                        title='This toggle hiding or showing all plugin functionality on the page'></label>
                </div>
				
  	</div>		
	<?php
	}
	
	public function sandbox_add_settings_field_dropdown($args)
	{
		$field_id = $args['label_for'];
		$field_default = $args['default'];
		$options = get_option($this->plugin_name . '-settings');
		$items = $args['choices'];

		$widget_settings = get_option( 'feelter_wp-settings' );
		$lang = $widget_settings['languages'];
		include(plugin_dir_path(dirname( __DIR__ )) . 'feelter_wp/languages/' . $lang . '.php');
	?>
		<select id="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" name="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>">
		<option class='choose' ><?php echo $langArray['Please Choose']?></option>
			<?php foreach ($items as $item) {
				$selected = ($options[$field_id] === $item->name) ? 'selected="selected"' : '';
				echo "<option value='$item->name' $selected>$item->display_name</option>";
			}
			?> </select>
	<?php
	}
	public function sandbox_add_settings_field_template_dropdown($args)
	{
		$field_id = $args['label_for'];
		$field_default = $args['default'];
		$target = $args['target'];
		$options = get_option($this->plugin_name . '-settings');
		$items = $args['types'];

		$widget_settings = get_option( 'feelter_wp-settings' );
		$lang = $widget_settings['languages'];
		include(plugin_dir_path(dirname( __DIR__ )) . 'feelter_wp/languages/' . $lang . '.php');
	?>
		<select id="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" name="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>">
			<option class='choose carusel pop_up social_wall' id='choose'><?php echo $langArray['Please Choose']?></option>
			<?php 
			foreach ($items as $item) {
				foreach ($item->templates as $template) {
					$selected = ($options[$target] === $template) ? 'selected="selected"' : '';
					$style = $selected ? 'block' : 'none';
					echo "<option class='$item->name' style='display :$style' value='$template' $selected>$template</option>";
				}
			}
			
			?> </select>
			
			<input type='button' value="<?php echo $langArray['Reset Settings'] ?>" id='reset' onclick='select_default();' ></input>
			<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
		<script>
			document.getElementById('feelter_wp-settings[widget_type]').onchange = function() {
				document.getElementById('choose').selected = 'selected';
				let selector = document.getElementById('feelter_wp-settings[widget_type]');
				let value = selector[selector.selectedIndex].value;
				let nodeList = document.getElementById("<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>").querySelectorAll('option');
				
				nodeList.forEach(function(option) {
					if (option.classList.contains(value)) {
						option.style.display = 'block';
					} else {
						option.style.display = 'none';
					}
				});
			}
		</script>
		<script>
                $(document).ready(function() {					
                    let nodeList = document.getElementById('feelter_wp-settings[widget_type_templates]').querySelectorAll('option');
                    let selector = document.getElementById('feelter_wp-settings[widget_type]');
                    let value = selector[selector.selectedIndex].value;
                if (value === 'carusel' ) {
                    document.getElementById('feelter_wp-settings[widget_type_templates]').querySelectorAll('option')[1].style.display='block';
                    document.getElementById('feelter_wp-settings[widget_type_templates]').querySelectorAll('option')[2].style.display='block';
                    document.getElementById('feelter_wp-settings[widget_type_templates]').querySelectorAll('option')[3].style.display='block';
               }
                else if (value === 'pop_up' ) {
                    document.getElementById('feelter_wp-settings[widget_type_templates]').querySelectorAll('option')[4].style.display='block';
                    document.getElementById('feelter_wp-settings[widget_type_templates]').querySelectorAll('option')[5].style.display='block';
                    document.getElementById('feelter_wp-settings[widget_type_templates]').querySelectorAll('option')[6].style.display='block';
               }
                else if (value === 'social_wall' ) {
                    document.getElementById('feelter_wp-settings[widget_type_templates]').querySelectorAll('option')[7].style.display='block';
                    document.getElementById('feelter_wp-settings[widget_type_templates]').querySelectorAll('option')[8].style.display='block';
                    document.getElementById('feelter_wp-settings[widget_type_templates]').querySelectorAll('option')[9].style.display='block';
               };
                });
    </script>
<?php
	}
	
}