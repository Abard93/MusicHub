<?php

namespace GoldAddons;

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * GoldAddons Carousel Widget.
 *
 * Elementor widget that inserts an carousel content into the page.
 *
 * @since 1.0.0
 */
final class Widget_Image_Carousel extends \Elementor\Widget_Base {
    
    /**
	 * Get widget name.
	 *
	 * Retrieve carousel widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
    public function get_name() {
		return 'goldaddons-image-carousel';
	}
    
    /**
	 * Get widget title.
	 *
	 * Retrieve carousel widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
    public function get_title() {
		return esc_attr__( '(GA) Image Carousel', 'gold-addons-for-elementor' );
	}
    
    /**
	 * Get widget icon.
	 *
	 * Retrieve carousel widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
    public function get_icon() {
		return 'fa fa-slideshare';
	}
    
    /**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the carousel widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'gold-addons-for-elementor' ];
	}
    
    /**
	 * Register carousel widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
        
        $this->start_controls_section(
			'content_section',
			[
				'label' => esc_attr__( 'Content', 'gold-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'carousel',
			[
				'label' => esc_attr__( 'Add Images', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
				'show_label' => false,
				'dynamic' => [
					'active' => true,
				]
			]
		);
        
        $this->add_control(
			'items',
			[
				'label' => esc_attr__( 'Slides to Show', 'gold-addons-for-elementor' ),
                'description' => esc_attr__( 'The number of items you want to see on the screen.', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10'
                ],
                'default' => '3',
				'frontend_available' => true,
                'separator' => 'before'
			]
		);
        
        $this->add_control(
			'margin',
			[
				'label' => esc_attr__( 'Margin', 'gold-addons-for-elementor' ),
                'description' => esc_attr__( 'margin-right (px) on item.', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
                'default' => [
                    'unit' => 'px',
                    'size' => 0
                ],
                'separator' => 'before'
			]
		);
        
        $this->add_control(
			'loop',
			[
				'label' => esc_attr__( 'Loop', 'gold-addons-for-elementor' ),
                'description' => esc_attr__( 'Infinity loop. Duplicate last and first items to get loop illusion.', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'false',
				'options' => [
					'false' => esc_attr__( 'No', 'gold-addons-for-elementor' ),
					'true' => esc_attr__( 'Yes', 'gold-addons-for-elementor' ),
				],
                'separator' => 'before'
			]
		);
        
        $this->add_control(
			'center',
			[
				'label' => esc_attr__( 'Center', 'gold-addons-for-elementor' ),
                'description' => esc_attr__( 'Center item. Works well with even an odd number of items.', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'false',
				'options' => [
					'false' => esc_attr__( 'No', 'gold-addons-for-elementor' ),
					'true' => esc_attr__( 'Yes', 'gold-addons-for-elementor' ),
				],
                'separator' => 'before'
			]
		);
        
        $this->add_control(
			'mouseDrag',
			[
				'label' => esc_attr__( 'Mouse Drag', 'gold-addons-for-elementor' ),
                'description' => esc_attr__( 'Mouse drag enabled.', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'false' => esc_attr__( 'No', 'gold-addons-for-elementor' ),
					'true' => esc_attr__( 'Yes', 'gold-addons-for-elementor' ),
				],
                'separator' => 'before'
			]
		);
        
        $this->add_control(
			'touchDrag',
			[
				'label' => esc_attr__( 'Touch Drag', 'gold-addons-for-elementor' ),
                'description' => esc_attr__( 'Touch drag enabled.', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'false' => esc_attr__( 'No', 'gold-addons-for-elementor' ),
					'true' => esc_attr__( 'Yes', 'gold-addons-for-elementor' ),
				],
                'separator' => 'before'
			]
		);
        
        $this->add_control(
			'pullDrag',
			[
				'label' => esc_attr__( 'Pull Drag', 'gold-addons-for-elementor' ),
                'description' => esc_attr__( 'Stage pull to edge.', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'false' => esc_attr__( 'No', 'gold-addons-for-elementor' ),
					'true' => esc_attr__( 'Yes', 'gold-addons-for-elementor' ),
				],
                'separator' => 'before'
			]
		);
        
        $this->add_control(
			'freeDrag',
			[
				'label' => esc_attr__( 'Free Drag', 'gold-addons-for-elementor' ),
                'description' => esc_attr__( 'Item pull to edge.', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'false',
				'options' => [
					'false' => esc_attr__( 'No', 'gold-addons-for-elementor' ),
					'true' => esc_attr__( 'Yes', 'gold-addons-for-elementor' ),
				],
                'separator' => 'before'
			]
		);
        
        $this->add_control(
			'autoWidth',
			[
				'label' => esc_attr__( 'Auto Width', 'gold-addons-for-elementor' ),
                'description' => esc_attr__( 'Set non grid content. Try using width style on divs.', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'false',
				'options' => [
					'false' => esc_attr__( 'No', 'gold-addons-for-elementor' ),
					'true' => esc_attr__( 'Yes', 'gold-addons-for-elementor' ),
				],
                'separator' => 'before'
			]
		);
        
        $this->add_control(
			'rewind',
			[
				'label' => esc_attr__( 'Rewind', 'gold-addons-for-elementor' ),
                'description' => esc_attr__( 'Go backwards when the boundary has reached.', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'false' => esc_attr__( 'No', 'gold-addons-for-elementor' ),
					'true' => esc_attr__( 'Yes', 'gold-addons-for-elementor' ),
				],
                'separator' => 'before'
			]
		);
        
        $this->add_control(
			'nav',
			[
				'label' => esc_attr__( 'Navigation', 'gold-addons-for-elementor' ),
                'description' => esc_attr__( 'Show next/prev buttons.', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'true' => esc_attr__( 'Yes', 'gold-addons-for-elementor' ),
					'false' => esc_attr__( 'No', 'gold-addons-for-elementor' )
				],
				'frontend_available' => true,
                'separator' => 'before'
			]
		);
        
        $this->add_control(
			'dots',
			[
				'label' => esc_attr__( 'Dots', 'gold-addons-for-elementor' ),
                'description' => esc_attr__( 'Show dots navigation.', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'false' => esc_attr__( 'No', 'gold-addons-for-elementor' ),
					'true' => esc_attr__( 'Yes', 'gold-addons-for-elementor' ),
				],
                'separator' => 'before'
			]
		);
        
        $this->add_control(
			'autoplay',
			[
				'label' => esc_attr__( 'Autoplay', 'gold-addons-for-elementor' ),
                'description' => esc_attr__( 'Autoplay carousel on load.', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'false',
				'options' => [
					'false' => esc_attr__( 'No', 'gold-addons-for-elementor' ),
					'true' => esc_attr__( 'Yes', 'gold-addons-for-elementor' ),
				],
                'separator' => 'before'
			]
		);
        
        $this->add_control(
			'autoplayTimeout',
			[
				'label' => esc_attr__( 'Autoplay Timeout', 'gold-addons-for-elementor' ),
                'description' => esc_attr__( 'Autoplay interval timeout.', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1000,
						'max' => 10000,
					],
				],
                'default' => [
                    'size' => 4000
                ],
                'condition' => [
                    'autoplay' => 'true'
                ]
			]
		);
        
        $this->add_control(
			'autoplayHoverPause',
			[
				'label' => esc_attr__( 'Autoplay Hover Pause', 'gold-addons-for-elementor' ),
                'label_block' => true,
                'description' => esc_attr__( 'Pause on mouse hover.', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'false',
				'options' => [
					'false' => esc_attr__( 'No', 'gold-addons-for-elementor' ),
					'true' => esc_attr__( 'Yes', 'gold-addons-for-elementor' ),
				],
                'condition' => [
                    'autoplay' => 'true'
                ]
			]
		);
        
        $this->add_control(
			'lazyLoad',
			[
				'label' => esc_attr__( 'Lazy Load', 'gold-addons-for-elementor' ),
                'description' => esc_attr__( 'Lazy load images. data-src and data-src-retina for highres. Also load images into background inline style if element is not <img>', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'false',
				'options' => [
					'false' => esc_attr__( 'No', 'gold-addons-for-elementor' ),
					'true' => esc_attr__( 'Yes', 'gold-addons-for-elementor' ),
				],
                'separator' => 'before'
			]
		);
        
        $this->end_controls_section();
        
    }
    
    /**
	 * Render carousel widget output on the frontend.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
        
		$settings = $this->get_settings_for_display();
        extract( $settings ); 
        
        if( empty( $carousel ) ) {
            return;
        }
        
        $data                   = array();
        $data['items']              = '"items": ' . esc_attr( $items ) . ',';
        $data['margin']             = '"margin": ' . esc_attr( $margin['size'] ) .',';
        $data['loop']               = '"loop": ' . esc_attr( $loop ) . ',';
        $data['center']             = '"center": ' . esc_attr( $center ) . ',';
        $data['mouseDrag']          = '"mouseDrag": ' . esc_attr( $mouseDrag ) . ',';
        $data['touchDrag']          = '"touchDrag": ' . esc_attr( $touchDrag ) . ',';
        $data['pullDrag']           = '"pullDrag": ' . esc_attr( $pullDrag ) .',';
        $data['freeDrag']           = '"freeDrag": ' . esc_attr( $freeDrag ) . ',';
        $data['autoWidth']          = '"autoWidth": ' . esc_attr( $autoWidth ) . ',';
        $data['rewind']             = '"rewind": ' . esc_attr( $rewind ) . ',';
        $data['nav']                = '"nav": ' . esc_attr( $nav ) . ',';
        $data['dots']               = '"dots": ' . esc_attr( $dots ) . ',';
        $data['autoplay']           = '"autoplay": ' . esc_attr( $autoplay ) . ',';
        
        if( $autoplay == 'true' ) {
            $data['autoplayTimeout']    = '"autoplayTimeout": '. esc_attr( $autoplayTimeout['size'] ) . ',';
            $data['autoplayHoverPause'] = '"autoplayHoverPause": '. esc_attr( $autoplayHoverPause ) . ',';
        }
        
        $data['lazyLoad']           = '"lazyLoad": ' . esc_attr( $lazyLoad );
        
        $this->add_render_attribute(
            'wrapper_attributes',
            [
                'class' => 'goldaddons-carousel owl-carousel',
                'data-owl-carousel' => '{ '. implode( ' ', $data ) .' }'
            ]
        ); ?>
        
        <div <?php echo $this->get_render_attribute_string( 'wrapper_attributes' ); ?>>
            <?php foreach( $carousel as $image ): ?>
                <img src="<?php echo esc_url( $image['url'] ); ?>">
            <?php endforeach; ?>
        </div>
        
    <?php
    }
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
