<?php
/**
 * Created by Alan on 19/5/2014.
 */

class Customizer {

    private $fontOptions;

    public function __construct() {
        add_action( 'customize_register', array($this, 'register') );
        add_action( 'wp_head', array($this, 'output_css'));

        add_action( 'customize_controls_print_scripts', array($this, 'customizer_js' ));

        $this->fontOptions = array(
            array(
                'id' => 'h1_font',
                'label' => __('Heading 1', 'scratch'),
                'section' => 'font_section',
                'settings' => array(
                    'font_id' => 'h1_font_id',
                    'font_size' => 'h1_font_size',
                    'font_color' => 'h1_font_color',
                    'font_weight_style' => 'h1_font_weight_style'
                ),
                'defaults' => array(
                    'font_id' => "Helvetica",
                    'font_size' => 36,
                    'font_color' => '#333333',
                    'font_weight_style' => '500'
                ),
                'priority' => 10
            ),
            array(
                'id' => 'h2_font',
                'label' => __('Heading 2', 'scratch'),
                'section' => 'font_section',
                'settings' => array(
                    'font_id' => 'h2_font_id',
                    'font_size' => 'h2_font_size',
                    'font_color' => 'h2_font_color',
                    'font_weight_style' => 'h2_font_weight_style'
                ),
                'defaults' => array(
                    'font_id' => "Helvetica",
                    'font_size' => 30,
                    'font_color' => '#333333',
                    'font_weight_style' => '500'
                ),
                'priority' => 20
            ),
            array(
                'id' => 'h3_font',
                'label' => __('Heading 3', 'scratch'),
                'section' => 'font_section',
                'settings' => array(
                    'font_id' => 'h3_font_id',
                    'font_size' => 'h3_font_size',
                    'font_color' => 'h3_font_color',
                    'font_weight_style' => 'h3_font_weight_style'
                ),
                'defaults' => array(
                    'font_id' => "Helvetica",
                    'font_size' => 24,
                    'font_color' => '#333333',
                    'font_weight_style' => '500'
                ),
                'priority' => 30
            ),
            array(
                'id' => 'h4_font',
                'label' => __('Heading 4', 'scratch'),
                'section' => 'font_section',
                'settings' => array(
                    'font_id' => 'h4_font_id',
                    'font_size' => 'h4_font_size',
                    'font_color' => 'h4_font_color',
                    'font_weight_style' => 'h4_font_weight_style'
                ),
                'defaults' => array(
                    'font_id' => "Helvetica",
                    'font_size' => 18,
                    'font_color' => '#333333',
                    'font_weight_style' => '500'
                ),
                'priority' => 40
            ),
            array(
                'id' => 'h5_font',
                'label' => __('Heading 5', 'scratch'),
                'section' => 'font_section',
                'settings' => array(
                    'font_id' => 'h5_font_id',
                    'font_size' => 'h5_font_size',
                    'font_color' => 'h5_font_color',
                    'font_weight_style' => 'h5_font_weight_style'
                ),
                'defaults' => array(
                    'font_id' => "Helvetica",
                    'font_size' => 14,
                    'font_color' => '#333333',
                    'font_weight_style' => '500'
                ),
                'priority' => 50
            ),
            array(
                'id' => 'h6_font',
                'label' => __('Heading 6', 'scratch'),
                'section' => 'font_section',
                'settings' => array(
                    'font_id' => 'h6_font_id',
                    'font_size' => 'h6_font_size',
                    'font_color' => 'h6_font_color',
                    'font_weight_style' => 'h6_font_weight_style'
                ),
                'defaults' => array(
                    'font_id' => "Helvetica",
                    'font_size' => 12,
                    'font_color' => '#333333',
                    'font_weight_style' => '500'
                ),
                'priority' => 60
            ),

            array(
                'id' => 'nav_font',
                'label' => __('Font', 'scratch'),
                'section' => 'nav_section',
                'settings' => array(
                    'font_id' => 'nav_font_id',
                    'font_size' => 'nav_font_size',
                    'font_color' => 'nav_font_color',
                    'font_weight_style' => 'nav_font_weight_style'
                ),
                'defaults' => array(
                    'font_id' => "",
                    'font_size' => 14,
                    'font_color' => '#333333',
                    'font_weight_style' => ''
                )
            )
        );
    }

