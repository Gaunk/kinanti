<?php

class Clients_model extends CI_Model
{



    public function getAllClients()
    {
        $this->db->order_by('id', 'desc');
        return  $this->db->get('clients')->result_array();

    }

    public function tambahClients($data, $tabel)
    {
        $this->db->insert($tabel, $data);
    }

    public function getClientsById($id)
    {
        return $this->db->get_where('clients',['id' => $id])->row_array();
        
    }

    public function editClients($id)
    {
        $data['clients'] = $this->db->get_where('clients',['id' => $id])->row_array();
       
        
        // cek jika ada gambar yang di upload
        $upload_image = $_FILES['image'];

        if($upload_image) {
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '1048';
            $config['upload_path'] = './assets/img/clients';
            $config['encrypt_name'] = TRUE;

           
          
            $this->load->library('upload', $config);
            
           if($this->upload->do_upload('image')) {
               $old_image = $data['clients']['gambar'];
               $path = './assets/img/clients/';

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
                    "status" => $this->input->post('status', true),
                    "tanggal" => $this->input->post('tanggal', true),
                    "user" => $this->input->post('user', true)
           ];
           $this->db->where('id', $this->input->post('id'));
           $this->db->update('clients', $data);
    }

    public function deleteData($id)
    {
        $this->db->where($id);
        return $this->db->delete('clients');
    }
}

   
