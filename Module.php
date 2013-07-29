<?php
namespace AMH;

class Module{
	protected $config=array(
		'enable'=>array('User'),
	);
	
	public function onBootstrap($e){
		$conf=$e->getApplication()->getConfig();
		if(isset($conf['AMH'])){
			$this->config=array_merge($this->config,$conf['AMH']);
		}
	}	
	
	function getAutoloaderConfig(){
		return array(
			'Zend\Loader\StandardAutoloader'=>array(
				'namespaces'=>array(
					__NAMESPACE__=>__DIR__.'/src/'.__NAMESPACE__,
				),
			),
		);
	}
	
	function getServiceConfig(){
		$serviceConfig=array('factories'=>array(
			
		));
		if(in_array('User',$this->config['enable'])){
			$serviceConfig['factories']=array_merge($serviceConfig['factories'],array(
				'AMH\User\Mapper\User'=>function($sm){
					return new \AMH\User\Mapper\User($sm->get('AMH\User\Pdo'),array('getArrayOnly'=>FALSE));
				},
				
				'AMH\User\Pdo'=>function($sm){
					$pdo=new \PDO('mysql:host=localhost;dbname=amh;','root','4837570Mind');
					$pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
					return $pdo;
				},
				
				'AMH\User\Mapper\Group'=>function($sm){
					return new \AMH\User\Mapper\Group($sm->get('AMH\User\Pdo'),array('getArrayOnly'=>FALSE));
				},
			));
		}
		
		return $serviceConfig;
	}
}
?>
