<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Mschools extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getitems($table, $where=NULL)//$where is an array like $whee{'name'=>$name}
    {
    /*	if($where)
    	{
    		$this->db->where($where);
    	}*/
    	$query=$this->db->get($table);
    	if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}