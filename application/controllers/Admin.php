<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation', 'url');
        $this->load->helper('text');
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }


    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }


    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }


    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('pesan', '<div class="text-center alert alert-success" role="alert">Access Changed!</div>');
    }



// ////////////////////////////////////////////////////////////////////////////
    // BLOCK BERITA COOY
// ////////////////////////////////////////////////////////////////////////////
    public function berita()
    {
        $this->load->model('Berita_model', 'berita');
        $data['title'] = 'Dashboard | Berita';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['berita'] = $this->berita->getAllBerita();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/berita', $data);
        $this->load->view('templates/footer');
        
    }

    public function tambahberita()
    {
        $this->load->model('Berita_model', 'berita');
        $data['title'] = 'Dashboard | Berita';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['berita'] = $this->berita->getAllBerita();

          $this->form_validation->set_rules('judul','Judul Berita', 'required');
          $this->form_validation->set_rules('isi','Isi Berita', 'required');
          $this->form_validation->set_rules('status','Status', 'required');
          $this->form_validation->set_rules('kategori','Kategori', 'required');
         

          if($this->form_validation->run() == false) {
              $this->load->view('templates/header', $data);
              $this->load->view('templates/sidebar', $data);
              $this->load->view('templates/topbar', $data);
              $this->load->view('admin/tambahberita', $data);
              $this->load->view('templates/footer');

          } else {
            $gambar = $_FILES['gambar']['name'];

            if ($gambar = '') {
            } else {
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size']     = '10000';
                $config['upload_path'] = './assets/img/berita/';
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('gambar')) {
                    $this->session->set_flashdata('pesan', '
                        <div class="alert alert-danger text-center" role="alert">
                         Berita gagal ditambahkan, cek kembali ukuran gambar dan tipe file gambar!
                         </div>
                        ');
                    redirect('admin/tambahberita');
                } else {
                    $gambar = $this->upload->data('file_name', true);

                    $data = [
                        "judul" => $this->input->post('judul', true),
                        "isi" => $this->input->post('isi', true),
                        "status" => $this->input->post('status', true),
                        "tanggal" => $this->input->post('tanggal', true),                        
                        "user" => $this->input->post('user', true),
                        "kategori" => $this->input->post('kategori', true),
                        "gambar" => $gambar
                    ];
                }
                $this->berita->tambahBerita($data, 'berita');
                $this->session->set_flashdata('pesan', '
                <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                  <strong>Berita!</strong> Sukses ditambahkan!!.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                ');
                redirect('admin/berita');

          }
      }

    }

    // Batas
    public function viewberita($id)
    {
        $this->load->model('Berita_model', 'berita');
        $data['title'] = 'Dashboard | View';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['berita'] = $this->berita->getBeritaById($id);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/viewberita', $data);
        $this->load->view('templates/footer');
    }
    // Batas

    public function editberita($id)
    {
        $this->load->model('Berita_model', 'berita');
        $data['title'] = 'Dashboard | Edit Berita';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['berita'] = $this->berita->getBeritaById($id);
        $data['status'] =  ['draff','publish'];
        $data['kategori'] = ['Kesehatan','Teknologi', 'Pertanian', 'Olahraga'];

        $this->form_validation->set_rules('judul','Judul','required');
        $this->form_validation->set_rules('isi','Isi','required');
        $this->form_validation->set_rules('status','Status','required');
        $this->form_validation->set_rules('kategori','Kategori','required');
        
        if($this->form_validation->run()== false) {
             $this->load->view('templates/header', $data);
              $this->load->view('templates/sidebar', $data);
              $this->load->view('templates/topbar', $data);
              $this->load->view('admin/editberita', $data);
              $this->load->view('templates/footer');
        } else {
            $this->berita->editBerita($id);
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-success mb-1 text-center" role="alert">
            <i class="fas fa-check-circle"></i>
            Berita Sukses di Update!
            </div>
            ');
            redirect('admin/berita');


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
