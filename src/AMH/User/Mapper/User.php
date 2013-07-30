<?php
namespace AMH\User\Mapper;

use \AMH\User\Model\User as UserModel;
use \AMH\User\Model\Group as GroupModel;

class User extends \AMH\Mapper\DB implements \AMH\Mapper\MapperInterface{
	protected $reqTables=array(
		'create table user(
			`id` int not null auto_increment primary key,
			`login` char(100) not null,
			`name` char(100),
			`password` text not null,
			`group` int,
			unique(`login`(100))
		)engine=myisam default charset=utf8',
	);
	
	protected function dbSelect($filter){
		$query='select `user`.`id`,`user`.`login`,`user`.`name`,`group`.`id` as groupid,`group`.`name` as groupname from `user`,`group` where `user`.`group`=`group`.`id`';
		if(count($filter)){
			$where='';
			foreach($filter as $field=>$val){
				switch($field){
				case 'id':
				case 'name':
				case 'login':
				case 'password':$val=md5($val);
				case 'group':
					$where.=' and '.$field.'=:'.$field;
					break;
				default:continue; break;
				}
			}
			
			$stt=$this->pdo->prepare($query.$where);
			foreach($filter as $field=>$val){
				$stt->bindValue($field,$val);
			}
			$stt->execute();
			return $stt;
		}
		
		return $this->pdo->query($query);
	}
	
	protected function dbInsert($usr){
		$stt=$this->pdo->prepare('insert into `user` values (null,:login,:name,:password,:group)');
		$stt->bindValue('login',$usr->login);
		$stt->bindValue('name',$usr->name);
		$stt->bindValue('password',$usr->password);
		$stt->bindValue('group',$usr->group->id);
		$stt->execute();
		return $stt;
	}
	
	protected function dbSave($usr){
		if(!$usr->id){
			return FALSE;
		}
		
		$stt=$this->pdo->prepare('update `user` set `login`=:login,`name`=:name,`password`=:password,`group`=:groupid where `id`=:id');
		$stt->bindValue('id',$usr->id);
		$stt->bindValue('login',$usr->login);
		$stt->bindValue('name',$usr->name);
		$stt->bindValue('password',$usr->password);
		$stt->bindValue('groupid',$usr->group->id);
		$stt->execute();
		return $stt;
	}
	
	protected function dbDelete($usr){
		if(!$usr->id){
			return FALSE;
		}
		
		$stt=$this->pdo->prepare('delete from `user` where `id`=:id');
		$stt->bindValue('id',$usr->id);
		$stt->execute();
		return $stt;
	}
	
	protected function fetch($usr){
		$user=new UserModel($usr);
		if(isset($usr['groupid'])&&$usr['groupid']){
			$user->group=new GroupModel(array('id'=>$usr['groupid'],'name'=>$usr['groupname']));
		}
		return $user;
	}
}
?>
