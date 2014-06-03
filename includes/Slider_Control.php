<?php
if ( ! class_exists( 'Scratch_Slider_Control' ) && class_exists( 'WP_Customize_Control' ) ) :
    class Scratch_Slider_Control extends WP_Customize_Control {

        public $type = 'slider';

        private $min = 0;
        private $max = 100;
        private $step = 1;
        private $unit = '';

        public function __construct( $manager, $id, $args = array() ) {

            $this->min = $args['min'];
            $this->max = $args['max'];
            $this->step = $args['step'];
            $this->unit = $args['unit'];

            parent::__construct( $manager, $id, $args );
        }

        protected function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <input class="slider" type="range"
                       min="<?php esc_attr_e($this->min) ?>"
                       max="<?php esc_attr_e($this->max) ?>"
                       step="<?php esc_attr_e($this->step) ?>"
                       value="<?php esc_attr_e( $this->value() ); ?>" <?php $this->link(); ?> />
                <span class="current-value-text" unit="<?php esc_attr_e($this->unit) ?>" ><?php esc_html_e($this->value() . $this->unit) ?></span>
<!--                <input class='reset-default-button' default-value="--><?php //esc_attr_e($this->setting->default) ?><!--" type="button" value="Default" />-->
            </label>
        <?php
        }


    }
endif;