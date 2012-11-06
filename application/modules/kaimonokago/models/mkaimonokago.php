<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This Model is Loaded in MY_Controller
 *
 */
class MKaimonokago extends Base_model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


    /**
     * Used in customers/admin
     * @param <type> $module
     * @return <type>
     */

    function getAllSimple($module, $where = NULL, $what = NULL,$prefix=NULL,$criteria=NULL,$order=NULL, $status=NULL)
    {
        $data = array();
        if(empty($prefix))
        {
            $table = 'omc_'.$module;
        }
        else
        {
            $table = $prefix.$module;
        }
        if(!empty($where)){
            $this->db->where($where,$what);
        }
        if(!empty($status))
        {
            $this->db->where('status',$status);
        }
        if(!empty($order))
        {
            $this->db->order_by($criteria,$order);
        }


        $Q = $this->db->get($table);
        if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row;
        }
        }
        $Q->free_result();
        return $data;
    }


    function getSimple($module, $where = NULL, $what = NULL,$prefix=NULL)
    {
        $data = array();
        if(empty($prefix))
        {
            $table = 'omc_'.$module;
        }
        else
        {
            $table = $prefix.$module;
        }
        if(!empty($where)){
            $this->db->where($where,$what);
        }
        $Q = $this->db->get($table);
        if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data = $row;
        }
        }
        $Q->free_result();
        return $data;
    }


    function getAllbyField($module, $field,$orderby)
    {
        $module_table = 'omc_'.$module;
        $this->db->select($field);
        /*
        $this->db->select("$module_table.id, $module_table.name,$module_table.parentid,$module_table.status,$module_table.table_id,$module_table.lang_id
         ,omc_languages.langname");
         *
         */
        if(is_array($orderby)){
             foreach ($orderby as $order){
                 $this->db->order_by("$order asc");
             }
         }else{
             $this->db->order_by("$orderby asc");
         }
         $Q = $this->db->get($module_table);
	     if ($Q->num_rows() > 0){
	       	foreach ($Q->result_array() as $row){
	         	$data[]= $row;
	       	}
	    }
	    $Q->free_result();
	    return $data;
    }

/**
 * Used in playroom/controller/admin/index
 * @param string $module
 * @param array $fields
 * @param array $orderby
 * @return array
 */
    function getAll($module,$fields,$orderby,$lang_id=NULL,$where=NULL,$what=NULL)
    {
        /* 
        if ($lang_id ===NULL){
            $lang_id = 0;
        }
        */
        $string= '';
        $module_table = 'omc_'.$module;
        $data = array();
        if(is_array($fields))
        {
            foreach ($fields as $field)
            {
                $field = $module_table.".".$field;
                $string .= ",$field";
            }
            $string =substr($string,1); // remove leading ","
        } 
        else
        {
            $string = $fields;
        }    
        
        /*
        $this->db->select("$module_table.id, $module_table.name,$module_table.parentid,$module_table.status,$module_table.table_id,$module_table.lang_id
         ,omc_languages.langname");
         *
         */
        if(is_array($orderby))
        {
            foreach ($orderby as $order)
            {
                $this->db->order_by("$order asc");
            }
        }
        else
        {
            $this->db->order_by("$orderby asc");
        }
        if(!empty($lang_id))
        {
            $this->db->select("$string,omc_languages.langname");
            $this->db->where('lang_id',$lang_id);
            $this->db->join('omc_languages', $module_table.'.lang_id = omc_languages.id','left');
        }
        if($where AND $what)
        {
            $this->db->where($where,$what);   
        }
        $Q = $this->db->get($module_table);
        if ($Q->num_rows() > 0)
        {
	       	foreach ($Q->result_array() as $row)
            {
	         	$data[] = $row;
	       	}
	    }
	    $Q->free_result();
	    return $data;
	}



    function addItem($module,$data,$return_id=FALSE,$prefix=NULL)
    {
        if(empty($prefix))
        {
            $module_table = 'omc_'.$module;
        }
        else
        {
            $module_table = $prefix.$module;
        }

        if($module=='email'){
            $this->db->set('date', 'NOW()', FALSE);
        }
        $this->db->insert($module_table, $data);
        if(isset($_POST['table_id']))
        {// table_id is used in category, playroom
            if($_POST['table_id']==0)
            {
                $this->addtableid($module_table);
            }
        }
        if($return_id==TRUE)
        {
            $retuened_id=$this->db->insert_id();
            return $retuened_id;
        }
    }



    function addtableid($module_table)
    {
         $table_id = $this->db->insert_id();
         $data = array(
            'table_id' =>  $table_id,
            );
        $this->db->where('id', $table_id);
        $this->db->update($module_table, $data);
    }

