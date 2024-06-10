<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }


    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            // cek jika ada gambar yang akan diupload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']      = '2048';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="text-center alert alert-success" role="alert">Your profile has been updated!</div>');
            redirect('user');
        }
    }


    public function changePassword()
    {
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="text-center alert alert-danger" role="alert">Wrong current password!</div>');
                redirect('user/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="text-center alert alert-danger" role="alert">Kata sandi baru tidak boleh sama dengan kata sandi saat ini!!</div>');
                    redirect('user/changepassword');
                } else {
                    // password sudah ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="text-center alert alert-success" role="alert">Kata sandi diubah
                        !!</div>');
                    redirect('user/changepassword');
                }
            }
        }
    }

// ////////////////////////////////////////////////////////////////////////////
    // BLOCK PRODUK COOY
// ////////////////////////////////////////////////////////////////////////////
public function produk()
    {
        $this->load->model('Produk_model', 'produk');
        $data['title'] = 'Dashboard | Produk';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['produk'] = $this->produk->getAllProduk();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/produk', $data);
        $this->load->view('templates/footer');
        
    }

    public function tambahproduk()
    {
        $this->load->model('Produk_model', 'produk');
        $data['title'] = 'Dashboard | Produk';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['produk'] = $this->produk->getAllProduk();
          $this->form_validation->set_rules('name','Nama Produk', 'required');
          $this->form_validation->set_rules('deskripsi','Deskripsi', 'required');
          $this->form_validation->set_rules('harga','Harga', 'required');
          $this->form_validation->set_rules('status','Status', 'required');
          $this->form_validation->set_rules('stock','Stock', 'required');
          $this->form_validation->set_rules('netto','Berat', 'required');
          $this->form_validation->set_rules('kategori','Kategori', 'required');
         

          if($this->form_validation->run() == false) {
              $this->load->view('templates/header', $data);
              $this->load->view('templates/sidebar', $data);
              $this->load->view('templates/topbar', $data);
              $this->load->view('admin/tambahproduk', $data);
              $this->load->view('templates/footer');

          } else {
            $gambar = $_FILES['gambar']['name'];

            if ($gambar = '') {
            } else {
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size']     = '1048';
                $config['upload_path'] = './assets/img/produk/';
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('gambar')) {
                    $this->session->set_flashdata('pesan', '
                        <div class="alert alert-danger text-center" role="alert">
                         Produk gagal ditambahkan, cek kembali ukuran gambar dan tipe file gambar!
                         </div>
                        ');
                    redirect('user/tambahproduk');
                } else {
                    $gambar = $this->upload->data('file_name', true);

                    $data = [
                        "name" => $this->input->post('name', true),
                        "deskripsi" => $this->input->post('deskripsi', true),
                        "harga" => $this->input->post('harga', true),
                        "status" => $this->input->post('status', true),
                        "stock" => $this->input->post('stock', true),
                        "netto" => $this->input->post('netto', true),
                        "kategori" => $this->input->post('kategori', true),
                        "tanggal" => $this->input->post('tanggal', true),                
                        "user" => $this->input->post('user', true),
                        "gambar" => $gambar
                    ];
                }
                $this->produk->tambahProduk($data, 'produk');
                $this->session->set_flashdata('pesan', '
                <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                  <strong>Produk!</strong> Sukses ditambahkan!!.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                ');
                redirect('user/produk');

          }
      }
        
    }
     // Batas
    public function viewproduk($id)
    {
        $this->load->model('Produk_model', 'produk');
        $data['title'] = 'Dashboard | View';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['produk'] = $this->produk->getProdukById($id);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/viewproduk', $data);
        $this->load->view('templates/footer');
    }

    // Batas
    public function editproduk($id)
    {
        $this->load->model('Produk_model', 'produk');
        $data['title'] = 'Dashboard | Edit Produk';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['produk'] = $this->produk->getProdukById($id);
        $data['status'] =  ['Ada','Habis'];
        $data['kategori'] = ['Kesehatan','Teknologi', 'Pertanian', 'Olahraga', 'Kain'];
        $data['netto'] = ['Ton','Kwintal', 'Kg'];

        $this->form_validation->set_rules('name','Nama','required');
        $this->form_validation->set_rules('deskripsi','Deskripsi', 'required');
        $this->form_validation->set_rules('harga','Harga', 'required');
        $this->form_validation->set_rules('status','Status', 'required');
        $this->form_validation->set_rules('stock','Stock', 'required');
        $this->form_validation->set_rules('netto','Berat', 'required');
        $this->form_validation->set_rules('kategori','Kategori', 'required');
        
        if($this->form_validation->run()== false) {
             $this->load->view('templates/header', $data);
              $this->load->view('templates/sidebar', $data);
              $this->load->view('templates/topbar', $data);
              $this->load->view('admin/editproduk', $data);
              $this->load->view('templates/footer');
        } else {
            $this->produk->editProduk($id);
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-success mb-1 text-center" role="alert">
            <i class="fas fa-check-circle"></i>
            Produk Sukses di Update!
            </div>
            ');
            redirect('user/produk');


        }

    }
    // Batas
    public function deleteproduk($id, $foto)
    {
        $this->load->model('Produk_model', 'produk');
        $path = '/assets/img/produk/';
        if($foto != 'default.jpeg') {
            unlink(FCPATH.$path.$foto);
        }
        $id = [
            'id' => $id
        ];
        $this->produk->deleteData($id);
        $this->session->set_flashdata('pesan', '
        <div class="alert alert-success mb-1 text-center" role="alert">
        <i class="fas fa-check-circle"></i>
        Produk Sukses di Hapus!
        </div>
        ');
    redirect('user/produk');
    }

// ////////////////////////////////////////////////////////////////////////////
    // BLOCK TESTIMONIALS COOY
// ////////////////////////////////////////////////////////////////////////////

    public function testimonials()
    {
        $this->load->helper('text');
        $this->load->model('Testimonials_model', 'testimonials');
        $this->load->model('Testimonials_model', 'user_pekerjaan');
        // 
        $data['title'] = 'Dashboard | Testimonials';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['testimonials'] = $this->testimonials->getAllTestimonials();
        $data['testimonials'] = $this->testimonials->getAllPekerjaanJoin();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/testimonials/testimonials', $data);
        $this->load->view('templates/footer');
        
    }

    public function tambahtestimonials()
    {
        $this->load->model('Testimonials_model', 'testimonials');
        $this->load->model('Testimonials_model', 'user_pekerjaan');
        $data['title'] = 'Dashboard | Testimonials';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['testimonials'] = $this->testimonials->getAllTestimonials();
        $data['user_pekerjaan'] = $this->user_pekerjaan->getAllPekerjaan();
        $data['testimonials'] = $this->testimonials->getAllPekerjaanJoin();
          $this->form_validation->set_rules('name','Nama', 'required');
          $this->form_validation->set_rules('isi','Isi', 'required');
          $this->form_validation->set_rules('id_pekerjaan','Pekerjaan', 'required');
          $this->form_validation->set_rules('status_perkawinan','Status Perkawinan', 'required');
         

          if($this->form_validation->run() == false) {
              $this->load->view('templates/header', $data);
              $this->load->view('templates/sidebar', $data);
              $this->load->view('templates/topbar', $data);
              $this->load->view('admin/testimonials/tambahtestimonials', $data);
              $this->load->view('templates/footer');

          } else {
            $gambar = $_FILES['gambar']['name'];

            if ($gambar = '') {
            } else {
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size']     = '1048';
                $config['upload_path'] = './assets/img/testimonials/';
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('gambar')) {
                    $this->session->set_flashdata('pesan', '
                        <div class="alert alert-danger text-center" role="alert">
                         Berita gagal ditambahkan, cek kembali ukuran gambar dan tipe file gambar!
                         </div>
                        ');
                    redirect('user/tambahtestimonials');
                } else {
                    $gambar = $this->upload->data('file_name', true);

                    $data = [
                        "name" => $this->input->post('name', true),
                        "isi" => $this->input->post('isi', true),
                        "status_perkawinan" => $this->input->post('status_perkawinan', true),
                        "tanggal" => $this->input->post('tanggal', true),                        
                        "user" => $this->input->post('user', true),
                        "id_pekerjaan" => $this->input->post('id_pekerjaan', true),
                        "gambar" => $gambar
                    ];
                }
                $this->testimonials->tambahTestimonials($data, 'testimonials');
                $this->session->set_flashdata('pesan', '
                <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                  <strong>Testimonials!</strong> Sukses ditambahkan!!.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                ');
                redirect('user/testimonials');

          }
      }

    }
 // Batas
    public function viewtestimonials($id)
    {
        $this->load->model('Testimonials_model', 'testimonials');
        $this->load->model('Testimonials_model', 'user_pekerjaan');
        $data['title'] = 'Dashboard | Testimonials';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['testimonials'] = $this->testimonials->getAllTestimonials();
        $data['user_pekerjaan'] = $this->user_pekerjaan->getAllPekerjaan();
        $data['testimonials'] = $this->testimonials->getAllPekerjaanJoin();
        $data['testimonials'] = $this->testimonials->getTestimonialsById($id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/testimonials/viewtestimonials', $data);
        $this->load->view('templates/footer');
    }

     // Batas
    public function deletetestimonials($id, $foto)
    {
        $this->load->model('Testimonials_model', 'testimonials');
        $path = '/assets/img/testimonials/';
        if($foto != 'default.jpeg') {
            unlink(FCPATH.$path.$foto);
        }
        $id = [
            'id' => $id
        ];
        $this->testimonials->deleteData($id);
        $this->session->set_flashdata('pesan', '
        <div class="alert alert-success mb-1 text-center" role="alert">
        <i class="fas fa-check-circle"></i>
        Testimonials Sukses di Hapus!
        </div>
        ');
    redirect('user/testimonials');
    }

// Batas
    public function edittestimonials($id)
    {
        $this->load->model('Testimonials_model', 'testimonials');
        $this->load->model('Testimonials_model', 'user_pekerjaan');
        $data['title'] = 'Dashboard | Testimonials';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['testimonials'] = $this->testimonials->getAllTestimonials();
        $data['user_pekerjaan'] = $this->user_pekerjaan->getAllPekerjaan();
        $data['testimonials'] = $this->testimonials->getAllPekerjaanJoin();
        $data['testimonials'] = $this->testimonials->getTestimonialsById($id);
        $data['status_perkawinan'] = ['Kawin', 'Janda', 'Belum Menikah' ,'Duda'];
        $this->form_validation->set_rules('name','Nama','required');
        $this->form_validation->set_rules('isi','Deskripsi', 'required');
        $this->form_validation->set_rules('id_pekerjaan','Pekerjaan', 'required');
        $this->form_validation->set_rules('status_perkawinan','Status', 'required');
        
        if($this->form_validation->run()== false) {
             $this->load->view('templates/header', $data);
              $this->load->view('templates/sidebar', $data);
              $this->load->view('templates/topbar', $data);
              $this->load->view('admin/testimonials/edittestimonials', $data);
              $this->load->view('templates/footer');
        } else {
            $this->testimonials->editTestimonials($id);
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-success mb-1 text-center" role="alert">
            <i class="fas fa-check-circle"></i>
            Testimonials Sukses di Update!
            </div>
            ');
            redirect('user/testimonials');


        }

    }

// ////////////////////////////////////////////////////////////////////////////
    // BLOCK CLIENTS COOY
// ////////////////////////////////////////////////////////////////////////////
     public function clients()
    {
        $this->load->model('Clients_model', 'clients');
        // 
        $data['title'] = 'Dashboard | clients';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['clients'] = $this->clients->getAllclients();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/clients/clients', $data);
        $this->load->view('templates/footer');
        
    }

    public function tambahclients()
    {
        $this->load->model('Clients_model', 'clients');
        $data['title'] = 'Dashboard | clients';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['clients'] = $this->clients->getAllclients();
          $this->form_validation->set_rules('name','Nama', 'required');
          $this->form_validation->set_rules('status','Status Hubungan', 'required');


          if($this->form_validation->run() == false) {
              $this->load->view('templates/header', $data);
              $this->load->view('templates/sidebar', $data);
              $this->load->view('templates/topbar', $data);
              $this->load->view('admin/clients/tambahclients', $data);
              $this->load->view('templates/footer');

          } else {
            $gambar = $_FILES['gambar']['name'];

            if ($gambar = '') {
            } else {
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size']     = '1048';
                $config['upload_path'] = './assets/img/clients/';
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('gambar')) {
                    $this->session->set_flashdata('pesan', '
                        <div class="alert alert-danger text-center" role="alert">
                         Berita gagal ditambahkan, cek kembali ukuran gambar dan tipe file gambar!
                         </div>
                        ');
                    redirect('user/tambahclients');
                } else {
                    $gambar = $this->upload->data('file_name', true);

                    $data = [
                        "name" => $this->input->post('name', true),   
                        "status" => $this->input->post('status', true),   
                        "tanggal" => $this->input->post('tanggal', true),                        
                        "user" => $this->input->post('user', true),
                        "gambar" => $gambar
                    ];
                }
                $this->clients->tambahClients($data, 'clients');
                $this->session->set_flashdata('pesan', '
                <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                  <strong>clients!</strong> Sukses ditambahkan!!.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                ');
                redirect('user/clients');

          }
      }

    }
 // Batas
    public function viewclients($id)
    {
        $this->load->model('Clients_model', 'clients');
        $data['title'] = 'Dashboard | clients';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['clients'] = $this->clients->getAllclients();
        $data['clients'] = $this->clients->getclientsById($id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/clients/viewclients', $data);
        $this->load->view('templates/footer');
    }

    // Batas
    public function editclients($id)
    {
        $this->load->model('Clients_model', 'clients');
        $data['title'] = 'Dashboard | Clients';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['clients'] = $this->clients->getAllClients();
        $data['clients'] = $this->clients->getClientsById($id);
        $data['status'] = ['Kerjasama', 'Tidak Kerjasama'];
        $this->form_validation->set_rules('name','Nama','required');
        $this->form_validation->set_rules('status','Status Hubungan','required');

        if($this->form_validation->run()== false) {
             $this->load->view('templates/header', $data);
              $this->load->view('templates/sidebar', $data);
              $this->load->view('templates/topbar', $data);
              $this->load->view('admin/clients/editclients', $data);
              $this->load->view('templates/footer');
        } else {
            $this->clients->editClients($id);
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-success mb-1 text-center" role="alert">
            <i class="fas fa-check-circle"></i>
            Clients Sukses di Update!
            </div>
            ');
            redirect('user/clients');


        }

    }

     // Batas
    public function deleteclients($id, $foto)
    {
        $this->load->model('Clients_model', 'clients');
        $path = '/assets/img/clients/';
        if($foto != 'default.jpeg') {
            unlink(FCPATH.$path.$foto);
        }
        $id = [
            'id' => $id
        ];
        $this->clients->deleteData($id);
        $this->session->set_flashdata('pesan', '
        <div class="alert alert-success mb-1 text-center" role="alert">
        <i class="fas fa-check-circle"></i>
        clients Sukses di Hapus!
        </div>
        ');
    redirect('user/clients');
    }





}
