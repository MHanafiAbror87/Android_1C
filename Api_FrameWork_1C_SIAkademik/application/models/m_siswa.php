<?php  


/**
* 
*/
class m_siswa extends CI_Model
{
	
	private $table_name = "pgn_siswa";

	private $primary = "kode_siswa";

	function get_all($kode_kelas){

		#Get all data users
		$this->db->where("kode_kelas",$kode_kelas);
		$data=$this->db->get($this->table_name);
		return $data->result();

	}

	function get_by_kode_siswa($kode_siswa){

		#Get data user by kode_siswa
		$this->db->where($this->primary,$kode_siswa);
		$data=$this->db->get($this->table_name);

		return $data->row();
	}


	function get_by_nama_siswa($nama_siswa){		
		#Get data by nama_siswa
		$this->db->where('nama_siswa',$nama_siswa);
		$data=$this->db->get($this->table_name)->row();

		return $data;
	}


	function insert($data){

		#Insert data to table pgn_siswa
		$insert=$this->db->insert($this->table_name,$data);

		return $insert;
	}

	function update($kode_siswa,$data){
		#Update data user by kode_siswa
		$this->db->where($this->primary,$kode_siswa);
		$update=$this->db->update($this->table_name,$data);
		if ($update) {
			$update=$this->get_by_kode_siswa($kode_siswa);
		}

		return $update;
	}

}

?>