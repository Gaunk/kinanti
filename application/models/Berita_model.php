<?php

class Berita_model extends CI_Model
{

    public function getAllBerita()
    {
        $this->db->order_by('id', 'desc');
        return  $this->db->get('berita')->result_array();

    }

    public function tambahBerita($data, $tabel)
    {
        $this->db->insert($tabel, $data);
    }

    public function getBeritaById($id)
    {
        return $this->db->get_where('berita',['id' => $id])->row_array();
        
    }

    public function editBerita($id)
    {
        $data['berita'] = $this->db->get_where('berita',['id' => $id])->row_array();
       
        
        // cek jika ada gambar yang di upload
        $upload_image = $_FILES['image'];

        if($upload_image) {
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '1048';
            $config['upload_path'] = './assets/img/berita';
            $config['encrypt_name'] = TRUE;

           
          
            $this->load->library('upload', $config);
            
           if($this->upload->do_upload('image')) {
               $old_image = $data['berita']['gambar'];
               $path = './assets/img/berita/';

               if($old_image != 'default.jpeg') {
                   unlink(FCPATH.$path.$old_image);
               } 
               
               $new_image = $this->upload->data('file_name');
               $this->db->set('gambar',$new_image);

            } else {
                   $this->upload->display_errors();                
                   
               }
           }
           $data = [
                    "judul" => $this->input->post('judul', true),
                    "isi" => $this->input->post('isi',  true),
                    "kategori" => $this->input->post('kategori', true),
                    "tanggal" => $this->input->post('tanggal', true),
                    "status" => $this->input->post('status', true),
                    "user" => $this->input->post('user', true)
           ];
           $this->db->where('id', $this->input->post('id'));
           $this->db->update('berita', $data);
    }

    public function deleteData($id)
    {
        $this->db->where($id);
        return $this->db->delete('berita');
    }
}

   
