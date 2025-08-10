<?php
/**
 * This class will return require files
 *
 * @since 3.0.9
 */

namespace AiosInitialSetup\App\Modules\Hooks;

use AiosInitialSetup\App\Modules\ActivityLogs\Insert;

class User
{

  /**
   * Constructor
   *
   * @since 3.0.9
   *
   * @access public
   * @return void
   */
  public function __construct()
  {
    add_action('wp_login', [$this, 'hooks_wp_login'], 10, 2);
    add_action('wp_logout', [$this, 'hooks_wp_logout']);
    add_action('delete_user', [$this, 'hooks_delete_user']);
    add_action('user_register', [$this, 'hooks_user_register']);
    add_action('profile_update', [$this, 'hooks_profile_update']);
    add_action('wp_login_failed', [$this, 'hooks_wrong_password']);
  }

  /**
   * @param $user_login
   * @param $user
   */
  public function hooks_wp_login($user_login, $user)
  {
    new Insert([
      'action' => 'User Logged In',
      'activity' => 'Username: <strong>' . $user->user_login . '</strong> | Role: <strong>' . (empty($user->roles[0]) ? 'No Role is Selected' : $user->roles[0]) . '</strong>',
      'object-type' => 'User'
    ]);
  }

  /**
   * @param $user_id
   */
  public function hooks_user_register($user_id)
  {
    $user = get_user_by('id', $user_id);

    new Insert([
      'action' => 'User Created',
      'activity' => 'Username: <strong>' . $user->user_login . '</strong> | Role: <strong>' . (empty($user->roles[0]) ? 'No Role is Selected' : $user->roles[0]) . '</strong>',
      'object-type' => 'User'
    ]);
  }

  /**
   * @param $user_id
   */
  public function hooks_delete_user($user_id)
  {
    $user = get_user_by('id', $user_id);

    new Insert([
      'action' => 'User Deleted',
      'activity' => 'Username: <strong>' . $user->user_login . '</strong> | Role: <strong>' . (empty($user->roles[0]) ? 'No Role is Selected' : $user->roles[0]) . '</strong>',
      'object-type' => 'User'
    ]);
  }

  /**
   *
   */
  public function hooks_wp_logout()
  {
    $user = wp_get_current_user();

    new Insert([
      'action' => 'User Logged Out',
      'activity' => 'Username: <strong>' . $user->user_login . '</strong> | Role: <strong>' . ( empty( $user->roles[0] ) ? 'No Role is Selected' : $user->roles[0] ) . '</strong>',
      'object-type' => 'User'
    ]);
  }

  /**
   * @param $user_id
   */
  public function hooks_profile_update($user_id)
  {
    $user = get_user_by('id', $user_id);

    new Insert([
      'action' => 'User Updated',
      'activity' => 'Username: <strong>' . $user->user_login . '</strong> | Role: <strong>' . ( empty( $user->roles[0] ) ? 'No Role is Selected' : $user->roles[0] ) . '</strong>',
      'object-type' => 'User'
    ]);
  }

  /**
   * @param $username
   */
  public function hooks_wrong_password($username)
  {
    if ($username !== '') {
      new Insert([
        'action' 		=> 'Invalid Login',
        'activity'		=> 'Someone is trying to access this user <strong>' . $username . ' with a wrong password</strong>',
        'object-type'	=> 'User'
      ]);
    }
  }

}

new User();
