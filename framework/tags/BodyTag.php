<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_TAGS . '/SimpleTag.php';
require_once INDY_TAGS . '/Tag.php';

abstract class BodyTag extends SimpleTag implements Tag
{
    private $bodyContent;
    
    public function __construct($bodyTag, &$pageScope)
    {                
        parent::__construct($bodyTag, $pageScope);
        
        $this->extractBodyContent($bodyTag);
    }
    
    public function getBodyContent()
    {
        return $this->bodyContent;
    }
    
    private function extractBodyContent($bodyTag)
    {
        /**
         * 
         * <test:body attrib="body">Replaces %body% with the attrib</test:body>
         * 
         * <c:if test="${10 > 5}">
         * 
         */
        $bodyTagPattern = "~" . REGEX_BODY_OPEN_TAG_PATTERN . "~is";
        
        $tags = array();
        preg_match_all($bodyTagPattern, $bodyTag, $tags, PREG_SET_ORDER);
        
        $tag = $tags[0];
        $openTag = $tag[0];            
        $closeTag = '<\\' . $tag[1] . '>';

        $start = strlen($openTag);
        $end = strlen($closeTag);

        $length = strlen($bodyTag) - $start - $end;

        $this->bodyContent = substr($bodyTag, $start, $length);
    }
}
?>
