<?php
/**
 * Custom HTML field class.
 */
class RWMB_Custom_Html_Field extends RWMB_Field
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
		$html = ! empty( $this->std ) ? $this->std : '';
		if ( ! empty( $this->callback ) && is_callable( $this->callback ) )
		{
			$html = call_user_func_array( $this->callback, array( $meta, $this ) );
		}
		return $html;
	}
}
