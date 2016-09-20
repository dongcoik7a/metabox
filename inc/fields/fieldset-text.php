<?php

/**
 * Fieldset text class.
 */
class RWMB_Fieldset_Text_Field extends RWMB_Text_Field
{
	/**
	 * Get field HTML
	 *
	 * @param mixed $meta
	 *
	 * @return string
	 */
	public function html( $meta )
	{
		$html = array();
		$tpl  = '<label>%s %s</label>';

		foreach ( $this->options as $key => $label )
		{
			$value                       = isset( $meta[$key] ) ? $meta[$key] : '';
			$this->attributes['name'] = $this->field_name . "[{$key}]";
			$html[]                      = sprintf( $tpl, $label, parent::html( $value ) );
		}

		$out = '<fieldset><legend>' . $this->desc . '</legend>' . implode( ' ', $html ) . '</fieldset>';

		return $out;
	}

	/**
	 * Do not show field description.
	 * @return string
	 */
	public function element_description()
	{
		return '';
	}

	/**
	 * Normalize parameters for field
	 *
	 * @param array $field
	 *
	 * @return array
	 */
	public function normalize( $field )
	{
		$field                       = parent::normalize( $field );
		$field['multiple']           = false;
		$field['attributes']['id']   = false;
		$field['attributes']['type'] = 'text';
		return $field;
	}

	/**
	 * Format value for the helper functions.
	 * @param string|array $value The field meta value
	 * @return string
	 */
	public function format_value( $value )
	{
		$output = '<table><thead><tr>';
		foreach ( $this->options as $label )
		{
			$output .= "<th>$label</th>";
		}
		$output .= '<tr>';

		if ( ! $this->clone )
		{
			$output .= $this->format_single_value( $value );
		}
		else
		{
			foreach ( $value as $subvalue )
			{
				$output .= $this->format_single_value( $subvalue );
			}
		}
		$output .= '</tbody></table>';
		return $output;
	}

	/**
	 * Format a single value for the helper functions.
	 * @param array $value The value
	 * @return string
	 */
	public function format_single_value( $value )
	{
		$output = '<tr>';
		foreach ( $value as $subvalue )
		{
			$output .= "<td>$subvalue</td>";
		}
		$output .= '</tr>';
		return $output;
	}
}
