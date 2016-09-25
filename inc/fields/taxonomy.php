<?php
/**
 * Taxonomy field class which set post terms when saving.
 */
class RWMB_Taxonomy_Field extends RWMB_Object_Choice_Field
{
	/**
	 * Add default value for 'taxonomy' field
	 *
	 * @param $field
	 * @return array
	 */
	public static function normalize( $field )
	{
		/**
		 * Backwards compatibility with field args
		 */
		if ( isset( $field['options']['args'] ) )
			$field['query_args'] = $field['options']['args'];
		if ( isset( $field['options']['taxonomy'] ) )
			$field['taxonomy'] = $field['options']['taxonomy'];
		if ( isset( $field['options']['type'] ) )
			$field['field_type'] = $field['options']['type'];

		/**
		 * Set default field args
		 */
		$field = parent::normalize( $field );
		$field = wp_parse_args( $field, array(
			'taxonomy'   => 'category',
		) );

		/**
		 * Set default query args
		 */
		$field['query_args'] = wp_parse_args( $field['query_args'], array(
			'hide_empty' => false,
		) );

		/**
		 * Set default placeholder
		 * - If multiple taxonomies: show 'Select a term'
		 * - If single taxonomy: show 'Select a %taxonomy_name%'
		 */
		if ( empty( $field['placeholder'] ) )
		{
			$field['placeholder'] = __( 'Select a term', 'meta-box' );
			if ( is_string( $field['taxonomy'] ) && taxonomy_exists( $field['taxonomy'] ) )
			{
				$taxonomy_object      = get_taxonomy( $field['taxonomy'] );
				$field['placeholder'] = sprintf( __( 'Select a %s', 'meta-box' ), $taxonomy_object->labels->singular_name );
			}
		}

		/**
		 * Prevent cloning for taxonomy field
		 */
		$field['clone'] = false;

		return $field;
	}

	/**
	 * Get options for selects, checkbox list, etc via the terms
	 *
	 * @param array $field Field parameters
	 *
	 * @return array
	 */
	public function get_options()
	{
		$terms = get_terms( $this->taxonomy, $this->query_args );
		$options = array();

		foreach( $terms as $term )
		{
			$options[ $term->term_id ] = (object) array(
				'parent' => $term->parent,
				'value'  => $term->term_id,
				'label'  => $term->name
			);
		}

		return $options;
	}

	/**
	 * Save meta value
	 *
	 * @param mixed $new
	 * @param mixed $old
	 * @param int   $post_id
	 *
	 * @return string
	 */
	public function save( $new, $old, $post_id )
	{
		$new = array_unique( array_map( 'intval', (array) $new ) );
		$new = empty( $new ) ? null : $new;
		wp_set_object_terms( $post_id, $new, $this->taxonomy );
	}

	/**
	 * Standard meta retrieval
	 *
	 * @param int   $post_id
	 * @param bool  $saved
	 *
	 * @return array
	 */
	public function meta( $post_id, $saved )
	{
		$meta = get_the_terms( $post_id, $this->taxonomy );
		$meta = (array) $meta;
		$meta = wp_list_pluck( $meta, 'term_id' );

		return $meta;
	}

	/**
	 * Get the field value
	 * Return list of post term objects
	 *
	 * @param  array    $args    Additional arguments. Rarely used. See specific fields for details
	 * @param  int|null $post_id Post ID. null for current post. Optional.
	 *
	 * @return array List of post term objects
	 */
	public function get_value( $args = array(), $post_id = null )
	{
		$value = get_the_terms( $post_id, $this->taxonomy );

		// Get single value if necessary
		if ( ! $this->clone && ! $this->multiple && is_array( $value ) )
		{
			$value = reset( $value );
		}
		return $value;
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
		return sprintf(
			'<a href="%s" title="%s">%s</a>',
			esc_url( get_term_link( $value ) ),
			esc_attr( $value->name ),
			$value->name
		);
	}
}
