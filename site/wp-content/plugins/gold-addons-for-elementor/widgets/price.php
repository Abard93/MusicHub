<?php

namespace GoldAddons;

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * GoldAddons Price Box Widget
 *
 * Elementor widget that inserts an price box content into the page.
 *
 * @since 1.0.2
 */
final class Widget_Price_Box extends \Elementor\Widget_Base {
    
    /**
	 * Get widget name.
	 *
	 * Retrieve price box widget name.
	 *
	 * @since 1.0.2
	 * @access public
	 * @return string Widget name.
	 */
    public function get_name() {
		return 'gold-addons-price-box';
	}
    
    /**
	 * Get widget title.
	 *
	 * Retrieve price box widget title.
	 *
	 * @since 1.0.2
	 * @access public
	 * @return string Widget title.
	 */
    public function get_title() {
		return esc_attr__( '(GA) Price Box', 'gold-addons-for-elementor' );
	}
    
    /**
	 * Get widget icon.
	 *
	 * Retrieve price box widget icon.
	 *
	 * @since 1.0.2
	 * @access public
	 * @return string Widget icon.
	 */
    public function get_icon() {
		return 'fa fa-dollar';
	}
    
    /**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the price box widget belongs to.
	 *
	 * @since 1.0.2
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'gold-addons-for-elementor' ];
	}
    
    /**
	 * Register price box widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.2
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
            'currency',
            [
                'label' => esc_attr__( 'Currency Symbol', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '$'
            ]
        );
        
        $this->add_control(
            'price',
            [
                'label' => esc_attr__( 'Price', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '99',
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
            'period',
            [
                'label' => esc_attr__( 'Period', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '/ mo',
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
            'title',
            [
                'label' => esc_attr__( 'Title', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'GoldAddons',
                'separator' => 'before'
            ]
        );
        
        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
			'icon',
			[
				'label' => esc_attr__( 'Icon', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICON,
				'label_block' => true,
				'default' => 'fa fa-plus',
			]
		);
        
        $repeater->add_control(
			'text',
			[
				'label' => esc_attr__( 'Text', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_attr__( 'New Feature', 'gold-addons-for-elementor' ),
				'default' => esc_attr__( 'New Feature', 'gold-addons-for-elementor' ),
			]
		);
        
        $repeater->add_control(
			'link',
			[
				'label' => esc_attr__( 'Link', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => esc_attr__( 'https://your-link.com', 'gold-addons-for-elementor' ),
			]
		);
        
        $this->add_control(
			'features',
			[
				'label' => esc_attr__( 'Features', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'text' => esc_attr__( 'Feature #1', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-plus',
					],
					[
						'text' => esc_attr__( 'Feature #2', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-plus',
					],
					[
						'text' => esc_attr__( 'Feature #3', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-plus',
					],
				],
				'title_field' => '<i class="{{ icon }}" aria-hidden="true"></i> {{{ text }}}',
                'separator' => 'before'
			]
		);
        
        $this->add_control(
            'button_title',
            [
                'label' => esc_attr__( 'Button Title', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Buy Now',
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
			'button',
			[
				'label' => esc_attr__( 'Button Link', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'gold-addons-for-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
                'separator' => 'before'
			]
		);
        
        $this->add_control(
			'featured',
			[
				'label' => esc_attr__( 'Featured ?', 'gold-addons-for-elementor' ),
                'description' => esc_attr__( 'If enabled the proper box shadow wil lbe applied to stick box out from other price boxes. Usually featured box should be in middle.', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_attr__( 'On', 'gold-addons-for-elementor' ),
				'label_off' => esc_attr__( 'Off', 'gold-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'no',
                'separator' => 'before'
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
            'styling',
            [
                'label' => esc_attr__( 'Styling', 'gold-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'head_typography',
				'label' => esc_attr__( 'Head Typography', 'gold-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .ga-pricing-deco',
			]
		);
        
        $this->add_control(
			'head_price_color',
			[
				'label' => esc_attr__( 'Head Price Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-pricing-price' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_control(
			'head_title_color',
			[
				'label' => esc_attr__( 'Head Title Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-pricing-title' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->start_controls_tabs( 
            'head_background_style' 
        );
        
        $this->start_controls_tab(
			'tab_head_normal',
			[
				'label' => esc_attr__( 'Normal', 'gold-addons-for-elementor' ),
			]
		);
        
        $this->add_control(
			'head_background_color',
			[
				'label' => esc_attr__( 'Head Background Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-pricing-deco' => 'background: {{VALUE}};',
				],
                'separator' => 'after'
			]
		);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
			'tab_head_hover',
			[
				'label' => esc_attr__( 'Hover', 'gold-addons-for-elementor' ),
			]
		);
        
         $this->add_control(
			'head_background_hover_color',
			[
				'label' => esc_attr__( 'Head Background Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-pricing-deco:hover' => 'background: {{VALUE}};',
				],
                'separator' => 'after'
			]
		);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'feature_list_typography',
				'label' => esc_attr__( 'List Typography', 'gold-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .ga-pricing-feature',
			]
		);
        
        $this->add_control(
			'feature_list_text_color',
			[
				'label' => esc_attr__( 'Feature List Text Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-pricing-feature' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->start_controls_tabs( 
            'feature_links_style' 
        );
        
        $this->start_controls_tab(
			'tab_links_normal',
			[
				'label' => esc_attr__( 'Normal', 'gold-addons-for-elementor' ),
			]
		);
        
        $this->add_control(
			'feature_list_link_color',
			[
				'label' => esc_attr__( 'Feature List Links Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-pricing-feature a' => 'color: {{VALUE}};',
				],
                'separator' => 'after'
			]
		);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
			'tab_links_hover',
			[
				'label' => esc_attr__( 'Hover', 'gold-addons-for-elementor' ),
			]
		);
        
        $this->add_control(
			'feature_list_link_hover_color',
			[
				'label' => esc_attr__( 'Feature List Links Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-pricing-feature a:hover' => 'color: {{VALUE}};',
				],
                'separator' => 'after'
			]
		);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->start_controls_tabs( 
            'button_background_style' 
        );
        
        $this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_attr__( 'Normal', 'gold-addons-for-elementor' ),
			]
		);
        
        $this->add_control(
			'button_text_color',
			[
				'label' => esc_attr__( 'Button Text Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-pricing-action' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_control(
			'button_background_color',
			[
				'label' => esc_attr__( 'Button Background Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-pricing-action' => 'background: {{VALUE}};',
				]
			]
		);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_attr__( 'Hover', 'gold-addons-for-elementor' ),
			]
		);
        
        $this->add_control(
			'button_text_hover_color',
			[
				'label' => esc_attr__( 'Button Text Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-pricing-action:hover' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_control(
			'button_background_hover_color',
			[
				'label' => esc_attr__( 'Button Background Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-pricing-action:hover' => 'background: {{VALUE}};',
				]
			]
		);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();
    }
    
    /**
	 * Render price box widget output on the frontend.
	 *
	 * @since 1.0.2
	 * @access protected
	 */
	protected function render() {
        
		$settings = $this->get_settings_for_display();
        extract( $settings );
        
        $btn_url = $button['url'] ? esc_url( $button['url'] ) : '';
        $btn_target = $button['is_external'] ? ' target="_blank"' : '';
        $btn_nofollow = $button['nofollow'] ? ' rel="nofollow"' : '';
        
        if( $featured == 'yes' ) {
            $featured_class = ' ga-pricing__item--featured';
        } else {
            $featured_class = '';
        }
        
        $this->add_render_attribute(
            'wrapper',
            [
                'class' => 'gold-addons-price-box '
            ]
        );
    ?>
    <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
        <div class="ga-pricing-item<?php echo $featured_class; ?>">
            <div class="ga-pricing-deco">
                <svg class="ga-pricing-deco-img" enable-background="new 0 0 300 100" height="100px" id="Layer_1" preserveAspectRatio="none" version="1.1" viewBox="0 0 300 100" width="300px" x="0px" xml:space="preserve" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" y="0px">
                    <path class="ga-deco-layer ga-deco-layer--1" d="M30.913,43.944c0,0,42.911-34.464,87.51-14.191c77.31,35.14,113.304-1.952,146.638-4.729c48.654-4.056,69.94,16.218,69.94,16.218v54.396H30.913V43.944z" fill="#FFFFFF" opacity="0.6"></path>
                    <path class="ga-deco-layer ga-deco-layer--2" d="M-35.667,44.628c0,0,42.91-34.463,87.51-14.191c77.31,35.141,113.304-1.952,146.6394.729c48.653-4.055,69.939,16.218,69.939,16.218v54.396H-35.667V44.628z" fill="#FFFFFF" opacity="0.6"></path>
                    <path class="ga-deco-layer ga-deco-layer--3" d="M43.415,98.342c0,0,48.283-68.927,109.133-68.927c65.886,0,97.983,67.914,97.983,67.914v3.716H42.401L43.415,98.342z" fill="#FFFFFF" opacity="0.7"></path>
                    <path class="ga-deco-layer ga-deco-layer--4" d="M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z" fill="#FFFFFF"></path>
                </svg>
                <div class="ga-pricing-price">
                    <span class="ga-pricing-currency"><?php echo esc_html( $currency ); ?></span><?php echo esc_html( $price ); ?><span class="ga-pricing-period"><?php echo esc_html( $period ); ?></span>
                </div>
                <h3 class="ga-pricing-title"><?php echo esc_html( $title ); ?></h3>
            </div>
            <?php if( $features ): ?>
            <ul class="ga-pricing-feature-list">
                <?php foreach( $features as $feature ): 
        
                    $href['wrapper_start'] = '';
                    $href['wrapper_end'] = '';
                    
                    if( ! empty( $feature['link']['url'] ) ) {
                        
                        $href['wrapper_start'] = '<a href="'. esc_url( $feature['link']['url'] ) .'"';
                        
                        // External URL
                        if( $feature['link']['is_external'] == 'on' ) {
                            $href['wrapper_start'] .= ' target="_blank"';
                        }
                        
                        // Nofollow URL
                        if( $feature['link']['nofollow'] == 'on' ) {
                            $href['wrapper_start'] .= ' rel="nofollow"';
                        }
                        
                        $href['wrapper_start'] .= '>';
                        
                        $href['wrapper_end'] = '</a>';
                    }
                
                ?>
                <li class="ga-pricing-feature">
                    <?php echo $href['wrapper_start']; ?>
                        <i class="<?php echo esc_attr( $feature['icon'] ); ?>"></i> <?php echo esc_html( $feature['text'] ); ?>
                    <?php echo $href['wrapper_end']; ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            
            <?php if( ! empty( $button_title ) ): ?>
            <a href="<?php echo $btn_url; ?>" class="ga-pricing-action" <?php echo $btn_target . $btn_nofollow; ?>>
                <?php echo esc_html( $button_title ); ?>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <?php
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
