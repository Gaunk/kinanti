<?php

class Produk_model extends CI_Model
{

    public function getAllProduk()
    {
        $this->db->order_by('id', 'desc');
        return  $this->db->get('produk')->result_array();

    }

    public function tambahProduk($data, $tabel)
    {
        $this->db->insert($tabel, $data);
    }

    public function getProdukById($id)
    {
        return $this->db->get_where('produk',['id' => $id])->row_array();
        
    }

    public function editProduk($id)
    {
        $data['produk'] = $this->db->get_where('produk',['id' => $id])->row_array();
       
        
        // cek jika ada gambar yang di upload
        $upload_image = $_FILES['image'];

        if($upload_image) {
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '1048';
            $config['upload_path'] = './assets/img/produk';
            $config['encrypt_name'] = TRUE;

           
          
            $this->load->library('upload', $config);
            
           if($this->upload->do_upload('image')) {
               $old_image = $data['produk']['gambar'];
               $path = './assets/img/produk/';

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
                    "name" => $this->input->post('name', true),
                    "deskripsi" => $this->input->post('deskripsi', true),
                    "harga" => $this->input->post('harga', true),
                    "status" => $this->input->post('status', true),
                    "stock" => $this->input->post('stock', true),
                    "kategori" => $this->input->post('kategori', true),
                    "tanggal" => $this->input->post('tanggal', true),                
                    "user" => $this->input->post('user', true)
           ];
           $this->db->where('id', $this->input->post('id'));
           $this->db->update('produk', $data);
    }

    public function deleteData($id)
    {
        $this->db->where($id);
        return $this->db->delete('produk');
    }
}

   
