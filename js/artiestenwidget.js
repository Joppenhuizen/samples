jQuery(document).ready(function($) {

    $('.artiest-list-item:first').addClass('selected');
    var imgClass = ($('#artiest-widget-img').width() / $('#artiest-widget-img').height() > 1) ? 'wide' : 'tall';
    $('#artiest-widget-img').removeClass('wide tall');
    $('#artiest-widget-img').addClass(imgClass);

    $('.artiesten-list-nav .next').click(function() {
        var select = $('.artiest-list-item.selected').prev();
        changeimg(select);
    });
    $('.artiesten-list-nav .prev').click(function() {
        var select = $('.artiest-list-item.selected').next();
        changeimg(select);
    });

    $('.artiesten-zoeken-letter').click(function() {
    	var item = $('.artiest-list-item[data-letter="' + $(this).text() + '"]');
        if (item.length > 0) {
            scroll(item.first());
            $('.artiesten-zoeken-letter.active').removeClass('active');
            $(this).addClass('active');
            $('.artiest-list-item').removeClass('selected');
            item.first().addClass('selected')
        }
    });
    function changeimg(select)
    {
        if (select.length > 0) {
            $('.artiest-list-item').removeClass('selected');
            select.addClass('selected');
            scroll(select);
            var nextletter = select.data('letter');
            $('.artiesten-zoeken-letter.active').removeClass('active');
            $('.artiesten-zoeken-letter:contains("'+nextletter+'")').addClass('active')
        }
    }

    function scroll(element) {
    	var img = $('#artiest-widget-img');
        img.attr('src', element.data('image'));
        img.attr('alt', element.data('alt'));
        var imgClass = (img.width() / img.height() > 1) ? 'wide' : 'tall';
        img.removeClass('wide tall');
        img.addClass(imgClass);
        var top = element.first().position().top;
        currentScroll = $('.artiesten-list').scrollTop();
        $('.artiesten-list').animate({
            scrollTop: currentScroll + top
        }, 200)
    }
})