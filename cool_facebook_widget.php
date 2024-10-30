<?php
/*
Plugin Name: Cool Facebook Widget
Plugin URI: http://www.dollaa.com
Description: Facebook Like Box enables you to display the facebook page likes when you scroll to bottom in your website.
Version: 1.1.2
Author: Son Pham
Author URI: http://www.ituts.org
License: GPL2
*/

add_action('admin_init', 'cfblb_enq_scripts');
add_action('wp_enqueue_scripts', 'cfblb_enq_scripts');
add_action( 'widgets_init', 'cool_widget' );
add_action("admin_menu", "dollaa_facebook_option");
add_action("plugins_loaded", "dollaa_init");
add_shortcode("dollaa_facebook_like_box","dollaa_facebook_like_box_sc");

function cfblb_enq_scripts(){
	if(is_admin()){
		wp_enqueue_script( 'switcher', plugins_url('/jquery.switcher.js', __FILE__), array(), '1.0.0', true );   
		wp_enqueue_style( 'wp-color-picker' );
    	wp_enqueue_script( 'my-script-handle', plugins_url('/admin_script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );   		
		wp_enqueue_style('cfblbcss', plugins_url('/fb.css', __FILE__));	 
	}
	else{
		wp_enqueue_style('cfblbcss', plugins_url('/fb.css', __FILE__));	
	 	wp_enqueue_script( 'cfblbjs', plugins_url('/fb.js', __FILE__), array(), '1.0.0', true );
	    wp_enqueue_script( 'cookie', plugins_url('/cookie.js', __FILE__), array(), '1.0.0', true );        	      
	}
}

// Add settings link on plugin page
function cool_facebook_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=cool-facebook-widget">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'cool_facebook_settings_link' );

//option plugin, get from database
function cfblb_retrieve_options(){
	$opt_val = array(
			'title' => stripslashes(get_option('cfblb_title')),
			'fb_url' => stripslashes(get_option('cfblb_fb_url')),
			'fb_border_color' => stripslashes(get_option('cfblb_fb_border_color')),
			'fb_color' => stripslashes(get_option('cfblb_fb_border_color')),
			'width' => stripslashes(get_option('cfblb_width')),
			'height' => stripslashes(get_option('cfblb_height')),
			'color_scheme' => stripslashes(get_option('cfblb_color_scheme')),
			'show_faces' => stripslashes(get_option('cfblb_show_faces')),
			'stream' => stripslashes(get_option('cfblb_stream')),
			'iframeborder' => stripslashes(get_option('cfblb_iframeborder')),
			'header' => stripslashes(get_option('cfblb_header')),
			'position' => stripslashes(get_option('cfblb_position')),			
			'positionfloat' => stripslashes(get_option('cfblb_positionfloat')),
			'cookie' => stripslashes(get_option('cfblb_cookie')),
			'disable_popup' => stripslashes(get_option('cfblb_disable_popup')),
			'showtitle' => stripslashes(get_option('cfblb_showtitle')),
			'tobottom' => stripslashes(get_option('cfblb_tobottom')),
	); 
	return $opt_val;
}

function dollaa_facebook_option(){
	
	add_options_page(
		__('Cool Facebook'), 
		__('Cool Facebook'), 
		'manage_options', 
		'cool-facebook-widget', 
		'dollaa_fb_like_options_page',
		plugin_dir_url(__FILE__).'images/fbflat.png');       
}

function dollaa_fb_like_options_page(){
	$cfblb_options = array(
			'cfb_title' => 'cfblb_title',
			'cfb_fb_url' => 'cfblb_fb_url',
			'cfb_fb_border_color' => 'cfblb_fb_border_color',
			'cfb_width' => 'cfblb_width',
			'cfb_height' => 'cfblb_height',
			'cfb_color_scheme' => 'cfblb_color_scheme',
			'cfb_show_faces' => 'cfblb_show_faces',
			'cfb_stream' => 'cfblb_stream',
			'cfb_iframeborder' => 'cfblb_iframeborder',
			'cfb_header' => 'cfblb_header',
			'cfb_position' => 'cfblb_position',
			'cfb_positionfloat' => 'cfblb_positionfloat',						
			'cfb_cookie' => 'cfblb_cookie',		
			'cfb_disable_popup' => 'cfblb_disable_popup',	
			'cfb_showtitle' => 'cfblb_showtitle',	
			'cfb_tobottom' => 'cfblb_tobottom',	
						
	);	
	if(isset($_POST['frm_submit'])){			
		if(!empty($_POST['frm_title'])) update_option($cfblb_options['cfb_title'], $_POST['frm_title']);
		if(!empty($_POST['frm_url'])) update_option($cfblb_options['cfb_fb_url'], $_POST['frm_url']);
		if(!empty($_POST['frm_border_color'])) update_option($cfblb_options['cfb_fb_border_color'], $_POST['frm_border_color']);
		if(!empty($_POST['frm_width'])) update_option($cfblb_options['cfb_width'], $_POST['frm_width']);
		if(!empty($_POST['frm_height'])) update_option($cfblb_options['cfb_height'], $_POST['frm_height']);
		if(!empty($_POST['frm_color_scheme'])) update_option($cfblb_options['cfb_color_scheme'], $_POST['frm_color_scheme']);
		if(!empty($_POST['frm_show_faces'])) update_option($cfblb_options['cfb_show_faces'], $_POST['frm_show_faces']);
		if(!empty($_POST['frm_stream'])) update_option($cfblb_options['cfb_stream'], $_POST['frm_stream']);
		if(!empty($_POST['frm_iframeborder'])) update_option($cfblb_options['cfb_iframeborder'], $_POST['frm_iframeborder']);
		if(!empty($_POST['frm_header'])) update_option($cfblb_options['cfb_header'], $_POST['frm_header']);
		if(!empty($_POST['frm_position'])) update_option($cfblb_options['cfb_position'], $_POST['frm_position']);		
		if(!empty($_POST['frm_positionfloat'])) update_option($cfblb_options['cfb_positionfloat'], $_POST['frm_positionfloat']);		
		if(!empty($_POST['frm_cookie'])) update_option($cfblb_options['cfb_cookie'], $_POST['frm_cookie']);		
		if(!empty($_POST['frm_disable_popup'])) update_option($cfblb_options['cfb_disable_popup'], $_POST['frm_disable_popup']);
		if(!empty($_POST['frm_showtitle'])) update_option($cfblb_options['cfb_showtitle'], $_POST['frm_showtitle']);
		if(!empty($_POST['frm_tobottom'])) update_option($cfblb_options['cfb_tobottom'], $_POST['frm_tobottom']);
?>
		<div id="message" class="updated fade"><p><strong><?php _e('Options saved.', 'facebooklikebox' ); ?></strong></p></div>
<?php	
	}
	$option_value = cfblb_retrieve_options();		
?>
	<div class="wrap">
		<div class="block-setting">
		<h2><?php echo __("Cool Facebook Options", "facebooklikebox");?></h2><br />		
			<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
			<table>
				<tr><td><h3 class="cool-face-setting-title"><?php _e('Facebook Settings', 'facebooklikebox');?></h3></td><td></td></tr>
				<tr height="40">
					<td width="150"><b><?php _e('Title', 'facebooklikebox');?>:</b></td>
					<td>
						<input type="text" name="frm_title" size="50" value="<?php if($option_value["title"] == '') echo 'Cool Facebook Widget'; else echo  $option_value['title'];?>"/>
					</td>
				</tr>
	        	<tr height="40">
					<td width="150"><b><?php _e('Facebook Page URL:', 'facebooklikebox');?></b></td>
					<td>
						<input type="text" name="frm_url" size="50" value="<?php if($option_value["fb_url"] == '') echo 'https://www.facebook.com/pages/Dollaa/532584886838339?fref=ts'; else echo  $option_value['fb_url'];?>"/>
					</td>
				</tr>
				<tr height="40">
					<td width="150"><b><?php _e('Width', 'facebooklikebox');?>:</b></td>
					<td>
						<input type="text" name="frm_width" value="<?php echo $option_value['width'];?>"/>px 
					</td>
				</tr>
				<tr height="40">
					<td width="150"><b><?php _e('Height', 'facebooklikebox');?>:</b></td>
	                <td>
	                	<input type="text" name="frm_height" value="<?php echo $option_value['height'];?>"/>px 
	        		</td>
				</tr>	
				<tr height="40">
					<td width="150"><b><?php _e('Show Title', 'facebooklikebox');?>:</b></td>
					<td>				
						<input type="checkbox" id="chk_showtitle"  value="1" <?php if($option_value['showtitle']=='true') echo 'checked' ?> name="frm_showtitle_1" class="toggle-button">					
						<input type="hidden" name="frm_showtitle" id="hidden_frm_showtitle_1" />
						<em style="margin-right:100px;">If turn on this option, header facebook box will turn off auto.</em>
					</td>
				</tr>           
				<tr height="40">
					<td width="150"><b><?php _e('Show Faces', 'facebooklikebox');?>:</b></td>
					<td>				
						<input type="checkbox" id="chk_face"  value="1" <?php if($option_value['show_faces']=='true') echo 'checked' ?> name="frm_show_faces_1" class="toggle-button">					
						<input type="hidden" name="frm_show_faces" id="hidden_frm_show_faces_1" />
					</td>
				</tr>
				<tr height="40">
					<td width="150"><b><?php _e('Stream', 'facebooklikebox');?>:</b></td>
					<td>					
						<input type="checkbox" id="chk_stream"  value="1" <?php if($option_value['stream']=='true') echo 'checked' ?> name="frm_stream_1" class="toggle-button">					
						<input type="hidden" name="frm_stream" id="hidden_frm_stream_1" />
					</td>
					</td>
				</tr>
				<tr height="40">
					<td width="168"><b><?php _e('Header', 'facebooklikebox');?></b></td>
					<td>					
						<input type="checkbox" id="chk_header"  value="1" <?php if($option_value['header']=='true') echo 'checked' ?> name="frm_header_1" class="toggle-button">					
						<input type="hidden" name="frm_header" id="hidden_frm_header_1" />
						</td>
					</td>
				</tr>
				<tr height="40">
					<td width="150"><b><?php _e('Border Iframe Display', 'facebooklikebox');?>:</b></td>
					<td>					
						<input type="checkbox" id="chk_iframeborder"  value="1" <?php if($option_value['iframeborder']=='true') echo 'checked' ?> name="frm_iframeborder_1" class="toggle-button">					
						<input type="hidden" name="frm_iframeborder" id="hidden_frm_iframeborder_1" />
					</td>
					</td>
				</tr>
				<tr height="40">
					<td width="150"><b><?php _e("Border Color", 'facebooklikebox');?>:</b></td>
					<td><input type="text" id="border-color-fb" name="frm_border_color" value="<?php echo $option_value['fb_border_color'];?>"/>
							</td>
				</tr>
	            <tr><td><h3 class="cool-face-setting-title"><?php _e('Display Settings', 'facebooklikebox');?></h3></td><td></td></tr>
	             <tr height="40">
					<td width="168"><b><?php _e('Disable Facebook Popup', 'facebooklikebox');?></b></td>
					<td>					
						<input type="checkbox" id="chk_popup"  value="1" <?php if($option_value['disable_popup']=='true') echo 'checked' ?> name="frm_disable_popup" class="toggle-button">					
						<em style="margin-right:60px">When turn on this option, popup when scroll to bottom will hidden</em>
						<input type="hidden" name="frm_disable_popup" id="hidden_frm_disable_popup" />
						</td>
					</td>
				</tr>	
				<tr height="40">
					<td width="150"><b><?php _e('Distance to the bottom', 'facebooklikebox');?>:</b></td>
					<td>
						<input type="text" name="frm_tobottom" value="<?php if($option_value['tobottom'] == '') echo "0"; else echo $option_value['tobottom'];?>"/>px 
					</td>
				</tr>	
	            <tr height="40">
					<td width="168"><b><?php _e('Position Display', 'facebooklikebox');?></b></td>
					<td>					
						<input type="checkbox" id="chk_position"  value="1" <?php if($option_value['position']=='true') echo 'checked' ?> name="frm_position_1" class="position-button">					
						<input type="hidden" name="frm_position" id="hidden_frm_position_1" />
						</td>
					</td>
				</tr>				
				<tr height="40">
					<td width="168"><b><?php _e('Cookie Close Display', 'facebooklikebox');?></b></td>
					<td>					
						<input type="checkbox" id="chk_cookie"  value="1" <?php if($option_value['cookie']=='true') echo 'checked' ?> name="frm_cookie_1" class="toggle-button">					
						<em style="margin-right:25px;">If turn on this option, when user hide facebook box, it'll never show again.</em>
						<input type="hidden" name="frm_cookie" id="hidden_frm_cookie_1" />
						</td>
					</td>
				</tr>						
				<tr height="60"><td></td><td><input type="submit" name="frm_submit" value="<?php _e('Save', 'facebooklikebox');?>" style="background-color:#CCCCCC;font-weight:bold;"/></td>
				</tr>
			</table>
			</form>
		</div><!-- setting block -->
		<div class="pay-block">
			<div>
				<h3>Freelancer Web Development</h3>				
				<!--div class="pls-support">Please support this plugin's development so more features and capabilities can be added!</div>
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
					">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form-->
				<div>					
					Hi there, I'm available on freelance.<br/>					
					Please check out my profile:  <a target="_blank" href="http://sondoha.elance.com" title="Elance profile">sondoha.elance.com</a> <br/><br/>
					I will not charge for your money until you are satisfied. I like your 100% satisfaction.<br/><br/>

					
					Skype: <a href="skype:sondoha?chat" title="skype">sondoha</a> | <a href="mailto:sondoha@dollaa.com?Subject=" target="_blank">sondoha@dollaa.com</a><br/>
				</div>
			</div>
		</div>
		<div class="feature-plugin">
			<!--iframe src="http://dollaa.com/iframe-to-plugins" width="100%" height="100%" /-->
			<iframe src="http://dollaa.com/iframe-to-plugins" frameborder="0" width="100%"></iframe>
		</div>
	</div>
<?php
}
function dollaa_facebook_like_box_sc($atts){
    ob_start();
    $option_value = cfblb_retrieve_options();
    $option_value['fb_url'] = str_replace(":", "%3A", $option_value['fb_url']);
    $option_value['fb_url'] = str_replace("/", "%2F", $option_value['fb_url']);
    
    if(isset($atts['width']) && !empty($atts['width'])) $option_value['width'] = $atts['width'];
    if(isset($atts['height']) && !empty($atts['height'])) $option_value['height'] = $atts['height'];    
    $position 	= ('true' == $option_value['position']) ? 'left' : 'right';
    $p 			= $option_value['width'] + 50;     
    $showTitle 	= $option_value['showtitle'];


    ?>
    <div id="facebook-like-box" style="<?php echo $position?>:-<?php echo $p?>px;width:<?php echo $option_value['width']?>px;height:<?php echo $option_value['height']?>px">
    	<?php if($showTitle == 'true'): $option_value['header'] = 'false';?>
    		<div class="cool-facebook-title">
    			<div class="cool-title"><?php echo $option_value['title']?></div>
    			<div id="close-box"><a>Hide</a>
    		</div>	    
    		</div>
    	<?php else: ?>
	    <div id="close-box"><a>Hide</a></div>	    
	<?php endif; ?>
	    <iframe 
	    src="//www.facebook.com/plugins/likebox.php?href=<?php echo $option_value['fb_url'];?>&amp;
	    width=<?php echo $option_value['width'];?>&amp;
	    height=<?php echo $option_value['height'];?>&amp;
	    colorscheme=<?php $option_value['color_scheme'];?>&amp;
	    show_faces=<?php echo $option_value['show_faces'];?>&amp;
	    stream=<?php echo $option_value['stream'];?>&amp;
	    header=<?php echo $option_value['header'];?>&amp;
	   "
	    scrolling="no" 
	    frameborder="0" 
	    style="<?php if($option_value['iframeborder'] == "true"):?>border:1px solid <?php echo $option_value['fb_border_color'];?> <?php endif;?>; overflow:hidden; width:<?php echo $option_value['width'];?>px; height:<?php echo $option_value['height'];?>px;" allowTransparency="true">
	    </iframe>
	</div>	
	<script type="text/javascript">
		function setCookie(){        
		    var c_value = "closed";   
		   document.cookie = "close=" + c_value;
		}
		jQuery(document).ready(function(e){        		
		    cl = jQuery.cookie("close");
		    topVal = '<?php echo $option_value["tobottom"]?>'; 
		    <?php 
		    	$option_value = cfblb_retrieve_options();
		    	$cookie_option = $option_value['cookie'];		    	
		     ?>
		   var cookieOpt = '<?php  echo $cookie_option ?>';

		   if((cl !='closed' && cookieOpt != 'true') || (cl == 'closed' && cookieOpt != 'true') ) {   
		        jQuery(window).scroll(function () {            
		            if (jQuery(window).height() + jQuery(window).scrollTop() >= jQuery(document).height()-topVal) {
		            jQuery("#facebook-like-box").addClass("face-active");
		            }
		            else {
		            jQuery("#facebook-like-box").removeClass("face-active");
		            }
		        });
		    }

		    jQuery("#close-box").click(function(){
		        jQuery("#facebook-like-box").removeClass("face-active");

		        setCookie();
		    });
		})
	</script>
	<?php 	
		if($position == 'right'):			

	?>
	<style type="text/css">
		#facebook-like-box {	
			right: <?php echo $p;?>px;
		}
		.face-active {
			right: 0 !important;
		}
		.cool-title {
			float: right;
			padding-left: 10px;
		}
		#close-box {
			padding-left: 0!important;			
			float: left!important;
		}
		.cool-facebook-title {
			padding-left: 0!important
		}
		.uiHeaderTitle {
			text-align: center;
		}
		</style>
<?php else:?>
	<style type="text/css">
		#facebook-like-box {	
			left: -<?php echo $p?>px;
		}
		.face-active {
			left: 0 !important;
		}
		#close-box {			
			top: 3px;
		}
		#close-box a {
			float: right;
		}
	</style>
