<?php
class formGenerator{
    private $html=array();
    private $action;
    private $method;
    public function __construct($action='',$method='post'){
        // setup form attributes
        $this->action=empty($action)?$_SERVER['PHP_SELF']:$action;
        $this->method=$method!='post'||$method!='get'?'post':$method;
    }
    // add form element
    public function addElement($type='text',$attributes=array
('name'=>'default'),$options=array()){
        if(!$elem=new formElement($type,$attributes,$options)){
            throw new Exception('Failed to instantiate '.$type.'
object');
        }
        $this->html[]=$elem->getHTML();
    }
    // add form part
    public function addFormPart($formPart='<br />'){
        $this->html[]=trim($formPart)==''?'<br />':$formPart;
    }
    // display form
    public function display(){
        $formOutput='<form action="'.$this->action.'"
method="'.$this->method.'">';
        foreach($this->html as $html){
            $formOutput.=$html;
        }
        $formOutput.='</form>';
        // load global JavaScript checking functions
        JSGenerator::initializeFunctions();
        // append JavaScript code to general (X)HTML output
        $formOutput.=JSGenerator::getCode();
        return $formOutput;
    }
}
?>