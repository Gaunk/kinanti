<?php

class Email_model extends CI_Model
{



    public function getAllEmail()
    {
        $this->db->order_by('id', 'desc');
        return  $this->db->get('email')->result_array();

    }

    public function tambahEmail($data, $tabel)
    {
        $this->db->insert($tabel, $data);
    }

    public function getEmailById($id)
    {
        return $this->db->get_where('email',['id' => $id])->row_array();
        
    }

    public function editEmail($id)
    {
        $data['email'] = $this->db->get_where('email',['id' => $id])->row_array();
           $data = [
                    "name" => $this->input->post('name', true),
                    "email" => $this->input->post('email', true),
                    "subject" => $this->input->post('subject', true),
                    "message" => $this->input->post('message', true),
                    "tanggal" => $this->input->post('tanggal', true)
           ];
           $this->db->where('id', $this->input->post('id'));
           $this->db->update('email', $data);
    }

    public function deleteData($id)
    {
        $this->db->where($id);
        return $this->db->delete('email');
    }
}

   
