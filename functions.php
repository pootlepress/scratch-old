<?php

require_once('includes/Customizer.php');
require_once('includes/Nav_Walker.php');
require_once('includes/Font_Control.php');
require_once('includes/Slider_Control.php');
require_once('includes/Header_Image_Control.php');
require_once('includes/Background_Image_Control.php');
require_once('includes/Font_Utility.php');

$customizer = new Customizer();

add_action('wp_enqueue_scripts', 'scratch_main_css');
function scratch_main_css() {
    wp_enqueue_style('scratch-main-css', get_stylesheet_directory_uri() . '/style.css');
}

add_action('wp_enqueue_scripts', 'scratch_scripts');
function scratch_scripts() {
    wp_enqueue_script('scratch-image-loaded', get_stylesheet_directory_uri() . '/assets/scripts/imagesloaded.pkgd.min.js', array('jquery'));
    wp_enqueue_script('scratch-front-script', get_stylesheet_directory_uri() . '/assets/scripts/front.js', array('jquery'));
}


add_action( 'init', 'scratch_register_menu' );
function scratch_register_menu() {
    register_nav_menu('main-menu',__( 'Main Menu', 'scratch' ));
}

function scratch_posted_on() {
    if ( is_sticky() && is_home() && ! is_paged() ) {
        echo '<span class="featured-post">' . __( 'Sticky', 'scratch' ) . '</span>';
    }

    // Set up and print post meta information.
    printf( '<span class="entry-date"><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s">%3$s</time></a></span> <span class="byline"><span class="author vcard"><a class="url fn n" href="%4$s" rel="author">%5$s</a></span></span>',
        esc_url( get_permalink() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() ),
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        get_the_author()
    );
}

function scratch_paging_nav() {
    // Don't print empty markup if there's only one page.
    if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
        return;
    }

    $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
    $pagenum_link = html_entity_decode( get_pagenum_link() );
    $query_args   = array();
    $url_parts    = explode( '?', $pagenum_link );

    if ( isset( $url_parts[1] ) ) {
        wp_parse_str( $url_parts[1], $query_args );
    }

    $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
    $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

    $format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
    $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

    // Set up paginated links.
    $links = paginate_links( array(
        'base'     => $pagenum_link,
        'format'   => $format,
        'total'    => $GLOBALS['wp_query']->max_num_pages,
        'current'  => $paged,
        'mid_size' => 1,
        'add_args' => array_map( 'urlencode', $query_args ),
        'prev_text' => __( '&larr; Previous', 'scratch' ),
        'next_text' => __( 'Next &rarr;', 'scratch' ),
        'type' => 'array'
    ) );

    if ( $links ) :

        $list = '';
        foreach ($links as &$link) {
            if (strpos($link, 'current') !== false) {
                $list .= "<li class='active'>" . $link . "</li>";
            } else {
                $list .= "<li>" . $link . "</li>";
            }

        }

        ?>
        <nav class="navigation paging-navigation" role="navigation">
<!--            <h1 class="screen-reader-text">--><?php //_e( 'Posts navigation', 'scratch' ); ?><!--</h1>-->
            <ul class="pagination loop-pagination">
                <?php echo $list; ?>
            </ul><!-- .pagination -->
        </nav><!-- .navigation -->
    <?php
    endif;
}

// Add support for custom headers.
$custom_header_support = array(
    'width'                  => 0,
    'height'                 => 0,
    'flex-width'             => true,
    'flex-height'            => true,
    // Callback for styling the header.
//    'wp-head-callback' => 'twentyeleven_header_style',
//    // Callback for styling the header preview in the admin.
//    'admin-head-callback' => 'twentyeleven_admin_header_style',
//    // Callback used to display the header preview in the admin.
//    'admin-preview-callback' => 'twentyeleven_admin_header_image',
);

//add_theme_support( 'custom-header', $custom_header_support );

add_theme_support('custom-background');

//add_action('admin_init', 'scratch_remove_theme_header_page');

function scratch_remove_theme_header_page() {
    global $submenu;
    foreach ($submenu as $slug => $menu) {
        if ($slug == 'themes.php') {
            $foundIndex = null;
            foreach ($menu as $index => $page) {
                if ($page[2] == 'custom-header') {
                    $foundIndex = $index;
                    break;
                }
            }

            if ($foundIndex != null) {
                unset($submenu[$slug][$foundIndex]);
            }
        }
    }
}