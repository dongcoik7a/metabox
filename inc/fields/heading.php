<?php

/**
 * Heading field class.
 */
class RWMB_Heading_Field extends RWMB_Field
{
	/**
	 * Enqueue scripts and styles
	 *
	 * @return void
	 */
	function admin_enqueue_scripts()
	{
		wp_enqueue_style( 'rwmb-heading', RWMB_CSS_URL . 'heading.css', array(), RWMB_VER );
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
		return sprintf( '<h4%s>%s</h4>', $attributes, $this->name );
	}

	/**
	 * Show end HTML markup for fields
	 *
	 * @param mixed $meta
	 * @param array $field
	 *
	 * @return string
	 */
	public function end_html( $meta )
	{
		return $this->element_description();
	}
}
