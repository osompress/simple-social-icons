// Common function to do the trick and our jQuery action
function color_picker_load() {
    var number = 1 + Math.floor( Math.random() * 5000000 );
    jQuery( this ).html( 'Color Picker' + number );
}

// Our jQuery
jQuery( document ).ready( function( $ ) {
    jQuery('.color-picker').wpColorPicker();
});

// Load jquery on save
jQuery( document ).ajaxComplete( function( event, XMLHttpRequest, ajaxOptions ) {
    var request = {}, pairs = ajaxOptions.data.split('&'), i, split, widget;
    for( i in pairs ) {
        split = pairs[i].split( '=' );
        request[decodeURIComponent( split[0] )] = decodeURIComponent( split[1] );
    }

    if( request.action && ( request.action === 'save-widget' ) ) {
        widget = jQuery('input.widget-id[value="' + request['widget-id'] + '"]').parents('.widget');
        if( !XMLHttpRequest.responseText ) 
            wpWidgets.save(widget, 0, 1, 0);
        else
            jQuery('.color-picker').wpColorPicker();
    }
});