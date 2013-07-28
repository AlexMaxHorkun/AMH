<?php
namespace AMH\Test;

class Test{
	protected $result=array('time'=>array(),'mem'=>array());
	
	public function start(){
		$this->result['time']=array();
		$this->result['mem']=array();
		
		$this->result['mem'][0]=memory_get_usage();
		$this->result['time'][0]=microtime(TRUE);		
	}
	
	public function finish(){
		if(!count($this->result['time'])||!count($this->result['mem'])){
			return;
		}
		
		$this->result['mem'][1]=memory_get_usage();
		$this->result['time'][1]=microtime(TRUE);
	}
	
	//формат[time] - в виде "&m; минут &s; секунд &ms;"
	//формат[memory] - "kb" или "mb" или "gb"
	public function getResult(array $format=null){
		if(count($this->result['time'])!=2||count($this->result['mem'])!=2){
			return FALSE;
		}
		
		$time=round($this->result['time'][1]-$this->result['time'][0],5);
		$mem=$this->result['mem'][1]-$this->result['mem'][0];
		
		if(isset($format['time'])){
			$s=(int)$time;
			$m=round($time/60);
			$ms=$time-$s;
			$s-=$m*60;
			$ms=substr((string)$ms,2);
			$time=$format['time'];
			$time=str_replace('&m;',$m,$time);
			$time=str_replace('&s;',$s,$time);
			$time=str_replace('&ms;',$ms,$time);
			unset($m,$s,$ms);
		}
		if(isset($format['mem'])){
			$exp=0;
			if(strtolower($format['mem'])=='mb'){
				$exp=2;
			}
			if(strtolower($format['mem'])=='kb'){
				$exp=1;
			}
			if(strtolower($format['mem'])=='gb'){
				$exp=3;
			}
			$mem/=pow(1024,$exp);
			unset($exp);
			$mem=round($mem,3);
		}
		
		return (object)array('time'=>$time,'memory'=>$mem);
	}
}
?>