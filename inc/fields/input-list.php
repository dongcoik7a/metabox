<?php
/**
 * Input list field.
 */
class RWMB_Input_List_Field extends RWMB_Choice_Field
{
	/**
	 * Enqueue scripts and styles
	 */
	public static function admin_enqueue_scripts()
	{
		wp_enqueue_style( 'rwmb-input-list', RWMB_CSS_URL . 'input-list.css', array(), RWMB_VER );
		wp_enqueue_script( 'rwmb-input-list', RWMB_JS_URL . 'input-list.js', array(), RWMB_VER, true );
	}

	/**
	 * Walk options
	 *
	 * @param mixed $meta
	 * @param mixed $options
	 * @param mixed $db_fields
	 *
	 * @return string
	 */
	public function walk( $options, $db_fields, $meta )
	{
		$walker = new RWMB_Walker_Input_List( $db_fields, $this, $meta );
		$output = sprintf( '<ul class="rwmb-input-list %s %s">',
			$this->collapse ? 'collapse' : '',
		 	$this->inline   ? 'inline'   : ''
		);
		$output .= $walker->walk( $options, $this->flatten ? - 1 : 0 );
		$output .= '</ul>';

		return $output;
	}

	/**
	 * Normalize parameters for field
	 *
	 * @param array $field
	 * @return array
	 */
	public static function normalize( $field )
	{
		$field = RWMB_Input_Field::normalize( $field );
		$field = parent::normalize( $field );
		$field = wp_parse_args( $field, array(
			'collapse' => true,
			'inline'   => null,
		) );

		$field['flatten'] = $field['multiple'] ? $field['flatten'] : true;
		$field['inline'] = ! $field['multiple'] && ! isset( $field['inline'] ) ? true : $field['inline'];

		return $field;
	}
}
