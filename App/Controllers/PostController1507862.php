<?php


namespace App\Controllers;


use App\Auth;
use App\Models\Posts1507862;
use App\Models\Product;
use Core\View;

class PostController1507862 extends AuthenticatedController1507862
{
    public function index1507862Action()
    {

        $search = $_GET["search_box"];
        $posts = Posts1507862::getAllPosts1507862($search);
        View::renderTemplate('Post/index1507862.html', ['posts' => $posts,'search' => $search]);
    }

    
    public function create1507862Action($id = null)
    {
        $post = null;
        if ($id != null) {
            $post = Posts1507862::findById1507862($id);
        }

       /* if (Auth::getUser()->id = 1 || $post->user_id = Auth::getUser()->id){
            View::renderTemplate('Post/add1507862.html', ['post' => $post]);
        }*/
        View::renderTemplate('Post/add1507862.html', ['post' => $post]);
    }

    public function save1507862Action()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $posts = new Posts1507862($_POST);
            if ($posts->savePost1507862()) {
                $this->redirect('/post1507862');
            }
            View::renderTemplate('Post/add1507862.html', ['posts' => $posts]);
        }
    }

    public function delete1507862Action($id = null)
    {
        $search = $_GET["s"];
        $posts = null;
        if ($id != null) {
            if (Posts1507862::delete1507862($id))
            {
                $this->redirect('/post1507862');
            }
        }
        $this->redirect('/post1507862');
    }

}