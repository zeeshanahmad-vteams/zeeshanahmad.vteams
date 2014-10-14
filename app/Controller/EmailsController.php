<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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

App::uses('CakeEmail', 'Network/Email');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class EmailsController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function display() {
	}
	public function sendemail() {
		$error = false;
	foreach($this->request->data['Email'] as $key=>$val):
		if("" == $val) {
			$this->Session->setFlash(ucfirst($key).' is required', 'default', array('class' => 'isa_error'), $key);
			$error = true;
		}if($key == "email") {
			$email = $this->request->data['Email']['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$this->Session->setFlash("Not a valid Email", 'default', array('class' => 'isa_error'), 'email');
				$error = true;
			}
		}
	endforeach;
	if($error)
		$this->redirect(array('controller'=>'emails', 'action'=>'display'));
	else {
		$Email = new CakeEmail('gmail');
		if($Email->template('default', 'default')
		->emailFormat('both')
		->to('zeeshan_ahmad10@yahoo.com')
		->from($this->request->data['Email']['email'], $this->request->data['Email']['name'])
		->subject($this->request->data['Email']['subject'])
		->send($this->request->data['Email']['details'])) {
			$this->Session->setFlash("Email sent succefully", 'default', array('class' => 'isa_success'), 'sent');
			$this->redirect(array('controller'=>'emails', 'action'=>'display'));
		} else {
			$this->Session->setFlash("Email not sent: ".$this->Email->smtpError, 'default', array('class' => 'isa_error'), 'error');
			$this->redirect(array('controller'=>'emails', 'action'=>'display'));
		}
			
		}
		
	}
}
