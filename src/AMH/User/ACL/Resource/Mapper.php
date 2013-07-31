<?php
namespace AMH\User\ACL\Resource;

use \AMH\Mapper\DB as DBMapper;
use \AMH\Mapper\MapperInterface as MapperInterface;

class Mapper extends DBMapper implements MapperInterface{
	protected $reqTables=array(
		'create table `acl_res`(
			`id` int not null auto_increment primary key,
			`name` text not null,
			`parent_id` int,
			unique(`name`(150))
		)engine=myisam default charset=utf8',
		'create table `acl_rights_user`(
			`res_id` int not null,
			`allow` bool not null,
			`user_id` int not null,
			primary key(`res_id`,`user_id`)
		)engine=myisam default charset=utf8',
		'create table `acl_rights_group`(
			`res_id` int not null,
			`allow` bool not null,
			`group_id` int not null,
			primary key(`res_id`,`group_id`)
		)engine=myisam default charset=utf8',
	);
	
	protected function dbSelect($filter){
		$result=array(
			'res'=>null,
			'user'=>null,
			'group'=>null,
		);
		$result['res']=$this->pdo->query('select * from `acl_res`');
		$result['user']=$this->pdo->query('select * from `acl_rights_user`');
		$result['group']=$this->pdo->query('select * from `acl_rights_group`');
		
		return $result;
	}
	
	protected function processSelected($res){
		
	}
	
	protected function dbInsert($res){
	
	}
	
	protected function dbSave($res){
	
	}
	
	protected function dbDelete($res){
	
	}
}
?>
