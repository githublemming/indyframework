<?php

require_once INDY_TAGS. '/SimpleTag.php';

class RemoveTag extends SimpleTag
{
    protected $var;
        
    public function doTag()
    {        
        $this->pageScope->removeAttribute($this->var);
    }
}

?>
