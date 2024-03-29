<?php

if ( ! class_exists( 'Scratch_Font_Control' ) && class_exists( 'WP_Customize_Control' ) ) :
	class Scratch_Font_Control extends WP_Customize_Control {

        public $option_name;
        public $type = 'font';

        public $default;
		/**
		 * Constructor.
		 *
		 * If $args['settings'] is not defined, use the $id as the setting ID.
		 *
		 * @since 3.4.0
		 * @uses WP_Customize_Upload_Control::__construct()
		 *
		 * @param WP_Customize_Manager $manager
		 * @param string $id
		 * @param array $args
		 */
		public function __construct( $manager, $id, $args = array() ) {

            $this->default = $args['defaults'];

			parent::__construct( $manager, $id, $args );

		}


        public function enqueue() {

            wp_enqueue_script( 'wp-color-picker' );

//            wp_enqueue_script('wp-customize-base', site_url() . '/wp-includes/js/customize-base.js', array('jquery'));
//            wp_enqueue_script('wp-customize-controls', site_url() . '/wp-admin/js/customize-controls.js', array('jquery'));
            // load in footer, so will appear after WP customize-base.js and customize-controls.js
            wp_enqueue_script('scratch-customize-controls', get_template_directory_uri() . '/assets/scripts/customize-controls.js', array('jquery'), false, true);


            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_style('scratch-customize-controls', get_template_directory_uri() . '/assets/styles/customize-controls.css');

            parent::enqueue();
        }

		/**
		 * Get Style Controls
		 *
		 * Controls:
		 *     - Font Family
		 *     - Font Weight
		 *     - Text Decoration
		 *     - Text Transform
		 *     - Display
		 *
		 * @since 1.2
		 * @version 1.3.1
		 *
		 */
		public function get_style_controls() {
//			$this->get_subset_control();
			$this->get_font_family_control();
			$this->get_font_weight_control();
//			$this->get_text_decoration_control();
//			$this->get_text_transform_control();
//			$this->get_hidden_style_controls();
		}

		/**
		 * Get Appearance Controls
		 *
		 * Controls:
		 *     - Font Color
		 *     - Background Color
		 *     - Font Size
		 *     - Line Height
		 *     - Letter Spacing
		 *
		 * @since 1.2
		 * @version 1.3.1
		 *
		 */
		public function get_appearance_controls() {
			$this->get_font_color_control();
//			$this->get_background_color_control();
			$this->get_font_size_control();
//			$this->get_line_height_control();
//			$this->get_letter_spacing_control();
		}


		/**
		 * Get Font Family Control
		 *
		 * Gets the font family select control. Will only show
		 * the fonts from the applicable subset if it has been
		 * selected.
		 *
		 * @uses EGF_Font_Utilities::get_google_fonts() 	defined in includes\class-egf-font-utilities
		 * @uses EGF_Font_Utilities::get_default_fonts() 	defined in includes\class-egf-font-utilities
		 *
		 * @since 1.2
		 * @version 1.3.1
		 * 
		 */
		public function get_font_family_control() {
			
			// Get defaults and current value
			$this_value      = $this->value('font_id');
			$default_value   = $this->default['font_id'];
			$current_value   = empty( $this_value ) ? '' : $this_value;

			// Get all font families
			$default_fonts = Scratch_Font_Utility::get_default_fonts();
	
			// Get control view
            ?>
            <label><?php _e( 'Font Family', 'scratch' ); ?>
            <select class='sc-font-family-list' <?php $this->link('font_id') ?> data-default-value="<?php echo $default_value ?>" autocomplete="off">
                <option value="" <?php selected( $current_value, ''); ?> ><?php _e( '&mdash; Theme Default &mdash;', 'scratch' ); ?></option>

                <?php foreach ( $default_fonts as $id => $properties ) : ?>
                    <option value="<?php echo $id; ?>" data-font-type="default" <?php selected( $current_value, $id ); ?>><?php echo $properties['name']; ?></option>
                <?php endforeach; ?>
            </select>
            </label>
            <?php
		}

		/**
		 * Get Font Weight Control
		 *
		 * Gets the font family select control. Preselects the 
		 * appropriate font weight if is has been selected.
		 *
		 * @uses EGF_Font_Utilities::get_font() 	defined in includes\class-egf-font-utilities
		 *
		 * @since 1.2
		 * @version 1.3.1
		 * 
		 */
		public function get_font_weight_control() {
			// Get values
			$this_value                = $this->value('font_weight_style');
			$font_id                   = $this->value('font_id');
            $font_id                   = empty($font_id) ? '' : $font_id;
            if ($font_id !== '') {
                $font                      = Scratch_Font_Utility::get_font( $font_id );
            } else {
                $font = null;
            }

			$default_font_weight_style = $this->default['font_weight_style'];
			$font_weight_style         = empty( $this_value) ? '' : $this_value;

            // Get control view
            ?>

            <label><?php _e( 'Font Weight/Style', 'scratch' ); ?>
            <select class="sc-font-weight-style-list" <?php $this->link('font_weight_style') ?> data-default-value="<?php echo $default_font_weight_style; ?>">
                <?php if ( $font ) : ?>
                    <option value="" <?php selected($font_weight_style, '') ?> ><?php _e( '&mdash; Theme Default &mdash;', 'scratch' ); ?></option>

                    <?php foreach ( $font['font_weights'] as $key => $value ) : ?>
                        <?php
                        $default_font_weight = '';

                        // Set font style and weight
                        $style_data = 'normal';
                        $weight     = 500;

                        if ( strpos( $value, 'italic' ) !== false ) {
                            $style_data = 'italic';
                        }

                        if ( $value !== 'regular' && $value !== 'italic' ) {
                            $weight = (int) substr( $value, 0, 3 );
                        }
                        ?>
                        <option value="<?php echo $value ?>" <?php selected($font_weight_style, $value) ?> data-stylesheet-url="<?php echo $font['urls'][ $value ] ?>" data-font-weight="<?php echo $weight; ?>" data-font-style="<?php echo $style_data; ?>">
                            <?php echo $value; ?>
                        </option>
                    <?php endforeach; ?>
                <?php else : ?>
                    <option value="" <?php selected($font_weight_style, '') ?> ><?php _e( '&mdash; Theme Default &mdash;', 'scratch' ); ?></option>
                    <option value="500">500</option>
                    <option value="500italic">500italic</option>
                <?php endif; ?>
            </select>
            </label>
            <?php
		}

		/**
		 * Get Hidden Style Controls
		 *
		 * Outputs a set of hidden text inputs used to control
		 * and store the following:
		 *
		 *     - Stylesheet URL
		 *     - Font Weight
		 *     - Font Style
		 *     - Font Name
		 *
		 * @since 1.2
		 * @version 1.3.1
		 * 
		 */
		public function get_hidden_style_controls() {

			// Get defaults and current value
			$this_value    = $this->value();
			
			// Get default values
			$default_stylesheet_url = $this->default['stylesheet_url'];
			$default_font_weight    = $this->default['font_weight'];
			$default_font_style     = $this->default['font_style'];
			$default_font_name      = $this->default['font_name'];

			// Get current values
			$current_stylesheet_url = isset( $this_value['stylesheet_url'] ) ? $this_value['stylesheet_url'] : $default_stylesheet_url;
			$current_font_weight    = isset( $this_value['font_weight'] )    ? $this_value['font_weight']    : $default_font_weight;
			$current_font_style     = isset( $this_value['font_style'] )     ? $this_value['font_style']     : $default_font_style;
			$current_font_name      = isset( $this_value['font_name'] )      ? $this_value['font_name']      : $default_font_name;

			// Get control view
			?>
            <input autocomplete="off" class="tt-font-stylesheet-url" type="hidden" data-default-value="<?php echo $default_stylesheet_url; ?>" value="<?php echo $current_stylesheet_url; ?>" >
            <input autocomplete="off" class="tt-font-weight-val" type="hidden" data-default-value="<?php echo $default_font_weight; ?>" value="<?php echo $current_font_weight; ?>" >
            <input autocomplete="off" class="tt-font-style-val" type="hidden" data-default-value="<?php echo $default_font_style; ?>" value="<?php echo $current_font_style; ?>" >
            <input autocomplete="off" class="tt-font-name-val" type="hidden" data-default-value="<?php echo $default_font_name; ?>" value="<?php echo $current_font_name; ?>" >
            <?php
		}

		/**
		 * Get Font Color Control
		 *
		 * Gets the font color input control.
		 *
		 * @since 1.2
		 * @version 1.3.1
		 * 
		 */
		public function get_font_color_control() {
			// Variables used in view
			$value         = $this->value('font_color');
			$default_color = $this->default['font_color'];
			$current_color = isset( $value ) ? $value : $default_color;

			// Get control view
			?>
            <label><?php _e( 'Font Color', 'scratch' ); ?>
                <input class="color-picker-hex sc-font-color-text-box" type="text" maxlength="7" placeholder="<?php esc_attr_e( 'Hex Value' ); ?>"
                       value="<?php echo $current_color; ?>" data-default-color="<?php echo $default_color ?>"
                    <?php $this->link('font_color') ?>
                    />
            </label>

            <?php
		}

		/**
		 * Get Font Size Control
		 *
		 * Gets the font size slider input control.
		 *
		 * @since 1.2
		 * @version 1.3.1
		 * 
		 */
		public function get_font_size_control() {

			// Variables used in view
			$value          = $this->value('font_size');
			$step           = 1;//$this->font_properties['font_size_step'];
			$min_range      = 10;//$this->font_properties['font_size_min_range'];
			$max_range      = 100;//$this->font_properties['font_size_max_range'];
			$default_amount = $this->default['font_size'];
			$default_unit   = 'px';//$this->defaults['font_size']['unit'];
			
			$current_amount = isset( $value ) ? $value : $default_amount;
			$current_unit   = $default_unit;
			
			// Get control view
			?>
            <label><?php _e( 'Font Size', 'scratch' ); ?>

                <input class='sc-font-size-number' type="number" min="<?php echo $min_range ?>"
                       max="<?php echo $max_range ?>" step="<?php echo $step ?>" value="<?php echo $current_amount ?>"
                       default="<?php echo $default_amount ?>"
                       <?php $this->link('font_size') ?>
                    />
                px

            </label>

            <?php
		}


		/**
		 * Get Hidden Control Input
		 *
		 * This hidden input is used to store all of the
		 * settings that belong to this current font
		 * control.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/wp_parse_args 	wp_parse_args()
		 * 
		 * @since 1.2
		 * @version 1.3.1
		 * 
		 */
		public function get_hidden_control_input() {
			$value = wp_parse_args( $this->value(), $this->default );
			?>
			<input type="hidden" id="<?php echo $this->id; ?>-settings" name="<?php echo $this->id; ?>" value="<?php $this->value(); ?>" data-customize-setting-link="<?php echo $this->option_name; ?>"/>
			<?php
		}

		/**
		 * Render Control Content
		 *
		 * Renders the control in the WordPress Customizer.
		 * Each section of the control has been split up
		 * in functions in order to make them easier to
		 * manage and update.
		 * 
		 * @since 1.2
		 * @version 1.3.1
		 * 
		 */
		public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <div class="customize-control-content">

                    <?php $this->get_font_family_control(); ?>

                    <div class="separator"></div>

                    <?php $this->get_font_weight_control(); ?>

                    <div class="separator"></div>

                    <?php $this->get_font_color_control(); ?>

                    <div class="separator"></div>

                    <?php $this->get_font_size_control(); ?>

<!--                    <input type="hidden" class="sc-font-value" value="--><?php //esc_attr_e($this->value()) ?><!--" --><?php //$this->link(); ?><!-- />-->
                </div>
            </label>
            <?php
		}
	}
endif;