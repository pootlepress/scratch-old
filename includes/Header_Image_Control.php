<?php
/**
 * Created by Alan on 3/6/2014.
 */

if (!class_exists('WP_Customize_Image_Control')) {
    require_once(ABSPATH . 'wp-includes/class-wp-customize-control.php');
}

class Scratch_Header_Image_Control extends WP_Customize_Image_Control {
    public $type = 'header';

    private $width = 0;
    private $height = 0;
    private $flexWidth = false;
    private $flexHeight = false;

    public function __construct( $manager, $id, $args = array() ) {

        $this->width = $args['width'];
        $this->height = $args['height'];
        $this->flexWidth = $args['flex-width'];
        $this->flexHeight = $args['flex-height'];

        parent::__construct( $manager, $id, $args);
    }

    public function to_json() {
        parent::to_json();
    }

    public function enqueue() {
        wp_enqueue_media();
        wp_enqueue_script( 'customize-views' );

        $this->prepare_control();

        wp_localize_script( 'customize-views', '_wpCustomizeHeader', array(
            'data' => array(
                'width' => absint( $this->width ),
                'height' => absint( $this->height ),
                'flex-width' => absint( $this->flexWidth ),
                'flex-height' => absint( $this->flexHeight ),
                'currentImgSrc' => $this->get_current_image_src(),
            ),
            'nonces' => array(
                'add' => wp_create_nonce( 'header-add' ),
                'remove' => wp_create_nonce( 'header-remove' ),
            ),
            'uploads' => $this->uploaded_headers,
            'defaults' => $this->default_headers
        ) );

        parent::enqueue();
    }

    public function prepare_control() {
        global $custom_image_header;
        if ( empty( $custom_image_header ) ) {
            return;
        }

        // Process default headers and uploaded headers.
        $custom_image_header->process_default_headers();
        $this->default_headers = $custom_image_header->get_default_header_images();
        $this->uploaded_headers = $custom_image_header->get_uploaded_header_images();
    }

    function print_header_image_template() {
        ?>
        <script type="text/template" id="tmpl-header-choice">
            <# if (data.random) { #>
                <button type="button" class="button display-options random">
                    <span class="dashicons dashicons-randomize dice"></span>
                    <# if ( data.type === 'uploaded' ) { #>
                        <?php _e( 'Randomize uploaded headers' ); ?>
                        <# } else if ( data.type === 'default' ) { #>
                            <?php _e( 'Randomize suggested headers' ); ?>
                            <# } #>
                </button>

                <# } else { #>

                    <# if (data.type === 'uploaded') { #>
                        <div class="dashicons dashicons-no close"></div>
                        <# } #>

                            <button type="button" class="choice thumbnail"
                                    data-customize-image-value="{{{data.header.url}}}"
                                    data-customize-header-image-data="{{JSON.stringify(data.header)}}">
                                <span class="screen-reader-text"><?php _e( 'Set image' ); ?></span>
                                <img src="{{{data.header.thumbnail_url}}}" alt="{{{data.header.alt_text || data.header.description}}}">
                            </button>

                            <# } #>
        </script>

        <script type="text/template" id="tmpl-header-current">
            <# if (data.choice) { #>
                <# if (data.random) { #>

                    <div class="placeholder">
                        <div class="inner">
					<span><span class="dashicons dashicons-randomize dice"></span>
					<# if ( data.type === 'uploaded' ) { #>
                        <?php _e( 'Randomizing uploaded headers' ); ?>
                        <# } else if ( data.type === 'default' ) { #>
                            <?php _e( 'Randomizing suggested headers' ); ?>
                            <# } #>
					</span>
                        </div>
                    </div>

                    <# } else { #>

                        <img src="{{{data.header.thumbnail_url}}}" alt="{{{data.header.alt_text || data.header.description}}}" tabindex="0"/>

                        <# } #>
                            <# } else { #>

                                <div class="placeholder">
                                    <div class="inner">
					<span>
						<?php _e( 'No image set' ); ?>
					</span>
                                    </div>
                                </div>

                                <# } #>
        </script>
    <?php
    }

    public function get_current_image_src() {
        $src = $this->value();
        if ( isset( $this->get_url ) ) {
            $src = call_user_func( $this->get_url, $src );
            return $src;
        }
        return null;
    }

    public function render_content() {
        $this->print_header_image_template();
        $visibility = $this->get_current_image_src() ? '' : ' style="display:none" ';
        $width = absint( $this->width );
        $height = absint( $this->height );
        ?>


        <div class="customize-control-content">
            <!--<p class="customizer-section-intro">
                <?php
                if ( $width && $height ) {
                    printf( __( 'While you can crop images to your liking after clicking <strong>Add new</strong>, your theme recommends a header size of <strong>%s &times; %s</strong> pixels.' ), $width, $height );
                } elseif ( $width ) {
                    printf( __( 'While you can crop images to your liking after clicking <strong>Add new</strong>, your theme recommends a header width of <strong>%s</strong> pixels.' ), $width );
                } else {
                    printf( __( 'While you can crop images to your liking after clicking <strong>Add new</strong>, your theme recommends a header height of <strong>%s</strong> pixels.' ), $height );
                }
                ?>
            </p>-->
            <div class="current">
				<span class="customize-control-title">
					<?php _e( 'Current header' ); ?>
				</span>
                <div class="container">
                </div>
            </div>
            <div class="actions">
                <?php /* translators: Hide as in hide header image via the Customizer */ ?>
                <button type="button"<?php echo $visibility ?> class="button remove"><?php _ex( 'Hide image', 'custom header' ); ?></button>
                <?php /* translators: New as in add new header image via the Customizer */ ?>
                <button type="button" class="button new"><?php _ex( 'Add new image', 'header image' ); ?></button>
                <div style="clear:both"></div>
            </div>
            <!--
            <div class="choices">
				<span class="customize-control-title header-previously-uploaded">
					<?php _ex( 'Previously uploaded', 'custom headers' ); ?>
				</span>
                <div class="uploaded">
                    <div class="list">
                    </div>
                </div>
				<span class="customize-control-title header-default">
					<?php _ex( 'Suggested', 'custom headers' ); ?>
				</span>
                <div class="default">
                    <div class="list">
                    </div>
                </div>
            </div>-->
        </div>
    <?php
    }
}