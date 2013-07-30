<?php
namespace AMH\User\Model;

use \AMH\Model\Model as AMHModel;

class User extends AMHModel{
	protected function preConstruct(){
		$this->addField(array(
			'name'=>'id',
			'set'=>AMHModel::FIELD_SET_ONLYONCE,
			'type'=>'int',
			'class'=>FALSE,
			'typeAutocast'=>TRUE,
		));
		
		$this->addField(array(
			'name'=>'login',
			'set'=>AMHModel::FIELD_SET_ONLYONCE,
			'type'=>'string',
			'class'=>TRUE,
			'typeAutocast'=>TRUE,
			'setCallback'=>function($val){
				if(!$this->name){
					$this->name=$val;
				}
				return $val;
			},
		));
		
		$this->addField(array(
			'name'=>'name',
			'set'=>AMHModel::FIELD_SET_ONLYONCE,
			'type'=>'string',
			'class'=>TRUE,
			'typeAutocast'=>TRUE,
		));
		
		$this->addField(array(
			'name'=>'group',
			'set'=>AMHModel::FIELD_SET_ONLYONCE,
			'type'=>FALSE,
			'class'=>'\AMH\User\Model\Group',
			'typeAutocast'=>FALSE,
		));
		
		$this->addField(array(
			'name'=>'password',
			'set'=>AMHModel::FIELD_SET_ONLYONCE,
			'type'=>'string',
			'class'=>TRUE,
			'typeAutocast'=>TRUE,
			'setCallback'=>function($val){
				return md5($val);
			},
		));
	}
	
	public function __toString(){
		return (string)$this->name;	
	}
}
?>
