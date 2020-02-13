<?php

namespace GoldAddons;

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * GoldAddons Team Widget
 *
 * Elementor widget that inserts an team content into the page.
 *
 * @since 1.0.1
 */
final class Widget_Team extends \Elementor\Widget_Base {
    
    /**
	 * Get widget name.
	 *
	 * Retrieve team widget name.
	 *
	 * @since 1.0.1
	 * @access public
	 * @return string Widget name.
	 */
    public function get_name() {
		return 'gold-addons-team';
	}
    
    /**
	 * Get widget title.
	 *
	 * Retrieve team widget title.
	 *
	 * @since 1.0.1
	 * @access public
	 * @return string Widget title.
	 */
    public function get_title() {
		return esc_attr__( '(GA) Team', 'gold-addons-for-elementor' );
	}
    
    /**
	 * Get widget icon.
	 *
	 * Retrieve team widget icon.
	 *
	 * @since 1.0.1
	 * @access public
	 * @return string Widget icon.
	 */
    public function get_icon() {
		return 'fa fa-address-card-o';
	}
    
    /**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the team widget belongs to.
	 *
	 * @since 1.0.1
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'gold-addons-for-elementor' ];
	}
    
    /**
	 * Register team widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.1
	 * @access protected
	 */
	protected function _register_controls() {
        
        $this->start_controls_section(
			'content',
			[
				'label' => esc_attr__( 'Content', 'gold-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
            'image',
            [
                'label' => esc_attr__( 'Add Image', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src()
                ]
            ]
        );
        
        $this->add_control(
            'image_dimension',
            [
                'label' => esc_attr__( 'Image Dimension', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::IMAGE_DIMENSIONS,
                'default' => [
                    'width' => '150',
                    'height' => '150'
                ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'width: {{WIDTH}}px; height: {{HEIGHT}}px;'
                ],
                'condition' => [
                    'style' => [ 'simple-v', 'simple-h' ]
                ]
            ]
        );
        
        $this->add_control(
            'wrapper_dimension',
            [
                'label' => esc_attr__( 'Image Dimension', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::IMAGE_DIMENSIONS,
                'default' => [
                    'width' => '260',
                    'height' => 'auto'
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'width: {{WIDTH}}px; height: {{HEIGHT}}px;'
                ],
                'condition' => [
                    'style' => 'card'
                ]
            ]
        );
        
        $this->add_control(
            'style',
            [
                'label' => esc_attr__( 'Style', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'simple-v' => esc_attr__( 'Simple Vertical', 'gold-addons-for-elementor' ),
                    'simple-h' => esc_attr__( 'Simple Horizontal', 'gold-addons-for-elementor' ),
                    'card' => esc_attr__( 'Card', 'gold-addons-for-elementor' )
                ],
                'default' => 'simple-v',
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
            'name',
            [
                'label' => esc_attr__( 'Person Name', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'John Doe',
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
            'subtitle',
            [
                'label' => esc_attr__( 'Position', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Founder, CEO',
                'separator' => 'before'
            ]
        );
        
        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'text',
			[
				'label' => esc_attr__( 'Text', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_attr__( 'Social Icon', 'gold-addons-for-elementor' ),
				'default' => esc_attr__( 'Social Icon', 'gold-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'icon',
			[
				'label' => esc_attr__( 'Icon', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICON,
				'label_block' => true,
				'default' => 'fa fa-facebook',
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
			'icons',
			[
				'label' => esc_attr__( 'Social Icons', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'text' => esc_attr__( 'Facebook', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-facebook',
					],
					[
						'text' => esc_attr__( 'Twitter', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-twitter',
					],
					[
						'text' => esc_attr__( 'Google+', 'gold-addons-for-elementor' ),
						'icon' => 'fa fa-google-plus',
					],
				],
				'title_field' => '<i class="{{ icon }}" aria-hidden="true"></i> {{{ text }}}',
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
        
        $this->add_control(
			'name_color',
			[
				'label' => esc_attr__( 'Name Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-team-name' => 'color: {{VALUE}};',
				],
			]
		);
        
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'label' => esc_attr__( 'Name Typography', 'gold-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .ga-team-name'
			]
		);
        
        $this->add_control(
			'position_color',
			[
				'label' => esc_attr__( 'Position Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ga-team-position' => 'color: {{VALUE}};',
				],
                'separator' => 'before'
			]
		);
        
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'position_typography',
				'label' => esc_attr__( 'Position Typography', 'gold-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .ga-team-position'
			]
		);
        
        $this->add_control(
			'simple_v_color',
			[
				'label' => esc_attr__( 'Border Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} img' => 'border-color: {{VALUE}};',
				],
                'condition' => [
                    'style' => 'simple-v'  
                ],
                'separator' => 'before'
			]
		);
        
        $this->add_control(
			'simple_h_border_color',
			[
				'label' => esc_attr__( 'Border Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} img' => 'border-color: {{VALUE}};',
				],
                'condition' => [
                    'style' => 'simple-h'  
                ],
                'separator' => 'before'
			]
		);
        
        $this->add_control(
			'card_border_color',
			[
				'label' => esc_attr__( 'Border Color', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gold-addons-team.ga-team-card' => 'border-color: {{VALUE}};',
				],
                'condition' => [
                    'style' => 'card'  
                ],
                'separator' => 'before'
			]
		);
        
        $this->end_controls_section();
    }
    
    /**
	 * Render team widget output on the frontend.
	 *
	 * @since 1.0.1
	 * @access protected
	 */
	protected function render() {
        
		$settings = $this->get_settings_for_display();
        extract( $settings );
        
        if( $style == 'simple-v' ) {
            $class = 'ga-team-simple-v';
            $wrapper['start'] = '';
            $wrapper['end'] = '';
            $wrapper['info_start'] = '';
            $wrapper['info_end'] = '';
            $heading = 'h6';
        }
        else
        if( $style == 'simple-h' ) {
            $class = 'ga-team-simple-h';
            $wrapper['start'] = '<div class="ga-d-table">';
            $wrapper['end'] = '</div>';
            $wrapper['info_start'] = '<div class="ga-team-info">';
            $wrapper['info_end'] = '</div>';
            $heading = 'h6';
        } else {
            $class = 'ga-team-card';
            $wrapper['start'] = '<div class="ga-card">';
            $wrapper['end'] = '</div>';
            $wrapper['info_start'] = '<div class="ga-team-info">';
            $wrapper['info_end'] = '</div>';
            $heading = 'h5';
        }
        
        $this->add_render_attribute(
            'wrapper',
            [
                'class' => 'gold-addons-team ' . esc_attr( $class )
            ]
        );
        
        $this->add_render_attribute(
            'href',
            [
                'data-toggle' => 'tooltip',
                'data-placement' => 'top'
            ]
        );
    ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            
            <?php echo $wrapper['start']; ?>
            
                <img src="<?php echo esc_url( $image['url']); ?>" alt="">
                
                <?php echo $wrapper['info_start']; ?>
                
                <?php if( $heading ): ?>
            
                    <<?php echo $heading; ?> class="ga-team-name"><?php echo esc_html( $name ); ?></<?php echo $heading; ?>>
            
                <?php endif; ?>
                
                <?php if( $subtitle ): ?>
                
                    <p class="ga-team-position"><?php echo esc_html( $subtitle ); ?></p>
            
                <?php endif; ?>
                
                <?php if( $icons ): ?>
                
                    <div class="ga-social-bar">
                        <?php foreach( $icons as $item ): $class = str_replace( 'fa fa-', 'ga-', $item['icon'] ); ?>
                            
                            <a href="<?php echo esc_attr( $item['link']['url'] ); ?>" 
                               <?php echo $this->get_render_attribute_string( 'href' ); ?> 
                               title="<?php echo esc_html( $item['text'] ); ?>" 
                               class="ga-social-button <?php echo $class; ?> ga-rounded-circle">
                            <i class="<?php echo esc_attr( $item['icon'] ); ?>"></i>
                        </a>
                            
                        <?php endforeach; ?>
                    </div>
            
                <?php endif; ?>
                
                <?php echo $wrapper['info_end']; ?>
            
            <?php echo $wrapper['end']; ?>
            
        </div>
    <?php
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
