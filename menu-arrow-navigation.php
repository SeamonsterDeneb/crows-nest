<?php
/**
 * Plugin Name: Crow's Nest Menu Navigation
 * Plugin URI: https://www.seamonsterstudios.com/crows-nest-arrow-key-navigation-for-menus/
 * Description: A plugin to add arrow-key navigation to menus
 * Version: 1.1
 * Author: SeaMonster Studios
 * Author URI: http://www.seamonsterstudios.com
 */
 
function menu_arrow_navigation_scripts_and_styles() {
    wp_enqueue_style('menu-arrow-navigation-styles', plugin_dir_url(__FILE__) . 'menu-arrow-navigation-styles.css');
    wp_enqueue_script('menu-arrow-navigation-script', plugin_dir_url(__FILE__) . 'menu-arrow-navigation-script.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'menu_arrow_navigation_scripts_and_styles');

function amwan_variables() {
	
	wp_enqueue_script('amwan_variables_script', plugin_dir_url(__FILE__) .'menu-arrow-navigation-script.js', array(), '1.0', true);
	$options = get_option( 'amwan_settings' );
    $primaryMenuSelector = $options['amwan_text_field_primary'];
    $secondaryMenuItemSelector = $options['amwan_text_field_secondary'];
    $instructionsColor = $options['amwan_text_field_color'];
    $fromTopLocation = $options['amwan_from_top'];
    $wholeMenuSelector = $options['amwan_text_field_whole_menu'];
    $mainContentSelector = $options['amwan_text_field_main_content'];
	$script  = 'primaryMenuSelector = '. json_encode($primaryMenuSelector) .'; ';
	$script .= 'secondaryMenuItemSelector = '. json_encode($secondaryMenuItemSelector) .'; ';
	$script .= 'instructionsColor = '. json_encode($instructionsColor) .'; ';
	$script .= 'fromTopLocation = '. json_encode($fromTopLocation) .'; ';
	$script .= 'wholeMenuSelector = '. json_encode($wholeMenuSelector) .'; ';
	$script .= 'mainContentSelector = '. json_encode($mainContentSelector) .'; ';
	
	wp_add_inline_script('amwan_variables_script', $script, 'before');
}
add_action('wp_enqueue_scripts', 'amwan_variables');


add_action( 'admin_menu', 'amwan_add_admin_menu' );
add_action( 'admin_init', 'amwan_settings_init' );


function amwan_add_admin_menu(  ) { 

	add_menu_page( "Crow's Nest", "Menu Setup", "manage_options", "accessible_menu_with_arrow_navigation", "amwan_options_page", "dashicons-universal-access-alt" );
}


function amwan_settings_init(  ) { 

	register_setting( 'pluginPage', 'amwan_settings' );

	add_settings_section(
		'amwan_pluginPage_section', 
		__( ' ', 'crows-nest-menu-navigation' ), 
		'amwan_settings_section_callback', 
		'pluginPage'
	);
	
	add_settings_field( 
		'amwan_text_field_color', 
		__( 'Color (hex or rgba) for the popup instructions - default is white', 'crows-nest-menu-navigation' ), 
		'amwan_text_field_color_render', 
		'pluginPage', 
		'amwan_pluginPage_section' 
	);
	add_settings_field( 
		'amwan_from_top', 
		__( 'Distance from top, as absolutely positioned item inside the menu - default is -50px', 'crows-nest-menu-navigation' ), 
		'amwan_from_top_render', 
		'pluginPage', 
		'amwan_pluginPage_section' 
	);

	add_settings_field( 
		'amwan_text_field_primary', 
		__( 'Primary Menu Items (the first level before anything drops down)', 'crows-nest-menu-navigation' ), 
		'amwan_text_field_primary_render', 
		'pluginPage', 
		'amwan_pluginPage_section' 
	);

	add_settings_field( 
		'amwan_text_field_secondary', 
		__( 'Secondary Menu Items (all of the links in the dropdowns)', 'crows-nest-menu-navigation' ), 
		'amwan_text_field_secondary_render', 
		'pluginPage', 
		'amwan_pluginPage_section' 
	);


	add_settings_field( 
		'amwan_text_field_whole_menu', 
		__( 'Whole Menu (the instructions will pop up above this)', 'crows-nest-menu-navigation' ), 
		'amwan_text_field_whole_menu_render', 
		'pluginPage', 
		'amwan_pluginPage_section' 
	);

	add_settings_field( 
		'amwan_text_field_main_content', 
		__( 'Page Main Content (where the skip-navigation link jumps to)', 'crows-nest-menu-navigation' ), 
		'amwan_text_field_main_content_render', 
		'pluginPage', 
		'amwan_pluginPage_section' 
	);
}


function amwan_text_field_primary_render(  ) { 

	$options = get_option( 'amwan_settings' );
	?>
	<input type='text' name='amwan_settings[amwan_text_field_primary]' value='<?php echo esc_html($options['amwan_text_field_primary']); ?>'>
	<?php
}

function amwan_text_field_secondary_render(  ) { 

	$options = get_option( 'amwan_settings' );
	?>
	<input type='text' name='amwan_settings[amwan_text_field_secondary]' value='<?php echo esc_html($options['amwan_text_field_secondary']); ?>'>

	<?php
}


function amwan_text_field_color_render(  ) { 

	$options = get_option( 'amwan_settings' );
	?>
	<input type='text' name='amwan_settings[amwan_text_field_color]' value='<?php echo esc_html($options['amwan_text_field_color']); ?>'>

	<?php
}

function amwan_from_top_render(  ) { 

	$options = get_option( 'amwan_settings' );
	?>
	<input type='text' name='amwan_settings[amwan_from_top]' value='<?php echo esc_html($options['amwan_from_top']); ?>'>

	<?php
}


function amwan_text_field_whole_menu_render(  ) { 

	$options = get_option( 'amwan_settings' );
	?>
	<input type='text' name='amwan_settings[amwan_text_field_whole_menu]' value='<?php echo esc_html($options['amwan_text_field_whole_menu']); ?>'>
	<?php
}


function amwan_text_field_main_content_render(  ) { 

	$options = get_option( 'amwan_settings' );
	?>
	<input type='text' name='amwan_settings[amwan_text_field_main_content]' value='<?php echo esc_html($options['amwan_text_field_main_content']); ?>'> 
	<?php
}


function amwan_settings_section_callback(  ) { 

	echo __( 'Fill the following fields in with the appropriate querySelectors (or CSS selectors) to identify the various parts of your menu that are to be navigable by keyboard arrow keys. Make sure these are specific enough to catch only the menu elements indicated.', 'crows-nest-menu-navigation' );
}


function amwan_options_page(  ) { 

		?>
		<form action='options.php' method='post'>

			<h1>Crow's Nest Menu Navigation</h1>
			<div class="amwan-options-page">
				<div class="amwan-setup">
					<?php
					settings_fields( 'pluginPage' );
					do_settings_sections( 'pluginPage' );
					submit_button();
					?>
				</div>
				<div class="amwan-instructions">
					<h2>General Instructions</h2>
					<div class="instruction-columns">
						<div class="instructions-text">
							<p>The easiest way to find the proper selectors for the various elements is to use the customizer and experiment with CSS selectors. We recommend you put a simple outline style into the Custom CSS section of the WordPress Customizer, and then try various CSS selectors out with it until you find the ones you need.</p>
							<p>For example, you could start with this style within the customizer:</p>
							<code>{
								outline: 2px solid red;
								}
							</code>
						</div>
						<div class="instructions-image first-instruction-image">
							<div class="image-holder"><img  tabindex="0" role="button" id="first-instruction-image" src="<?php echo plugin_dir_url(__FILE__)?>1-customize.jpg" alt="screenshot of Wordpress customizer with base style put in"></div>
							<div class="btn-instructions">click images to expand or contract</div>
						</div>
					</div>
					<div class="instruction-columns">
						<div class="instructions-text">
							<p>After setting the style, you can experiment with altering the selector by inspecting in your browser an instance of the needed element (right-click on the element and choose Inspect), and finding the combination of id, class, and element that work together to get you just the ones you need. You'll likely find that it will be easiest to get only the elements you want by using the child combinator (greater-than sign) rather than the general descendant combinator (space). This way, for example, your submenu links won't be included. <a href="https://youtu.be/XAjYsjXP5Dc">Learn more about CSS combinators here.</a> Your initial style in the customizer may look something like this:</p>
							<code>
								#site-navigation>ul>li>a{
									outline: 2px solid red;
								}
							</code>
						</div>
						<div class="instructions-image second-instruction-image">
							<div class="image-holder"><img  tabindex="0" role="button" id="second-instruction-image" src="<?php echo plugin_dir_url(__FILE__)?>2-finding-selectors.jpg" alt="screenshot of open devtools with selectors outlined"></div>
						</div>
					</div>
					<div class="instruction-columns">
						<div class="instructions-text">
							<p>You may find that your CSS selector may include some elements that you'd rather not have as part of your menu to be navagable through keyboard. You may be able to fix this by simply making your selector more specific, but in some cases it might just be easier to exclude particular elements using the CSS :not() pseudoselector. Simply find a selector for that element and add it inside the parentheses of the :not() pseudoselector. Unfortunately, you can't add more than one selector inside the parentheses, but you can add multiple :not() pseudoselectors. You may end up with something like this:</p>
							<code>
								#site-navigation>ul>li>a:not(#menu-item-42240 a):not(#menu-item-66290 a):not(#menu-item-21883 a):not(#menu-item-66289 a){
									outline: 2px solid red;
								}
							</code>
						</div>
						<div class="instructions-image third-instruction-image">
							<div class="image-holder"><img  tabindex="0" role="button" id="third-instruction-image" src="<?php echo plugin_dir_url(__FILE__)?>3-excluding-selectors.jpg" alt="screenshot of customizer with selectors added, outlining several undesired items, devtools open with those selectors outlined"></div>
						</div>
					</div>
					<div class="instruction-columns">
						<div class="instructions-text">
							<p>Once you've identified the right selectors in the customizer (only the menu elements you want are showing the outline) copy and paste them into this page's boxes ("Color", "Primary Menu Items", etc) and save to enable menu navigation using the arrow keys!</p>
						</div>
						<div class="instructions-image fourth-instruction-image">
							<div class="image-holder"><img  tabindex="0" role="button" id="fourth-instruction-image" src="<?php echo plugin_dir_url(__FILE__)?>4-excluded.jpg" alt="screenshot of customizer with selectors excluded, showing only the desired items on the page outlined"></div>
						</div>
					</div>
					<hr>
					<h2>Tips and Tricks</h2>
					<ul>
						<li>You can add elements to the selector separating the different rules to be combined using a comma between selectors. For example, "#menu-main-nav>li>a,.header-notice a" would include any link element that is directly inside a list item that is directly inside of a list with an ID of "main-menu-nav", as well as any link that is anywhere inside of an element with the class of "header-notice". </li>
						<li>You may need to exclude invisible DOM elements if these are found by your querySelector. If your navigation is being stopped somewhere, you should write this in the console:<br>
							<code>var selection = document.querySelectorAll('[your selector here]');<br>
								console.log(selection);
							</code>
							<p>If the console reveals that there are more nodes in your selection than you count menu items, you may be selecting a hidden item that you'll need to exclude with a :not() assertion.</p>
						</li>
					</ul>
				</div>
			</div>
			<style>
				.amwan-options-page {
					display: flex;
					flex-direction: column;
				}
				.amwan-instructions {
					margin-left: 10px;
					border: solid lightsteelblue;
					padding: 20px;
				}
				.amwan-instructions h2 {
					font-size: 18px;
					font-weight: 700;
				}
				.amwan_setup tr {
					display: block;
				}
				.amwan-setup input{
					width: 100%;
				}
				.amwan-setup textarea {
					height: 100px;
				}
				.amwan-instructions ul {
					position: relative;
					list-style: none;
					margin-left: 15px;
					padding-left: 15px;
				}
				.amwan-instructions li::before {
					content: '▶';
					position: absolute;
					left: 0;
				}
				.instruction-columns {
					display: flex;
					outline: 1px solid black;
					position: relative;
					min-height: 200px;
				}
				.instructions-text {
					margin: 0 20px;
				}
				.btn-instructions {
					margin-right: 40px;
					text-align: center;
					position: relative;
					z-index: 400;
					background: #fff;
					border: solid;
					border-radius: 10px;
				}
				.image-holder {
					width: 150px;
					height: 130px;
				}
				.instructions-image,
				.instructions-image img {
					width: 150px;
				}
				img {
					position: absolute;
					width: 130px;
					right: 10px;
					top: 50%;
    				transform: translateY(-50%);
					border: 1px solid black;
					z-index: 200; 
					transition: width 1s, right 1s, top 1s, z-index 1s;
				}
				img.expand {
					width: 80vw!important;
					right: 150px;
					top: 350px;
					border: 2px solid black;
					z-index: 50000; 
				}
			</style>
			<script>
				 var expandButton1 = document.querySelector('.first-instruction-image img');
				var expandButton2 = document.querySelector('.second-instruction-image img');
				var expandButton3 = document.querySelector('.third-instruction-image img');
				var expandButton4 = document.querySelector('.fourth-instruction-image img');
				expandButton1.addEventListener("click", () => {
					contractOthers(x='first-instruction-image');
					expand(x='first-instruction-image');
				})
				expandButton1.addEventListener("keyup", function(event) {
					event.preventDefault();
					if (event.keyCode === 13) {
						contractOthers(x='first-instruction-image');
						expand(x='first-instruction-image');
					}
				})
				expandButton2.addEventListener("click", () => {
					contractOthers(x='second-instruction-image');
					expand(x='second-instruction-image');
				})
				expandButton2.addEventListener("keyup", function(event) {
					event.preventDefault();
					if (event.keyCode === 13) {
						contractOthers(x='second-instruction-image');
						expand(x='second-instruction-image');
					}
				})
				expandButton3.addEventListener("click", () => {
					contractOthers(x='third-instruction-image');
					expand(x='third-instruction-image');
				})
				expandButton3.addEventListener("keyup", function(event) {
					event.preventDefault();
					if (event.keyCode === 13) {
						contractOthers(x='third-instruction-image');
						expand(x='third-instruction-image');
					}
				})
				expandButton4.addEventListener("click", () => {
					contractOthers(x='fourth-instruction-image');
					expand(x='fourth-instruction-image');
				})
				expandButton4.addEventListener("keyup", function(event) {
					event.preventDefault();
					if (event.keyCode === 13) {
						contractOthers(x='fourth-instruction-image');
						expand(x='fourth-instruction-image');
					}
				})
				function contractOthers(x) {
					var expanded = document.querySelectorAll(".expand:not(#"+x+")");
					expanded.forEach(element=>{
						element.classList.remove("expand");
					});
				}
				function expand(x) {
					var lightbox = document.getElementById(x);
					lightbox.classList.toggle("expand");
				}
			</script>
		</form>
		<?php
} 
?>