<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/evgeniifeelter
 * @since      1.0.0
 *
 * @package    Feelter_wp
 * @subpackage Feelter_wp/admin/partials
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php

//translation
$widget_settings = get_option( 'feelter_wp-settings' );
$lang = $widget_settings['languages'];

include(plugin_dir_path(dirname( __DIR__ )) . 'languages/' . $lang . '.php');

defined('ABSPATH') or exit;

if (!function_exists('wp_remote_retrieve_response_code')) {
	require_once ABSPATH . WPINC . '/http.php';
}

$not_connected = $langArray['Not Connected']; //variables for translation
$connected = '✔️ API ' . $langArray['Connected'];
$please_choose = 'Please Choose';

$nonce = wp_create_nonce('feelter_wp_nonce');
//
$fs_apiKey = get_option('Feelter_wp_api_key');
$fs_domain = get_option('Feelter_wp_domain');
$fs_cid = get_option('Feelter_wp_cid');
$fs_headers_option = get_option('Feelter_wp_headers');
if (empty($fs_headers_option)) $fs_headers_option = 'on';
$Feelter_wp_status = add_option('Feelter_wp_status', $not_connected);
$widget_settings = get_option('feelter_wp-settings');
add_option('prev_toggle_status',false);

if (!empty($fs_apiKey)) {
	$target_url = 'https://self-service.feelter.com/api/public/validate-api-key?key=' . $fs_apiKey;
	$request = wp_remote_get($target_url, array('timeout' => 10, 'redirection' => 0, 'sslverify' => false));

?>
<!--	 <?php var_dump($request); ?> --><?php
										$cid = json_decode(wp_remote_retrieve_body($request))->cid; 
										if ($cid != 2000 || is_wp_error($request) ) {
											$Feelter_wp_status = $not_connected ; // Checking it twice...
										} else {							
											$Feelter_wp_status = $connected ;
										}
									}
										?>
<!-- help button --> 	
		<div id='feelter_wp-admin' class='wrap feelter_wp-settings'>
			<div class='main'>
				<h2 class='gradient-text' ><?php echo $langArray['Feelter Widget Settings'] ?></h2>
			
            <div class='api_switch_holder'>
				<form action='options.php' method='POST' id='Feelter_wp_api_settings'>
					<table class='form-table'>
						<tr valign='top'>
							<th scope='row'><?php 
							echo $langArray['Status'];?></th>
							<td>
								<span class='status' title='<?php echo $langArray["This status showing that you currently connected and authorized on Feelter server"]; ?>' id='Feelter_wp_status'><?php echo $Feelter_wp_status; ?></span>
							</td>
						</tr>
						<tr valign='top'>
							<th scope='row' ><?php echo 'API ' . $langArray['Key'];?></th>
							<td>
								<input type='text' title='<?php echo $langArray["In this section you can get and enter your API key"]; ?>' size=90 placeholder='Your Feelter_wp API key' id='Feelter_wp_api_key' name='Feelter_wp_api_key' value='<?php
																																								if (!empty($fs_apiKey)) echo $fs_apiKey;
																																							?>' />								
								<p style='color:#6e6d7a;'><?php echo $langArray['To reset the connection you can left the field blank and press connect.'];?>
								 
									<a target='_blank' href='https://www.FraudSentinel.com/apikey'><?php echo $langArray['Get your API key here.'];?></a>
								</p>
								<div class='dropdown' id='dropdown' >
        							<button id='help'>?</button>
                						<div id='main1bannerbottom' >
                							<div class='bannerbottom1'> 
												<span ><?php echo $langArray['If you have questions regarding our plugin or API, our support is here to help.']; ?></span>
        										<span ><a href='mailto:info@example.com' target='_blank'><strong>support@feelter.com</strong></a></span>
											</div>
    									</div>																	
									</div>									
							</td>
						</tr>
					</table>	
							<?php
								$other_attributes = array('id' => 'my_submit2');
								submit_button(__($langArray['Connect'], 'textdomain'), 'primary', 'my_submit2', true, $other_attributes); ?>
				</form>		
								</div>
			
						
			<form method='post' action='options.php' id='myForm'>
			<div class='switch-holder1' id='switch-holder1'	>
				<?php
					settings_fields('feelter_wp-settings');
					do_settings_sections( 'feelter_wp-settings' );
					$other_attributes = array('id' => 'my_submit','onclick'=>'loader();');?>	
				<div id='div_submit'>
				<?php		
					submit_button(__($langArray['Update Store'], 'textdomain'), 'primary', 'my_submit', true, $other_attributes); ?>
				</div>
				<div id='replace_submit' style='display:none;'>
                <img src='../wp-content/plugins/feelter_wp/admin/partials/spinner-2.gif' style='width:75px;height:75px; margin-left: 100px;' alt='loading...'>
            </div>
			</div>
			</form>		
				<!-- Scripts below for dropdown list of languages -->
				<link rel='stylesheet' href='//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
  <!-- <link rel='stylesheet' href='/resources/demos/style.css'> -->
  <script src='https://code.jquery.com/jquery-1.12.4.js'></script>
  <script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css'>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js'></script>
	<script>
		 //function below creating dropdown list with icons
  $( function() {
    $.widget( 'custom.iconselectmenu', $.ui.selectmenu, {
      _renderItem: function( ul, item ) {
        var li = $( '<li>' ),
          wrapper = $( '<div>', { text: item.label } );
 
        if ( item.disabled ) {
          li.addClass( 'ui-state-disabled' );
        }
 
        $( '<span>', {
          style: item.element.attr( 'data-style' ),
          'class': 'ui-icon ' + item.element.attr( 'data-class' )
        })
          .appendTo( wrapper );
 
        return li.append( wrapper ).appendTo( ul );
      }
    });
 
    $( '#feelter_wp-settings\\[languages\\]' )
      .iconselectmenu()
      .iconselectmenu( 'menuWidget' )
        .addClass( 'ui-menu-icons customicons' );
  } );
