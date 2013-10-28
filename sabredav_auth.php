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

    $form = drupal_get_form('user_login');
    $form_state = form_state_defaults();
    $form_state['values']['name'] = $username;
    $form_state['values']['pass'] = $password;
    form_execute_handlers('validate', $form, $form_state);
    if (!isset($form_state['uid'])) {
      return FALSE;
    }

    $account = user_load($form_state['uid']);
    return $account && user_access('sabredav', $account);
  }
}
