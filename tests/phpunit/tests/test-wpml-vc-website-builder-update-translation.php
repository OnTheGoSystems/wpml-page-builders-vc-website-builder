<?php

/**
 * Class Test_WPML_VC_Website_Builder_Update_Translations
 *
 * @group page-builders
 * @group vc-website-builder
 * @group wpmlcore-5165
 */
class Test_WPML_VC_Website_Builder_Update_Translations extends OTGS_TestCase {

	/**
	 * @test
	 */
	public function it_updates_translations() {

		\WP_Mock::wpPassthruFunction( '__' );

		$node_id                   = mt_rand();
		$translated_post_id        = mt_rand();
		$original_post_id          = mt_rand();
		$original_post             = (object) array( 'ID' => $original_post_id );
		$lang                      = 'en';
		$translation               = 'translation-value';
		$translated_editor_element = 'translated-editor-field-value';
		$string_translations       = array(
			'output-textBlock-' . $node_id => array(
				$lang => array(
					'status' => 10,
					'value'  => $translation
				)
			)
		);

		$element = array(
			'id'     => $node_id,
			'tag'    => 'textBlock',
			'output' => 'output field value',
		);

		$translated_element = array(
			'id'     => $node_id,
			'tag'    => 'textBlock',
			'output' => $translated_editor_element,
		);

		$data['elements'] = array(
			array(
				'id'     => $node_id,
				'tag'    => 'textBlock',
				'output' => 'output field value',
			),
		);

		$translated_data['elements'] = array(
			array(
				'id'     => $node_id,
				'tag'    => 'textBlock',
				'output' => $translated_editor_element,
			),
		);

		\WP_Mock::wpFunction( 'get_post_meta', array(
			'times'  => 1,
			'args'   => array( $original_post_id, 'vcv-pageContent', true ),
			'return' => $data,
		) );

		\WP_Mock::wpFunction( 'update_post_meta', array(
			'times' => 1,
			'args'  => array( $translated_post_id, 'vcv-pageContent', $translated_data ),
		) );

		$this->add_copy_meta_fields_checks( $translated_post_id, $original_post_id );

		$translatable_nodes = $this->getMockBuilder( 'WPML_VC_Website_Builder_Translatable_Nodes' )
		                           ->setMethods( array( 'update' ) )
		                           ->getMock();
		$translatable_nodes->expects( $this->once() )
		                   ->method( 'update' )
		                   ->with( $node_id, $element )
		                   ->willReturn( $translated_element );

		$data_settings = $this->getMockBuilder( 'WPML_VC_Website_Builder_Data_Settings' )
		                      ->disableOriginalConstructor()
		                      ->getMock();

		$data_settings->method( 'get_meta_field' )
		              ->willReturn( 'vcv-pageContent' );

		$data_settings->method( 'get_node_id_field' )
		              ->willReturn( 'id' );

		$data_settings->method( 'get_fields_to_copy' )
		              ->willReturn( array(
			              'vcvSourceAssetsFiles',
			              'vcvSourceCss',
			              'vcvSettingsSourceCustomCss',
			              'vcv-globalElementsCssData',
			              'vcvSourceCssFileUrl',
			              'vcvSourceCssFileHash',
			              'vcv-settingsLocalJs',
		              ) );

		$data_settings->method( 'convert_data_to_array' )
		              ->with( $data )
		              ->willReturn( $data );

		$data_settings->method( 'prepare_data_for_saving' )
		              ->with( $translated_data )
		              ->willReturn( $translated_data );

		$data_settings->method( 'get_fields_to_save' )
		              ->willReturn( array( 'vcv-pageContent' ) );

		$subject = new WPML_VC_Website_Builder_Update_Translation( $translatable_nodes, $data_settings );
		$subject->update( $translated_post_id, $original_post, $string_translations, $lang );
	}

	private function add_copy_meta_fields_checks( $translated_post_id, $original_post_id ) {
		foreach (
			array(
				'vcvSourceAssetsFiles',
				'vcvSourceCss',
				'vcvSettingsSourceCustomCss',
				'vcv-globalElementsCssData',
				'vcvSourceCssFileUrl',
				'vcvSourceCssFileHash',
				'vcv-settingsLocalJs',
			) as $meta_key
		) {
			$value = rand_str();
			\WP_Mock::wpFunction( 'get_post_meta', array(
				'times'  => 1,
				'args'   => array( $original_post_id, $meta_key, true ),
				'return' => $value,
			) );
			\WP_Mock::wpFunction( 'update_post_meta', array(
				'times' => 1,
				'args'  => array( $translated_post_id, $meta_key, $value ),
			) );
			\WP_Mock::onFilter( 'wpml_pb_copy_meta_field' )
			        ->with(
				        array(
					        $value,
					        $translated_post_id,
					        $original_post_id,
					        $meta_key
				        )
			        )
			        ->reply( $value );
		}

	}
}