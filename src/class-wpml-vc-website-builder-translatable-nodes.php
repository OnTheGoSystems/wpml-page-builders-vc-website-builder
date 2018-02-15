<?php

/**
 * Class WPML_VC_Website_Builder_Translatable_Nodes
 */
class WPML_VC_Website_Builder_Translatable_Nodes extends WPML_Page_Builders_Translatable_Nodes {

	const SETTINGS_FIELD = 'settings';

	/**
	 * @var string
	 */
	private $settings_field;

	/**
	 * @var string
	 */
	private $type;

	public function __construct() {
		$this->settings_field = self::SETTINGS_FIELD;
		$this->type           = 'tag';
	}

	/**
	 * @param array $settings
	 * @param string $field_key
	 *
	 * @return string
	 */
	public function get_field_value( $settings, $field_key ) {
		return isset( $settings[ $field_key ] ) ? $settings[ $field_key ] : '';
	}

	/**
	 * @param array $settings
	 *
	 * @return string
	 */
	public function get_type( $settings ) {
		return isset( $settings[ $this->type ] ) ? $settings[ $this->type ] : '';
	}

	/**
	 * @param array $settings
	 * @param string $field_key
	 * @param WPML_PB_String $string
	 *
	 * @return array
	 */
	public function update_field_value( $settings, $field_key, $string ) {
		$settings[ $field_key ] = $string->get_value();
		return $settings;
	}

	public function initialize_nodes_to_translate() {

		$this->nodes_to_translate = array(
			'textBlock'   => array(
				'conditions' => array( $this->type => 'textBlock' ),
				'fields'     => array(
					array(
						'field'       => 'output',
						'type'        => __( 'Text editor', 'wpml-string-translation' ),
						'editor_type' => 'VISUAL'
					),
				),
			),
			'feature' => array(
				'conditions' => array( $this->type => 'feature' ),
				'fields'     => array(
					array(
						'field'       => 'description',
						'type'        => __( 'Feature', 'wpml-string-translation' ),
						'editor_type' => 'VISUAL'
					),
				),
			),
			'featureSection' => array(
				'conditions' => array( $this->type => 'featureSection' ),
				'fields'     => array(
					array(
						'field'       => 'description',
						'type'        => __( 'Feature Section', 'wpml-string-translation' ),
						'editor_type' => 'VISUAL'
					),
				),
			),
			'heroSection' => array(
				'conditions' => array( $this->type => 'heroSection' ),
				'fields'     => array(
					array(
						'field'       => 'description',
						'type'        => __( 'Hero Section', 'wpml-string-translation' ),
						'editor_type' => 'VISUAL'
					),
				),
			),
			'outlineButton' => array(
				'conditions' => array( $this->type => 'outlineButton' ),
				'fields'     => array(
					array(
						'field'       => 'buttonText',
						'type'        => __( 'Outline Button', 'wpml-string-translation' ),
						'editor_type' => 'LINE'
					),
				),
			),
			'faqToggle' => array(
				'conditions' => array( $this->type => 'faqToggle' ),
				'fields'     => array(
					array(
						'field'       => 'textBlock',
						'type'        => __( 'Faq Toggle: Text Block', 'wpml-string-translation' ),
						'editor_type' => 'VISUAL'
					),
					array(
						'field'       => 'titleText',
						'type'        => __( 'Faq Toggle: Title Text', 'wpml-string-translation' ),
						'editor_type' => 'LINE'
					),
				),
			),
			'basicButton' => array(
				'conditions' => array( $this->type => 'basicButton' ),
				'fields'     => array(
					array(
						'field'       => 'buttonText',
						'type'        => __( 'Basic button', 'wpml-string-translation' ),
						'editor_type' => 'LINE'
					),
				),
			),
			'separatorTitle' => array(
				'conditions' => array( $this->type => 'separatorTitle' ),
				'fields'     => array(
					array(
						'field'       => 'title',
						'type'        => __( 'Separator Title', 'wpml-string-translation' ),
						'editor_type' => 'LINE'
					),
				),
			),
			'featureDescription' => array(
				'conditions' => array( $this->type => 'featureDescription' ),
				'fields'     => array(
					array(
						'field'       => 'description',
						'type'        => __( 'Feature Description', 'wpml-string-translation' ),
						'editor_type' => 'VISUAL'
					),
				),
			),
		);

		$this->nodes_to_translate = apply_filters( 'wpml_vc_website_builder_modules_to_translate', $this->nodes_to_translate );
	}
}