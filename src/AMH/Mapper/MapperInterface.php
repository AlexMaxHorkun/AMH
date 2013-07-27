<?php
namespace AMH\Mapper;

interface MapperInterface{
	public function get(array $filter=array());
	
	public function insert($item);
	
	public function save($item);
	
	public function delete($item);
}
?>
