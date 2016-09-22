<?php
/**
 * Password field class.
 */
class RWMB_Password_Field extends RWMB_Text_Field
{
	/**
	 * Store secured password in the database.
	 * @param mixed $new
	 * @param mixed $old
	 * @param int   $post_id
	 * @return string
	 */
	public function value( $new, $old, $post_id )
	{
		$new = $new != $old ? wp_hash_password( $new ) : $new;
		return $new;
	}
}
