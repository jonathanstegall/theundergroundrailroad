<?php
class formElement{
    private $html='';
    public function __construct($type='text',$attributes=array
('name'=>'default'),$options=array()){
        // check for <input> elements
        if(preg_match("/^
(text|radio|checkbox|password|hidden|submit|reset|button|image|
file)$/",$type)){
            $openTag='<input type="'.$type.'" ';
            $closeChar=' ';
            $closeTag='/>';
        }
        // check for <textarea> and <select> elements
        else if(preg_match("/^(textarea|select)$/",$type)){
            $openTag='<'.$type.' ';
            $closeChar='>';
            $closeTag='</'.$type.'>';
        }
        else{
            throw new Exception('Invalid element type');
        }
        if(!is_array($attributes)||count($attributes)<1){
            throw new Exception('Invalid number of attributes for
<'.type.'> element');
        }
        // loop over element attributes
        $elemAttributes='';
        foreach($attributes as $attribute=>$value){
            if(empty($attribute)||empty($value)){
                throw new Exception('Invalid attribute or value
for <'.type.'> element');
            }
            // check for 'required' attribute - add client-side validation
            $attribute=='required'?JSGenerator::addValidation
($attributes
['name'],$value):$elemAttributes.=$attribute.'="'.$value.'" ';
        }
        // check for <select> options
        $selOptions='';
        if(count($options)>0){
            foreach($options as $value=>$text){
                if(empty($value)||empty($text)){
                    throw new Exception('Invalid value or text
for <'.type.'> element');
                }
                $selOptions.='<option
value="'.$value.'">'.$text.'</option>';
            }
        }
        // build form element(X)HTML output
        $this->html.=$openTag.trim
($elemAttributes).$closeChar.$selOptions.$closeTag;
    }
    // return complete (X)HTML
    public function getHTML(){
        return $this->html;
    }
}

abstract class JSGenerator{
    private static $js=array();
    // load external JavaScript validating functions
    public function initializeFunctions(){
        self::$js['ext']='<script language="javascript"
src="functions.js"></script>';
    }
    // add JavaScript validating function to selected field
    public function addValidation($fieldName,$valData){
        if(!is_array($valData)){
            throw new Exception('Invalid client-side validation
array');
        }
        $obj='document.getElementsByTagName("form")[0].elements
["'.$fieldName.'"]';
        // obtain client-side validating function & error message
        list($valFunction,$errorMessage)=$valData;
        self::$js['int'].='if
(!'.$valFunction.'('.$obj.',"'.$errorMessage.'")){'.$obj.'.focus
();return false};';
    }
    // return JavaScript code
    public function getCode(){
        return self::$js['ext'].'<script language="javascript">function validate(){'.self::$js['int'].'}
</script>';
    }
}

class formGenerator{
    private $html=array();
    private $action;
    private $method;
    public function __construct($action='',$method='post'){
        // setup form attributes
        $this->action=empty($action)?$_SERVER['PHP_SELF']:$action;
        $this->method=$method!='post'||$method!
='get'?'post':$method;
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