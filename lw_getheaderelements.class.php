<?php

class lw_getheaderelements extends lw_plugin {

    function __construct() {
		parent::__construct();
		$this->fileStoragePath = $this->config['path']['datapool']."lw_form/";
		$reg 	 		= lw_registry::getInstance();
		$this->fPost 	= $reg->getEntry('fPost');
		$this->config	= $reg->getEntry('config');
		$this->maxFileSize = array();
    }

    function buildPageOutput() {
        $this->db->setStatement("SELECT a.id FROM t:lw_container a, t:lw_cobject b WHERE a.page_id = :id AND a.object_id = b.id AND b.description like '%lw_header%' ORDER BY a.seq ");
        $this->db->bindParameter('id', 'i', $this->request->getIndex());
        $erg = $this->db->pselect();
        foreach($erg as $element)
        {
	        $this->db->setStatement("SELECT * FROM t:lw_eav WHERE entity_id = :eid ");
	        $this->db->bindParameter('eid', 'i', $element['id']);
	        $field = $this->db->pselect();
	        foreach($field as $single) {
			    if ($single['attribute'] == 'lw_header') {
				    $out.= stripslashes(html_entity_decode($single['value']));
			    }
			}	        
        }
        return $out;
    }
}
