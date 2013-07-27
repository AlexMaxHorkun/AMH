<?php
namespace AMH\ViewHelper;

class MesNredirect extends \Zend\View\Helper\AbstractHelper{
	public function __invoke($mes,$url='',array $params=array()){
		$color=null;
		if(isset($params['color'])){
			$color=$params['color'];
		}
		$secs=2.5;
		if(isset($params['secs'])){
			$secs=$params['secs'];
		}
		$class='';
		if(isset($params['class'])){
			$class=$params['class'];
		}
		$style='';
		if(isset($params['style'])){
			$style=$params['style'];
		}
		$width=240;
		if(isset($params['width'])){
			$width=$params['width'];
		}
		$height=64;
		if(isset($params['height'])){
			$secs=$params['height'];
		}
				
		$html='<div valign="middle" mnr-view-helper="1"
			style="position:fixed;
				padding:10px;
				text-align:center;
				margin-left:auto;margin-right:auto;
				border:1px solid gray;
				border-radius:5px;
				background-color:white;
				vertical-align:middle;'
				.(($color)? 'color:'.$color.';':'').'" 
			class="'.$class.'"><h4>'
			.$mes.
			'</h4></div>
			<script>
				jQuery("div[mnr-view-helper=\'1\']").css("width","0px");
				jQuery("div[mnr-view-helper=\'1\']").css("height","0px");
				jQuery("div[mnr-view-helper=\'1\']").animate({width:'.$width.',height:'.$height.'},500);
				setTimeout(function(){window.location="'.$url.'";},'.($secs*1000).')
			</script>';
		return $html;
	}
}
?>
