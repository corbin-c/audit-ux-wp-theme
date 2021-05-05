<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Audit_UX
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'audit-ux' ); ?></a>

	<header id="masthead">
    <div class="site-header">
      <div class="site-title">
        <?php the_custom_logo(); ?>
        <h1 class="screen-reader-text">
          <a title="Retour à la page d'accueil" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <?php bloginfo( 'name' ); ?>
          </a>
        </h1>
      </div>
      <nav id="site-contact" class="contact">
        <?php
        wp_nav_menu(
          array(
            'theme_location' => 'contact-menu',
            'menu_id'        => 'contact-menu',
          )
        );
        ?>
      </nav><!-- #site-contact -->
      <nav id="site-navigation" class="main-navigation">
        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'audit-ux' ); ?></button>
        <?php
        wp_nav_menu(
          array(
            'theme_location' => 'menu-1',
            'menu_id'        => 'primary-menu',
          )
        );
        ?>
      </nav><!-- #site-navigation -->
    </div>
    <?php breadcrumbs(); ?><!-- breadcrumbs #crumbs -->
	</header><!-- #masthead -->
