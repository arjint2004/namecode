<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Nameconvert extends Module {

	public $version = '2.1';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Name Identifier'
			),
			'description' => array(
				'en' => 'This is a PyroCMS module nameconvert.'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'content', // You can also place modules in their top level menu. For example try: 'menu' => 'Nameconvert',
			'sections' => array(
				'items' => array(
					'name' 	=> 'Name Identifier', // These are translated from your language file
					'uri' 	=> 'admin/nameconvert',
						'shortcuts' => array(
							'create' => array(
								'name' 	=> 'nameconvert:create',
								'uri' 	=> 'admin/nameconvert/create',
								'class' => 'add'
								)
							)
						)
				)
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('nameconvert');
		$this->db->delete('settings', array('module' => 'nameconvert'));

		$nameconvert = array(
                        'id' => array(
									  'type' => 'INT',
									  'constraint' => '11',
									  'auto_increment' => TRUE
									  ),
						'name' => array(
										'type' => 'VARCHAR',
										'constraint' => '100'
										),
						'slug' => array(
										'type' => 'VARCHAR',
										'constraint' => '100'
										)
						);

		$nameconvert_setting = array(
			'slug' => 'nameconvert_setting',
			'title' => 'Nameconvert Setting',
			'description' => 'A Yes or No option for the Nameconvert module',
			'`default`' => '1',
			'`value`' => '1',
			'type' => 'select',
			'`options`' => '1=Yes|0=No',
			'is_required' => 1,
			'is_gui' => 1,
			'module' => 'nameconvert'
		);

		$this->dbforge->add_field($nameconvert);
		$this->dbforge->add_key('id', TRUE);

		if($this->dbforge->create_table('nameconvert') AND
		   $this->db->insert('settings', $nameconvert_setting) AND
		   is_dir($this->upload_path.'nameconvert') OR @mkdir($this->upload_path.'nameconvert',0777,TRUE))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('nameconvert');
		$this->db->delete('settings', array('module' => 'nameconvert'));
		{
			return TRUE;
		}
	}


	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}
}
/* End of file details.php */
