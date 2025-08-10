<?php
/**
 * This will disable right click and inspect element
 *
 * @since 2.8.6
 */

namespace AiosInitialSetup\App\Modules\DisableRightClickAndInspectElement;

class Module {

  /**
   * Constructor
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function __construct()
  {
    $this->add_actions();
  }

  /**
   * Add Actions.
   *
   * @since 1.0.0
   *
   * @access protected
   */
  protected function add_actions()
  {
    add_action('wp_head', [$this, 'disable_scripts'], 20);
  }

  /**
   * Enqueue scripts and styles for initial setup sub page
   *
   * @since 2.8.6
   *
   * @access public
   */
  public function disable_scripts()
  {
    echo '<script type="text/javascript">( function($) {
$( document ).ready( function() {
    function __construct() { disable_contextmenu(); }
    function disable_contextmenu() {
      $("body").on("contextmenu",function(){
        console.log( "Context Menu is Disabled!" );
        return false;
      });

      $(document).keydown(function(event){
        if(event.keyCode==123){ return false; } else if (event.ctrlKey && event.shiftKey && event.keyCode==73){ return false; }
      });
    }
    __construct();
  } );
} )( jQuery );
</script>';
  }
}

new Module();
