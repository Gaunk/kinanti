<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	    {
	        parent::__construct();
	        $this->load->library('form_validation', 'url');
	        $this->load->helper('text');
	    }
	public function index()
	{
		
		$this->load->model('Berita_model', 'berita');
		$this->load->model('Produk_model', 'produk');
		$this->load->model('Testimonials_model', 'testimonials');
		$this->load->model('Testimonials_model', 'pekerjaan');
		$this->load->model('Clients_model', 'clients');
		$data['judul'] = 'PT Kinanti Sejahtera Lestari';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['berita'] = $this->berita->getAllBerita();
        $data['produk'] = $this->produk->getAllProduk();
        $data['testimonials'] = $this->testimonials->getAllTestimonials();
        $data['clients'] = $this->clients->getAllClients();
        $data['testimonials'] = $this->testimonials->getAllPekerjaanJoin();
        $data['kategori'] = ['Kesehatan','Teknologi', 'Pertanian', 'Olahraga', 'Kain'];
        $data['netto'] = ['Ton','Kwintal', 'Kg'];
		$this->load->view('home/head', $data);
		$this->load->view('home/header', $data);
		$this->load->view('home', $data);
		$this->load->view('home/footer', $data);
	}


	// ////////////////////////////////////////////////////////////////////////////
    // BLOCK SEND KIRIM PESAN EMAIL COOY
// ////////////////////////////////////////////////////////////////////////////

 

    public function kirimemail()
    {
        $this->load->model('Email_model', 'email');
        $data['title'] = 'Dashboard | Berita';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['email'] = $this->email->getAllEmail();

          $this->form_validation->set_rules('name','Nama', 'required');
          $this->form_validation->set_rules('email','E-mail', 'required');
          $this->form_validation->set_rules('subject','Subject', 'required');
          $this->form_validation->set_rules('message','Pesan', 'required');
         

          if($this->form_validation->run() == false) {
              	$this->load->view('home/head', $data);
		        $this->load->view('home/header', $data);
		        $this->load->view('home', $data);
		        $this->load->view('home/footer', $data);

          } else {
           

                    $data = [
                        "name" => $this->input->post('name', true),
                        "email" => $this->input->post('email', true),
                        "status" => $this->input->post('status', true),
                        "subject" => $this->input->post('subject', true),                        
                        "message" => $this->input->post('message', true),
                    ];
                }
                $this->email->tambahEmail($data, 'email');
                $this->session->set_flashdata('pesan', '
                <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                  <strong>Email!</strong> Sukses terkirim!!.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                ');
                redirect('home');

          
  }

    

    // Batas
    public function viewemail($id)
    {
        $this->load->model('Email_model', 'email');
        $data['title'] = 'Dashboard | View';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['email'] = $this->berita->getBeritaById($id);
        $this->load->view('home/head', $data);
		$this->load->view('home/header', $data);
		$this->load->view('home', $data);
		$this->load->view('home/footer', $data);
    }
    // Batas

    public function editemail($id)
    {
        $this->load->model('Email_model', 'email');
        $data['title'] = 'Dashboard | Edit Berita';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['email'] = $this->email->getEmailById($id);
        

        $this->form_validation->set_rules('judul','Judul','required');
        $this->form_validation->set_rules('isi','Isi','required');
        $this->form_validation->set_rules('status','Status','required');
        $this->form_validation->set_rules('kategori','Kategori','required');
        
        if($this->form_validation->run()== false) {
             $this->load->view('home/head', $data);
		        $this->load->view('home/header', $data);
		        $this->load->view('home', $data);
		        $this->load->view('home/footer', $data);
        } else {
            $this->email->editEmail($id);
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-success mb-1 text-center" role="alert">
            <i class="fas fa-check-circle"></i>
            Berita Sukses di Update!
            </div>
            ');
            redirect('home');


        }

    }
    // Batas

    public function deleteberita($id, $foto)
    {
        $this->load->model('Berita_model', 'berita');
        $path = '/assets/img/berita/';
        if($foto != 'default.jpeg') {
            unlink(FCPATH.$path.$foto);
        }
        $id = [
            'id' => $id
        ];
        $this->berita->deleteData($id);
        $this->session->set_flashdata('pesan', '
        <div class="alert alert-success mb-1 text-center" role="alert">
        <i class="fas fa-check-circle"></i>
        Berita Sukses di Hapus!
        </div>
        ');
    redirect('admin/berita');
    }

}
