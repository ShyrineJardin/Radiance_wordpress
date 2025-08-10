<?php

/**
 * Name: Contact Form 7 Mail Mesage Body - Line Breaks
 * Description: Enable line break generation on mail message body
 */

namespace AiosInitialSetup\App\Modules\ContactForm7EnableLineBreakGenerationOnMessageBody;

class Module
{
  /**
   * Module constructor.
   */
  public function __construct()
  {
    add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts'], 9);

    add_action('wp_ajax_aios_cf7_line_breaks', [$this, 'aios_cf7_line_breaks']);
  }

  public function enqueue_scripts()
  {

    wp_register_script('aios-contact-form-line-breaks', plugin_dir_url(__FILE__) . '/js/scripts.js');

    wp_enqueue_script('aios-contact-form-line-breaks');

    wp_localize_script('aios-contact-form-line-breaks', 'ajaxurl', admin_url('admin-ajax.php'));
  }

  public function aios_cf7_line_breaks()
  {
    if (isset($_POST['data'])) {

      $cf_ids = array();

      foreach ($_POST['data'] as $data) {

        if( strpos( $data['name'], 'aios_enable_line_breaks' ) !== false ) {

          $cf_ids[] = $data['value'];
        }
      }
    }

    $args = array(
      'post_type'   => 'wpcf7_contact_form',
      'numberposts' => -1,
    );

    $get_posts = get_posts( $args );

    if( count( $get_posts ) > 0 ) {

      foreach ($get_posts as $post_key => $post_value) {

        $post_id = $post_value->ID;

        if( $post_id ) {

          $_mail = maybe_unserialize( get_post_meta( $post_id, '_mail', true ) );

          $_config_validation = maybe_unserialize( get_post_meta( $post_id, '_config_validation', true ) );

          if( isset( $_config_validation['mail.sender'] ) ) {

              $get_sender = $_mail['sender'];

              if( !empty( trim( $get_sender ) ) ) {

                $replace_array = array(
                    '<<' => '<',
                    '>>' => '>',
                );

                foreach ($replace_array as $key => $value) {
                    
                    $update_sender = str_replace( $key, $value, $get_sender );

                    $get_sender = $update_sender;
                }

                $new_sender = 'no-reply@' . $_SERVER['SERVER_NAME'];

                $_mail['sender'] = preg_replace( '/(?<=<).*?(?=>)/', $new_sender, $get_sender );

              } else {

                $_mail['sender'] = '<no-reply@' . $_SERVER['SERVER_NAME'] . '>';
              }

              update_post_meta( $post_id, '_mail', $_mail );

              unset( $_config_validation['mail.sender'] );

              update_post_meta( $post_id, '_config_validation', $_config_validation );
          }

          if( empty( $_mail['use_html'] ) ) {

              $_mail['use_html'] = 1;

              update_post_meta( $post_id, '_mail', $_mail );
          }

          if( in_array( $post_id, $cf_ids ) ) {

            $get_body = strip_tags( $_mail['body'] );

            $new_html_array = array();

            $split_body = preg_split("/\r\n|\n|\r/", $get_body);

            $ctr = 0;

            foreach ($split_body as $sb_key => $sb_value) {

              $trim_value = trim( $sb_value );

              if( !empty( $trim_value ) ) {

                $new_html_array[] = ( $ctr > 0 ? '<br/>' : '' ) . $trim_value;

                $ctr++;
              }
            }

            $new_html = implode( PHP_EOL, $new_html_array );

            $_mail['body'] = $new_html;

            update_post_meta( $post_id, 'modified_with_line_breaks', true );

            update_post_meta( $post_id, '_mail', $_mail );
          }
        }
      }
    }

    echo json_encode(['Updated']);
    die();
  }
}

new Module ();
