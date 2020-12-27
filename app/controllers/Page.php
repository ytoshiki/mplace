<?php
 
  class Page extends Controller {
    public function __construct() {
      $this->page_model = $this->model("PageModel");
      $this->authorized = (isset($_SESSION["user_id"]) && isset($_SESSION["user_role"]));
      $this->authenticated = $this->authorized ? (($_SESSION["user_role"] == "admin") || ($_SESSION["user_role"] == "subscriber")) : false;
    }

    public function index($page = null) {
      if($_SERVER["REQUEST_METHOD"] == "GET" && $page == "all") {
        $data = array();
        $data["posts"] = $this->page_model->getAllPosts();
        $data["categories"] = $this->page_model->getCategories();
        if($this->authenticated) {
          $data["bookmarks"] = $this->page_model->getBookmarks($_SESSION["user_id"]);
        }
        $this->view('pages/main_page', $data);
      } elseif($_SERVER["REQUEST_METHOD"] == "GET" && $page == null) {
        $data = array();
        $data["readmore"] = true;
        $data["posts"] = $this->page_model->getPosts();
        $data["categories"] = $this->page_model->getCategories();
        if($this->authenticated) {
          $data["bookmarks"] = $this->page_model->getBookmarks($_SESSION["user_id"]);
        }
        $this->view('pages/main_page', $data);
      }
    }

    public function post($id) {
      if($_SERVER["REQUEST_METHOD"] == "GET") {
        $post = $this->page_model->getPost($id);
        $comments = $this->page_model->getComments($id);
        $widgetsPosts = $this->page_model->getSimilarPosts($id, $post["category_id"]);
        $data = array();
        $data["post"] = $post;
        $data["comments"] = $comments;
        if($widgetsPosts) {
          $data["widgets"] = $widgetsPosts;
        }

        if($this->authenticated) {
          $user_id = $_SESSION["user_id"];
          $post_id = $id;
          $bookmarked = $this->page_model->checkBookmarked($user_id, $post_id);
          $data["bookmarked"] = $bookmarked;
        }

        $this->view('pages/singlePost_page', $data);
      }
    }

    public function comment($id) {

      
      if($_SERVER["REQUEST_METHOD"] == "POST") {

        if(!isset($_SESSION["user_id"])) {
          redirect();
          die();
        }

        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $tem_comment = trim($_POST["comment"]);
        $tem_c_id = trim($_POST["category_id"]);
     
        // Error Info
        $error = array();
        $error["comment"] = "";
  
        if(empty($tem_comment)) {
          $error["comment"] = "Comment cannot be empty.";
        }
  
        if(empty($error["comment"])) {

            // <- saved image 
            $data = array();
            $data["comment"] = trim($_POST["comment"]);
            $data["post_id"] = intval($id);
            $data["user_id"] = intval($_SESSION["user_id"]);
            $data["category_id"] = intval($tem_c_id);

            // $this->view('pages/singlePost_page', $post);

            if($this->page_model->createComment($data)) {
              redirect("page/post/" . $id);
            } else {
              echo "failed";
            }
  
          } else {
       
            $data = array();
            $post = $this->page_model->getPost($id);
            $u_id = $_SESSION["user_id"];
            $data["post"] = $post;
            $data["widgets"] = $this->page_model->getSimilarPosts($id, $post["category_id"]);
            $data["bookmarked"] = $this->page_model->checkBookmarked($u_id, $id);
            $data["comments"] = $this->page_model->getComments($id);
            $data["error"] = $error;
            $this->view("pages/singlePost_page", $data);
          }
  
      }
    }

    public function filter($category) {
      $postResult = $this->page_model->filterByCategory($category);
      if($postResult) {
        $data = array();
        $data["posts"] = $postResult;
        $data["categories"] = $this->page_model->getCategories();
        if($this->authenticated) {
          $data["bookmarks"] = $this->page_model->getBookmarks($_SESSION["user_id"]);
        }
        $this->view('pages/main_page', $data);
      } else {
        $data = array();
       
        $data["categories"] = $this->page_model->getCategories();
        $this->view('pages/main_page', $data);
      }

    }

    public function search() {
      if($_SERVER["REQUEST_METHOD"] == 'GET' && isset($_GET["submit"])) {
        $p_title = filter_var($_GET["search"], FILTER_SANITIZE_STRING);

        $postResult = $this->page_model->filterByKeyword($p_title);

        if($postResult) {
          $data = array();
          $data["title"] = "Search Result";
          $data["posts"] = $postResult;
          $this->view('pages/search_result', $data);
        } else {
          $this->view('pages/search_result');
        }
        
      }
    }

    public function bookmark() {
      if(!$this->authenticated) {
        redirect();
        exit();
      }

      $posts = $this->page_model->getBookmarksAll($_SESSION["user_id"]);

      if($posts) {
        $data = array();
        $data["title"] = "Bookmarks";
        $data["posts"] = $posts;
        $this->view('pages/search_result', $data);
      } else {
        $this->view('pages/search_result');
      }

    }

    public function book($post_id, $action = null) {
      if(!$this->authenticated) {
        redirect();
        exit();
      } 

      if($action == null) {

        $result = $this->page_model->addBookmark($_SESSION["user_id"], $post_id);
 

        if($result) {
          
          // Redirect to the prev url
          header('Location: ' . $_SERVER['HTTP_REFERER']);
          exit;
        }
      } elseif($action == "remove") {
        $result = $this->page_model->removeBookmark($_SESSION["user_id"], $post_id);

        
        if($result) {
        
          // Redirect to the prev url

          header('Location: ' . $_SERVER['HTTP_REFERER']);
          exit;
        } 
      } 

    }


    

   
  }