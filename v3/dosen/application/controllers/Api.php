<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DosenModel');
        $this->load->model('StrukturalModel');
        $this->load->library('ApiDosen');
    }

    public function nip($nip)
    {
        if (is_numeric($nip)) {
            $datastruktural = $this->StrukturalModel->getStrukturalByIDDosen(['nip' => $nip]);
            if (count($datastruktural) > 0) {
                $send = ApiDosen::encrypt($datastruktural[0], "UNRI", "SendToLogbookV1");

                header('Content-Type: application/json');
                header('Access-Control-Allow-Origin: *');
                header('Access-Control-Allow-Methods: GET, POST');
                header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
                echo json_encode(['status' => '000', 'data' => $send]);
            } else {
                echo '{}';
            }
        } else {
            echo '{"Error":"can\'t connect"}';
        }
    }
}
