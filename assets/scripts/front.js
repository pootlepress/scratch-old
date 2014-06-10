(function ($) {

    $(document).ready(function () {

        var imageUrl = $('body').css('background-image');

        if (typeof imageUrl != 'undefined' && imageUrl != null && imageUrl != '') {

            imageUrl = imageUrl.match(/^url\("?(.+?)"?\)$/);

            if (imageUrl[1]) {
                imageUrl = imageUrl[1];

                var $image = $("<img id='temp-bg-image'/>");
                $image.hide();
                $('body').prepend($image);

                imagesLoaded("#temp-bg-image", function () {
                    var imageWidth = $('#temp-bg-image').get()[0].width;
                    var imageHeight = $('#temp-bg-image').get()[0].height;

                    $('#temp-bg-image').remove();

                    function resizeBgImage() {
                        var windowWidth = window.innerWidth;

                        if (imageWidth > windowWidth) {
                            var imageNewHeight = windowWidth / imageWidth * imageHeight;
                            $('body').css('background-size', windowWidth + "px " + imageNewHeight + "px");
                        }
                    }

                    $(window).resize(function () {
                        resizeBgImage();
                    });

                   resizeBgImage();
                });

                $image.attr('src', imageUrl);
            }
        }


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
