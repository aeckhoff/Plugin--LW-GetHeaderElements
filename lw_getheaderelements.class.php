<?php

/**************************************************************************
*  Copyright notice
*
*  Copyright 2010-2012 Logic Works GmbH
*
*  Licensed under the Apache License, Version 2.0 (the "License");
*  you may not use this file except in compliance with the License.
*  You may obtain a copy of the License at
*
*  http://www.apache.org/licenses/LICENSE-2.0
*  
*  Unless required by applicable law or agreed to in writing, software
*  distributed under the License is distributed on an "AS IS" BASIS,
*  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
*  See the License for the specific language governing permissions and
*  limitations under the License.
*  
***************************************************************************/

class lw_getheaderelements extends lw_plugin 
{
    function __construct() 
    {
		parent::__construct();
		$this->fileStoragePath = $this->config['path']['datapool']."lw_form/";
    }

    function buildPageOutput() 
    {
        $this->db->setStatement("SELECT a.id FROM t:lw_container a, t:lw_cobject b WHERE a.page_id = :id AND a.object_id = b.id AND b.description like '%lw_header%' ORDER BY a.seq ");
        $this->db->bindParameter('id', 'i', $this->request->getIndex());
        $erg = $this->db->pselect();
        foreach($erg as $element) {
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
