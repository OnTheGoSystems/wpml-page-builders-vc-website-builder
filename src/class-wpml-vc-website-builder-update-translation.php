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
}