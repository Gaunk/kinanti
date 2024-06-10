<?php

class Testimonials_model extends CI_Model
{
    // PAGINATION
    

    // BATAS

    public function getAllPekerjaan()
    {
        $this->db->order_by('id_pekerjaan', 'desc');
        return  $this->db->get('user_pekerjaan')->result_array();
    }

    public function getAllPekerjaanJoin()
    {
         $this->db->select('*');
         $this->db->from('user_pekerjaan');
         $this->db->join('testimonials','testimonials.id_pekerjaan=user_pekerjaan.id_pekerjaan');
         $query = $this->db->get();
         return $query->result_array();
    }



    public function getAllTestimonials()
    {
        $this->db->order_by('id', 'desc');
        return  $this->db->get('testimonials')->result_array();

    }

    public function tambahTestimonials($data, $tabel)
    {
        $this->db->insert($tabel, $data);
    }

    public function getTestimonialsById($id)
    {
        return $this->db->get_where('testimonials',['id' => $id])->row_array();
        
    }

    public function editTestimonials($id)
    {
        $data['testimonials'] = $this->db->get_where('testimonials',['id' => $id])->row_array();
       
        
        // cek jika ada gambar yang di upload
        $upload_image = $_FILES['image'];

        if($upload_image) {
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '1048';
            $config['upload_path'] = './assets/img/testimonials';
            $config['encrypt_name'] = TRUE;

           
          
            $this->load->library('upload', $config);
            
           if($this->upload->do_upload('image')) {
               $old_image = $data['testimonials']['gambar'];
               $path = './assets/img/testimonials/';

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
                    "isi" => $this->input->post('isi',  true),
                    "id_pekerjaan" => $this->input->post('id_pekerjaan', true),
                    "status_perkawinan" => $this->input->post('status_perkawinan', true),
                    "tanggal" => $this->input->post('tanggal', true),
                    "user" => $this->input->post('user', true)
           ];
           $this->db->where('id', $this->input->post('id'));
           $this->db->update('testimonials', $data);
    }

    public function deleteData($id)
    {
        $this->db->where($id);
        return $this->db->delete('testimonials');
    }
}

   
