<?php

require_once DRUPAL_ROOT . '/sites/all/libraries/SabreDAV/vendor/autoload.php';

/**
 * Class Sabre_DAV_Auth_Backend_Drupal
 *
 * Checks WebDAV users credentials against drupal's user
 * auth and ensures they have permission to use WebDAV
 */
class Sabre_DAV_Auth_Backend_Drupal extends \Sabre\DAV\Auth\Backend\AbstractBasic
{
  public function validateUserPass($username, $password) {
    $account = user_load_by_name($username);
    return $account && user_access('sabredav', $account) && user_authenticate($username, $password);
  }
}
