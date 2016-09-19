<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $uses = array('AppController', 'Impianto');
	public $helpers = array('Html', 'Form', 'Session', 'Cache');

    public function beforeFilter() {
        parent::beforeFilter();
        $idUtenteLoggato = $this->Auth->user('id');
        $this->theme = 'Tisa';

        if ($this->Impianto->isAmministratore($idUtenteLoggato)) {
            $this->layout = 'administrator';
        } else {
            $this->layout = 'titolare';
		}
    }
    const SUCCESS_FLASH = 'success_flash';
    const ERROR_FLASH = 'error_flash';
    const INFO_FLASH = 'info_flash';
    const WARNING_FLASH = 'warning_flash';
    const PAGE_TITLE_PREFIX = '';
    const INDIRIZZO_EMAIL_AUTOMATICHE = "info@example.com";

	 public $components = array(
        'DebugKit.Toolbar',
		'Session',
        'Auth' => array(
            'loginRedirect' => array(
                'controller' => 'Users',
                'action' => 'index'
            ),
            'logoutRedirect' => array(
                'controller' => 'Impianti',
                'action' => 'login',
            ),
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'Impianto',
                    'passwordHasher' => 'Blowfish',
                    'fields' => array(
                      'username' => 'nome',
                      'password' => 'password'
                    )
                )
            ),
            'authorize' => array('Controller'),
            'unauthorizedRedirect' => array('controller' => 'Users', 'action' => 'unauthorizedAccess')
        )
    );

	public function beforeRender() {
        parent::beforeRender();
        $this->set('page_title_suffix', " - Zenit S.r.l.");
    }

    public function isAuthorized($user) {
		return true;
        $idUtenteLoggato= $this->Auth->user('id');
        return $this->Impianto->isAmministratore($idUtenteLoggato);
    }

}
