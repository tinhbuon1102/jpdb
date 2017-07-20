<?php
Yii::import('zii.widgets.CLinkPager');
class SimplaPager extends CLinkPager{
	const CSS_HIDDEN_PAGE='hidden';
	const CSS_SELECTED_PAGE='current';
	public function run()
	{
		 //
		 // here we call our createPageButtons
		 //
		 $buttons=$this->createPageButtons();
		 //
		 // if there is nothing to display return
		 if(empty($buttons))
			  return;
		 //
		 // display the buttons
		 //
		 echo $this->header; // if any
		 echo implode("&nbsp;",$buttons);
	}
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
       //
       // CSS_HIDDEN_PAGE and CSS_SELECTED_PAGE
		   // are constants that we use to apply our styles
		   //
		if($hidden || $selected)
			$class=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
		$class .= ' number';
	 
		   //
		   // here I write my custom link - site.call is a JS function that takes care of an AJAX call
		   //
		return CHtml::link($label,'#',array(
					'class'=>$class,
					'onclick'=>"site.call(CONST_MAIN_LAYER,'{$this->createPageUrl($this->getController(),$page)}');"));
	}
	public function createPageUrl($controller,$page)
	{
		// HERE I USE POST AS I DO AJAX CALLS VIA POST NOT GET AS IT IS BY 
		// DEFAULT ON YII
		$params=$this->getPages()->params===null ? $_POST : $this->getPages()->params;
		if($page>0) // page 0 is the default
		   $params[$this->getPages()->pageVar]=$page+1;
	   else
		  unset($params[$this->getPages()->pageVar]);
	    return $controller->createUrl($this->getPages()->route,$params);
	}
   
}
?>