<?php

namespace GoldAddons;

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * GoldAddons Modal Widget.
 *
 * Elementor widget that inserts an modal content into the page.
 *
 * @since 1.0.0
 */
final class Widget_Modal extends \Elementor\Widget_Base {
    
    /**
	 * Get widget name.
	 *
	 * Retrieve modal widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
    public function get_name() {
		return 'goldaddons-modal';
	}
    
    /**
	 * Get widget title.
	 *
	 * Retrieve modal widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
    public function get_title() {
		return esc_attr__( '(GA) Modal', 'gold-addons-for-elementor' );
	}
    
    /**
	 * Get widget icon.
	 *
	 * Retrieve modal widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
    public function get_icon() {
		return 'fa fa-clone';
	}
    
    /**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the modal widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'gold-addons-for-elementor' ];
	}
    
    /**
	 * Get modal sizes.
	 *
	 * Retrieve an array of modal sizes for the modal widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 * @return array An array containing modal sizes.
	 */
	public static function get_modal_sizes() {
		return [
			'modal-sm' => esc_attr__( 'Small', 'gold-addons-for-elementor' ),
			'modal-df' => esc_attr__( 'Default', 'gold-addons-for-elementor' ),
			'modal-lg' => esc_attr__( 'Large', 'elementor' )
		];
	}
    
    /**
	 * Register modal widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
        
        ##############################
        # CALLBACK SECTION
        ##############################
        $this->start_controls_section(
			'callback_section',
			[
				'label' => esc_attr__( 'Callback', 'gold-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
            
        $this->add_control(
            'callback_type',
            [
                'label' => esc_attr__( 'Callback Type', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'link' => esc_attr__( 'Link', 'gold-addons-for-elementor' ),
                    'button' => esc_attr__( 'Button', 'gold-addons-for-elementor' )
                ],
                'default' => 'link'
            ]
        );

        $this->add_control(
            'callback_text',
            [
                'label' => esc_attr__( 'Callback Text', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_attr__( 'Click Here', 'gold-addons-for-elementor' ),
                'default' => esc_attr__( 'Open Modal', 'gold-addons-for-elementor' ),
                'separator' => 'before'
            ]
        );
        
        $this->add_responsive_control(
			'align',
			[
				'label' => esc_attr__( 'Alignment', 'gold-addons-for-elementor' ),
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
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);
        
        $this->end_controls_section();
        
        ##############################
        # CONTENT SECTION
        ##############################
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_attr__( 'Content', 'gold-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'callback_id',
			[
				'label' => esc_attr__( 'Modal ID', 'gold-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => esc_attr__( 'unique_callback_name', 'gold-addons-for-elementor' ),
                'separator' => 'after'
			]
		);
        
        $this->add_control(
            'title',
            [
                'label' => esc_attr__( 'Modal Title', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'default' => esc_attr__( 'GoldAddons Modal', 'gold-addons-for-elementor' )
            ]
        );
        
        $this->add_control(
            'size',
            [
                'label' => esc_attr__( 'Modal Size', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => self::get_modal_sizes(),
                'default' => 'modal-df',
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
            'content',
            [
                'label' => esc_attr__( 'Modal Content', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'placeholder' => esc_html__( 'Add custom content...', 'gold-addons-for-elementor' ),
                'separator' => 'before'
            ]
        );
        
        $this->add_responsive_control(
			'modal_content_align',
			[
				'label' => esc_attr__( 'Content Alignment', 'gold-addons-for-elementor' ),
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
					],
				],
				'selectors' => [
                    '{{WRAPPER}} .modal-content' => 'text-align: {{VALUE}};',
                ],
				'default' => '',
			]
		);

		$this->end_controls_section();
        
        ##############################
        # STYLE SECTION
        ##############################
        $this->start_controls_section(
            'link_styling_tab',
            [
                'label' => esc_attr__( 'Link Styling', 'gold-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'callback_type' => 'link'
                ]
            ]
        );    
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'link_typography',
                'label' => esc_attr__( 'Typography', 'gold-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .ga-link',
                'separator' => 'before'
            ]
        );

        $this->start_controls_tabs(
            'link_styling_tabs'
        );

        $this->start_controls_tab(
            'link_styling_normal_tab',
            [
                'label' => esc_attr__( 'Normal', 'gold-addons-for-elementor' )
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label' => esc_attr__( 'Text Color', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.ga-link' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->end_controls_tab();
        
        $this->start_controls_tab(
            'link_styling_hover_tab',
            [
                'label' => esc_attr__( 'Hover', 'gold-addons-for-elementor' )
            ]
        );
        
        $this->add_control(
            'link_hover_color',
            [
                'label' => esc_attr__( 'Text Color', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ga-link:hover' => 'color: {{VALUE}}'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section(); // End link styling tab.

        ##########################
        # BUTTON STYLING TAB
        ##########################
        $this->start_controls_section(
            'button_styling_tab',
            [
                'label' => esc_attr__( 'Button Styling', 'gold-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'callback_type' => 'button'
                ]
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => esc_attr__( 'Typography', 'gold-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} a.btn',
                'separator' => 'before'
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
            'button_normal_color',
            [
                'label' => esc_attr__( 'Text Color', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ga-button' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'button_normal_bg_color',
            [
                'label' => esc_attr__( 'Background Color', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ga-button' => 'background-color: {{VALUE}}'
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
            'button_hover_color',
            [
                'label' => esc_attr__( 'Text Color', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ga-button:hover' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'button_hover_bg_color',
            [
                'label' => esc_attr__( 'Background Color', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors'  => [
                    '{{WRAPPER}} .ga-button:hover' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .ga-button',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_attr__( 'Border Radius', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'padding',
            [
                'label' => esc_attr__( 'Padding', 'gold-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .ga-button' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->end_controls_section(); // End button styling tab.
	}
    
    /**
	 * Render modal widget output on the frontend.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
        
		$settings = $this->get_settings_for_display();
        extract( $settings );
        
        /**
         * If $callback_id isset 
         * else generate modal unique callback id.
         */
        if( $callback_id ) {
            $callback_id = str_replace( ' ', '_', $callback_id ); // Remove empty space from callback.
            $callback_id = 'goldaddons-modal-' . esc_attr( $callback_id );
        } else {
            $callback_id = 'goldaddons-modal-' . esc_attr( uniqid() );
        }
        
