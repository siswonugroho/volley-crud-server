<?php

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Users extends RestController
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Users_model');
  }

  public function index_get()
  {
    $id = $this->get('id');
    if (is_null($id)) {
      $data['users'] = $this->Users_model->getUsers()->result();
    } else {
      $data['users'] = $this->Users_model->getUserById('tm_user', $id)->result();
    }
    if ($data['users']) {
      $this->response($data['users'], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'ID tidak ditemukan'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function index_delete()
  {
    $id = $this->delete('id');
    if (is_null($id)) {
      $this->response([
        'message' => 'Harap masukkan ID'
      ], RestController::HTTP_NOT_ACCEPTABLE);
    } else {
      if ($this->Users_model->deleteUser('tm_user', $id) > 0) {
        $this->response([
          'message' => 'Data berhasil dihapus'
        ], RestController::HTTP_OK);
      } else {
        $this->response([
          'message' => 'ID tidak ditemukan'
        ], RestController::HTTP_BAD_REQUEST);
      }
    }
  }

  public function index_post()
  {
    $data = [
      'nama' => filter_var($this->post('nama'), FILTER_SANITIZE_STRING),
      'username' => filter_var($this->post('username'), FILTER_SANITIZE_STRING),
      'password' => filter_var($this->post('password'), FILTER_SANITIZE_STRING),
      'grup' => filter_var($this->post('grup'), FILTER_SANITIZE_STRING),
    ];

    if ($this->Users_model->createUser('tm_user', $data) > 0) {
      $this->response([
        'message' => 'Data berhasil ditambahkan'
      ], RestController::HTTP_CREATED);
    } else {
      $this->response([
        'message' => 'Gagal menambahkan data'
      ], RestController::HTTP_BAD_REQUEST);
    }
  }

  public function index_put()
  {
    $id = $this->put('id');

    $data = [
      'nama' => filter_var($this->put('nama'), FILTER_SANITIZE_STRING),
      'username' => filter_var($this->put('username'), FILTER_SANITIZE_STRING),
      'password' => filter_var($this->put('password'), FILTER_SANITIZE_STRING),
      'grup' => filter_var($this->put('grup'), FILTER_SANITIZE_STRING),
    ];

    if ($this->Users_model->updateUser('tm_user', $data, $id) > 0) {
      $this->response([
        'message' => 'Data berhasil diedit'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'message' => 'Gagal mengedit data'
      ], RestController::HTTP_BAD_REQUEST);
    }
  }

  
}
