<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();
        $this->load->model('Admin_model', 'admin');
    }

    public function index()
    {
        $data['title'] = "Dashboard";
        $data['barang'] = $this->admin->count('barang');
        $data['barang_masuk'] = $this->admin->count('barang_masuk');
        $data['barang_keluar'] = $this->admin->count('barang_keluar');
        $data['distributor'] = $this->admin->count('distributor');
        $data['user'] = $this->admin->count('user');
        $data['stok'] = $this->admin->sum('barang', 'stok');
    
        $data['barang_min'] = array_slice($this->admin->getBarangMin(), 0, 5);
        $data['transaksi'] = [
            'barang_masuk' => array_slice($this->admin->getBarangMasukWithDetails(), 0, 5),
            'barang_keluar' => array_slice($this->admin->getBarangKeluar(), 0, 5)
        ];
    
        // Line Chart
        $bln = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $data['cbm'] = [];
        $data['cbk'] = [];
    
        foreach ($bln as $b) {
            $data['cbm'][] = $this->admin->chartBarangMasuk($b);
            $data['cbk'][] = $this->admin->chartBarangKeluar($b);
        }
    
        $this->template->load('templates/dashboard', 'dashboard', $data);
    }    

}
