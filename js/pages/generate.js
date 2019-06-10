$('.btnnewsched').click(function(e) {
    $('.newform').show();
    $(this).hide();
});

$('.btncancel').click(function() {
    $('.newform').hide();
    $('.btnnewsched').show();
});
