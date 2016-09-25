<?php
/**
 * User field class.
 */
class RWMB_User_Field extends RWMB_Object_Choice_Field
{
	/**
	 * Normalize parameters for field
	 *
	 * @param array $field
	 *
	 * @return array
	 */
	public static function normalize( $field )
	{
		/**
		 * Set default field args
		 */
		$field = parent::normalize( $field );

		/**
		 * Prevent select tree for user since it's not hierarchical
		 */
		$field['field_type'] = 'select_tree' === $field['field_type'] ? 'select' : $field['field_type'];

		/**
		 * Set to always flat
		 */
		$field['flatten'] = true;

		/**
		 * Set default placeholder
		 */
		$field['placeholder'] = empty( $field['placeholder'] ) ? __( 'Select an user', 'meta-box' ) : $field['placeholder'];

		/**
		 * Set default query args
		 */
		$field['query_args'] = wp_parse_args( $field['query_args'], array(
			'orderby' => 'display_name',
			'order'   => 'asc',
			'role'    => '',
			'fields'  => 'all',
		) );

		return $field;
	}

	/**
	 * Get users
	 *
	 * @return array
	 */
	public function get_options()
	{
		$query = new WP_User_Query( $this->query_args );
		$options = array();
		foreach( $query->get_results() as $user )
		{
			$options[ $user->ID ] = (object) array(
				'parent' => 0,
				'value'  => $user->ID,
				'label'  => $user->display_name
			);
		}
		return $options;
	}

	/**
	 * Get option label
	 *
	 * @param string   $value Option value
	 *
	 * @return string
	 */
	public function get_option_label( $value )
	{
		$user  = get_userdata( $value );
		return '<a href="' . get_author_posts_url( $value ) . '">' . $user->display_name . '</a>';
	}
}
