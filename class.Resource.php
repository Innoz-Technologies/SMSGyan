<?php

abstract class Resource {
    /**
     * Contains the complete text article
     * @var type 
     */
    public $article;
    /**
     * Related media URL
     * @var type 
     */
    public $media;
    /**
     * Media's caption. Will be used for listing suggestion
     * @var type 
     */
    public $media_caption;
    /**
     * Priority
     * @var int
     */
    public $priority;
    protected $global_id;
    protected $source_machine;
    
    /**
     * Returns all content for the resource
     */
    abstract protected function get_data($query);
    
    function __constructor($global_id, $source_machine) {
        $this->global_id = $global_id;
        $this->source_machine = $source_machine;
    }
}
?>