/**
 * usded in customer/controllers/, slideshow/controllers/, menus, products, pages, playroom category,
 * @param <type> $module
 * @param <type> $data
 */


    function updateItem($module,$data)
    {
        if($module=='subjects' OR $module =='schools')
        {
            $module_table = 'hw_'.$module;
        }
        else
        {
            $module_table = 'omc_'.$module;
        }
        
        if($module =='customer')
        {// omc_cutomer has customer_id
            $idname = 'customer_id';
            $this->db->where($idname, id_clean($_POST['customer_id']));
        }
        else
        {
            $idname = 'id';
            $this->db->where($idname, id_clean($_POST['id']));
        }
	   $this->db->update($module_table, $data);
    }



    function getAllDisplay($module, $lang_id=NULL,$checkfield,$value)
    {
        $module_table = 'omc_'.$module;
        if(!$lang_id)
        {
            $lang_id = '0';
        }
        // I don't want to show this root if there is already 0 under parentid with that lang_id
        // this can be different by module for now playroom, it is parentid

        $checkroot = $this->_checkroot($module_table, $lang_id,$checkfield,$value);
        if(!$checkroot==TRUE)
        {
            $data[0] = 'root';
        }

        $this->db->where('parentid',0);
        $Q = $this->db->get_where($module_table,array('lang_id'=>$lang_id));

        if ($Q->num_rows() > 0)
        {
            foreach ($Q->result_array() as $row)
            {
                $data[$row['id']] = $row['name'];
            }
        }
        $Q->free_result();
        return $data; 
    }


     function _checkroot($module_table, $lang_id, $checkfield, $value)
     {  
        $Q = $this->db->get_where($module_table,array('lang_id'=>$lang_id, $checkfield=>$value));
         if ($Q->num_rows() > 0)
         {
            foreach ($Q->result_array() as $row)
            {
                return TRUE;
            }
        }
     }


    function changeStatus($module, $id)
    {
        if($module=='subjects' OR $module =='schools')
        {
            $table='hw_'.$module;
        }
        else
        {
            $table='omc_'.$module;
        }
        // getting status of page
        $tableinfo = array();
        // since the following uses getInfo which add omc_, here I use module
        $tableinfo = $this->getInfo($module,$id);
        
        $status = $tableinfo['status'];
        if($status =='active')
        {
            $data = array('status' => 'inactive');
            $this->db->where('id', $id);
            $this->db->update($table, $data);
        }
        else
        {
            $data = array('status' => 'active');
            $this->db->where('id', $id);
            $this->db->update($table, $data);
        }
    }

    
    function changeBooleanStatus($module, $id,$what)
    {
        // getting status of page
        $tableinfo = array();
        // since the following uses getInfo which add omc_, here I use module
        $tableinfo = $this->getInfo($module,$id);
        $table='omc_'.$module;
        $boolean = $tableinfo[$what];
        if($boolean =='1')
        {
            $data = array($what => '0');
            $this->db->where('id', $id);
            $this->db->update($table, $data);
        }
        else
        {

            $data = array($what => '1');
            $this->db->where('id', $id);
            $this->db->update($table, $data);
        }

    }    
    
    
    /**
     * used in playroom, category, kaimonokago,product,
     * @param <type> $module
     * @param <type> $id
     * @return <type>
     */
    function getInfo($module, $id, $lang_id=NULL)
    {
        $data = array();
        if($module=='subjects' OR $module =='schools')
        {
            $table='hw_'.$module;
        }
        else
        {
            $table='omc_'.$module;
        }
        
        if($module=='customer')
        {
            $where = 'customer_id';
        }
        elseif($module=='category' AND !empty($lang_id))
        {
            $where = 'table_id';// this is for welcome, function cat()
        }  
        else 
        {
            $where = 'id';
        }
        
        if(!empty($lang_id))
        {
            $this->db->where('lang_id', $lang_id); 
        }
        $options = array($where =>$id);
        $Q = $this->db->get_where($table,$options,1);
        if ($Q->num_rows() > 0)
        {
            $data = $Q->row_array();
        }
        $Q->free_result();
        return $data;
    }
    
    
    function getTopItems($module, $lang_id=NULL,$checkfield,$value)
    {
        $module_table = "omc_".$module;
        if(!$lang_id)
        {
            $lang_id = '0';
        }
        $checkroot = $this->_checkroot($module_table, $lang_id,$checkfield,$value);
        if(!$checkroot==TRUE)
        {
            $data[0] = 'root';
        }
        $this->db->where('parentid',0);
        $Q = $this->db->get_where($module_table,array('lang_id'=>$lang_id));
        if ($Q->num_rows() > 0)
        {
            foreach ($Q->result_array() as $row)
            {
                $data[$row['id']] = $row['name'];
            }
        }
        $Q->free_result();
        return $data;
    }


    function deleteitem($table, $id)
    {
        // $data = array('status' => 'inactive');
        if($table =='omc_customer')
        {
            $idname = 'customer_id';
        }  
        else 
        {
            $idname = 'id';
        }
	 $this->db->where($idname, $id)->delete($table);
    }

    /**
     * for pages module, $two is path of (parent/english) content
     * for menus module, $two is id
     * @param string $module
     * @param int $two
     * @param int $lang_id
     * @return bool
     */
    function checktrans($module, $two, $lang_id)
    {
        // from menus, $two is omc_menus.id
        $data = array();
        $table = "omc_".$module;
        if($module =='pages' OR $module =='lilly_fairies_pages')
        {
            $where = 'path';
        }
        elseif($module=='menus' OR $module =='lilly_fairies_menus')
        {
            // should be menu_id??
            $where = 'page_uri_id';
        }
        elseif($module =='category')
        {
            $where = 'table_id';
        }
	    $Q = $this->db->get_where($table,array($where=>$two,'lang_id'=>$lang_id));
        if ($Q->num_rows() > 0)
        {
           foreach ($Q->result_array() as $row)
           {
                $data[$row['id']] = $row['name'];
           }
        }
        $Q->free_result();
        return $data;
    }


         /**
      * This is used in pages/controllers/admin/delete to check if the page is assigned to a menu
      * omc_menus.page_uri_id is the same as omc_pages.id of the page
      */

    function checkItem($moduleToCheck, $fieldToCheck, $id)
    {
        $data = array();
        $table = 'omc_'.$moduleToCheck;
        $this->db->where($fieldToCheck,$id);
        $Q = $this->db->get($table,1);
        if ($Q->num_rows() > 0)
        {
            foreach ($Q->result_array() as $row)
            {
                $data = $row;
            }
        }
        $Q->free_result();
        return $data;
    }


    function simpleinsertitem($table, $data,$prefix)
    {
        $module_table = $prefix.$table;
        if($table=='homework'){
            $this->db->set('date', 'NOW()', FALSE);
        }
        $this->db->insert($module_table, $data);
    }

}

?>
