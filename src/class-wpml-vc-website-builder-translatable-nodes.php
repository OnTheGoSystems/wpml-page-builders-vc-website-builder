<?php

/**
 * Class WPML_VC_Website_Builder_Translatable_Nodes
 */
class WPML_VC_Website_Builder_Translatable_Nodes implements IWPML_Page_Builders_Translatable_Nodes {

	const SETTINGS_FIELD = 'settings';

	/**
	 * @var string
	 */
	private $settings_field;

	/**
	 * @var string
	 */
	private $type;

	/** @var array */
	private $nodes_to_translate;

	public function __construct() {
		$this->settings_field = self::SETTINGS_FIELD;
		$this->type           = 'tag';
	}

	/**
	 * @param string|int $node_id
	 * @param array $settings
	 *
	 * @return WPML_PB_String[]
	 */
	public function get( $node_id, $settings ) {

		if ( ! $this->nodes_to_translate ) {
			$this->initialize_nodes_to_translate();
		}

		$strings = array();

		foreach ( $this->nodes_to_translate as $node_type => $node_data ) {
			if ( $this->conditions_ok( $node_data, $settings ) ) {
				foreach ( $node_data['fields'] as $field ) {
					$field_key = $field['field'];
					if ( isset( $settings[ $field_key ] ) && trim( $settings[ $field_key ] ) ) {

						$string = new WPML_PB_String(
							$settings[ $field_key ],
							$this->get_string_name( $node_id, $field, $settings ),
							$field['type'],
							$field['editor_type']
						);

						$strings[] = $string;
					}
				}
				if ( isset( $node_data['integration-class'] ) ) {
					try {
						$node    = new $node_data['integration-class']();
						$strings = $node->get( $node_id, $settings, $strings );
					} catch ( Exception $e ) {
					}
				}
			}
		}

		return $strings;
	}

	/**
	 * @param string $node_id
	 * @param array $settings
	 * @param WPML_PB_String $string
	 *
	 * @return array
	 */
	public function update( $node_id, $settings, WPML_PB_String $string ) {

		if ( ! $this->nodes_to_translate ) {
			$this->initialize_nodes_to_translate();
		}

		foreach ( $this->nodes_to_translate as $node_type => $node_data ) {
			if ( $this->conditions_ok( $node_data, $settings ) ) {
				foreach ( $node_data['fields'] as $field ) {
					$field_key = $field['field'];
					if ( $this->get_string_name( $node_id, $field, $settings ) == $string->get_name() ) {
						$settings[ $field_key ] = $string->get_value();
					}
				}
				if ( isset( $node_data['integration-class'] ) ) {
					try {
						$node = new $node_data['integration-class']();
						$node->update( $node_id, $settings, $string );
					} catch ( Exception $e ) {

					}
				}
			}
		}

		return $settings;
	}

	/**
	 * @param string $node_id
	 * @param array $field
	 * @param array $settings
	 *
	 * @return string
	 */
	public function get_string_name( $node_id, $field, $settings ) {
		return $field['field'] . '-' . $settings[ $this->type ] . '-' . $node_id;
	}

	/**
	 * @param array $node_data
	 * @param array $settings
	 *
	 * @return bool
	 */
	private function conditions_ok( $node_data, $settings ) {
		$conditions_meet = true;
		foreach ( $node_data['conditions'] as $field_key => $field_value ) {
			if ( ! isset( $settings[ $field_key ] ) || $settings[ $field_key ] != $field_value ) {
				$conditions_meet = false;
				break;
			}
		}

		return $conditions_meet;
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