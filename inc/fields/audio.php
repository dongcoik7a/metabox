<?php
/**
 * Audio class which users WordPress media popup to upload and select images.
 */
class RWMB_Audio_Field extends RWMB_Media_Field
{
	/**
	 * Enqueue scripts and styles
	 *
	 * @return void
	 */
	static function admin_enqueue_scripts()
	{
		parent::admin_enqueue_scripts();
		wp_enqueue_style( 'rwmb-audio', RWMB_CSS_URL . 'audio.css', array( 'rwmb-media' ), RWMB_VER );
		wp_enqueue_script( 'rwmb-audio', RWMB_JS_URL . 'audio.js', array( 'rwmb-media' ), RWMB_VER, true );
		/**
		 * Prevent loading localized string twice.
		 * @link https://github.com/rilwis/meta-box/issues/850
		 */
		$wp_scripts = wp_scripts();
		if ( ! $wp_scripts->get_data( 'rwmb-audio', 'data' ) )
		{
			wp_localize_script( 'rwmb-audio', 'i18nRwmbAudio', array(
				'extensions' => wp_get_audio_extensions(),
			) );
		}
	}

	/**
	 * Normalize parameters for field
	 *
	 * @param array $field
	 *
	 * @return array
	 */
	static function normalize( $field )
	{
		$field              = parent::normalize( $field );
		$field['mime_type'] = 'audio';

		return $field;
	}

	/**
	 * Get the field value.
	 * @param array $field
	 * @param array $args
	 * @param null  $post_id
	 * @return mixed
	 */
	static function get_value( $field, $args = array(), $post_id = null )
	{
		return;
	}

	/**
	 * Output the field value.
	 * @param array $field
	 * @param array $args
	 * @param null  $post_id
	 * @return mixed
	 */
	static function the_value( $field, $args = array(), $post_id = null )
	{
		return;
	}

	/**
	 * Get uploaded file information.
	 *
	 * @param int   $file_id Attachment image ID (post ID). Required.
	 * @param array $args    Array of arguments (for size).
	 * @return array|bool False if file not found. Array of image info on success
	 */
	static function file_info( $file_id, $args = array() )
	{
		return;
	}

	/**
	 * Template for media item
	 * @return void
	 */
	static function print_templates()
	{
		parent::print_templates();
		require_once( RWMB_INC_DIR . 'templates/audio.php' );
	}
}
