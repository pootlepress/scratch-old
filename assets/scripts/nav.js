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
        })
    });

})(jQuery);
