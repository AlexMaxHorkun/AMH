<?php
namespace AMH\Mapper;

use \AMH\Model\Model as AMHModel;

abstract class Mapper{
	protected $reqTables=array();
	protected $items=null;
	protected $pdo;
	protected $options=array(
		'getArrayOnly'=>TRUE,
		'fieldsMap'=>array(),//ключи - название колонок, значения - названия ствойств
		'storeLastReceived'=>FALSE,
	);
	protected $lastUsedFilter=null;
	
	abstract protected function dbSelect($filter);
	abstract protected function dbInsert($item);
	abstract protected function dbSave($item);
	abstract protected function dbDelete($item);
	
	protected function fetch($row){
		$fields=array();
		foreach($row as $key=>$val){
			if(isset($this->options['fieldsMap'][$key])){
				$key=$this->options['fieldsMap'][$key];
			}
			$fields[$key]=$val;
		}
		return (object)$fields;
	}
	
	private function createTables(){
		if(count($this->reqTables)){
			try{
				foreach($this->reqTables as $query){
					$this->pdo->query($query);
				}
				unset($query);
			}
			catch(\PDOException $e){
				throw new \Exception('Invalid table queries given to '.get_class($this));
				return FALSE;
			}
			return TRUE;
		}
		else{
			throw new \Exception(get_class($this).' - Cannot use database, table(s) does not exist and no queries to create them defined');
			return FALSE;
		}
	}
	
	public function __construct(\PDO $pdo,array $options=array()){
		$this->pdo=$pdo;
		$this->setOptions($options);
	}
	
	public function setOptions(array $options){
		if(isset($options['getArrayOnly'])){
			$this->options['getArrayOnly']=$options['getArrayOnly'];
			
		}
		if(isset($options['fieldsMap'])&&is_array($options['fieldsMap'])){
			$this->options['fieldsMap']=$options['fieldsMap'];
		}
		if(isset($options['storeLastReceived'])){
			$this->options['storeLastReceived']=$options['storeLastReceived'];
		}
	}
	
	public function get(array $filter=array()){
		if(is_array($this->items)&&count($this->items)&&$this->options['storeLastReceived']&&$filter==$this->lastUsedFilter){
			return $this->items;
		}
		
		try{
			$res=$this->dbSelect($filter);
		}
		catch(\PDOException $e){
			if($e->getCode()=='42S02'){
				if($this->createTables()){
					return $this->get($filter);
				}
				else
					return FALSE;
			}
		}
		
		$items=array();
		
		$res->setFetchMode(\PDO::FETCH_ASSOC);
		while($row=$res->fetch()){
			$items[]=$this->fetch($row);
		}
		
		if((count($items)==1)&&(!$this->options['getArrayOnly'])){
			$items=$items[0];
		}
		
		if(!count($items)){
			$items=null;
		}
		
		if($this->options['storeLastReceived']){
			$this->items=$items;
			$this->lastUsedFilter=$filter;
		}
		
		return $items;
	}
	
	public function insert($item){
		return $this->manage('Insert',$item);
	}
	
	public function save($item){
		return $this->manage('Save',$item);
	}
	
	public function delete($item){
		return $this->manage('Delete',$item);
	}
	
	private function manage($action,$item){
		switch($action){
		case 'Insert':
		case 'Save':
		case 'Delete':
			break;
		default:
			throw new \Exception('Wrong "action" parametr given to '.get_class($this).'::'.__FUNCTION__);
			return null;
		}
		
		try{
			$method='db'.$action;
			$res=$this->$method($item);
		}
		catch(\PDOException $e){
			if($e->getCode()=='42S02'){
				$this->createTables();
				return $this->manage($action,$item);
			}
			else{
				return FALSE;
			}
		}
		
		if($action=='Insert'){
			return $this->pdo->lastInsertId();
		}
		
		return TRUE;
	}
}
?>
