<?php 

class Myadmin extends CI_Controller {

	function __construct(){
		parent::__Construct();
		$this->load->database();
		$this->load->model("Modeladmin");
		$this->load->library('form_validation');
	}

	public function index(){
		$data ['title'] = "ADMIN";
		$this->load->view('headadm',$data);
		$this->load->view('view_dashboard');
		$this->load->view('footadm');
	}

	public function tambahdata(){
		$data ['title'] = "TAMBAH DATA | Sekolah Tinggi Teknologi Bandung";
		$data ['tampil'] = $this->Modeladmin->tampilkan_data();
		$this->load->view('headadm',$data);
		$this->load->view('modul/view_tambahdata',$data);
		$this->load->view('footadm');
	}

	public function editdata($id){
		$where = array('id' => $id);
		$data ['title'] = "EDIT DATA | Sekolah Tinggi Teknologi Bandung";
		$data ['datamhs'] = $this->Modeladmin->edit_data($where, 'data_mahasiswa')->row_array();
		$this->load->view('headadm',$data);
		$this->load->view('modul/view_editdata',$data);
		$this->load->view('footadm');
	}

	public function aksi_tambah_data(){
		$this->form_validation->set_rules('npm','Npm','required|trim',['required'=>'Npm Tidak Boleh Kosong!']);
		$this->form_validation->set_rules('nama','Nama','required|trim',['required'=>'Nama Tidak Boleh Kosong!']);
		$this->form_validation->set_rules('semester','Semester','required|trim',['required'=>'Semester Tidak Boleh Kosong!']);

		if($this->form_validation->run() !=false){
			
		$npm = $this->input->post('npm');
		$nama =$this->input->post('nama');
		$semester =$this->input->post('semester');

		$data = array(
			'npm'=> $npm, 
			'nama'=> $nama,
			'semester'=> $semester
		);	
		
		$this->Modeladmin->tambah_data($data,'data_mahasiswa');
		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Data Berhasil Tersimpan</div>');
		redirect('Myadmin/tambahdata');
		}
		else{
			$this->tambahdata();
		}
	}

	public function aksi_edit_data(){
		$id = $this->input->post('id');
		$npm = $this->input->post('npm');
		$nama =$this->input->post('nama');
		$semester =$this->input->post('semester');	

		$data = array(
			'npm'=> $npm, 
			'nama'=> $nama,
			'semester'=> $semester
		);	

		$where = array(
			'id' => $id
		);

		$this->Modeladmin->update_data($where,$data,'data_mahasiswa');
		redirect('Myadmin/tambahdata');
	}	

	function hapus($id){
		$where = array('id' => $id);
		$this->Modeladmin->hapus_data($where,'data_mahasiswa');
		redirect('Myadmin/tambahdata');
	}


}
 ?>