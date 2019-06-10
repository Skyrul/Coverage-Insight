(function() {
    console.log('customer view loaded');

    window.onload = function() {
        store.set('audio', false);
        store.set('video', false);
    }

    // Events
    $('#vidbtn-audio').on('click', function(e) {
        var s = store.get('audio');
        if (!s) {
            $(this).addClass('vid-btns-selected');
            $(this).find('span').text('Turn-Off Call');
            store.set('audio', true);
        } else {
            $(this).removeClass('vid-btns-selected');
            $(this).find('span').text('Call');
            store.set('audio', false);
        }
    });
    $('#vidbtn-video').on('click', function(e) {
        var s = store.get('video');
        if (!s) {
            $('#videostream').attr('class', 'col-md-11 form');
            $('#customerinfo').attr('class', 'col-md-offset-1 col-md-6 customer-info-bottom');
            $('.stream3').removeClass('hide');
            $(this).addClass('vid-btns-selected');
            $(this).find('span').text('Turn-Off Video');
            store.set('video', true);
        } else {
            $('#videostream').attr('class', 'col-md-6');
            $('#customerinfo').attr('class', 'col-md-4');
            $('.stream3').addClass('hide');
            $(this).removeClass('vid-btns-selected');
            $(this).find('span').text('Video');
            store.set('video', false);
        }
    });    


})();