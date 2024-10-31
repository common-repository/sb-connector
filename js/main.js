( function( $ ) {
    var client = new ZeroClipboard( $(".zclip") );

    client.on( 'ready', function(event) {
        // console.log( 'movie is loaded' );

        client.on( 'copy', function(event) {
            var element_to_copy, clipboard_value;

            if ( $(event.target).data('method') == 'direct')
                element_to_copy = $($(event.target).data('target'));
            else if ($(event.target).data('method') == 'closest') {
                if (typeof $(event.target).data('parent') != 'undefined' && $(event.target).data('parent') != '')
                    element_to_copy = $(event.target).closest($(event.target).data('parent')).find($(event.target).data('target'));
                else
                    element_to_copy = $(event.target).closest($(event.target).data('target'));
            }

            if ($(event.target).data('copyType') == 'value')
                clipboard_value = $(element_to_copy).val();
            else if ($(event.target).data('copyType') == 'html')
                clipboard_value = $(element_to_copy).html();

            event.clipboardData.setData("text/plain", clipboard_value);
        } );

        client.on( 'aftercopy', function(event) {
            //console.log('Copied text to clipboard: ' + event.data['text/plain']);
        } );
    } );

    client.on( 'error', function(event) {
        // console.log( 'ZeroClipboard error of type "' + event.name + '": ' + event.message );
        ZeroClipboard.destroy();
    } );
} ) ( jQuery );