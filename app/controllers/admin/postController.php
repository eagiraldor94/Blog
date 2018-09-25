<?php
namespace app\controllers\admin;
use app\controllers\BaseController;
use app\models\BlogPost;
use Sirius\Validation\Validator;
class PostController extends BaseController {
  public function getIndex(){
    // admin/posts or admin/posts/index
    $blogPosts = BlogPost::all();
    return $this->render('admin/posts.twig',['blogPosts'=>$blogPosts]);
  }
  public function getEdit($id){
    $blogPosts = BlogPost::where('id', $id)->get();
    return $this->render('admin/edit-post.twig',['blogPosts'=>$blogPosts]);
  }
  public function postEdit(){
    $errors = [];
    $result= false;
    $validator = new Validator();
    $validator->add('title', 'required');
    $validator->add('content', 'required');

    if ($validator->validate($_POST)){
      $blogPost = BlogPost::where('id', $_POST['id'])->first();
      $blogPost->title = $_POST['title'];
      $blogPost->content = $_POST['content'];
        if ($_POST['image']) {
          $blogPost->img_url = $_POST['image'];
        }
      $blogPost->save();
      $result = true;
    } else {
      $errors = $validator->getMessages();
    }

    return $this->render('admin/edit-post.twig', ['result' => $result,
      'errors'=> $errors
      ]);
  }
  public function getDelete($id){
    $blogPost = BlogPost::where('id', $id)->first();
    $blogPost->delete();
    $result = true;
    $blogPosts = BlogPost::all();
    return $this->render('admin/posts.twig',[
      'blogPosts'=>$blogPosts,
      'result'=>$result
  ]);
  }
  public function getCreate(){
    //admin/posts/create
    return $this->render('admin/insert-post.twig');
  }
  public function postCreate(){
    $errors = [];
    $result= false;
    $validator = new Validator();
    $validator->add('title', 'required');
    $validator->add('content', 'required');

    if ($validator->validate($_POST)){
      $blogPost = new BlogPost([
          'title'=>$_POST['title'],
          'content'=>$_POST['content']
        ]);
        if ($_POST['image']) {
          $blogPost->img_url = $_POST['image'];
        }
      $blogPost->save();
      $result = true;
    } else {
      $errors = $validator->getMessages();
    }

    return $this->render('admin/insert-post.twig', ['result' => $result,
      'errors'=> $errors
  ]);
  }
} ?>
