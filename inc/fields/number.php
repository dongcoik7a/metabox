<?php
/**
 * Number field class.
 */
class RWMB_Number_Field extends RWMB_Input_Field
{
	/**
	 * Normalize parameters for field
	 *
	 * @param array $field
	 *
	 * @return array
	 */
	public function normalize( $field )
	{
		$field = parent::normalize( $field );

		$field = wp_parse_args( $field, array(
			'step' => 1,
			'min'  => 0,
			'max'  => false,
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
			'step' => $this->step,
			'max'  => $this->max,
			'min'  => $this->min,
		) );
		return $attributes;
	}
}
