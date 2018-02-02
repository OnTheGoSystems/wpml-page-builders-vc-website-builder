<?php

/**
 * Class Test_WPML_VC_Website_Builder_Register_Strings
 *
 * @group page-builders
 * @group vc-website-builder
 * @group wpmlcore-5165
 */
class Test_WPML_VC_Website_Builder_Register_Strings extends WPML_PB_TestCase2 {

	/**
	 * @test
	 */
	public function it_registers_strings() {
		list( $name, $post, $package ) = $this->get_post_and_package( 'VC_Website_Builder' );
		$node_id  = mt_rand() . '-node-id';
		$settings = array(
			'id'     => $node_id,
			'tag'    => 'textBlock',
			'output' => '',
		);
		$string   = new WPML_PB_String( rand_str(), rand_str(), rand_str(), rand_str() );
		$strings  = array( $string );

		$data = array(
			'elements' => array(
				array(
					'id'     => $node_id,
					'tag'    => 'textBlock',
					'output' => '',
				),
			),
		);

		\WP_Mock::wpFunction( 'get_post_meta', array(
			'times'  => 1,
			'args'   => array( $post->ID, 'vcv-pageContent', false ),
			'return' => array( urlencode( json_encode( $data ) ) ),
		) );

		WP_Mock::expectAction( 'wpml_start_string_package_registration', $package );
		WP_Mock::expectAction( 'wpml_delete_unused_package_strings', $package );

		$translatable_nodes = $this->getMockBuilder( 'WPML_VC_Website_Builder_Translatable_Nodes' )
		                           ->setMethods( array( 'get', 'initialize_nodes_to_translate' ) )
		                           ->disableOriginalConstructor()
		                           ->getMock();
		$translatable_nodes->expects( $this->once() )
		                   ->method( 'get' )
		                   ->with( $node_id, $settings )
		                   ->willReturn( $strings );

		$data_settings = $this->getMockBuilder( 'WPML_VC_Website_Builder_Data_Settings' )
		                      ->disableOriginalConstructor()
		                      ->getMock();

		$data_settings->method( 'get_meta_field' )
		              ->willReturn( 'vcv-pageContent' );

		$data_settings->method( 'get_node_id_field' )
		              ->willReturn( 'id' );

		$data_settings->method( 'convert_data_to_array' )
		              ->with( array( urlencode( json_encode( $data ) ) ) )
		              ->willReturn( json_decode( json_encode( $data ), true ) );

		$string_registration = $this->getMockBuilder( 'WPML_PB_String_Registration' )
		                            ->setMethods( array( 'register_string' ) )
		                            ->disableOriginalConstructor()
		                            ->getMock();

		$string_registration->expects( $this->once() )
		                    ->method( 'register_string' )
		                    ->with(
			                    $package['post_id'],
			                    $string->get_value(),
			                    $string->get_editor_type(),
			                    $string->get_title(),
			                    $string->get_name() );

		$subject = new WPML_VC_Website_Builder_Register_Strings( $translatable_nodes, $data_settings, $string_registration );
		$subject->register_strings( $post, $package );
	}
}