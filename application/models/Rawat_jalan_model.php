<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rawat_jalan_model extends CI_Model
{

    public $table = 'rawat_jalan';
    public $id = 'id_rawat_jalan';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id_rawat_jalan,tgl_periksa,nama_pasien,nama_dokter,jenis_tindakan');
        $this->datatables->from('rawat_jalan');
        //add this line for join
        $this->datatables->join('tindakan', 'rawat_jalan.id_tindakan  = tindakan.id_tindakan');
        $this->datatables->add_column('action', anchor(site_url('rawat_jalan/read/$1'),'Read')." | ".anchor(site_url('rawat_jalan/update/$1'),'Update')." | ".anchor(site_url('rawat_jalan/delete/$1'),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_rawat_jalan');
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->datatables->join('tindakan', 'rawat_jalan.id_tindakan  = tindakan.id_tindakan');
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_rawat_jalan', $q);
	$this->db->or_like('id_tindakan', $q);
	$this->db->or_like('tgl_periksa', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_rawat_jalan', $q);
	$this->db->or_like('id_tindakan', $q);
	$this->db->or_like('tgl_periksa', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file Rawat_jalan_model.php */
/* Location: ./application/models/Rawat_jalan_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-10-22 16:47:07 */
/* http://harviacode.com */