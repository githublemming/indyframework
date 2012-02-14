<?php

require_once INDY_TAGS. '/SimpleTag.php';

class SetTag extends SimpleTag
{
    protected $var;
    protected $value;
        
    public function doTag()
    {              
        $this->pageScope->setAttribute($this->var, $this->value);
    }
}

?>
