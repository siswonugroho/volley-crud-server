<?php

class Users_model extends CI_Model {
  
  public function getUsers()
  {
    $this->db->select('*');
    $this->db->from('tm_user');
    $this->db->join('tm_grup', 'tm_user.grup = tm_grup.id_grup');
    $query = $this->db->get();
    return $query;
  }

  public function getUserById($table, $id)
  {
    return $this->db->get_where($table, ['id' => $id]);
  }

  public function deleteUser($table, $id)
  {
    $this->db->delete($table, ['id' => $id]);
    return $this->db->affected_rows();
  }

  public function createUser($table, $data)
  {
    $this->db->insert($table, $data);
    return $this->db->affected_rows();
  }

  public function updateUser($table, $data, $id)
  {
    $this->db->update($table, $data, ['id' => $id]);
    return $this->db->affected_rows();
  }
}