<?php

/**
 * Class Test_WPML_VC_Website_Builder_Data_Settings
 *
 * @group page-builders
 * @group vc-website-builder
 * @group wpmlcore-5165
 */
class Test_WPML_VC_Website_Builder_Data_Settings extends OTGS_TestCase {

	/**
	 * @test
	 */
	public function it_gets_meta_field() {
		$subject = new WPML_VC_Website_Builder_Data_Settings();
		$this->assertEquals( 'vcv-pageContent', $subject->get_meta_field() );
	}

	/**
	 * @test
	 */
	public function it_gets_node_id_field() {
		$subject = new WPML_VC_Website_Builder_Data_Settings();
		$this->assertEquals( 'id', $subject->get_node_id_field() );
	}

	/**
	 * @test
	 */
	public function it_gets_field_to_copy() {
		$fields_to_copy = array(
			'vcvSourceAssetsFiles',
			'vcvSourceCss',
			'vcvSettingsSourceCustomCss',
			'vcv-globalElementsCssData',
			'vcvSourceCssFileUrl',
			'vcvSourceCssFileHash',
			'vcv-settingsLocalJs',
		);

		$subject = new WPML_VC_Website_Builder_Data_Settings();
		$this->assertEquals( $fields_to_copy, $subject->get_fields_to_copy() );
	}

	/**
	 * @test
	 */
	public function it_converts_data_to_array() {
		$data = array(
			'id'        => mt_rand(),
			'something' => rand_str( 10 ),
		);

		$subject = new WPML_VC_Website_Builder_Data_Settings();
		$this->assertEquals( $data, $subject->convert_data_to_array( array( json_encode( $data ) ) ) );
	}

	/**
	 * @test
	 */
	public function it_prepares_data_for_saving() {
		$data = array(
			'id'        => mt_rand(),
			'something' => rand_str( 10 ),
		);

		\WP_Mock::wpFunction( 'wp_json_encode', array(
			'args'   => array( $data ),
			'return' => json_encode( $data ),
		) );

		$subject = new WPML_VC_Website_Builder_Data_Settings();
		$this->assertEquals( urlencode( json_encode( $data ) ), $subject->prepare_data_for_saving( $data ) );
	}

	/**
	 * @test
	 */
	public function it_gets_pb_name() {
		$subject = new WPML_VC_Website_Builder_Data_Settings();
		$this->assertEquals( 'Visual Composer Website Builder', $subject->get_pb_name() );
	}

	/**
	 * @test
	 */
	public function it_gets_field_to_save() {
		$fields_to_copy = array( 'vcv-pageContent' );

		$subject = new WPML_VC_Website_Builder_Data_Settings();
		$this->assertEquals( $fields_to_copy, $subject->get_fields_to_save() );
	}
}