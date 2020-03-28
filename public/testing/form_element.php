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
            throw new Exception('Invalid number of attributes for <'.type.'> element');
        }
        // loop over element attributes
        $elemAttributes='';
        foreach($attributes as $attribute=>$value){
            if(empty($attribute)||empty($value)){
                throw new Exception('Invalid attribute or value for <'.type.'> element');
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
?>