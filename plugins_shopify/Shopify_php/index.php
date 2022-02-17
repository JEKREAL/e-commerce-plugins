<?php

include_once('inc/functions.php');

$token = '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';
$shop = 'feeltrify'; 
$script_name = 'shopify.js';

$language = isset($_POST['languages']) ? $_POST['languages'] : ''; 
$location = isset($_POST['locations']) ? $_POST['locations'] : '';  
$location_anch = isset($_POST['anch_locations']) ? $_POST['anch_locations'] : '';
$layout = isset($_POST['layout']) ? $_POST['layout'] : '';
$anch_layout = isset($_POST['anch_layout']) ? $_POST['anch_layout'] : '';
$type = isset($_POST['types']) ? $_POST['types'] : '';
$template = isset($_POST['templates']) ? $_POST['templates'] : '';
$show = isset($_POST['show']) ? $_POST['show'] : '';
$params=1;
$please_choose = _('Please Choose');

$script_array = array(
	'script_tag' => array(
		'event' => 'onload', 
		'src' => 'https://feeltrify.000webhostapp.com/scripts/' . $script_name . '?location1=' . $location . '&location2=' . $location_anch . '&show=' . $show . '&layout=' . $layout . '&anch_layout=' . $anch_layout . '&type1=' .  $type . '&template1=' . $template . '&language1=' . $language
	)
);

$scriptTag = shopify_call($token, $shop, '/admin/api/2021-07/script_tags.json', $script_array, 'GET'); 
$scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT); 

if ($scriptTag['script_tags']) {
    $url_components = parse_url(end($scriptTag['script_tags'])['src']);
    parse_str($url_components['query'], $params);
    $location =  $params['location1'];
    $location_anch = $params['location2'];
    $type = $params['type1'];
    $template = $params['template1'];
    }

$locations_arr = array($please_choose,'.product','.header','.share-button','.product__title');
$anch_locations_arr =  array($please_choose,'.product','.header','.share-button','.product__title');
$locations_names_arr = array($please_choose,'Product','Header','Share-button','Product title');
$anch_locations_names_arr = array($please_choose,'Product','Header','Share-button','Product title');

$types_arr = array(
    $please_choose => array(),
	_('Carusel') => array('TemplateCar1','TemplateCar2', 'TemplateCar3'),
	_('Pop-up') => array('TemplatePop1','TemplatePop2', 'TemplatePop3'),
	_('Social-Wall') => array('TemplateSoc1','TemplateSoc2','TemplateSoc3') 
);

$languages_arr = array('eng', 'fr_FR', 'ru_RU');
$languages_names_arr = array('English', 'French', 'Russian');

$language ? $locale = $language : $locale = $params['language1'];
if (defined('LC_MESSAGES')) {
        setlocale(LC_ALL, $locale); // Linux
        bind_textdomain_codeset('messages', 'UTF-8');
        bindtextdomain('messages', './locale');
} else {
        putenv('LC_ALL={$locale}'); // windows
        bindtextdomain('messages', '.\locale');
       }
textdomain('messages');

if (isset($_POST['submit']) || isset($_POST['submit1'])){

    if (!isset($_POST['layout'])) unset($params['layout']);
    if (!isset($_POST['anch_layout'])) unset($params['anch_layout']);
    if (!isset($_POST['show'])) unset($params['show']);
    if (!isset($_POST['template1'])) unset($params['template1']);
    if (!isset($_POST['language1'])) unset($params['language1']);
    
    if(!empty($_POST['show'])) {
        if(!strpos(end($scriptTag['script_tags'])['src'],$script_name)){
        $scriptTag = shopify_call($token, $shop, '/admin/api/2021-07/script_tags.json', $script_array, 'POST');
        }
                $tags = $scriptTag['script_tags'];
                $end = end($tags);
                if (!empty($end) && isset($end['id'])) {
                $endid = $end['id'];
                $scriptTag = shopify_call($token, $shop, '/admin/api/2021-07/script_tags/' .$endid . '.json',$script_array, 'PUT');
                }
    }
    elseif (empty($_POST['show']) && strpos(end($scriptTag['script_tags'])['src'],$script_name))
    {
        foreach ($scriptTag as $script) {
            foreach ($script as $key => $value) {
                if (!isset($scriptTag['script_tags']) && strpos($script['src'],$script_name)) continue;
                $tags = $scriptTag['script_tags'];
                $end = end($tags);
                if (!empty($end) && isset($end['id'])) {
                $endid = $end['id'];
                $scriptTag = shopify_call($token, $shop, '/admin/api/2021-07/script_tags/' .$endid . '.json',$script_array, 'PUT');
                }
  }
        }  
    }
};

