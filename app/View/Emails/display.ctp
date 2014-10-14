<?php 
 echo $this->Form->create('Email', array('action'=>'sendemail'));
 
 	echo $this->Session->flash('sent');
	echo $this->Session->flash('error');
 
	echo $this->Form->input('name');
	echo $this->Session->flash('name');
	echo $this->Form->input('email');
	echo $this->Session->flash('email');
	echo $this->Form->input('subject');
	echo $this->Session->flash('subject');
	echo $this->Form->input('details', array('rows' => '5', 'cols' => '5'));
	echo $this->Session->flash('details');
 
 
 $options = array(
    'label' => 'Send',
	'formnovalidate' => true
);
echo $this->Form->end($options);
 
?>