jQuery(document).ready(function($){   
  $('#border-color-fb').wpColorPicker({defaultColor:'#008ffc'});    
      jQuery(".toggle-button").switcher({
            namespace: 'theme-switcher'
    });

    jQuery(".position-button").switcher({
            ontext: 'Left',
            offtext: 'Right',
            namespace: 'theme-switcher'
    });     
 
})