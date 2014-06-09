(function ($) {

    $(document).ready(function () {
        $('#navigation ul > li').each(function () {

            $(this).hover(function () {
                var $li = $(this);
                $li.find('.sub-menu').show();
            }, function () {
                var $li = $(this);
                $li.find('.sub-menu').hide();
            });
        });

        $('#navigation .logo-title-cell .logo-title.use-title > li > a > .title').each(function () {
            var titleWidth = $(this).width();
            var $cell = $(this).closest('td');
            $cell.width(titleWidth);
        });

        imagesLoaded('#navigation .logo-title-cell > .logo-title.use-logo a > .logo', function () {
            var $logo = $('#navigation .logo-title-cell > .logo-title.use-logo a > .logo');
            var width = $logo.width();
            var height = $logo.height();

            var barHeight = $('#navigation .logo-title-cell').height();

            var $td = $logo.closest('td');
            var logoWidth = width;
            $td.width(logoWidth);

            var offsetTop = height / 2;
            $logo.css('top', -offsetTop);
        });
    });

})(jQuery);
