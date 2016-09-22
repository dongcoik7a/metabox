<?php
/**
 * Text field class.
 */
class RWMB_Text_Field extends RWMB_Input_Field
{
	/**
	 * Normalize parameters for field
	 *
	 * @return array
	 */
	public static function normalize( $field )
	{
		$field = parent::normalize( $field );

		$field = wp_parse_args( $field, array(
			'size'        => 30,
			'maxlength'   => false,
			'pattern'     => false,
		) );

		return $field;
	}

	/**
	 * Get the attributes for a field
	 *
	 * @param mixed $value
	 *
	 * @return array
	 */
	public function get_attributes( $value = null )
	{
		$attributes = parent::get_attributes( $value );
		$attributes = wp_parse_args( $attributes, array(
			'size'        => $this->size,
			'maxlength'   => $this->maxlength,
			'pattern'     => $this->pattern,
			'placeholder' => $this->placeholder,
		) );

		return $attributes;
	}
}
