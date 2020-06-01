<?php

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Retrieve Blog Categories
 *
 * @since 1.0.3
 * @return array
 */
function goldaddons_get_blog_categories() {
    $categories = get_categories();
    
    foreach( $categories as $category ) {
        $id = esc_attr( $category->term_id );
        $cat[$id] = esc_html( $category->name );
    }
    
    return $cat;
}

/**
 * Add new "Gold Addons" Category to The Elementor
 *
 * @since 1.0.0
 */
function goldaddons_add_elementor_widget_categories( $elements_manager ) {
    
    // Add New Elementor Category
	$elements_manager->add_category(
		'gold-addons-for-elementor',
		[
			'title' => esc_attr__( 'Gold Addons', 'gold-addons-for-elementor' ),
			'icon' => 'fa fa-plug',
		]
	);
    
}
add_action( 'elementor/elements/categories_registered', 'goldaddons_add_elementor_widget_categories' );

/**
 * Custom Excerpt Length
 *
 * @since 1.0.3
 */
function goldaddons_the_excerpt( $settings) {
    $length = isset( $settings['excerpt_length'] ) ? $settings['excerpt_length'] : '55';
    $readmore = isset( $settings['excerpt_readmore'] ) ? $settings['excerpt_readmore'] : esc_html__( 'Read More', 'gold-addons-for-elementor' );
    
	$excerpt = get_the_excerpt();
	$length++;

	if ( mb_strlen( $excerpt ) > $length ) {
		$subex = mb_substr( $excerpt, 0, $length - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
        // Post tags.
        if( 'yes' == $settings['post_tags'] ) {
            echo '<div class="ga-blog-post-tags">';
                the_tags( '', ' ', '' );
            echo '</div>';
        }
        if( 'yes' == $settings['readmore_link'] ) {
		  echo '<p><a href="'. get_the_permalink() .'" class="ga-link-readmore">'. $readmore . '</a></p>';
        }
	} else {
		echo $excerpt;
	}
}

/**
 * Widget Blog Pagination
 *
 * @since 1.0.3
 */
function goldaddons_pagination( $query = null, $settings = null ) {
    $big        = 999999999;
    $translated = esc_html__( 'Page', 'gold-addons-for-elementor' );
    $prev_link  = get_previous_posts_link( __( '&laquo; Older Entries', 'gold-addons-for-elementor' ) );
    $next_link  = get_next_posts_link( __( 'Newer Entries &raquo;', 'gold-addons-for-elementor' ) );
    
    if( get_query_var('paged') ) {
        $paged = get_query_var('paged');
    }
    elseif( get_query_var('page') ) {
        $paged = get_query_var('page');
    } else { 
        $paged = 1; 
    }
    
    if( 'pagination' !== $settings['load_posts_type'] ) {
        $btn_txt = isset( $settings['load_more_button_txt'] ) ? esc_html( $settings['load_more_button_txt'] ) : esc_html__( 'Load More', 'gold-addons-for-elementor' );
        $class   = ' ga-infinite';
        $display = ' style="display:none;"';
        $loader  = '<div class="ga-posts-load-status">';
            $loader .= '<div class="loader-ellips infinite-scroll-request">';
                $loader .= '<span class="loader-ellips__dot"></span>';
                $loader .= '<span class="loader-ellips__dot"></span>';
                $loader .= '<span class="loader-ellips__dot"></span>';
                $loader .= '<span class="loader-ellips__dot"></span>';
            $loader .= '</div>';
            $loader .= '<p class="infinite-scroll-last">'. esc_html__( 'End of content.', 'gold-addons-for-elementor' ) .'</p>';
            $loader .= '<p class="infinite-scroll-error">'. esc_html__( 'No more posts to load.', 'gold-addons-for-elementor' ) .'</p>';
        $loader .= '</div>';
        if( 'load_more_button' == $settings['load_posts_type'] ) {
            $loader .= '<p id="infinite-load-more">';
                $loader .= '<a id="ga-infinite-load-more-btn" class="ga-infinite-load-more-btn ga-button"><i class="fa fa-spinner fa-pulse fa-fw"></i> '. $btn_txt .'</a>';
            $loader .= '</p>';
        }
    } else {
        $class   = '';
        $display = '';
        $loader  = '';
    }
    
    if( $query->max_num_pages > 1 ) {
        
        echo $loader;
        
        echo '<div id="goldaddons-pagination" class="goldaddons-pagination'. $class .'"'. $display .'>';
        
            echo paginate_links( array(
                'base'                  => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'                => '?paged=%#%',
                'current'               => max( 1, $paged ),
                'prev_text'             => '<i class="fa fa-angle-double-left"></i>',
                'next_text'             => '<i class="fa fa-angle-double-right"></i>',
                'total'                 => $query->max_num_pages,
                'type'                  => 'list',
                'before_page_number'    => '<span class="screen-reader-text">' . $translated . '</span>'
            ) );
        
        echo '</div>';
        
    }
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
