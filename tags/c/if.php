<?php

require_once INDY_TAGS. '/BodyTag.php';

class IfTag extends BodyTag
{
    protected $test;
        
    public function doTag()
    {    	
        if ($this->test == 1)
        {
            $body = $this->getBodyContent();
                        
            $this->out($body);
        }
    }
}

?>
