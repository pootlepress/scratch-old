
(function( exports, $ ){
    var api = wp.customize;

    api.FontControl = api.Control.extend({
        ready: function() {
            var control = this,
                picker = this.container.find('.color-picker-hex');

            picker.val( control.settings['font_color']()).wpColorPicker({
                change: function() {
                    control.settings['font_color'].set( picker.wpColorPicker('color') );
                },
                clear: function() {
                    control.settings['font_color'].set( false );
                }
            });
        }
    });

    api.controlConstructor['font'] = api.FontControl;

    $(document).ready(function () {
        $('#customize-controls .customize-control-slider').each(function () {
            var $control = $(this);
            var $currentValueText = $control.find('.current-value-text');
            $control.find('.slider').change(function () {
                $currentValueText.text($(this).val() + $currentValueText.attr('unit'));
            });
            $control.find('.slider').bind('input', function () {
                $currentValueText.text($(this).val() + $currentValueText.attr('unit'));
            });
        });
    });

//    $(document).ready(function () {
//        $("#customize-controls .customize-control-font").each(function () {
//            var $control = $(this);
//
//            populateFontWeightStyleOptions($control);
//
//            $control.find('.sc-font-family-list').change(function () {
//                populateFontWeightStyleOptions($control);
//            });
//
//        });
//    });

    function populateFontWeightStyleOptions($control) {
        if (typeof SCFontControlFonts != 'undefined' && SCFontControlFonts != null) {

            var fontID = $control.find('.sc-font-family-list').val();

            if (typeof SCFontControlFonts[fontID] != 'undefined') {
                var fontStyleWeights = SCFontControlFonts[fontID]['font_weights'];

                var options = [];

                for (var i in fontStyleWeights) {
                    var styleWeight = fontStyleWeights[i];

                    var style = 'normal';
                    var fontWeight = '500';

                    if (styleWeight != 'regular' && styleWeight != 'italic') {
                        fontWeight = style.substr(0, 3);
                    }

                    if (styleWeight.indexOf('italic') >= 0) {
                        style = 'italic';
                    }

                    var $option = $('<option></option>');
                    $option.attr('value', styleWeight);
                    $option.text(styleWeight);
                    $option.attr('data-font-weight', fontWeight);
                    $option.attr('data-font-style', style);

                    options.push($option);
                }

                $control.find('.sc-font-weight-style-list').empty();
                $control.find('.sc-font-weight-style-list').append("<option value=''>— Theme Default —</option>");

                for (var i in options) {
                    $control.find('.sc-font-weight-style-list').append(options[i]);
                }


            }
        }
    }

    function setHiddenField($fontControl) {
        var fontFamily = $fontControl.find('.sc-font-family-list').val();
        var fontWeightStyle = $fontControl.find('.sc-font-weight-style-list').val();
        var fontColor = $fontControl.find('.sc-font-color-text-box').val();
        var fontSize = $fontControl.find('.sc-font-size-number').val();

        var value = {
            'font_id': fontFamily,
            'font_size': {'amount': fontSize },
            'font_color': fontColor,
            'font_weight_style': fontWeightStyle
        };

        var json = JSON.stringify(value);
        $fontControl.find('.sc-font-value').val(json);
    }

})( wp, jQuery );
