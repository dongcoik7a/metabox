<?php

/**
 * Abstract input field class which is used for all <input> fields.
 */
abstract class RWMB_Input_Field extends RWMB_Field
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
		return sprintf( '<input %s>%s', self::render_attributes( $attributes ), s$this->datalist() );
	}

	/**
	 * Normalize parameters for field
	 *
	 * @return array
	 */
	public static function normalize( $field )
	{
		$field = parent::normalize( $field );
		$field = wp_parse_args( $field, array(
			'datalist' => false,
			'readonly' => false,
		) );
		if ( $field['datalist'] )
		{
			$field['datalist'] = wp_parse_args( $field['datalist'], array(
				'id'      => $field['id'] . '_list',
				'options' => array(),
			) );
		}
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
		$attributes = wp_parse_args( $attributes, array(
			'list'        => $this->datalist ? $this->datalist['id'] : false,
			'readonly'    => $this->readonly,
			'value'       => $value,
			'placeholder' => $this->placeholder,
			'type'        => $this->type,
		) );

		return $attributes;
	}

	/**
	 * Create datalist, if any.
	 *
	 * @return array
	 */
	protected function datalist()
	{
		if ( empty( $this->datalist ) )
			return '';

		$datalist = $this->datalist;
		$html     = sprintf( '<datalist id="%s">', $datalist['id'] );
		foreach ( $datalist['options'] as $option )
		{
			$html .= sprintf( '<option value="%s"></option>', $option );
		}
		$html .= '</datalist>';
		return $html;
	}
}
