<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Module_permission_model extends MY_Model {

	
	public function assign_module_permissions( $role_id, $menus="" )
	{
		
		if( empty($role_id) || empty($menus) ) {
			return false;
		}

		foreach ($menus as $menu ) {
			
			$create = array(
				ROLE_ID		=>	$role_id,
				MENU_ID		=>	$menu
			);
			
			$this->db->insert( ROLE_MENU_MAPPING, $create );
		}	
		
		return true;
	}
	
	public function update_module_permissions( $role_id, $menus="" )
	{
		
		if( empty($role_id) || empty($menus) ) {
			return false;
		}
		//print_r( $role_id ); print_r( $menus ); exit();

		$this->db->where( ROLE_ID, $role_id );
		$delete = $this->db->delete( ROLE_MENU_MAPPING );

		foreach ($menus as $menu ) {
			
			$create = array(
				ROLE_ID		=>	$role_id,
				MENU_ID		=>	$menu
			);
			
			$this->db->replace( ROLE_MENU_MAPPING, $create );
		}	
		
		return true;
	}

	public function get_assigned_menues_for_role($role_id)
	{
		$query = $this->db->select('*')
				->where( ROLE_ID, $role_id )
				->get( ROLE_MENU_MAPPING );

		return $query->result();
	} 

	public function get_menu_by_order()
	{
		$query = $this->db->select('*')
							->from( ROLE_MENU )
							->order_by( 'menu_sequence', 'asc' )
							->get();

		return $query->result();
	}
}