    public function register(WP_Customize_Manager $customizeManager)
    {
        // settings
        $customizeManager->add_setting('bg_color', array(
            'default' => '#ffffff',
        ));
        $customizeManager->add_setting('page_width', array(
            'default' => 960,
        ));
        $customizeManager->add_setting('page_full_width', array(
           'default' => false
        ));

        $customizeManager->add_setting('nav_bg_color', array(
            'default' => '#f8f8f8',
        ));
        $customizeManager->add_setting('nav_opacity', array(
            'default' => 100,
        ));

        $customizeManager->add_setting('fix_nav_bar_to_top', array(
            'default' => false,
        ));
        $customizeManager->add_setting('nav_align', array(
            'default' => 'left',
        ));
        $customizeManager->add_setting('nav_sub_item_align', array(
            'default' => 'left',
        ));

        $customizeManager->add_setting('a_link_color', array(
            'default' => '#428bca'
        ));


        // sections
        $customizeManager->add_section('global_section', array(
            'title' => __('Global Options', 'scratch'),
            'priority' => 10
        ));
        $customizeManager->add_section('logo_title_section', array(
            'title' => __('Logo / Site Title', 'scratch'),
            'priority' => 20
        ));
        $customizeManager->add_section('nav_section', array(
            'title' => __('Nav Bar', 'scratch'),
            'priority' => 30
        ));
        $customizeManager->add_section('font_section', array(
            'title' => __('Fonts', 'scratch'),
            'priority' => 40
        ));

        // controls
        $customizeManager->add_control(new WP_Customize_Color_Control($customizeManager, 'bg_color', array(
            'label' => __('Page Background Color', 'scratch'),
            'section' => 'global_section',
            'settings' => 'bg_color',
            'priority' => 10
        )));

        $customizeManager->add_control(new Scratch_Slider_Control($customizeManager, 'page_width', array(
            'label' => __('Page Width', 'scratch'),
            'section' => 'global_section',
            'settings' => 'page_width',
            'min' => 768,
            'max' => 1600,
            'step' => 1,
            'unit' => 'px',
            'priority' => 20
        )));

        $customizeManager->add_control('page_full_width', array(
            'label'    => __( 'Set to Full Width', 'scratch'),
            'section'  => 'global_section',
            'settings' => 'page_full_width',
            'type'     => 'checkbox',
            'priority' => 30
        ) );

        //
        // Header Image
        //
        $customizeManager->add_setting( 'background_image', array(
            'default'        => get_theme_support( 'custom-background', 'default-image' ),
            'theme_supports' => 'custom-background',
        ) );

		$customizeManager->add_setting( new WP_Customize_Background_Image_Setting( $customizeManager, 'background_image_thumb', array(
            'theme_supports' => 'custom-background',
        ) ) );

		$customizeManager->add_control( new Scratch_Background_Image_Control( $customizeManager, 'background_image', array(
            'label'    => __( 'Background Image' ),
            'section'  => 'global_section',
            'context'  => 'custom-background',
            'get_url'  => 'get_background_image',
            'priority' => 40
        ) ) );

        //
        // Logo/Site Title
        //

        // move site title control from built in section to Logo / Site Title section
        $titleControl = $customizeManager->get_control('blogname');
        $titleControl->section = 'logo_title_section';
        $titleControl->priority = 10;

        $customizeManager->remove_section('title_tagline');

        $customizeManager->add_setting('logo_image', array(
            'default' => '',
        ));
        $customizeManager->add_control(new WP_Customize_Image_Control($customizeManager, 'logo_image', array(
            'label' => __('Logo', 'scratch'),
            'section' => 'logo_title_section',
            'priority' => 20
        )));

        //
        // Nav Bar
        //
        $customizeManager->add_control(new WP_Customize_Color_Control($customizeManager, 'nav_bg_color', array(
            'label' => __('Nav Bar Background Color', 'scratch'),
            'section' => 'nav_section',
            'settings' => 'nav_bg_color'
        )));

        $customizeManager->add_control(new Scratch_Slider_Control($customizeManager, 'nav_opacity', array(
            'label' => __('Nav Bar Opacity', 'scratch'),
            'section' => 'nav_section',
            'settings' => 'nav_opacity',
            'min' => 0,
            'max' => 100,
            'step' => 1,
            'unit' => '%'
        )));

        $customizeManager->add_control('fix_nav_bar_to_top', array(
            'label'    => __( 'Fix Nav Bar to Top', 'scratch'),
            'section'  => 'nav_section',
            'settings' => 'fix_nav_bar_to_top',
            'type'     => 'checkbox'
        ) );

        $customizeManager->add_control( 'nav_align', array(
            'label'   => __('Align Nav Bar', 'scratch'),
            'section' => 'nav_section',
            'type'    => 'select',
            'choices' => array(
                'left' => __('Left', 'scratch'),
                'center' => __('Middle', 'scratch'),
                'right' => __('Right', 'scratch'),
            )
        ));

        $customizeManager->add_control( 'nav_sub_item_align', array(
            'label'   => __('Align Nav Sub Menu Items', 'scratch'),
            'section' => 'nav_section',
            'type'    => 'select',
            'choices' => array(
                'left' => __('Left', 'scratch'),
                'center' => __('Middle', 'scratch'),
                'right' => __('Right', 'scratch'),
            )
        ));

        // add fonts

        foreach ($this->fontOptions as $fontOption) {
            foreach ($fontOption['settings'] as $key => $settingID) {
                $defaultValue = $fontOption['defaults'][$key];
                $customizeManager->add_setting($settingID, array(
                    'default' => $defaultValue
                ));
            }

            $customizeManager->add_control(new Scratch_Font_Control($customizeManager, $fontOption['id'], $fontOption));
        }

        $customizeManager->add_control(new WP_Customize_Color_Control($customizeManager, 'a_link_color', array(
            'label' => __('Link Color', 'scratch'),
            'section' => 'font_section',
            'settings' => 'a_link_color',
            'priority' => 100
        )));

        $customizeManager->remove_section('background_image');
    }

