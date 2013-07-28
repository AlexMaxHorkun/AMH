<?php
namespace AMH\User\Model;

use \AMH\Model\Model as AMHModel;

class Group extends AMHModel{
	protected function preConstruct(){
		$this->addField(array(
			'name'=>'id',
			'set'=>AMHModel::FIELD_SET_ONLYONCE,
			'type'=>'int',
			'class'=>FALSE,
			'typeAutocast'=>TRUE,
		));
		$this->addField(array(
			'name'=>'name',
			'set'=>AMHModel::FIELD_SET_ONLYONCE,
			'type'=>'string',
			'class'=>TRUE,
			'typeAutocast'=>TRUE,
		));
	}
	
	public function __toString(){
		return $this->name;
	}
}
?>