        $this->add_render_attribute(
            'wrapper',
            [
                'id'        => $callback_id,
                'class'     => [ 'goldaddons-modal', 'modal fade' ],
                'tabindex'  => '-1',
                'role'      => 'dialog'
            ]
        ); 
        
        if( $callback_type == 'link' ) {
            $this->add_render_attribute(
                'data_attributes',
                [
                    'href'        => '#',
                    'data-toggle' => 'modal',
                    'data-target' => '#' . $callback_id,
                    'class'       => 'ga-link goldaddons-modal-trigger'
                ]
            ); 
        }
        else
        if( $callback_type == 'button' ) {
            $this->add_render_attribute(
                'data_attributes',
                [
                    'data-toggle'   => 'modal',
                    'data-target'   => '#' . $callback_id,
                    'class'         => 'ga-button goldaddons-modal-trigger'
                ]
            );
        }
        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div class="modal-dialog <?php echo esc_attr( $size ); ?>" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><?php esc_html_e( $title ); ?></h4>
                        <button class="close" type="button" data-dismiss="modal" aria-label="<?php esc_html_e( 'Close', 'gold-addons-for-elementor' ); ?>">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo $content; ?>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary btn-sm" type="button" data-dismiss="modal">
                            <?php esc_html_e( 'Close', 'gold-addons-for-elementor' ); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php if( in_array( $callback_type, array( 'link', 'button' ) ) && ! empty( $callback_text ) ): ?>
        <a <?php echo $this->get_render_attribute_string( 'data_attributes' ); ?>>
            <?php echo esc_html( $callback_text ); ?>
        </a>
        <?php endif;
	}
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
