<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a nameconvert module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Nameconvert Module
 */
class Nameconvert_m extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		
	}
	
	
	//PROCESS
	
	public function getIndikatorforSearch()
	{
		$q=$this->db->query('SELECT k.id as id_kat,k.kategori, i.nama FROM  default_name_kategori_indikator k JOIN default_indikator i ON i.id_kat_indikator=k.id WHERE i.active=1');
		$asal=$q->result_array();
		$p1=array();
		foreach($asal as $dataasal){
			$p1[$dataasal['kategori']][]=$dataasal['nama'];
		}
		//pr($p1);
		//echo $this->db->last_query();die();
		return $p1;
	}
	
	//NAME LIST

	public function get_namaByIdGroup($id=0)
	{
		$q=$this->db->query('SELECT * FROM default_nameconverts WHERE id_group='.$id.' AND kesimpulan="" AND result=""');
		//echo $this->db->last_query();die();
		return $q->result_array();
	}
	public function get_nama()
	{
		$q=$this->db->query('SELECT * FROM default_nameconverts WHERE  kesimpulan="" AND result="" OR  kesimpulan like "%unknown%" ORDER BY kesimpulan ASC');
		//echo $this->db->last_query();die();
		return $q->result_array();
	}	
	public function get_nameById($id=0)
	{

		$q=$this->db->query('SELECT * FROM default_nameconverts WHERE id='.$id.'');
		//echo $this->db->last_query();die();
		$cnt=$q->result_array();
		return $cnt;
	}
	public function get_count_name($active=1,$cnd='')
	{
		if($cnd==''){$cndact='';}else{$cndact=$cnd;}
		if($active==''){$cndact.='';}else{$cndact.='AND active='.$active.'';}
		$q=$this->db->query('SELECT COUNT(*) FROM default_nameconverts WHERE 1 '.$cndact.'');
		//echo $this->db->last_query();die();
		$cnt=$q->result_array();
		return $cnt[0]['COUNT(*)'];
	}
	public function get_name($field="*",$limit=array(),$active=1,$cnd='')
	{
		if($cnd==''){$cndact='';}else{$cndact=$cnd;}
		if($active==''){$cndact.='';}else{$cndact.='AND active='.$active.'';}
		$q=$this->db->query('SELECT * FROM default_nameconverts WHERE 1 '.$cndact.' ORDER BY name ASC  LIMIT '.$limit[1].','.$limit[0].'');
		//echo $this->db->last_query();
		return $q->result_array();
	}
	//NAME GROUP
	public function get_count_nameGroup()
	{

		$q=$this->db->query('SELECT COUNT(*) FROM default_name_group');
		//echo $this->db->last_query();die();
		$cnt=$q->result_array();
		return $cnt[0]['COUNT(*)'];
	}
	public function get_nameGroupById($id=0)
	{
		$q=$this->db->query('SELECT id,`group`,keterangan,active FROM default_name_group WHERE id='.$id.' ');
		//echo $this->db->last_query();die();
		return $q->result_array();
	}
	public function get_nameGroup($field="*",$limit=array(),$active=1)
	{
		if($active==''){$cndact='';}else{$cndact='AND active='.$active.'';}
		$q=$this->db->query('SELECT id,`group`,keterangan,active FROM default_name_group WHERE 1 '.$cndact.' LIMIT '.$limit[1].','.$limit[0].'');
		//echo $this->db->last_query();die();
		return $q->result_array();
	}
	public function getAll_nameGroup($field="*",$active=1)
	{
		if($active==''){$cndact='';}else{$cndact='AND active='.$active.'';}
		$q=$this->db->query('SELECT id,`group`,keterangan,`active` FROM default_name_group WHERE 1 '.$cndact.'');
		//echo $this->db->last_query();die();
		return $q->result_array();
	}	
	//IDENTIFIER CAT
	public function get_count_identifierCat()
	{

		$q=$this->db->query('SELECT COUNT(*) FROM default_name_kategori_indikator');
		//echo $this->db->last_query();die();
		$cnt=$q->result_array();
		return $cnt[0]['COUNT(*)'];
	}
	public function get_identifierCat($field="*",$limit=array(),$active=1)
	{
		if($active==''){$cndact='';}else{$cndact='AND active='.$active.'';}
		$q=$this->db->query('SELECT * FROM default_name_kategori_indikator WHERE 1 '.$cndact.'  LIMIT '.$limit[1].','.$limit[0].'');
		//echo $this->db->last_query();die();
		return $q->result_array();
	}
	public function get_identifierCatById($id=0)
	{
		$q=$this->db->query('SELECT * FROM default_name_kategori_indikator WHERE id='.$id.' ');
		//echo $this->db->last_query();die();
		return $q->result_array();
	}
	public function get_identifierCatAll($field="*",$active=1)
	{
		if($active==''){$cndact='';}else{$cndact='AND active='.$active.'';}
		$q=$this->db->query('SELECT * FROM default_name_kategori_indikator WHERE 1 '.$cndact.'');
		//echo $this->db->last_query();die();
		return $q->result_array();
	}
	//IDENTIFIER NAME
	public function get_count_identifierName($cnd='')
	{

		$q=$this->db->query('SELECT COUNT(*) FROM default_indikator WHERE 1 '.$cnd.'');
		//echo $this->db->last_query();
		//die();
		$cnt=$q->result_array();
		return $cnt[0]['COUNT(*)'];
	}
	public function get_identifierNameById($id=0)
	{
		$q=$this->db->query('SELECT * FROM default_indikator WHERE id='.$id.' ');
		//echo $this->db->last_query();die();
		return $q->result_array();
	}
	public function get_identifierName($field="*",$limit=array(),$cnd)
	{
		$q=$this->db->query('SELECT * FROM default_indikator WHERE active=1 '.$cnd.' ORDER BY nama ASC LIMIT '.$limit[1].','.$limit[0].'');
		//echo $this->db->last_query();//die();
		return $q->result_array();
	}
	
	public function get_nameGroupAll($field="*",$active=1)
	{
		if($active==''){$cndact='';}else{$cndact='AND active='.$active.'';}
		$q=$this->db->query('SELECT * FROM default_name_group WHERE 1 '.$cndact.'');
		//echo $this->db->last_query();die();
		return $q->result_array();
	}
	//ITEMS
	public function create($input)
	{
		$to_insert = array(
			'name' => $input['name'],
			'slug' => $this->_check_slug($input['slug'])
		);

		return $this->db->insert('nameconvert', $to_insert);
	}

	public function _check_slug($slug)
	{
		$slug = strtolower($slug);
		$slug = preg_replace('/\s+/', '-', $slug);

		return $slug;
	}
}
