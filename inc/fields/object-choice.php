<?php

/**
 * Abstract field to select an object: post, user, taxonomy, etc.
 */
abstract class RWMB_Object_Choice_Field extends RWMB_Choice_Field
{
	/**
	 * Get field HTML
	 *
	 * @param mixed $meta
	 * @return string
	 */
	public function html( $meta )
	{
		$class_name      = $this-> get_type_class();
		$options         = $this->get_options();
		$options         = $this->filter_options( $options );
		$args            = $this->field;
		$args['options'] = $options;
		$field           = new $class_name( $args );
		return $field->html( $meta );
	}
	/**
	 * Normalize parameters for field
	 *
	 * @param array $field
	 *
	 * @return array
	 */
	public static function normalize( $field )
	{
		$field = parent::normalize( $field );
		$field = wp_parse_args( $field, array(
			'flatten'    => true,
			'query_args' => array(),
			'field_type' => 'select_advanced',
		) );

		if ( 'checkbox_tree' === $field['field_type'] )
		{
			$field['field_type'] = 'checkbox_list';
			$field['flatten']    = false;
		}
		if ( 'radio_list' == $field['field_type'] )
		{
			$field['multiple'] = false;
		}
		if ( 'checkbox_list' == $field['field_type'] )
		{
			$field['multiple'] = true;
		}

		return $field;
	}

	/**
	 * Enqueue scripts and styles
	 */
	public static function admin_enqueue_scripts()
	{
		RWMB_Input_List_Field::admin_enqueue_scripts();
		RWMB_Select_Field::admin_enqueue_scripts();
		RWMB_Select_Tree_Field::admin_enqueue_scripts();
		RWMB_Select_Advanced_Field::admin_enqueue_scripts();
	}

	/**
	 * Get correct rendering class for the field.
	 * @return string
	 */
	protected function get_type_class()
	{
		if ( in_array( $field->field_type, array( 'checkbox_list', 'radio_list' ) ) )
		{
			return 'RWMB_Input_List_Field';
		}
		return self::get_class_name( $field->field_type );
	}
}
