<?php  


/**
* 
*/
require APPPATH . 'libraries/REST_Controller.php';

class Siswa extends REST_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		#Configure limit request methods
		$this->methods['index_get']['limit']=10; #10 requests per hour per siswa/key
		$this->methods['index_post']['limit']=10; #10 requests per hour per siswa/key
		$this->methods['index_delete']['limit']=10; #10 requests per hour per siswa/key
		$this->methods['index_put']['limit']=10; #10 requests per hour per siswa/key
		
		#Configure load model api table siswa
		$this->load->model('m_siswa');
	}


	function index_get($kode_kelas=null,$kode_siswa=null){	
		
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'success get siswa' , 'data' => null );
		
		#Set response API if Not Found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'no siswa were found' , 'data' => null );
        
		#
		if (!empty($this->get('kode_siswa')))
			$kode_siswa=$this->get('kode_siswa');

		if (!empty($this->get('kode_kelas')))
		$kode_kelas=$this->get('kode_kelas');

		if ($kode_siswa==null||$kode_siswa==0) {
			#Call methode get_all from m_users model
			$siswa=$this->m_siswa->get_all($kode_kelas);
		
		}

		if ($kode_siswa!=null&&$kode_siswa!=0) {
			
			#Check if kode_siswa <= 0
			if ($kode_siswa<=0) {
				$this->response($response['NOT_FOUND'], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}

			#Call methode get_by_kode_siswa from m_siswa model
			$siswa=$this->m_siswa->get_by_kode_siswa($kode_siswa);
		}


        # Check if the siswa data store contains siswa
		if ($siswa) {
			$response['SUCCESS']['data']=$siswa;

			#if found siswa
			$this->response($response['SUCCESS'] , REST_Controller::HTTP_OK);

		}else{

	        #if Not found siswa
	        $this->response($response['NOT_FOUND'], REST_Controller::HTTP_NOT_FOUND); # NOT_FOUND (404) being the HTTP response code

		}

	}


	function valkode_siswaate($kode_siswa){
		$siswa=$this->m_siswa->get_by_kode_siswa($kode_siswa);
		if ($siswa)
			return TRUE;
		else
			return FALSE;
	}

	function Upload_Images($name) 
    {

    		if ($this->post('foto')) {
	    		$strImage = str_replace('data:image/png;base64,', '', $this->post('foto'));			
    		}else{
    			$strImage = str_replace('data:image/png;base64,', '', $this->put('foto'));
    		}
    		if (!empty($strImage)) {
    			$img = imagecreatefromstring(base64_decode($strImage));
							
				if($img != false)
				{
				   if (imagejpeg($img, './upload/avatars/'.$name)) {
				   	return true;
				   }else{
				   	return false;
				   }
				}
			}
	}


}

?>