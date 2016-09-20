<?php
/**
 * Button field class.
 */
class RWMB_Button_Field extends RWMB_Field
{
	/**
	 * Get field HTML
	 *
	 * @param mixed $meta
	 * @return string
	 */
	public function html( $meta )
	{
		$attributes = $this->get_attributes( $meta );
		return sprintf( '<a href="#" %s>%s</a>', self::render_attributes( $attributes ), $this->std );
	}

	/**
	 * Normalize parameters for field
	 *
	 * @param array $field
	 * @return array
	 */
	static function normalize( $field )
	{
		$field        = parent::normalize( $field );
		$field['std'] = $field['std'] ? $field['std'] : __( 'Click me', 'meta-box' );
		return $field;
	}

	/**
	 * Get the attributes for a field
	 *
	 * @param mixed $value
	 * @return array
	 */
	public function get_attributes( $value = null )
	{
		$attributes = parent::get_attributes( $value );
		$attributes['class'] .= ' button hide-if-no-js';

		return $attributes;
	}
}
