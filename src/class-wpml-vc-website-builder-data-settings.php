<?php

class WPML_VC_Website_Builder_Data_Settings implements IWPML_Page_Builders_Data_Settings {

	/**
	 * @return string
	 */
	public function get_meta_field() {
		return 'vcv-pageContent';
	}

	/**
	 * @return string
	 */
	public function get_node_id_field() {
		return 'id';
	}

	/**
	 * @return array
	 */
	public function get_fields_to_copy() {
		return array(
			'vcvSourceAssetsFiles',
			'vcvSourceCss',
			'vcvSettingsSourceCustomCss',
			'vcv-globalElementsCssData',
			'vcvSourceCssFileUrl',
			'vcvSourceCssFileHash',
			'vcv-settingsLocalJs',
		);
	}

	/**
	 * @param mixed $data
	 *
	 * @return array
	 */
	public function convert_data_to_array( $data ) {
		return json_decode( urldecode( is_array( $data ) ? $data[0] : $data ), true );
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public function prepare_data_for_saving( array $data ) {
		return urlencode( wp_json_encode( $data ) );
	}

	/**
	 * @return string
	 */
	public function get_pb_name() {
		return 'Visual Composer Website Builder';
	}

	/**
	 * @return array
	 */
	public function get_fields_to_save() {
		return array( 'vcv-pageContent' );
	}

	public function add_hooks() {}
}