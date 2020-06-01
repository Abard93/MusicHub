<?php

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} 

$categories     = isset( $settings['categories'] ) ? $settings['categories'] : '';
$date_format    = isset( $settings['date_format'] ) ? $settings['date_format'] : '';
$orderby        = isset( $settings['order_by'] ) ? $settings['order_by'] : 'date';
$order          = isset( $settings['sort_order'] ) ? $settings['sort_order'] : 'desc';
$featured_image = isset( $settings['enable_featured_image'] ) ? $settings['enable_featured_image'] : 'yes';
$fimg_permalink = isset( $settings['featured_image_permalink'] ) ? $settings['featured_image_permalink'] : 'yes';
$fimg_size      = isset( $settings['featured_image_size'] ) ? $settings['featured_image_size'] : 'full';
$posts_per_page = isset( $settings['posts_per_page'] ) ? $settings['posts_per_page'] : '8';
$paged          = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1; //Protect against arbitrary paged values


$post_meta = true;
if( 'yes' !== $settings['meta_date'] && 'yes' !== $settings['meta_author'] && 'yes' !== $settings['meta_category'] && 'yes' !== $settings['meta_comments'] ) {
    $post_meta = false;
}

$author_id          = get_the_author_meta( 'ID' );
$author_posts_url   = get_author_posts_url( $author_id, get_the_author_meta( 'user_nicename' ) );

$args = array(
    'cat'            => $categories,
    'post_status'    => 'publish',
    'orderby'        => $orderby,
    'order'          => $order,
    'posts_per_page' => $posts_per_page,
    'paged'          => $paged
);

$the_query = new WP_Query( $args ); ?>

<div id="ga-blog-posts" class="ga-blog-layout-list">
    
    <?php if( $the_query->have_posts() ): ?>
       
        <?php if( 'pagination' !== $settings['load_posts_type'] ): ?>
            <div class="ga-infinite-wrapper">
        <?php endif; ?>
            
            <?php while( $the_query->have_posts() ): $the_query->the_post(); ?>
                <div class="ga-blog-entry ga-clearfix">

                    <?php if( has_post_thumbnail() && 'yes' == $featured_image ): ?>
                        <div class="ga-blog-entry-image">
                            
                            <?php if( 'yes' == $fimg_permalink ) 
                                    echo '<a href="'. get_the_permalink() .'" alt="'. get_the_title() .'">'; ?>
                            
                                <?php the_post_thumbnail( $fimg_size ); ?>
                            
                            <?php if( 'yes' == $fimg_permalink ) echo '</a>'; ?>
                            
                        </div>
                    <?php endif; ?>
                    
                    <div class="ga-entry-content-wrapper">

                        <div class="ga-blog-entry-title">
                            <h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                        </div>

                        <?php if( $post_meta ): ?>
                        <ul class="ga-blog-entry-meta ga-clearfix">

                            <?php if( 'yes' == $settings['meta_date'] ): ?>
                                <li><i class="fa fa-calendar"></i> <?php the_date( $date_format ); ?></li>
                            <?php endif; ?>

                            <?php if( 'yes' == $settings['meta_author'] ): ?>
                            <li><i class="fa fa-user"></i> <a href="<?php echo esc_url( $author_posts_url ); ?>"><?php echo ucfirst( get_the_author() ); ?></a></li>
                            <?php endif; ?>

                            <?php if( 'yes' == $settings['meta_category'] ): ?>
                                <li><i class="fa fa-folder-open"></i> <?php the_category( ', ' ); ?></li>
                            <?php endif; ?>

                            <?php if( 'yes' == $settings['meta_comments'] ): ?>
                                <li><i class="fa fa-comments"></i> <?php echo get_comments_number(); ?></li>
                            <?php endif; ?>

                        </ul>
                        <?php endif; ?>

                        <div class="ga-blog-entry-content">
                        <?php if( 'the_content' == $settings['posts_content'] ): ?>

                            <?php the_content(); ?>
                            
                            <?php if( 'yes' == $settings['post_tags'] ): ?>
                                <div class="ga-blog-post-tags">
                                    <?php the_tags( '', ' ', '' ); ?>
                                </div>
                            <?php endif; ?>

                        <?php else: ?>

                            <?php goldaddons_the_excerpt( $settings ); ?>

                        <?php endif; ?>
                        </div>
                        
                    </div>

                </div>
            <?php endwhile; ?>
        
        <?php if( 'pagination' !== $settings['load_posts_type'] ): ?>
            </div>
        <?php endif; ?>
    
        <?php wp_reset_postdata(); ?>
    
        <?php goldaddons_pagination( $the_query, $settings ); ?>
    
    <?php endif; ?>
    
</div>

<?php

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