//functions below changing flag to required on mouse click and on page loading
$(function() {
  $(document).on('click', '#feelter_wp-settings\\[languages\\]-button,#feelter_wp-settings\\[languages\\]-menu', function ( ) {
       if ($('#feelter_wp-settings\\[languages\\]-button').text()==='English'){
        $('.ui-selectmenu-text').prop('style','background-image: url( ../wp-content/plugins/feelter_wp/img/united-states.png);');
    }
    else if ($('#feelter_wp-settings\\[languages\\]-button').text()==='French'){
        $('.ui-selectmenu-text').prop('style','background-image: url( ../wp-content/plugins/feelter_wp/img/france.png);');
    }
    else if ($('#feelter_wp-settings\\[languages\\]-button').text()==='Russian'){
        $('.ui-selectmenu-text').prop('style','background-image: url( ../wp-content/plugins/feelter_wp/img/russia.png);');
    }
  })
});
  $(document).ready(function(){
      if ($('#feelter_wp-settings\\[languages\\]-button').text()==='English'){
        $('.ui-selectmenu-text').prop('style','background-image: url( ../wp-content/plugins/feelter_wp/img/united-states.png);');
    }
    else if ($('#feelter_wp-settings\\[languages\\]-button').text()==='French'){
        $('.ui-selectmenu-text').prop('style','background-image: url( ../wp-content/plugins/feelter_wp/img/france.png);');
    }
    else if ($('#feelter_wp-settings\\[languages\\]-button').text()==='Russian'){
        $('.ui-selectmenu-text').prop('style','background-image: url( ../wp-content/plugins/feelter_wp/img/russia.png);');
    }
});

  </script>
  <style> 
    /* select with custom icons */
    .ui-selectmenu-menu .ui-menu.customicons .ui-menu-item-wrapper {
      padding: 0.5em 0 0.5em 2em;
    }
    .ui-selectmenu-menu .ui-menu.customicons .ui-menu-item .ui-icon {
      height: 24px;
      width: 24px;
      top: 0.1em;
    }
    .ui-icon.en_EN {
      background: url('../wp-content/plugins/feelter_wp/img/united-states.png') 0 0 no-repeat;
    }
    .ui-icon.fr_FR {
      background: url('../wp-content/plugins/feelter_wp/img/france.png') 0 0 no-repeat;
    }
    .ui-icon.ru_RU {
      background: url('../wp-content/plugins/feelter_wp/img/russia.png') 0 0 no-repeat;
    }
	#feelter_wp-settings\5Blanguages\5D-button {
        width:60px;
		position: absolute;
		top: 0;
   		left:0;
		border-top:none;
    }
    .ui-selectmenu-text {
        height: 24px;  
        width:  24px;
        /* Hide the text. */
        text-indent: 100%;
        white-space: nowrap;
        overflow: hidden;
	}
	.switch-toggle input[type='checkbox'] + label::before {
        content: '<?php echo $langArray['OFF']; ?>';
     }
    .switch-toggle input[type='checkbox']:checked + label::before {
        content: '<?php echo $langArray['ON']; ?>';
     }	
	 table tr, table td { border: none !important; }
    
  </style>
  <!-- Scripts above for dropdown list of languages -->
  
	<script> // Hide/Show button and loader	+ CSS for localizatons
	if ( '<?php echo $lang ?>' === 'fr_FR') {
            document.getElementById('switch-holder1').style.maxHeight = '490px';
			document.getElementById('my_submit').style.width = '160px';
			document.getElementById('reset').style.width = '160px';
			// document.getElementById('dropdown').style.marginLeft = '187px';
			// document.getElementById('dropdown').style.top = '231px';
        }
	if ( '<?php echo $lang ?>' === 'ru_RU') {
		document.getElementById('reset').style.width = '160px';
		// document.getElementById('dropdown').style.marginLeft = '280px';
		// 	document.getElementById('dropdown').style.top = '231px';
			document.getElementById('switch-holder1').style.maxHeight = '490px';

	}

        function loader() {
			let childNodes = document.getElementById('myForm').getElementsByTagName('*');
             for (let node of childNodes) {
                node.disabled = false;
            }
            document.getElementById('div_submit').style.display = 'none';
            document.getElementById('reset').style.display = 'none';
            document.getElementById('replace_submit').style.display = '';
            return true;
        }
        var firstLoad = true;
        function restoreSubmit() {
            if (firstLoad) {
                firstLoad = false;
                return;
            }
            document.getElementById('div_submit').style.display = '';
            document.getElementById('reset').style.display = '';
            document.getElementById('replace_submit').style.display = 'none';
		}
        // To disable restoring submit button, disable or delete next line.
        document.onfocus = restoreSubmit;
    </script>

	<script type='text/javascript'> //disable values 
			function select_default()  {  //pop-up
				$.confirm({
				        boxWidth: '30%',
    useBootstrap: false,
    title: "<?php echo $langArray['Reset settings']; ?>",
    content: "<?php echo $langArray['Please confirm settings reset. This will be automatically closed in 10 seconds']; ?>",
    autoClose: 'cancelAction|10000',
	
    buttons: {
		
        deleteUser: {
            text: "<?php echo $langArray['Apply'] ?>",
            action: function () {
				 loader();
                 $('.choose').prop('selected',true);	
				 $('#myForm').submit();		
            }
        },
        cancelAction: {text: "<?php echo $langArray['Cancel'] ?>",
		action: function () {
            $.alert({
             title: false,
             content: "<?php echo $langArray['Action canceled!'] ?>",
             boxWidth: '30%',
             useBootstrap: false,
			 buttons: { 
                 confirmButton: {text: "<?php echo $langArray['Ok']; ?>",}
             },
});
        }
		}
    }
});			
			}
			function feelter_wp_fixsubmit(form_id) {
		jQuery(function($) {
			if ($('#Feelter_wp_status').text().includes('✔️')) {
				$('#myForm').show();					
				$('#myForm :input').prop('disabled', false);				
			}
			else {
				$('#myForm :input[type="checkbox"]').prop('checked', false);
				$('#myForm :input').prop('disabled', true);
				$('#reset').prop('disabled', true);
				$('#feelter_wp-settings\\[languages\\]	').prop('disabled', false);						
			};
				$(form_id+' :input[type="submit"]').prop('disabled', true);
				$(form_id+' input[type="text"]').keyup(function() {				
				$(form_id+' :input[type="submit"]').prop('disabled', false);
			});
				$(form_id+' input[type="checkbox"]').click(function(){
				$(form_id+' :input[type="submit"]').prop('disabled', false);
			});
				$(form_id+' select').click(function(){
				$(form_id+' :input[type="submit"]').prop('disabled', false);
			});
			if ($('#myForm :input[type="checkbox"]').prop('checked') ) {		
				$('#myForm select').prop('disabled', false);			
		   }
			   else {
				$('#myForm select').prop('disabled', true);	
				$('#feelter_wp-settings\\[languages\\]').prop('disabled', false);		
		   };				
			});									
	}
	
	// Restricts input for the set of matched elements to the given inputFilter function.
	(function($) {
		$.fn.feelter_wp_inputFilter = function(inputFilter) {
			return this.on('input keydown keyup mousedown mouseup select contextmenu drop', function() {
				if (inputFilter(this.value)) {
					this.oldValue = this.value;
					this.oldSelectionStart = this.selectionStart;
					this.oldSelectionEnd = this.selectionEnd;
				} else if (this.hasOwnProperty('oldValue')) {
					this.value = this.oldValue;
					this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
				} else {
					this.value = '';
				}
			});
		};
	}(jQuery));
	
	jQuery(document).ready(function($) {	
		// Limit inputs in optional text fields 
		$('#Feelter_wp_domain').feelter_wp_inputFilter(function(value) {
			return /^[a-zA-Z0-9_.-]*$/.test(value);
		});
		$('#Feelter_wp_cid').feelter_wp_inputFilter(function(value) {
			return /^[a-zA-Z0-9_.-]*$/.test(value);
		});
	
		feelter_wp_fixsubmit('#Feelter_wp_api_settings');
		$('#fs_headers_option').change(function() {
	
			headers = 'off';	
			if (this.checked) {
				headers = 'on';
				$('#Feelter_wp_domain').prop('disabled', false);
				$('#Feelter_wp_cid').prop('disabled', false);
			} else {
				$('#Feelter_wp_domain').prop('disabled', true);
				$('#Feelter_wp_cid').prop('disabled', true);
			}
	
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: "<?php echo admin_url('admin-ajax.php'); ?>",
				data: {
					action: 'feelter_wp_set',
					headers: headers,
					n: '<?php echo $nonce; ?>'
				}
			});
	
		});
	
		$('#Feelter_wp_api_settings').submit(function(event) {	
			event.preventDefault();	
			apiKey = $('#Feelter_wp_api_key').val();
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: "<?php echo admin_url('admin-ajax.php'); ?>",
				data: {
					action: 'feelter_wp_set',
					apiKey: apiKey,
					n: '<?php echo $nonce; ?>',
					toggleStatus: $('#myForm :input[type="checkbox"]').is(':checked') 
				}
			}).done(function(data) {
				$.each(data, function(key, value) {
					if (key === 'connection') {
						if (value === 'ya') $('#Feelter_wp_status').text('<?php echo $connected ?>');
						else if (value === 'nop') $('#Feelter_wp_status').text('<?php echo $not_connected ?>');
						else $('#Feelter_wp_status').text('');
	
					}else if (key === 'toggle_override'){
						$('#myForm :input[type="checkbox"]').prop('checked', value);
					}
				});
			}).always(function() {
				feelter_wp_fixsubmit('#Feelter_wp_api_settings');
			});	
		});
	
		$('#myForm :input[type="checkbox"]').click(function(event) {		
			$.ajax({
			type: 'post',
			dataType: 'json',
			url: "<?php echo admin_url('admin-ajax.php'); ?>",
			data: {
			action: 'feelter_wp_sync',
			prevToggleStatus: $('#myForm :input[type="checkbox"]').is(':checked') 
	}
		})
		});
	});
	</script>