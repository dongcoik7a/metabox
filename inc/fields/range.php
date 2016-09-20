<?php
/**
 * HTML5 range field class.
 */
class RWMB_Range_Field extends RWMB_Number_Field
{
	/**
	 * Get field HTML
	 *
	 * @param mixed $meta
	 * @return string
	 */
	public function html( $meta )
	{
		$output = parent::html( $meta );
		$output .= sprintf( '<span class="rwmb-output">%s</span>', $meta );
		return $output;
	}

	/**
	 * Enqueue styles
	 */
	public static function admin_enqueue_scripts()
	{
		wp_enqueue_style( 'rwmb-range', RWMB_CSS_URL . 'range.css', array(), RWMB_VER );
		wp_enqueue_script( 'rwmb-range', RWMB_JS_URL . 'range.js', array(), RWMB_VER, true );
	}

	/**
	 * Normalize parameters for field.
	 * @param array $field
	 * @return array
	 */
	public function normalize( $field )
	{
		$field = wp_parse_args( $field, array(
			'max' => 10,
		) );
		$field = parent::normalize( $field );
		return $field;
	}

	/**
	 * Ensure number in range.
	 *
	 * @param mixed $new
	 * @param mixed $old
	 * @param int   $post_id
	 *
	 * @return int
	 */
	public function value( $new, $old, $post_id )
	{
		$new = intval( $new );
		$min = intval( $this->min );
		$max = intval( $this->max );

		if ( $new < $min )
		{
			return $min;
		}
		if ( $new > $max )
		{
			return $max;
		}
		return $new;
	}
}
