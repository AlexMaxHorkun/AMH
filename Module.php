<?php
namespace AMH;

class Module{
	function getAutoloaderConfig(){
		return array(
			'Zend\Loader\StandardAutoloader'=>array(
				'namespaces'=>array(
					__NAMESPACE__=>__DIR__.'/src/'.__NAMESPACE__,
				),
			),
		);
	}
	
	/*function getServiceConfig(){
		return [
			'factories'=>[
				'modelTest'=>function($sm){
					
				}
			],
		];
	}*/
}
?>
