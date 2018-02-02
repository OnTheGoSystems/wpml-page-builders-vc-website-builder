<?php

/**
 * Class WPML_Beaver_Builder_Update_Translation
 */
class WPML_VC_Website_Builder_Update_Translation extends WPML_Page_Builders_Update_Translation {

	/** @param array $data_array */
	public function update_strings_in_modules( array &$data_array ) {
		foreach ( $data_array['elements'] as &$element ) {
			if ( ! in_array( $element['tag'], array( 'row', 'column' ), true ) ) {
				$element = $this->update_strings_in_node( $element[ $this->data_settings->get_node_id_field() ], $element );
			}
		}
	}

	/**
	 * @param string $node_id
	 * @param $settings
	 *
	 * @return mixed
	 */
	public function update_strings_in_node( $node_id, $settings ) {
		$strings = $this->translatable_nodes->get( $node_id, $settings );
		foreach ( $strings as $string ) {
			$translation = $this->get_translation( $string );
			$settings    = $this->translatable_nodes->update( $node_id, $settings, $translation );
		}

		return $settings;
	}
}