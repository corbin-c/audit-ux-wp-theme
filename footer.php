<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Audit_UX
 */

?>

	<footer id="colophon" class="site-footer">
    <section id="social"><h2>Suivez-nous sur les réseaux sociaux</h2>
    <?php
      wp_nav_menu(
        array(
          'theme_location' => 'footer-social',
          'menu_id'        => 'footer-social',
        )
      );
    ?>
    </section>
    <div class="site-info">
      <?php the_custom_logo(); ?>
      <?php 
        if (is_active_sidebar( 'footer-1' )) {
          dynamic_sidebar( 'footer-1' );
        }
      ?>
      <section id="legal"><h2>Plus d'informations</h2>
      <?php
        wp_nav_menu(
          array(
            'theme_location' => 'footer-legal',
            'menu_id'        => 'footer-legal',
          )
        );
      ?>
      </section>
      <p id="copyright">© Copyright <?php echo date("Y"); ?> <?php bloginfo( 'name' ); ?>®</p>
    </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
