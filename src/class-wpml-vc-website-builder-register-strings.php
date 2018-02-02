<?php

/**
 * Class WPML_VC_Website_Builder_Register_Strings
 */
class WPML_VC_Website_Builder_Register_Strings extends WPML_Page_Builders_Register_Strings {

	/**
	 * @param array $data_array
	 * @param array $package
	 */
	protected function register_strings_for_modules( array $data_array, array $package ) {
		foreach ( $data_array['elements'] as $element ) {
			if ( ! in_array( $element['tag'], array( 'row', 'column' ), true ) ) {
				$this->register_strings_for_node( $element[ $this->data_settings->get_node_id_field() ], $element, $package );
			}
		}
	}
}