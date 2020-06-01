<?php

namespace GoldAddons;

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * GoldAddons Blog Widget
 *
 * Elementor widget that inserts an blog content into the page.
 *
 * @since 1.0.3
 */
final class Widget_Blog extends \Elementor\Widget_Base {
    
    /**
	 * Get widget name.
	 *
	 * Retrieve blog widget name.
	 *
	 * @since 1.0.3
	 * @access public
	 * @return string Widget name.
	 */
    public function get_name() {
		return 'gold-addons-blog';
	}
    
    /**
	 * Get widget title.
	 *
	 * Retrieve blog widget title.
	 *
	 * @since 1.0.3
	 * @access public
	 * @return string Widget title.
	 */
    public function get_title() {
		return esc_attr__( '(GA) Blog', 'gold-addons-for-elementor' );
	}
    
    /**
	 * Get widget icon.
	 *
	 * Retrieve blog widget icon.
	 *
	 * @since 1.0.3
	 * @access public
	 * @return string Widget icon.
	 */
    public function get_icon() {
		return 'fa fa-align-center';
	}
    
    /**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the blog widget belongs to.
	 *
	 * @since 1.0.3
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'gold-addons-for-elementor' ];
	}
    
    /**
	 * Register blog widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.3
	 * @access protected
	 */
	protected function _register_controls() {
        
        /** General TAB Section
         ****************************/
        $this->start_controls_section(
			'general_section',
			[
				'label' => esc_attr__( 'General', 'gold-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
            'layout',
            [
                'label' => esc_attr__( 'Blog Layout', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'list' => esc_attr__( 'List', 'gold-addons-for-elementor' ),
                    'grid' => esc_attr__( 'Grid', 'gold-addons-for-elementor' ),
                    'timeline' => esc_attr__( 'Timeline', 'gold-addons-for-elementor' ),
                    'small_thumbs' => esc_attr__( 'Small Thumbs', 'gold-addons-for-elementor' )
                ],
                'default' => 'list'
            ]
        );
        
        $this->add_control(
            'grid_columns',
            [
                'label' => esc_attr__( 'Grid Columns', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'ga-blog-columns-2' => esc_attr__( '2 Columns', 'gold-addons-for-elementor' ),
                    'ga-blog-columns-3' => esc_attr__( '3 Columns', 'gold-addons-for-elementor' ),
                    'ga-blog-columns-4' => esc_attr__( '4 Columns', 'gold-addons-for-elementor' )
                ],
                'default' => 'ga-blog-columns-2',
                'condition' => [
                    'layout' => 'grid'
                ],
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
			'post_type_divider',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);
        
        $this->add_control(
            'load_posts_type',
            [
                'label' => esc_attr__( 'Pagination Type', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'pagination' => esc_attr__( 'Pagination', 'gold-addons-for-elementor' ),
                    'load_more_button' => esc_attr__( 'Load More Button', 'gold-addons-for-elementor' ),
                    'lazy_load' => esc_attr__( 'Infinite Scroll', 'gold-addons-for-elementor' )
                ],
                'default' => 'pagination'
            ]
        );
        
        $this->add_control(
            'load_more_button_txt',
            [
                'label' => esc_attr__( 'Load More Button Text', 'gold-addons-for-elementor' ),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_attr__( 'Load More', 'gold-addons-for-elementor' ),
                'condition' => [
                    'load_posts_type' => 'load_more_button'
                ],
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
			'entrance_animation',
			[
				'label' => __( 'Entrance Animation', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ANIMATION,
				'prefix_class' => 'animated ',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'load_posts_type',
                            'operator' => '!==',
                            'value' => 'lazy_load'
                        ]
                    ]
                ],
                'separator' => 'before'
			]
		);
        
        $this->end_controls_section();
        
        /** Content TAB Section
         ****************************/
        $this->start_controls_section(
			'content_section',
			[
				'label' => esc_attr__( 'Content', 'gold-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control( 
            'categories',
            [
                'label' => esc_attr__( 'Blog Categories', 'gold-addons-for-elementor' ),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => goldaddons_get_blog_categories(),
                'default' => 'all',
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
            'posts_content',
            [
                'label' => esc_attr__( 'Posts Content', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'the_content' => esc_attr__( 'Full Content', 'gold-addons-for-elementor' ),
                    'the_excerpt' => esc_attr__( 'The Excerpt', 'gold-addons-for-elementor' ),
                ],
                'default' => 'the_excerpt',
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
            'excerpt_length',
            [
                'label' => esc_attr__( 'Excerpt Length', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 999,
                'step' => 1,
                'default' => 55,
                'condition' => [
                    'posts_content' => 'the_excerpt'
                ],
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
            'post_tags',
            [
                'label' => esc_attr__( 'Show Post Tags ?', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_attr__( 'Show', 'gold-addons-for-elementor' ),
                'label_off' => esc_attr__( 'Hide', 'gold-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
            'readmore_link',
            [
                'label' => esc_attr__( 'Show Read More Link ?', 'gold-addons-for-elementor' ),
                'type'  => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_attr__( 'Show', 'gold-addons-for-elementor' ),
                'label_off' => esc_attr__( 'Hide', 'gold-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'posts_content' => 'the_excerpt'  
                ],
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
            'excerpt_readmore',
            [
                'label' => esc_attr__( 'Read More Link Text', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_attr__( 'Read More', 'gold-addons-for-elementor' ),
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'readmore_link',
                            'operator' => '==',
                            'value' => [ 'yes' ]
                        ],
                        [
                            'name' => 'posts_content',
                            'operator' => '==',
                            'value' => [ 'the_excerpt' ]
                        ]
                    ]
                ]
            ]
        );
        
        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_attr__( 'Posts Per Page', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 999,
                'step' => 1,
                'default' => 8,
                'separator' => 'before'
            ]
        );
        
        $this->end_controls_section();
        
        /** Featured Image TAB Section
         ****************************/
        $this->start_controls_section(
			'featured_image_section',
			[
				'label' => esc_attr__( 'Featured Image', 'gold-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
            'enable_featured_image',
            [
                'label' => esc_attr__( 'Enable Featured Image', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_attr__( 'Show', 'gold-addons-for-elementor' ),
                'label_off' => esc_attr__( 'Hide', 'gold-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes'
            ]
        );
        
        $this->add_control(
            'featured_image_permalink',
            [
                'label' => esc_attr__( 'Featured Image Permalink', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_attr__( 'Show', 'gold-addons-for-elementor' ),
                'label_off' => esc_attr__( 'Hide', 'gold-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'enable_featured_image' => 'yes'
                ],
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
            'featured_image_size',
            [
                'label' => esc_attr__( 'Featured Image Size', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'thumbnail' => esc_attr__( 'Thumbnail', 'gold-addons-for-elementor' ),
                    'medium' => esc_attr__( 'Medium', 'gold-addons-for-elementor' ),
                    'large' => esc_attr__( 'Large', 'gold-addons-for-elementor' ),
                    'full' => esc_attr__( 'Full', 'gold-addons-for-elementor' ),
                    'custom' => esc_attr__( 'Custom', 'gold-addons-for-elementor' )
                ],
                'default' => 'full',
                'condition' => [
                    'enable_featured_image' => 'yes'  
                ],
                'separator' => 'before'
            ]
        );
        
        $this->add_responsive_control(
			'featured_image_custom_size',
			[
				'label' => __( 'Featured Image Custom Size', 'Gold' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1920,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '825',
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => '700',
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => '295',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .ga-blog-entry-image img' => 'width: {{SIZE}}{{UNIT}}; height:auto;',
				],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'enable_featured_image',
                            'operator' => '==',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'featured_image_size',
                            'operator' => '==',
                            'value' => 'custom'
                        ]
                    ]
                ]
			]
		);
        
        $this->end_controls_section();
        
        /** Post Meta Section
         ****************************/
        $this->start_controls_section(
			'posts_meta_section',
			[
				'label' => esc_attr__( 'Post Meta', 'gold-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'meta_date',
			[
				'label' => esc_attr__( 'Post Date', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_attr__( 'Show', 'gold-addons-for-elementor' ),
				'label_off' => esc_attr__( 'Hide', 'gold-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'condition' => [
                    'layout' => [ 'list', 'grid', 'small_thumbs' ]
                ]
			]
		);
        
        $this->add_control(
            'date_format',
            [
                'label' => esc_attr__( 'Post Date Format', 'gold-addons-for-elementor' ),
                'description' => sprintf( '%s <a href="%s" target="_blank">%s</a>', esc_attr__( 'Date format', 'gold-addons-for-elementor' ), 'https://codex.wordpress.org/Formatting_Date_and_Time', esc_attr__( 'Guide', 'gold-addons-for-elementor' ) ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'F j, Y',
                'conditions' => [ 
                    'terms' => [
                        [
                            'name' => 'layout',
                            'operator' => '!==',
                            'value' => 'timeline',
                        ],
                        [
                            'name' => 'meta_date',
                            'operator' => '==',
                            'value' => 'yes'
                        ]
                    ]
                ],
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
			'meta_author',
			[
				'label' => esc_attr__( 'Post Author', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_attr__( 'Show', 'gold-addons-for-elementor' ),
				'label_off' => esc_attr__( 'Hide', 'gold-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'separator' => 'before'
			]
		);
        
        $this->add_control(
			'meta_category',
			[
				'label' => esc_attr__( 'Post Category', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_attr__( 'Show', 'gold-addons-for-elementor' ),
				'label_off' => esc_attr__( 'Hide', 'gold-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'separator' => 'before'
			]
		);
        
        $this->add_control(
			'meta_comments',
			[
				'label' => esc_attr__( 'Post Comments', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_attr__( 'Show', 'gold-addons-for-elementor' ),
				'label_off' => esc_attr__( 'Hide', 'gold-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'separator' => 'before'
			]
		);
        
        $this->end_controls_section();
        
        /** Post Order Section
         ****************************/
        $this->start_controls_section(
			'posts_order_section',
			[
				'label' => esc_attr__( 'Posts Order', 'gold-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
            'order_by',
            [
                'label' => esc_attr__( 'Order by', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'author' => esc_attr__( 'Author', 'gold-addons-for-elementor' ),
                    'date' => esc_attr__( 'Date', 'gold-addons-for-elementor' ),
                    'ID' => esc_attr__( 'Post ID', 'gold-addons-for-elementor' ),
                    'rand' => esc_attr__( 'Random', 'gold-addons-for-elementor' ),
                    'name' => esc_attr__( 'Name', 'gold-addons-for-elementor' ),
                    'modified' => esc_attr__( 'Last Modified', 'gold-addons-for-elementor' ),
                    'comments' => esc_attr__( 'Number of Comments', 'gold-addons-for-elementor' ),
                    'title' => esc_attr__( 'Title', 'gold-addons-for-elementor' )
                ],
                'default' => 'date',
                'separator' => 'after'
            ]
        );
        
        $this->add_control(
            'sort_order',
            [
                'label' => esc_attr__( 'Sort Order', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'ASC' => esc_attr__( 'Ascending', 'gold-addons-for-elementor' ),
                    'DESC' => esc_attr__( 'Descending', 'gold-addons-for-elementor' )
                ],
                'default' => 'DESC'
            ]
        );
        
        $this->end_controls_section();
        
        /**
         * Article Wrapper [STYLING]
         */
        $this->start_controls_section(
            'styling_article_wrapper',
            [
                'label' => esc_attr__( 'Article Wrapper', 'gold-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        
        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'article_wrapper_box_shadow',
				'label' => esc_attr__( 'Box Shadow', 'gold-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .ga-blog-entry',
			]
		);
        
        $this->end_controls_section();
        
        /**
         * Featured Image [STYLING]
         */
        $this->start_controls_section(
            'styling_featured_image',
            [
                'label' => esc_attr__( 'Featured Image', 'gold-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'featured_image_border',
				'label' => esc_attr__( 'Border', 'gold-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .ga-blog-entry-image img',
                'separator' => 'before'
			]
		);
        
        $this->add_control(
            'featured_image_border_radius',
            [
                'label' => esc_attr__( 'Border Radius', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-blog-entry-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );
        
        $this->end_controls_section();
        
        /**
         * Post Content Wrapper
         */
        $this->start_controls_section(
            'styling_post_content_wrapper',
            [
                'label' => esc_attr__( 'Content Wrapper', 'gold-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'content_wrapper_background',
				'label' => esc_attr__( 'Content Wrapper Background', 'gold-addons-for-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ga-blog-layout-list .ga-entry-content-wrapper, {{WRAPPER}} .ga-grid-entry-content-wrapper, {{WRAPPER}} .ga-blog-timeline-wrapper .ga-entry-content-wrapper, {{WRAPPER}} .ga-blog-layout-small-thumbs .ga-blog-entry',
			]
		);
        
        $this->add_control(
			'content_wrapper_padding',
			[
				'label' => esc_attr__( 'Content Wrapper Padding', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ga-blog-layout-list .ga-entry-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .ga-grid-entry-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .ga-blog-timeline-wrapper .ga-entry-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .ga-blog-layout-small-thumbs .ga-blog-entry' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->end_controls_section();
        
        /** Post Title Styling TAB
         ****************************/
        $this->start_controls_section(
            'styling_post_title',
            [
                'label' => esc_attr__( 'Post Title', 'gold-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        
        $this->start_controls_tabs( 
            'title_color_tabs' 
        );
        
        $this->start_controls_tab(
			'title_color_normal_tab',
			[
				'label' => esc_attr__( 'Normal', 'gold-addons-for-elementor' ),
			]
		);
        
        $this->add_control(
			'title_color',
			[
				'label' => esc_attr__( 'Post Title Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-blog-entry-title h2 a' => 'color: {{VALUE}};',
				],
                'separator' => 'after'
			]
		);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
			'title_color_hover_tab',
			[
				'label' => esc_attr__( 'Hover', 'gold-addons-for-elementor' ),
			]
		);
        
        $this->add_control(
			'title_hover_color',
			[
				'label' => esc_attr__( 'Post Title Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-blog-entry-title h2 a:hover' => 'color: {{VALUE}};',
				],
                'separator' => 'after'
			]
		);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_attr__( 'Post Title Font', 'gold-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .ga-blog-entry-title h2, {{WRAPPER}} .ga-blog-entry-title h2 a'
            ]
        );
        
        $this->add_control(
			'post_title_align_before_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);
        
        $this->add_responsive_control(
			'post_title_align',
			[
				'label' => esc_attr__( 'Post Title Align', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_attr__( 'Left', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_attr__( 'Center', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_attr__( 'Right', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-align-right',
					]
				],
				'selectors' => [
                    '{{WRAPPER}} .ga-blog-entry-title h2' => 'text-align: {{VALUE}};',
                ],
				'default' => 'left'
			]
		);
        
        $this->end_controls_section();
        
        /** Post Meta Styling TAB
         ****************************/
        $this->start_controls_section(
            'styling_post_meta',
            [
                'label' => esc_attr__( 'Post Meta', 'gold-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        
        $this->add_control(
			'post_meta_color',
			[
				'label' => esc_attr__( 'Post Meta Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .ga-blog-entry-meta li:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ga-blog-entry-meta li' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ga-blog-entry-meta li i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ga-blog-entry-meta li a' => 'color: {{VALUE}};'
				],
                'separator' => 'after'
			]
		);
        
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'post_meta_typography',
                'label' => esc_attr__( 'Post Meta Font', 'gold-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .ga-blog-entry-meta li'
            ]
        );
        
        $this->end_controls_section();
        
        /* Content Styling TAB
         * ------------------------- */
        $this->start_controls_section(
            'styling_post_content',
            [
                'label' => esc_attr__( 'Post Content', 'gold-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        
        $this->start_controls_tabs( 
            'content_text_color_tabs' 
        );
        
        $this->start_controls_tab(
			'content_text_color_normal_tab',
			[
				'label' => esc_attr__( 'Normal', 'gold-addons-for-elementor' ),
			]
		);
        
        $this->add_control(
			'content_text_color',
			[
				'label' => esc_attr__( 'Content Text Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-blog-entry-content' => 'color: {{VALUE}};'
				],
                'separator' => 'after'
			]
		);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
			'content_text_color_hover_tab',
			[
				'label' => esc_attr__( 'Hover', 'gold-addons-for-elementor' ),
			]
		);
        
        $this->add_control(
			'content_text_hover_color',
			[
				'label' => esc_attr__( 'Content Text Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-blog-entry-content:hover' => 'color: {{VALUE}};'
				],
                'separator' => 'after'
			]
		);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => esc_attr__( 'Content Font', 'gold-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .ga-blog-entry-content'
            ]
        );
        
        $this->add_responsive_control(
			'content_align',
			[
				'label' => esc_attr__( 'Content Align', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_attr__( 'Left', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_attr__( 'Center', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_attr__( 'Right', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-align-right',
					]
				],
				'selectors' => [
                    '{{WRAPPER}} .ga-blog-entry-content' => 'text-align: {{VALUE}};',
                ],
				'default' => 'left',
                'separator' => 'before'
			]
		);
        
        $this->end_controls_section();
        
        /** Timeline Layout Styling TAB
         ****************************/
        $this->start_controls_section(
            'styling_timeline_section',
            [
                'label' => esc_attr__( 'Timeline Layout', 'gold-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout' => 'timeline'
                ]
            ]
        );
        
        $this->start_controls_tabs( 
            'timeline_date_border_color_tabs' 
        );
        
        $this->start_controls_tab(
			'timeline_date_border_color_normal_tab',
			[
				'label' => esc_attr__( 'Normal', 'gold-addons-for-elementor' ),
			]
		);
        
        $this->add_control(
			'timeline_date_border_color',
			[
				'label' => esc_attr__( 'Timeline Date Border Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-blog-entry .ga-blog-entry-timeline' => 'border-color: {{VALUE}};'
				],
                'separator' => 'after'
			]
		);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
			'timeline_date_border_color_hover_tab',
			[
				'label' => esc_attr__( 'Hover', 'gold-addons-for-elementor' ),
			]
		);
        
        $this->add_control(
			'timeline_date_border_hover_color',
			[
				'label' => esc_attr__( 'Timeline Date Border Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-blog-entry:hover .ga-blog-entry-timeline' => 'border-color: {{VALUE}};'
				],
                'separator' => 'after'
			]
		);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->start_controls_tabs( 
            'timeline_date_text_color_tabs' 
        );
        
        $this->start_controls_tab(
			'timeline_date_text_color_normal_tab',
			[
				'label' => esc_attr__( 'Normal', 'gold-addons-for-elementor' ),
			]
		);
        
        $this->add_control(
			'timeline_date_text_color',
			[
				'label' => esc_attr__( 'Timeline Date Text Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-blog-entry .ga-blog-entry-timeline' => 'color: {{VALUE}};',
				],
                'separator' => 'after'
			]
		);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
			'timeline_date_text_color_hover_tab',
			[
				'label' => esc_attr__( 'Hover', 'gold-addons-for-elementor' ),
			]
		);
        
        $this->add_control(
			'timeline_date_text_hover_color',
			[
				'label' => esc_attr__( 'Timeline Date Text Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-blog-entry:hover .ga-blog-entry-timeline' => 'color: {{VALUE}};',
				],
                'separator' => 'after'
			]
		);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->start_controls_tabs( 
            'timeline_date_bg_color_tabs' 
        );
        
        $this->start_controls_tab(
			'timeline_date_bg_color_normal_tab',
			[
				'label' => esc_attr__( 'Normal', 'gold-addons-for-elementor' ),
			]
		);
        
        $this->add_control(
			'timeline_date_bg_color',
			[
				'label' => esc_attr__( 'Timeline Date Background Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-blog-entry .ga-blog-entry-timeline' => 'background-color: {{VALUE}};',
				],
                'separator' => 'after'
			]
		);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
			'timeline_date_bg_color_hover_tab',
			[
				'label' => esc_attr__( 'Hover', 'gold-addons-for-elementor' ),
			]
		);
        
        $this->add_control(
			'timeline_date_bg_hover_color',
			[
				'label' => esc_attr__( 'Timeline Date Background Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-blog-entry:hover .ga-blog-entry-timeline' => 'background-color: {{VALUE}};',
				],
                'separator' => 'after'
			]
		);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();
        
        /* The Excerpt Styling TAB
         * ------------------------ */
        $this->start_controls_section(
            'styling_excerpt',
            [
                'label' => esc_attr__( 'Post Excerpt', 'gold-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'posts_content' => 'the_excerpt'
                ]
            ]
        );
        
        $this->start_controls_tabs( 
            'readmore_link_color_tabs' 
        );
        
        $this->start_controls_tab(
			'readmore_link_color_normal_tab',
			[
				'label' => esc_attr__( 'Normal', 'gold-addons-for-elementor' ),
			]
		);
        
        $this->add_control(
			'readmore_link_color',
			[
				'label' => esc_attr__( 'Read More Link Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-link-readmore' => 'color: {{VALUE}};',
				],
                'separator' => 'after'
			]
		);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
			'readmore_link_color_hover_tab',
			[
				'label' => esc_attr__( 'Hover', 'gold-addons-for-elementor' ),
			]
		);
        
        $this->add_control(
			'readmore_link_hover_color',
			[
				'label' => esc_attr__( 'Read More Link Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-link-readmore:hover' => 'color: {{VALUE}};',
				],
                'separator' => 'after'
			]
		);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'readmore_link_typography',
                'label' => esc_attr__( 'Read More Link Font', 'gold-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .ga-link-readmore'
            ]
        );
        
         $this->add_control(
			'readmore_link_align_before_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);
        
        $this->add_responsive_control(
			'readmore_link_align',
			[
				'label' => esc_attr__( 'Read More Link Align', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_attr__( 'Left', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_attr__( 'Center', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_attr__( 'Right', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-align-right',
					]
				],
				'selectors' => [
                    '{{WRAPPER}} .ga-link-readmore' => 'text-align: {{VALUE}};',
                ],
				'default' => 'left'
			]
		);
        
        $this->end_controls_section();
        
        /**
         * Post Tags
         */
        $this->start_controls_section(
            'styling_post_tags',
            [
                'label' => esc_attr__( 'Post Tags', 'gold-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'load_posts_type' => 'pagination'
                ]
            ]
        );
        
        $this->start_controls_tabs(
            'post_tags_color_styling_tabs'
        );

        $this->start_controls_tab(
            'post_tags_color_styling_normal_tab',
            [
                'label' => esc_attr__( 'Normal', 'gold-addons-for-elementor' )
            ]
        );

        $this->add_control(
            'post_tags_normal_color',
            [
                'label' => esc_attr__( 'Color', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ga-blog-post-tags a' => 'color: {{VALUE}}'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
            'post_tags_color_styling_hover_tab',
            [
                'label' => esc_attr__( 'Hover', 'gold-addons-for-elementor' )
            ]
        );

        $this->add_control(
            'post_tags_hover_color',
            [
                'label' => esc_attr__( 'Color', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ga-blog-post-tags a:hover' => 'color: {{VALUE}}'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->add_control(
			'hr_post_tags_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'post_tags_typography',
				'label' => esc_attr__( 'Typography', 'gold-addons-for-elementor' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ga-blog-post-tags a'
			]
		);
        
        $this->add_control(
			'hr_post_tags_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'post_tags_padding',
			[
				'label' => esc_attr__( 'Padding', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ga-blog-post-tags a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
        
        $this->add_control(
			'hr_post_tags_3',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'post_tags_margin',
			[
				'label' => esc_attr__( 'Margin', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ga-blog-post-tags a' => 'margin: 0 {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .ga-blog-post-tags' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};'
				]
			]
		);
        
        $this->add_control(
			'hr_post_tags_4',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->start_controls_tabs(
            'post_tags_background_styling_tabs'
        );

        $this->start_controls_tab(
            'post_tags_background_normal_tab',
            [
                'label' => esc_attr__( 'Normal', 'gold-addons-for-elementor' )
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'post_tags_background',
				'label' => esc_attr__( 'Background Color', 'gold-addons-for-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ga-blog-post-tags a',
			]
		);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
            'post_tags_background_hover_tab',
            [
                'label' => esc_attr__( 'Hover', 'gold-addons-for-elementor' )
            ]
        );
        
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'post_tags_background_hover',
				'label' => esc_attr__( 'Background Color', 'gold-addons-for-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ga-blog-post-tags a:hover',
			]
		);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->add_control(
			'hr_post_tags_5',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'post_tags_box_shadow',
				'label' => esc_attr__( 'Box Shadow', 'gold-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .ga-blog-post-tags a',
			]
		);
        
        $this->add_control(
			'hr_post_tags_6',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'post_tags_border',
				'label' => esc_attr__( 'Border', 'gold-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .ga-blog-post-tags a',
			]
		);
        
        $this->add_control(
			'hr_post_tags_7',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'post_tags_border_radius',
			[
				'label' => esc_attr__( 'Border Radius', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ga-blog-post-tags a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        
        $this->end_controls_section();
        
        /** Pagination Styling TAB
         ****************************/
        $this->start_controls_section(
            'styling_pagination',
            [
                'label' => esc_attr__( 'Post Pagination', 'gold-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'load_posts_type' => 'pagination'
                ]
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'pagination_border',
                'selector' => '{{WRAPPER}} .goldaddons-pagination ul.page-numbers > li > span.current, .goldaddons-pagination ul.page-numbers > li > a:hover'
            ]
        );
        
        $this->add_control(
            'pagination_border_radius',
            [
                'label' => esc_attr__( 'Border Radius', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .goldaddons-pagination ul.page-numbers > li > span.current, .goldaddons-pagination ul.page-numbers > li > a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
            'pagination_txt_color',
            [
                'label' => esc_attr__( 'Pagination Text Color', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .goldaddons-pagination ul.page-numbers > li > span.current, .goldaddons-pagination ul.page-numbers > li > a:hover' => 'color: {{VALUE}}'
                ],
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
            'pagination_bg_color',
            [
                'label' => esc_attr__( 'Pagination Background Color', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .goldaddons-pagination ul.page-numbers > li > span.current, .goldaddons-pagination ul.page-numbers > li > a:hover' => 'background-color: {{VALUE}}'
                ],
                'separator' => 'before'
            ]
        );
        
        $this->end_controls_section();
        
        /** Load More Button Styling TAB
         * ---------------------------- */
        $this->start_controls_section(
            'styling_load_more_button',
            [
                'label' => esc_attr__( 'Load More Button', 'gold-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'load_posts_type' => 'load_more_button'
                ]
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} #ga-infinite-load-more-btn'
            ]
        );
        
        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_attr__( 'Border Radius', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} #ga-infinite-load-more-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
            'button_padding',
            [
                'label' => esc_attr__( 'Padding', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} #ga-infinite-load-more-btn' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
			'button_styling_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);
        
        $this->start_controls_tabs(
            'button_styling_tabs'
        );

        $this->start_controls_tab(
            'button_styling_normal_tab',
            [
                'label' => esc_attr__( 'Normal', 'gold-addons-for-elementor' )
            ]
        );

        $this->add_control(
            'button_txt_normal_color',
            [
                'label' => esc_attr__( 'Button Text Color', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #ga-infinite-load-more-btn' => 'color: {{VALUE}}'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
            'button_styling_hover_tab',
            [
                'label' => esc_attr__( 'Hover', 'gold-addons-for-elementor' )
            ]
        );

        $this->add_control(
            'button_txt_hover_color',
            [
                'label' => esc_attr__( 'Button Text Color', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #ga-infinite-load-more-btn:hover' => 'color: {{VALUE}}'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->add_control(
			'button_styling_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);
        
        $this->start_controls_tabs(
            'button_bg_styling_tabs'
        );

        $this->start_controls_tab(
            'button_bg_styling_normal_tab',
            [
                'label' => esc_attr__( 'Normal', 'gold-addons-for-elementor' )
            ]
        );

        $this->add_control(
            'button_bg_normal_color',
            [
                'label' => esc_attr__( 'Button Background Color', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #ga-infinite-load-more-btn' => 'background-color: {{VALUE}}'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
            'button_bg_styling_hover_tab',
            [
                'label' => esc_attr__( 'Hover', 'gold-addons-for-elementor' )
            ]
        );

        $this->add_control(
            'button_bg_hover_color',
            [
                'label' => esc_attr__( 'Button Background Color', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #ga-infinite-load-more-btn:hover' => 'background-color: {{VALUE}}'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->add_responsive_control(
			'load_more_btn_align',
			[
				'label' => esc_attr__( 'Button Alignment', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_attr__( 'Left', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_attr__( 'Center', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_attr__( 'Right', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => esc_attr__( 'Justified', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-align-justify',
					]
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
                'separator' => 'before'
			]
		);
        
        $this->end_controls_section();
    }
    
    /**
	 * Render blog widget output on the frontend.
	 *
	 * @since 1.0.3
	 * @access protected
	 */
	protected function render() {
        
        $settings = $this->get_settings_for_display();
        $layout = esc_attr( $settings['layout'] );
        
        $this->add_render_attribute(
            'wrapper',
            [
                'class' => 'gold-addons-blog'
            ]
        ); ?>
    
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            
            <?php if( 'list' == $layout ): ?>
            
                <?php require_once( GOLDADDONS_DIR . 'templates/blog-list.php' ); ?>
            
            <?php elseif( 'grid' == $layout ): ?>
                
                <?php require_once( GOLDADDONS_DIR . 'templates/blog-grid.php' ); ?>
            
            <?php elseif( 'timeline' == $layout ): ?>
            
                <?php require_once( GOLDADDONS_DIR . 'templates/blog-timeline.php' ); ?>
            
            <?php elseif( 'small_thumbs' == $layout ): ?>
            
                <?php require_once( GOLDADDONS_DIR . 'templates/blog-small-thumbs.php' ); ?>
            
            <?php endif; ?>
            
        </div>

    <?php
    }
}
    
    /* Omit closing PHP tag to avoid "Headers already sent" issues. */
    