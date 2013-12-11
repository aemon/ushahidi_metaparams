<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Mark - Load All Events
 **/

class metaparams {
    
    protected $table_prefix;
    protected $table_alias;

    public function __construct()
    {
        
        Event::add('system.pre_controller', array($this, 'add'));
        
        $this->table_prefix = Kohana::config('database.default.table_prefix');
        $this->request = ($_SERVER['REQUEST_METHOD'] == 'POST')? $_POST : $_GET; 
        
    }

    public function add()
    {
        Event::add('ushahidi_action.display_admin_report_meta', array($this, 'display_admin_report_meta'));
        Event::add('ushahidi_action.report_edit', array($this, 'save_admin_report_meta'));
        Event::add('ushahidi_action.add_report_meta', array($this, 'get_report_meta'));
    }
    
   
    
    public function  display_admin_report_meta(){      

        $element_id = Event::$data;
        $view = View::factory('admin_metaparams_block'); 
        $db = Database::instance();
        $query = 'SELECT *, CONCAT(locale,"_",type) as name '
                . 'FROM '.$this->table_prefix.'metaparams WHERE element_id='.$element_id;
        $query = $db->query($query);
        $metaparams = $query->result_array(FALSE); 
        $set_metaparams = array();
        foreach($metaparams as $param){ 
            $set_metaparams[$param['name']] = $param['value'];
        }   
        $view->set_metaparams = $set_metaparams; 
        $view->fields_list = Kohana::config('metaparams.locales_fields');  
  
        $view->render(TRUE);    
    }
    
    public function  save_admin_report_meta(){
        $db = Database::instance();    
        $element_id = Event::$data;
        if (!empty($element_id)){
            $sql = "DELETE FROM ".$this->table_prefix."metaparams WHERE element_id=".$element_id;
            $query = $db->query($sql);
            $list = Kohana::config('metaparams.locales_fields');
              foreach ($list as $locale=>$params){
                  foreach ($params as $name=>$original_name){
                      $sql = "INSERT INTO ".$this->table_prefix."metaparams SET element_id=".$element_id.", locale='".$locale."',"
                      ."type ='".$name."', value='".addslashes($this->request[$locale.'_'.$name])."'";
                      $query = $db->query($sql);
                  }
              }
        }
    }
    
    public function get_report_meta(){
        $locale =  Kohana::config('locale.language', false);
        $id = Event::$data['id'];
        $db = Database::instance(); 
        $sql = "SELECT * FROM ".$this->table_prefix."metaparams WHERE element_id=".$id." AND locale='".$locale."' ";
        $query = $db->query($sql);
        $result = $query->result_array(FALSE);
        if (!empty($result)){
            foreach ($result as $row){
                if ($row['type']=='description'){
                    Event::$data['metadescription'] = $row['value'];   
                }
                if ($row['type']=='keywords'){
                    Event::$data['metakeywords'] = $row['value'];   
                }
            }
        }
        return '';
        
    }
    
    
    
    
    
}
new metaparams;