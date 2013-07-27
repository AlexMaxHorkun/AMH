<?php
namespace AMH\Hydrator;

class Model implements \Zend\Stdlib\Hydrator\HydratorInterface{
	public function extract($object){
		return $object->toArray();
	}

    public function hydrate(array $data, $object){
    	$obj=$object->toArray();
    	$data=array_merge($obj,$data);
    	return new \AMH\Model\Model($data);
    }
}
?>
