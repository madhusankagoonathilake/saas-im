<?php

namespace SaaSInfoManager\Bundle\CoreBundle\Entity;

class TemplateMessage {
    
    protected $type;
    protected $content;
    
    /**
     * 
     * @param string $type
     * @param string $content
     */
    public function __construct($type, $content) {
        $this->type = $type;
        $this->content = $content;
    }
    
    public function getType() {
        return $this->type;
    }

    public function getContent() {
        return $this->content;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setContent($content) {
        $this->content = $content;
    }


}
