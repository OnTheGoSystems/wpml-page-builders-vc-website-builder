<?php

/**
 * Class WPML_VC_Website_Builder_Translatable_Nodes
 */
class WPML_VC_Website_Builder_Translatable_Nodes extends WPML_Page_Builders_Translatable_Nodes implements IWPML_Page_Builders_Translatable_Nodes {

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
			'basicButton' => array(
				'conditions' => array( $this->type => 'basicButton' ),
				'fields'     => array(
					array(
						'field'       => 'buttonText',
						'type'        => __( 'Basic button', 'wpml-string-translation' ),
						'editor_type' => 'VISUAL'
					),
				),
			),
		);

		$this->nodes_to_translate = apply_filters( 'wpml_vc_website_builder_modules_to_translate', $this->nodes_to_translate );
	}
}