$scriptTag = shopify_call($token, $shop, '/admin/api/2021-07/script_tags.json', $script_array, 'GET');
$scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Widget settings</title>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    
    <style type='text/css'>  
        <?php include 'css/settings.css';
        ?>
    </style>
   
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css'>
     <style>  
     .switch-toggle input[type='checkbox'] + label::before {
        content: '<?php echo _('OFF'); ?>';
     }
     .switch-toggle input[type='checkbox']:checked + label::before {
        content: '<?php echo _('ON'); ?>';
     }
     .switch-toggle2 input[type='checkbox'] + label::before {
        content: '<?php echo _('BEFORE'); ?>';
     }
     .switch-toggle2 input[type='checkbox']:checked + label::before {
        content: '<?php echo _('AFTER'); ?>';
     }
    </style>
   
  <link rel='stylesheet' href='//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
  <script src='https://code.jquery.com/jquery-1.12.4.js'></script>
  <script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>
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
    $( '#languages' )
      .iconselectmenu( {
      icons: { button: ' ui-icon-blank' }
})
      .iconselectmenu( 'menuWidget' )
        .addClass( 'ui-menu-icons customicons' );
  });
  
   //function below making dropdown list with icons appear on hover and changing default flag dinamicly
    $(function() {
  $(document).on('mouseover', '#languages-button,#languages-menu', function ( ) {
      $( '#languages' ).iconselectmenu('open');
       if ($('#languages-button').text()==='English'){
        $('.ui-selectmenu-text').prop('style','background-image: url( img/united-states_38.png);');
    }
    else if ($('#languages-button').text()==='French'){
        $('.ui-selectmenu-text').prop('style','background-image: url( img/france_38.png);');
    }
    else if ($('#languages-button').text()==='Russian'){
        $('.ui-selectmenu-text').prop('style','background-image: url( img/russia_38.png);');
    }
  }).on('mouseout', '#languages-button,#languages-menu', function ( ) {
      $( '#languages' ).iconselectmenu('close');
       if ($('#languages-button').text()==='English'){
        $('.ui-selectmenu-text').prop('style','background-image: url( img/united-states_38.png);');
    }
    else if ($('#languages-button').text()==='French'){
        $('.ui-selectmenu-text').prop('style','background-image: url( img/france_38.png);');
    }
    else if ($('#languages-button').text()==='Russian'){
        $('.ui-selectmenu-text').prop('style','background-image: url( img/russia_38.png);');
    }
  });
});
  //function below changing flag to required on mouse click and on page loading
  $(document).ready(function(){
      if ($('#languages-button').text()==='English'){
        $('.ui-selectmenu-text').prop('style','background-image: url( img/united-states_38.png);');
    }
    else if ($('#languages-button').text()==='French'){
        $('.ui-selectmenu-text').prop('style','background-image: url( img/france_38.png);');
    }
    else if ($('#languages-button').text()==='Russian'){
        $('.ui-selectmenu-text').prop('style','background-image: url( img/russia_38.png);');
    }
  $('#languages-menu').click(function(){
    if ($('#languages-button').text()==='English'){
        $('.ui-selectmenu-text').prop('style','background-image: url( img/united-states_38.png);');
    }
    else if ($('#languages-button').text()==='French'){
        $('.ui-selectmenu-text').prop('style','background-image: url( img/france_38.png);');
    }
    else if ($('#languages-button').text()==='Russian'){
        $('.ui-selectmenu-text').prop('style','background-image: url( img/russia_38.png);');
    }
  });
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
    .ui-icon.eng {
      background: url('img/united-states.png') 0 0 no-repeat;
    }
    .ui-icon.fr_FR {
      background: url('img/france.png') 0 0 no-repeat;
    }
    .ui-icon.ru_RU {
      background: url('img/russia.png') 0 0 no-repeat;
    }
    #languages-button {
        width:5px;
        border:none;
        background-color: white;
        margin-left:-15px;
    }

    .ui-selectmenu-text {
        height: 38px;  
        width: 38px;
        /* Hide the text. */
        text-indent: 100%;
        white-space: nowrap;
        overflow: hidden;
    }
  </style>
</head>

<body>
   
    <form method='post' action='#' id='myForm' >
        <div id='info_header'>
        <select  name='languages' id='languages'>
                        <?php foreach ($languages_arr as $index=>$lang) {
					                      if ($lang === $_POST['languages'] || $lang === $params['language1']){
					                         $params['language1'] =  $lang;
					                         $selected =  'selected="selected"';
					                      }else{
					                          $selected = '';
					                       }
					  echo "<option class='$lang' data-class='$lang' value='$lang' $selected>$languages_names_arr[$index]</option>";
                               }
			?>
        </select>
         <div class='dropdown' >
        <button id='help'>?</button>
                <div id='main1bannerbottom' >
                <div class='bannerbottom1'> <span ><?php echo _('If you have questions regarding our plugin or API, our support is here to help.'); ?></span>
        <span ><a href='mailto:info@example.com' target='_blank'><strong>support@feelter.com</strong></a></span></div>
    </div>
</div>
</div>
        <h2 class='gradient-text'><?php echo _('Feelter Widget Settings'); ?></h2>
        <!-- Setting ON/OFF parameters -->
        <div class='wrap'>
            <div class='show_switch-holder' id='show_switch-holder'>
                <div class='show_switch-label'>
                   <span><?php echo _('Show Widget'); ?></span>
                </div>
                <div class='switch-toggle'>
                    <input type='checkbox' id='show' name='show' value='1' <?php echo 
                         (isset($_POST['show']) ||  (isset($params['show']) &&
                                (!empty($params['show']))))? 'checked=1' : '' ; ?>>
                    <label for='show'
                        title='<?php echo _("This toggle hiding or showing all plugin functionality on the page") ?>'></label>
                </div>
        </div>
   
            <!-- Setting ON/OFF parameters -->
            <!-- Setting parameters for location and layout of the widget, for types and templates  -->
            <div class='wrap1'>
                <div class='switch-holder1' id='switch-holder1'>
                    <div class='switch-label1'>
                        <span><?php echo _('Choose location'); ?></span>
                    </div>
                    <select data-placeholder='Enter location' name='locations' class='switch-toggle'>
                        <?php foreach ($locations_arr as $index=>$locat) {
					                      if ($locat === $_POST['locations'] || $locat === $params['location1']){
					                         $params['location1'] =  $locat;
					                         $selected =  'selected="selected"';
					                      }else{
					                          $selected = '';
					                       }
                               
					  echo "<option class='$locat' value='$locat' $selected>"; echo _($locations_names_arr[$index]); echo '</option>';
                               }
			?>
                    </select>
                    
                        <label class='switch-toggle2'>
                            <input type='checkbox' id='layout' name='layout' value='1' <?php echo
                                (isset($_POST['layout']) || (isset($params['layout']) &&
                                (!empty($params['layout']))))? 'checked=1' : '' ; ?> >
                            <label for='layout'
                                title='<?php echo _('This toggle determins the widget layout(before or after the element on the page') ?>'></label>
                        </label>
                   
                    <br /><br />
                    <div class='switch-label1'>
                        <span><?php echo _('Choose anchor location'); ?></span>
                    </div>
                    <select data-placeholder='Enter anchor location' name='anch_locations' class='switch-toggle'>
                        <?php foreach ($anch_locations_arr as $index=>$anch_locat) {
					                      if ($anch_locat === $_POST['anch_locations'] || $anch_locat === $params['location2']){
					                         $params['location2'] =  $anch_locat;
					                         $selected =  'selected="selected"';
					                      }else{
					                          $selected = '';
					                       }
                               
					  echo "<option class='$anch_locat' value='$anch_locat' $selected>"; echo _($anch_locations_names_arr[$index]); echo '</option>';
                               }
			?>
                    </select>
                    
                        <label class='switch-toggle2'>
                            <input type='checkbox' id='anch_layout' name='anch_layout' value='1' <?php echo
                                (isset($_POST['anch_layout']) || (isset($params['anch_layout']) &&
                                (!empty($params['anch_layout']))))? 'checked=1' : '' ; ?> >
                            <label for='anch_layout'
                                title="<?php echo _('This toggle determins the widget layout(before or after the element on the page') ?>"></label>
                        </label>
                    
                    <br /><br />
                    <div class='switch-label1'>
                        <span><?php echo _('Choose widget type'); ?></span>
                    </div>
                    <select data-placeholder='Enter widget type' name='types' class='switch-toggle' id='types'>
                        <?php foreach ($types_arr as $type_name=>$value) {
					                      if ($type_name === $_POST['types'] || $type_name === $params['type1'] ){
					                         $params['type1'] =  $type_name;
					                         $selected =  'selected="selected"';
					                      }else{
					                          $selected = '';
					                       }
					  echo "<option class='$type_name' style='display :$style' value='$type_name' $selected>"; echo _($type_name); echo '</option>';
                               }
			?>
                    </select>
                    <br /><br />
                    <div class='switch-label1'>
                        <span><?php echo _('Choose template'); ?></span>
                    </div>
                    <select data-placeholder='Enter template' name='templates' class='switch-toggle' id='templates'>
                        <option id='choose'><?php echo _($please_choose); ?></option>
                        <?php 
                        foreach ($types_arr as $type_name=>$arr) {
                                    foreach ($arr as $template_name){
					                      if ($template_name === $_POST['templates'] || $template_name === $params['template1'] ){
					                          $params['template1'] =  $template_name;
					                          $selected =  'selected="selected"';
					                      }else{
					                          $selected = '';
					                       }
                                // $style = $selected ? 'block' : 'none';
					  echo "<option class='$type_name' style='display :none' value='$template_name' $selected>$template_name</option>";
                               }
                               }
                    
			?>
                    </select>
                </div>
            </div>
            <br /><br />
            <!-- Setting parameters for location and layout of the widget, for types and templates  -->
            <div id='div_submit'>
                <input type='submit' name='submit' id='my_submit' value='<?php echo _('Update Store'); ?>' onclick='loader();'>
            </div>
            <div id='replace_submit' style='margin-left:150px; display:none;'>
                <img src='img/Spinner-3.gif' alt='loading...'>
            </div>
            <button type='button'  value='reset' onclick='select_default();' id='reset'><?php echo _('Reset Settings'); ?></button>
            
    </form>
    <!-- info box -->
     <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js'></script> 
    <script> // CSS for localizations +
        if ( '<?php echo $locale ?>' === 'fr_FR') {
            document.getElementById('switch-holder1').className = 'switch-holder_FR';
            document.getElementById('show_switch-holder').style.width = '370px';
            document.getElementById('reset').style.marginLeft = '300px';
            document.getElementById('my_submit').style.width = '160px';
            document.getElementById('help').style.marginLeft = '75px';
        }
         if ( '<?php echo $locale ?>' === 'ru_RU') {
            document.getElementById('switch-holder1').className = 'switch-holder_FR';
            document.getElementById('show_switch-holder').style.width = '370px';
            document.getElementById('reset').style.marginLeft = '300px';
            document.getElementById('help').style.marginLeft = '75px';
        }
        // Open dropdown languages on hover
       
       
        
        // Hide/Show buttons and loader
        function loader() {
            let childNodes = document.getElementById('switch-holder1').getElementsByTagName('*');
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
    <script> //This script is connecting types and templates dropdown lists to show templates depends on choosen type
        document.getElementById('types').onchange = function () {
            document.getElementById('choose').selected = 'selected';
            let selector_type = document.getElementById('types');
            let type_value = selector_type[selector_type.selectedIndex].value;
            let nodeList = document.getElementById('templates').querySelectorAll('option');
            nodeList.forEach(function (option) {
                if (option.classList.contains(type_value)) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
            
        }
    </script>
    <script>
            $(document).ready(function() {
                    let typeList = document.getElementById('types').querySelectorAll('option');
                    if (typeList[0].selected) {document.getElementById('choose').selected = 'selected';}
                    let nodeList = document.getElementById('templates').querySelectorAll('option');
                    let selector_type = document.getElementById('types');
                    let type_value = selector_type[selector_type.selectedIndex].value;
                if (type_value === 'Carusel' ) {
                    nodeList[1].style.display='block';
                    nodeList[2].style.display='block';
                    nodeList[3].style.display='block';
               }
                else if (type_value === 'Pop-up' ) {
                    nodeList[4].style.display='block';
                    nodeList[5].style.display='block';
                    nodeList[6].style.display='block';
               }
                else if (type_value === 'Social-Wall' ) {
                    nodeList[7].style.display='block';
                    nodeList[8].style.display='block';
                    nodeList[9].style.display='block';
               };
                });
    </script>
    <script> //This script is disabling all other settings when the widget turned off.
        let childNodes = document.getElementById('switch-holder1').getElementsByTagName('*');
        if (!document.getElementById('show').checked) {
            for (let node of childNodes) {
                node.disabled = true;
            }
        }
    </script>
    <script> //reset button script
          function select_default()  {
				    $.confirm({
				        boxWidth: '30%',
    useBootstrap: false,
    title: '<?php echo _("Reset settings"); ?>',
    content: "<?php echo _('Please confirm settings reset. This will be automatically closed in 10 seconds'); ?>",
    autoClose: 'cancelAction|10000',
    
    buttons: {
        deleteUser: {
            text: "<?php echo _('Apply'); ?>",
            action: function () {
                 $('.Please').prop('selected',true);
				 $('#my_submit').trigger('click');	
            }
        },
        cancelAction: {text: "<?php echo _('Cancel') ?>",
        action:function () {
            $.alert({
             title: false,
             content: "<?php echo _('Action canceled!') ?>",
             boxWidth: '30%',
             useBootstrap: false,
             buttons: { 
                 confirmButton: {text: "<?php echo _('Ok'); ?>",}
             },
});
        }
    }
    }
});
        }
    </script>
</body>

</html>