<?php
/**
 * The helper class.
 */

/**
 * Wrapper class for helper functions.
 */
class RWMB_Helper
{
	/**
	 * Stores all registered fields
	 * @var array
	 */
	private static $fields = array();

	/**
	 * Hash all fields into an indexed array for search
	 * @param string $post_type Post type
	 */
	public static function hash_fields( $post_type )
	{
		self::$fields[$post_type] = array();

		$meta_boxes = RWMB_Core::get_meta_boxes();
		foreach ( $meta_boxes as $meta_box )
		{
			$meta_box = RW_Meta_Box::normalize( $meta_box );
			if ( ! in_array( $post_type, $meta_box['post_types'] ) )
			{
				continue;
			}
			foreach ( $meta_box['fields'] as $field )
			{
				if ( ! empty( $field->id ) )
				{
					self::$fields[$post_type][$field->id] = $field;
				}
			}
		}
	}

	/**
	 * Find field by field ID.
	 * This function finds field in meta boxes registered by 'rwmb_meta_boxes' filter.
	 *
	 * @param string $field_id Field ID
	 * @param int    $post_id
	 * @return array|false Field params (array) if success. False otherwise.
	 */
	public static function find_field( $field_id, $post_id = null )
	{
		$post_type = get_post_type( $post_id );
		if ( empty( self::$fields[$post_type] ) )
		{
			self::hash_fields( $post_type );
		}
		$fields = self::$fields[$post_type];
		if ( ! isset( $fields[$field_id] ) )
		{
			return false;
		}
		$field = $fields[$field_id];
		return $field;
	}

	/**
	 * Get post meta
	 *
	 * @param string   $key     Meta key. Required.
	 * @param int|null $post_id Post ID. null for current post. Optional
	 * @param array    $args    Array of arguments. Optional.
	 *
	 * @return mixed
	 */
	public static function meta( $key, $args = array(), $post_id = null )
	{
		$post_id = empty( $post_id ) ? get_the_ID() : $post_id;
		$args    = wp_parse_args( $args, array(
			'type'     => 'text',
			'multiple' => false,
			'clone'    => false,
		) );

		$field = array(
			'id'       => $key,
			'type'     => $args['type'],
			'clone'    => $args['clone'],
			'multiple' => $args['multiple'],
		);

		if( 'map' === $args['type'] )
		{
			$field = wp_parse_args( array(
				'multiple' => false,
				'clone'    => false,
			), $field );
		}

		$class_name = RWMB_Field::get_class_name( $args['type'] );
		$field = new $class_name( $field );

		switch ( $args['type'] )
		{
			case 'taxonomy_advanced':
			case 'taxonomy':
				if ( empty( $args['taxonomy'] ) )
				{
					$meta =  array();
				}
				break;
			case 'map':
			case 'oembed':
				$meta  = $field->the_value( $field, $args, $post_id );
				break;
			default:
				$meta = $field->get_value( $args, $post_id );
		}
		return apply_filters( 'rwmb_meta', $meta, $key, $args, $post_id );
	}
}