<?php endif;?>
	
<?php
    $output_string = ob_get_contents();
    ob_end_clean();
    return $output_string;
}
function insert_facebook_floating() {
	$html = '';
	$html .=do_shortcode('[dollaa_facebook_like_box]');
	//check if disable on, not show popup
	$option_value = cfblb_retrieve_options();
	if($option_value['disable_popup'] == 'false'){
		echo $html;
	}
}

add_action('wp_footer', 'insert_facebook_floating', 100);

/*Add Widget */

//create widget
class MY_Widget extends WP_Widget {

	function MY_Widget() {
		$widget_ops = array( 'classname' => 'coolfacebook', 'description' => __('A widget that displays facebook like box ', 'coolfacebook') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'cool-face-widget' );
		
		$this->WP_Widget( 'cool-face-widget', __('Cool Facebook Widget', 'coolfacebook'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		//Our variables from the widget settings.
		$option_value = cfblb_retrieve_options();
		//$title = apply_filters('widget_title', $instance['title'] );
		$title = $instance['title'];
		$width = $instance['width'];
		$height = $instance['height'];
		$header = $instance['show_header'];
		$stream = $instance['show_stream'];
		$face = $instance['show_face'];

		$stream = isset( $instance['show_stream'] ) ? $instance['show_stream'] : false;
		$face = isset( $instance['show_face'] ) ? $instance['show_face'] : false;
		$header = isset( $instance['show_header'] ) ? $instance['show_header'] : false;		
		echo $before_widget;
		echo $before_title . $title . $after_title;
		?>	
		<div style="overflow: hidden;background: #FFF">	
		<iframe 
	src="//www.facebook.com/plugins/likebox.php?href=<?php echo $option_value['fb_url'];?>&amp;width=<?php echo $width;?>&amp;height=<?php echo $height;?>&amp;colorscheme=<?php echo $option_value['color_scheme'];?>&amp;show_faces=<?php echo true;?>&amp;stream=<?php echo $stream;?>&amp;header=<?php echo $header;?>&amp;border_color=%23<?php echo $option_value['fb_border_color'];?>" 
        scrolling="no" frameborder="0" style="border:0px solid <?php echo $option_value['fb_border_color'];?>; overflow:hidden; width:<?php echo $width;?>px; height:<?php echo $height;?>px;" allowTransparency="true">
		</iframe>
		</div>

		<?php		
		echo $after_widget;
	}
	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );		
		$instance['width'] = strip_tags( $new_instance['width'] );		
		$instance['height'] = strip_tags( $new_instance['height']);		

		$instance['show_header'] = $new_instance['show_header'];
		$instance['show_face'] = $new_instance['show_face'];
		$instance['show_stream'] = $new_instance['show_stream'];

		return $instance;
	}

	function form( $instance ) {
		//Set up some default widget settings.

		$option_value = cfblb_retrieve_options();

		$defaults = array( 'width' => __($option_value['width'], 'df'), 'height' => __($option_value['height'], 'df'), 'title' => __('Cool Facebook Widget', 'df'), 'show_face' => true);
		$instance = wp_parse_args( (array) $instance, $defaults );		
		 ?>	
		 <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'df'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>	
		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e('Width:', 'df'); ?></label>
			<input id="<?php echo $this->get_field_id( 'with' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo $instance['width']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Height:', 'df'); ?></label>
			<input id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $instance['height']; ?>" style="width:100%;" />
		</p>							
	<?php
	}
}
function cool_widget() {
	register_widget( 'MY_Widget' );
}
function dollaa_init(){	
	wp_register_sidebar_widget('Cool Facebook Widget', __('Cool Facebook Widget'), 'my_widget');
}

?>
