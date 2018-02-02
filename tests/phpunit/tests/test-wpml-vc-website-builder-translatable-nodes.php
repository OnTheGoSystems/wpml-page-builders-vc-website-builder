<?php

/**
 * Class Test_WPML_VC_Website_Builder_Translatable_Nodes
 *
 * @group page-builders
 * @group vc-website-builder
 * @group wpmlcore-5165
 */
class Test_WPML_VC_Website_Builder_Translatable_Nodes extends OTGS_TestCase {

	/**
	 * @test
	 * @dataProvider node_data_provider
	 *
	 * @param $type
	 * @param $fields
	 */
	public function it_gets( $type, $fields, $items_field, $items ) {
		$node_id = rand_str( 10 );

		$element = array(
			'id'  => $node_id,
			'tag' => $type,
		);

		foreach ( $fields as $field ) {
			$element[ $field['field'] ] = $field['value'];
		}

		\WP_Mock::wpPassthruFunction( '__' );
		\WP_Mock::wpPassthruFunction( 'esc_html__' );

		$subject = new WPML_VC_Website_Builder_Translatable_Nodes();
		$strings = $subject->get( $node_id, $element );

		foreach ( $strings as $key => $string ) {
			$this->assertSame( $fields[ $key ]['value'], $string->get_value() );
		}
	}

	public function node_data_provider() {

		return array(
			'Text Editor'  => array(
				'textBlock',
				array(
					array(
						'field'       => 'output',
						'type'        => 'textBlock',
						'editor_type' => 'VISUAL',
						'value'       => 'textBlock output value'
					)
				),
				'',
				array(),
			),
			'Basic Button' => array(
				'basicButton',
				array(
					array(
						'field'       => 'output',
						'type'        => 'basicButton',
						'editor_type' => 'VISUAL',
						'value'       => 'Basic button output value'
					)
				),
				'',
				array(),
			),
		);
	}

	/**
	 * @test
	 */
	public function it_updates() {
		$node_id     = mt_rand();
		$element     = array( 'tag' => 'textBlock', 'output' => rand_str() );
		$translation = rand_str();

		$string = new WPML_PB_String( $translation, 'output-textBlock-' . $node_id, 'anything', 'anything' );

		$subject = new WPML_VC_Website_Builder_Translatable_Nodes();
		$element = $subject->update( $node_id, $element, $string );

		$this->assertEquals( $translation, $element['output'] );
	}
}