    public function customizer_js() {
        $fonts = Scratch_Font_Utility::get_default_fonts();
        $fontsJson = json_encode($fonts);
        echo "<script>var SCFontControlFonts = $fontsJson ;</script>";
    }

    private function get_font_css($element, $fontOption) {
        $fontFamily = get_theme_mod($element . '_font_id');
        if (empty($fontFamily)) {
            $fontFamily = $fontOption['defaults']['font_id'];
        }

        $fontSize = get_theme_mod($element . '_font_size');
        $fontColor = get_theme_mod($element . '_font_color');
        $fontWeightStyle = get_theme_mod($element . '_font_weight_style');
        if (empty($fontWeightStyle)) {
            $fontWeightStyle = $fontOption['defaults']['font_weight_style'];
        }

        $fontStyle = (strpos($fontWeightStyle, 'italic') === false ? 'normal' : 'italic');
        $fontWeight = str_replace('italic', '', $fontWeightStyle);

        $result = "$element {\n";
        $result .= "\t" . 'font-family: "' . $fontFamily . "\";\n";
        $result .= "\t" . 'font-size: ' . $fontSize . "px;\n";
        $result .= "\t" . 'color: ' . $fontColor . ";\n";
        $result .= "\t" . 'font-style: ' . $fontStyle . ";\n";
        $result .= "\t" . 'font-weight: ' . $fontWeight . ";\n";
        $result .= "}\n";

        return $result;
    }

