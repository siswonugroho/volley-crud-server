<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
 
  function __construct()
  {
    parent::__construct();
    $this->load->model('Users_model');
  }

  private function send_response($data, $response_code = null) {
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($data));
    if (!is_null($response_code)) {
      http_response_code($response_code);
    }
  }

  public function index()
  {
    $id = $this->input->get('id');
    if (is_null($id)) {
      $data['users'] = $this->Users_model->getUsers()->result();
    } else {
      $data['users'] = $this->Users_model->getUserById('tm_user', $id)->result();
    }
    if ($data['users']) {
      $this->send_response($data['users'], 200);;
    } else {
      $this->send_response([
        'message' => 'ID tidak ditemukan'
      ], 200);
    }
  }

  public function apiDelete()
  {
    $id = filter_var($this->input->post('id'), FILTER_SANITIZE_STRING);
    if (is_null($id)) {
      $this->send_response([
        'message' => 'Harap masukkan ID'
      ], 200);
    } else {
      if ($this->Users_model->deleteUser('tm_user', $id) > 0) {
        $this->send_response([
          'message' => 'Data berhasil dihapus'
        ], 200);
      } else {
        $this->send_response([
          'message' => 'ID tidak ditemukan'
        ], 200);
      }
    }
  }

  public function apiInsert()
  {
    $data = [
      'nama' => filter_var($this->input->post('nama'), FILTER_SANITIZE_STRING),
      'username' => filter_var($this->input->post('username'), FILTER_SANITIZE_STRING),
      'password' => filter_var($this->input->post('password'), FILTER_SANITIZE_STRING),
      'grup' => filter_var($this->input->post('grup'), FILTER_SANITIZE_STRING),
    ];

    if ($this->Users_model->createUser('tm_user', $data) > 0) {
      $this->send_response([
        'message' => 'Data berhasil ditambahkan'
      ], 201);
    } else {
      $this->send_response([
        'message' => 'Gagal menambahkan data'
      ], 200);
    }
  }

  public function apiUpdate()
  {
    $id = filter_var($this->input->post('id'), FILTER_SANITIZE_STRING);

    $data = [
      'nama' => filter_var($this->input->post('nama'), FILTER_SANITIZE_STRING),
      'username' => filter_var($this->input->post('username'), FILTER_SANITIZE_STRING),
      'password' => filter_var($this->input->post('password'), FILTER_SANITIZE_STRING),
      'grup' => filter_var($this->input->post('grup'), FILTER_SANITIZE_STRING),
    ];

    if ($this->Users_model->updateUser('tm_user', $data, $id) > 0) {
      $this->send_response([
        'message' => 'Data berhasil diedit'
      ], 201);
    } else {
      $this->send_response([
        'message' => 'Gagal mengedit data'
      ], 200);
    }
  }

  
}
