<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a nameconvert module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Nameconvert Module
 */
class Plugin_Nameconvert extends Plugin
{
	/**
	 * Item List
	 * Usage:
	 * 
	 * {{ nameconvert:items limit="5" order="asc" }}
	 *      {{ id }} {{ name }} {{ slug }}
	 * {{ /nameconvert:items }}
	 *
	 * @return	array
	 */
	function items()
	{
		$limit = $this->attribute('limit');
		$order = $this->attribute('order');
		
		return $this->db->order_by('name', $order)
						->limit($limit)
						->get('nameconvert_items')
						->result_array();
	}
}

/* End of file plugin.php */