    private function get_font_css_value($element, $fontOption) {
        $fontFamily = get_theme_mod($element . '_font_id');
        if (empty($fontFamily)) {
            $fontFamily = $fontOption['defaults']['font_id'];
        }

        $fontSize = get_theme_mod($element . '_font_size');
        $fontColor = get_theme_mod($element . '_font_color');
        $fontWeightStyle = get_theme_mod($element . '_font_weight_style');
        if (empty($fontWeightStyle)) {
            $fontWeightStyle = $fontOption['defaults']['font_weight_style'];
        }

        $fontStyle = (strpos($fontWeightStyle, 'italic') === false ? 'normal' : 'italic');
        $fontWeight = str_replace('italic', '', $fontWeightStyle);

        $result = array(
            'font-family' => '"' . $fontFamily . '"',
            'font-size' => $fontSize . 'px',
            'color' => $fontColor,
            'font-style' => $fontStyle,
            'font-weight' => $fontWeight
        );

        return $result;
    }


    public function output_css() {

        $css = '';

        $bodyCss = "body { \n";
        $bodyCss .= "\t" . 'background-color: ' . get_theme_mod('bg_color') . ";\n";
        if (get_theme_mod('fix_nav_bar_to_top')) {
            $bodyCss .= "\t" . 'padding-top: 51px;' . "\n";
        }
        $bodyCss .= "}\n";

        $isFullWidth = get_theme_mod('page_full_width');
        if ($isFullWidth) {
            $pageCss = ".block {\n";
            $pageCss .= "\t" . 'width: 100%;' . "\n";
            $pageCss .= "}\n";
        } else {
            $pageCss = ".block {\n";
            $pageCss .= "\t" . 'width: ' . get_theme_mod('page_width') . 'px;' . "\n";
            $pageCss .= "\t" . 'margin-left: auto; margin-right: auto;' . "\n";
            $pageCss .= "}\n";
        }

        //
        // Nav
        //
        $navBgColor = get_theme_mod('nav_bg_color');

        $navR = substr($navBgColor, 1, 2);
        $navR = (int)hexdec($navR);
        $navG = substr($navBgColor, 3, 2);
        $navG = (int)hexdec($navG);
        $navB = substr($navBgColor, 5, 2);
        $navB = (int)hexdec($navB);

        $navOpacityPercent = (int)get_theme_mod('nav_opacity');
        $navOpacityFloat = $navOpacityPercent / 100;

        $navBgRGBA = "rgba($navR, $navG, $navB, $navOpacityFloat)";

        $navCss = '';
        $navCss .= "#navigation {\n";
        $navCss .= "\t" . 'background-color: ' . $navBgRGBA . "; background-image: none; \n";
        $navCss .= "}\n";

        $navAlign = get_theme_mod('nav_align');
        $navCss .= "#navigation .navbar-collapse {\n";
        $navCss .= "\t" . 'text-align: ' . $navAlign . "; \n";
        $navCss .= "}\n";

        $navFont = $this->get_font_css_value('nav', $this->fontOptions[6]);
        $navFontCss = '';
        $navFontCss .= "#navigation .navbar-nav > li > a, #navigation .logo-title .title {\n";
        foreach ($navFont as $key => $value) {
            if (!empty($value)) {
                $navFontCss .= "\t" . $key . ': ' . $value . ";\n";
            }
        }
        $navFontCss .= "}\n";

        //
        // Heading
        //
        $h1Css = $this->get_font_css('h1', $this->fontOptions[0]);
        $h2Css = $this->get_font_css('h2', $this->fontOptions[1]);
        $h3Css = $this->get_font_css('h3', $this->fontOptions[2]);
        $h4Css = $this->get_font_css('h4', $this->fontOptions[3]);
        $h5Css = $this->get_font_css('h5', $this->fontOptions[4]);
        $h6Css = $this->get_font_css('h6', $this->fontOptions[5]);

        $linkCss = '';
        $linkColor = get_theme_mod('a_link_color');
        if ($linkColor != '') {
            $linkCss .= 'a { color: ' . $linkColor . ";}\n";
        }

        $css .= $bodyCss;
        $css .= $pageCss;
        $css .= $navCss;
        $css .= $navFontCss;
        $css .= $h1Css;
        $css .= $h2Css;
        $css .= $h3Css;
        $css .= $h4Css;
        $css .= $h5Css;
        $css .= $h6Css;
        $css .= $linkCss;

        ?>
        <style>
            <?php echo $css ?>
        </style>
    <?php
    }
} 