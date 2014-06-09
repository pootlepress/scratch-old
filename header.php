<!DOCTYPE html>
<html>
<head>
    <title><?php echo wp_title( '|', false, 'right' ) . get_bloginfo( 'name' ); ?></title>
    <?php do_action('wp_head'); ?>
</head>
<body <?php body_class(); ?>>

<div id='page'>

    <div id="header-container">
<!--        <header id='header' class="block page-header">-->
<!---->
<!--        <h1><a href="--><?php //echo home_url() ?><!--">--><?php //echo get_bloginfo('name') ?><!--</a></h1>-->
<!---->
<!--        </header>-->
        <div style="height: 20px"></div>

    </div>

    <?php
    $fixNavToTop = get_theme_mod('fix_nav_bar_to_top');
    if ($fixNavToTop) {
        $fixClass = 'navbar-fixed-top';
    } else {
        $fixClass = '';
    }

    ?>
    <nav id="navigation" class="block navbar navbar-default <?php echo $fixClass ?>" role="navigation">

        <table>
            <tr>
                <td class="logo-title-cell">
        <?php


            $logoImage = get_theme_mod('logo_image');
            if (empty($logoImage)) {
                $titleDisplay = '';
                $logoDisplay = 'style="display: none;"';
                $logoTitleClass = 'use-title';
            } else {
                $titleDisplay = 'style="display: none;"';
                $logoDisplay = '';
                $logoTitleClass = 'use-logo';
            }
            echo '<ul class="logo-title ' . $logoTitleClass . '">' .
                    '<li>' .
                    '<a href="' . esc_attr(home_url()) . '">' .
                    '<span class="title" ' . $titleDisplay . '>' . esc_html(get_option('blogname')) . '</span>' .
                    '<img class="logo" ' . $logoDisplay . ' src="' . esc_attr($logoImage) . '" />' .
                    '</a>' .
                    '</li>' .
                '</ul>';

            echo "</td>";
            echo "<td class='menu-cell'>";
if ( function_exists( 'has_nav_menu' ) && has_nav_menu( 'main-menu' ) ) {

            $navArgs = array(
                'theme_location'  => 'main-menu',
                'menu'            => '',
                'container'       => 'div',
                'container_class' => 'collapse navbar-collapse',
                'container_id'    => '',
                'menu_class'      => '',
                'menu_id'         => '',
                'echo'            => true,
                'fallback_cb'     => 'wp_page_menu',
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      => '<ul id="%1$s" class="%2$s nav navbar-nav"> %3$s</ul>',
                'depth'           => 0,
                'walker'          => new Scratch_Nav_Walker()
            );

            wp_nav_menu( $navArgs );
        } else {
            ?>

        <ul id="menu-main" class="nav navbar-nav">
			<?php
                if ( is_page() ) { $highlight = 'page_item'; } else { $highlight = 'page_item current_page_item'; } ?>
                <li class="<?php echo esc_attr( $highlight ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e(get_bloginfo('name')) ?></a></li>
                <?php wp_list_pages( 'sort_column=menu_order&depth=6&title_li=&exclude=' ); ?>
        </ul><!-- /#nav -->
        <?php
        }

        ?>
                </td>
            </tr>
        </table>

    </nav>

    <div id='main' class="block">