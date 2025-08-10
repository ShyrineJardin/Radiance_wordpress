<?php
/**
 * Common methods to create input, select, and textarea
 *
 * @return void
 */
if (!class_exists('aios_create_fields')) {
	class AIOS_CREATE_FIELDS
  {
		public static function input_field($args = [])
    {
		  $fields = new \AiosInitialSetup\Helpers\Classes\Fields();
		  return $fields->input_field($args);
		}

		public static function select($args = [])
    {
      $fields = new \AiosInitialSetup\Helpers\Classes\Fields();
      return $fields->select($args);
		}

		public static function image_upload($args = [])
    {
      $fields = new \AiosInitialSetup\Helpers\Classes\Fields();
      return $fields->image_upload($args);
		}
	}
}
