<?php
/**
 * Divider field class.
 */
class RWMB_Divider_Field extends RWMB_Field
{
	/**
	 * Enqueue scripts and styles
	 *
	 * @return void
	 */
	static function admin_enqueue_scripts()
	{
		wp_enqueue_style( 'rwmb-divider', RWMB_CSS_URL . 'divider.css', array(), RWMB_VER );
	}

	/**
	 * Show begin HTML markup for fields
	 *
	 * @param mixed $meta
	 *
	 * @return string
	 */
	public function begin_html( $meta )
	{
		$attributes = empty( $this->id ) ? '' : " id='{$this->id}'";
		return "<hr$attributes>";
	}

	/**
	 * Show end HTML markup for fields
	 *
	 * @param mixed $meta
	 *
	 * @return string
	 */
	public function end_html( $meta )
	{
		return '';
	}
}
