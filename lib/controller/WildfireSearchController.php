<?php

class WildfireSearchController extends ApplicationController {

  public $results = array();
  public $search_fields = array('text'=>array('cols'=>array('title', 'content'), 'fuzzy'=>true));
  public $paginate = false;
  /**
   * $model_filters = array(
   *                        array('col'=>"column_name", 'val'=>"value", 'operator'=>"= / != / etc")
   *                      );
   */
  public $model_filters = array();


  public function index(){
    //based on the cms content type & scope
    $model = new $this->cms_content_class($this->cms_live_scope);
    //grab the search param data
    if($this->searched = Request::param('search')){
      $sql = "";
      //searh_fields key is the key in the post data - $_POST['search']['x']
      foreach($this->search_fields as $post_key=>$config){
        //if there is a matching var in the post data, we'll use it
        if($term = $this->searched[$post_key]){
          foreach($config['cols'] as $col){
            //need to make these escaped, use pdo etc
            if($config['fuzzy']) $sql .= "(`".$col."` LIKE '%".$term."%') OR";
            else $sql .= "(`".$col."` = '".$term."') OR";
          }
        }
      }
      //apply the sql
      if(strlen($sql)) $model->filter("(".rtrim($sql, " OR").")");
      else $model->filter("1=0");
      //if theres model filters set, apply them
      if($this->model_filters) foreach($this->model_filters as $filter) $model->filter($filter['col'], $filter['val'], $filter['operator']);
      //option to paginate or not
      if($this->paginate){
        if(!$this->this_page = Request::param('page')) $this->this_page = 1;
        if($per = Request::param('per_page')) $this->per_page = $per;
        $this->results = $model->page($this->this_page, $this->per_page);
      }
      else $this->results = $model->all();
    }
    
  }


  public function _inline(){
    $this->use_layout = false;
    $this->paginate = true;
    $this->index();
    $this->use_view = "_inline";
  }


}
?>