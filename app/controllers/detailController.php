<?php
namespace app\controllers;
use app\models\BlogPost;
use app\controllers\BaseController;
class DetailController extends BaseController {
  public function getIndex($id){
    $blogPosts = BlogPost::where('id', $id)->get();
    return $this->render('detail.twig',['blogPosts'=>$blogPosts]);
  }

}
 ?>
