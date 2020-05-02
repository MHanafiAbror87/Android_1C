<?php  

/**
* 
*/
class m_dashboard extends CI_Model
{

	function get_data(){
		return $this->db->query("SELECT * FROM pgn_siswa ",false)->row();
		// return $this->db->get()->row();
	}	

}

?>