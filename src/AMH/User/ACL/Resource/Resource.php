<?php
namespace \AMH\User\ACL\Resource;

use \AMH\Model\Model as AMHModel;

class Resource extends AMHModel{
	protected function preConstruct(){
		$this->addField(array('name'=>'name','type'=>'string','typeAutocast'=>TRUE));
		
		$this->addField(array('name'=>'allow','class'=>'STDObject'));
		
		$this->addField(array('name'=>'deny','class'=>'STDObject'));
		
		$this->addField(array('name'=>'children','type'=>'array','typeAutocast'=>TRUE));
		
		$this->allow=(object)array('user'=array(),'group'=>array());
		$this->deny=(object)array('user'=array(),'group'=>array());
	}
}
?>
