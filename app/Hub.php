<?php 

class Hub {

  private $url;
  private $split_url;
  private $controller = "Post";
  private $method = "index";
  private $params = array();


  public function __construct() {
    $this->getUrl();

    
      if($this->split_url && file_exists("app/controllers/" . ucfirst($this->split_url[0]) . ".php")) {

        $this->controller = ucfirst($this->split_url[0]);
        array_shift($this->split_url);
      }

           
      require_once("app/controllers/" . $this->controller . ".php");
      $this->controller = new $this->controller();
      
    
     
      if($this->split_url && method_exists($this->controller, $this->split_url[0])) {
        $this->method = $this->split_url[0];
        array_shift($this->split_url);
      } 
    
      if($this->split_url) {
        $this->params = $this->split_url;
      }
    
      call_user_func_array([$this->controller, $this->method], $this->params);
  }

  public function getUrl() {
    if(isset($_GET['url'])) {
      $this->url = rtrim($_GET['url'], '/');
      $this->split_url = explode('/', $this->url);
    }
  }
}

?>