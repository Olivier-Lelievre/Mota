<?php get_header(); ?>
  <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
    
  <h2><?php single_post_title(); ?></h2>
  <p>Type : <?php the_field( 'type' ); ?></p>
  
  

  <!-- Utilisation de get_the_terms pour récupérer la taxonomie catégorie -->
  <p>Catégorie : <?php $categories = get_the_terms( get_the_ID(), 'categorie' );
    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
        foreach ( $categories as $category ) {
            echo esc_html( $category->name );
        }
    } else {
        echo 'Aucune catégorie';
    }
    ?>
</p>

<!-- Afficher la photo principale - fonctionne avec image sur array dans SCF -->
<div class="photo-display">
        <?php if (get_field('image')) : ?>
            <img src="<?php echo esc_url(get_field('image')['url']); ?>" alt="<?php echo esc_attr(get_field('image')['alt']); ?>">
        <?php endif; ?>
    </div>



	  

	  <?php the_post_navigation(); ?>

  <?php endwhile; endif; ?>
<?php get_footer(); ?>