<?php

/**
 * Key-value field class.
 */
abstract class RWMB_Key_Value_Field extends RWMB_Text_Field
{
	/**
	 * Get field HTML
	 *
	 * @param mixed $meta
	 * @return string
	 */
	function html( $meta )
	{
		// Key
		$key                       = isset( $meta[0] ) ? $meta[0] : '';
		$attributes                = $this->get_attributes( $field, $key );
		$attributes['placeholder'] = $this->placeholder['key'];
		$html                      = sprintf( '<input %s>', self::render_attributes( $attributes ) );

		// Value
		$val                       = isset( $meta[1] ) ? $meta[1] : '';
		$attributes                = $this->get_attributes( $val );
		$attributes['placeholder'] = $this->placeholder['value'];
		$html .= sprintf( '<input %s>', $this->render_attributes( $attributes ) );

		return $html;
	}

	/**
	 * Show begin HTML markup for fields
	 *
	 * @param mixed $meta
	 * @return string
	 */
	function begin_html( $meta )
	{
		$desc = $this->desc ? "<p id='{$this->id}_description' class='description'>{$this->desc}</p>" : '';

		if ( empty( $this->name ) )
			return '<div class="rwmb-input">' . $desc;

		return sprintf(
			'<div class="rwmb-label">
				<label for="%s">%s</label>
			</div>
			<div class="rwmb-input">
			%s',
			$this->id,
			$this->name,
			$desc
		);
	}

	/**
	 * Do not show field description.
	 * @param array $field
	 * @return string
	 */
	public static function element_description( $field )
	{
		return '';
	}

	/**
	 * Escape meta for field output
	 *
	 * @param mixed $meta
	 * @return mixed
	 */
	public function esc_meta( $meta )
	{
		foreach ( (array) $meta as $k => $pairs )
		{
			$meta[$k] = array_map( 'esc_attr', (array) $pairs );
		}
		return $meta;
	}

	/**
	 * Sanitize field value.
	 *
	 * @param mixed $new
	 * @param mixed $old
	 * @param int   $post_id
	 * @param array $field
	 *
	 * @return string
	 */
	public function value( $new, $old, $post_id )
	{
		foreach ( $new as &$arr )
		{
			if ( empty( $arr[0] ) && empty( $arr[1] ) )
				$arr = false;
		}
		$new = array_filter( $new );
		return $new;
	}

	/**
	 * Normalize parameters for field
	 *
	 * @param array $field
	 * @return array
	 */
	public static function normalize( $field )
	{
		$field                       = parent::normalize( $field );
		$field['clone']              = true;
		$field['multiple']           = true;
		$field['attributes']['type'] = 'text';
		$field['placeholder']        = wp_parse_args( (array) $field['placeholder'], array(
			'key'   => 'Key',
			'value' => 'Value',
		) );
		return $field;
	}

	/**
	 * Format value for the helper functions.
	 * @param string|array $value The field meta value
	 * @return string
	 */
	public function format_value( $value )
	{
		$output = '<ul>';
		foreach ( $value as $subvalue )
		{
			$output .= sprintf( '<li><label>%s</label>: %s</li>', $subvalue[0], $subvalue[1] );
		}
		$output .= '</ul>';
		return $output;
	}
}
