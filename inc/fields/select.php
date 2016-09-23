<?php
/**
 * Select field class.
 */
class RWMB_Select_Field extends RWMB_Choice_Field
{
	/**
	 * Enqueue scripts and styles
	 */
	public function admin_enqueue_scripts()
	{
		wp_enqueue_style( 'rwmb-select', RWMB_CSS_URL . 'select.css', array(), RWMB_VER );
		wp_enqueue_script( 'rwmb-select', RWMB_JS_URL . 'select.js', array(), RWMB_VER, true );
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
		$attributes = $this->get_attributes( $meta );
		$walker     = new RWMB_Walker_Select( $db_fields, $this, $meta );
		$output     = sprintf(
			'<select %s>',
			self::render_attributes( $attributes )
		);
		if ( false === $this->multiple )
		{
			$output .= $this->placeholder ? '<option value="">' . esc_html( $this->placeholder ) . '</option>' : '';
		}
		$output .= $walker->walk( $options, $this->flatten ? - 1 : 0 );
		$output .= '</select>';
		$output .= $this->get_select_all_html();
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
		$field = parent::normalize( $field );
		$field = $field['multiple'] ? RWMB_Multiple_Values_Field::normalize( $field ) : $field;
		$field = wp_parse_args( $field, array(
			'size'            => $field['multiple'] ? 5 : 0,
			'select_all_none' => false,
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
		$attributes = parent::get_attributes(  $value );
		$attributes = wp_parse_args( $attributes, array(
			'multiple' => $this->multiple,
			'size'     => $this->size,
		) );

		return $attributes;
	}

	/**
	 * Get html for select all|none for multiple select
	 *
	 * @param array $field
	 * @return string
	 */
	public function get_select_all_html()
	{
		if ( $this->multiple && $this->select_all_none )
		{
			return '<div class="rwmb-select-all-none">' . __( 'Select', 'meta-box' ) . ': <a data-type="all" href="#">' . __( 'All', 'meta-box' ) . '</a> | <a data-type="none" href="#">' . __( 'None', 'meta-box' ) . '</a></div>';
		}
		return '';
	}
}
