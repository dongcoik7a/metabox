<?php

/**
 * Abstract class for any kind of choice field.
 */
abstract class RWMB_Choice_Field extends RWMB_Field
{
	/**
	 * Walk options
	 *
	 * @param mixed $meta
	 * @param mixed $options
	 * @param mixed $db_fields
	 * @return string
	 */
	public function walk( $options, $db_fields, $meta )
	{
		return '';
	}

	/**
	 * Get field HTML
	 *
	 * @param mixed $meta
	 * @return string
	 */
	public function html( $meta )
	{
		$meta      = (array) $meta;
		$options   = $this->get_options();
		$options   = $this->filter_options( $options );
		$db_fields = $this->get_db_fields();
		return ! empty( $options ) ? $this->walk( $options, $db_fields, $meta ) : null;
	}

	/**
	 * Normalize parameters for field
	 *
	 * @param array $field
	 * @return array
	 */
	public static function normalize( $field )
	{
		$field = isset( $field['multiple'] ) && $field['multiple']  ? RWMB_Multiple_Values_Field::normalize( $field ) : RWMB_Field::normalize( $field ) ;
		$field = wp_parse_args( $field, array(
			'flatten' => true,
			'options' => array(),
		) );

		return $field;
	}

	/**
	 * Get field names of object to be used by walker
	 *
	 * @return array
	 */
	public function get_db_fields()
	{
		return array(
			'parent' => 'parent',
			'id'     => 'value',
			'label'  => 'label',
		);
	}

	/**
	 * Get options for walker
	 *
	 * @return array
	 */
	public function get_options()
	{
		$options = array();
		foreach ( (array) $this->options as $value => $label )
		{
			$option = is_array( $label ) || is_object( $label ) ? $label : array( 'label' => (string) $label, 'value' => (string) $value );
			$option = (object) $option;
			if ( isset( $option->label) && isset( $option->value) )
				$options[$option->value] = $option;
		}
		return $options;
	}

	/**
	 * Filter options for walker
	 *
	 * @param array $options
	 * @return array
	 */
	public function filter_options( $options )
	{
		$db_fields = $this->get_db_fields();
		$label     = $db_fields['label'];
		foreach ( $options as &$option )
		{
			$option         = apply_filters( 'rwmb_option', $option, $this );
			$option->$label = apply_filters( 'rwmb_option_label', $option->$label, $option, $this );
		}
		return $options;
	}

	/**
	 * Format a single value for the helper functions.
	 * @param string $value The value
	 * @return string
	 */
	public function format_single_value( $value )
	{
		return $this->get_option_label( $value );
	}

	/**
	 * Get option label
	 *
	 * @param string $value Option value
	 *
	 * @return string
	 */
	public function get_option_label( $value )
	{
		$options = $this->get_options();
		return $options[$value]->label;
	}
}
