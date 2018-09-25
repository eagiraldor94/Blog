<?php
namespace app\controllers;
use app\models\BlogPost;
class IndexController extends BaseController {
  public function getIndex($number = 1){
    $count = BlogPost::count();
    $count = $count/3;
    $next = null;
    $prev = null;
    $countersHigh = null;
    $countersLow = null;
    if ($number>1){
      $prev = $number -1;
    }
    if ($number<$count){
      $next=$number+1;
    }
    $links = [
      'next' => $next,
      'prev' => $prev
    ];
    if ($number<$count) {
      $countersHigh= array();
      $a=1;
      for ($i=$number+1; $i < $count+1 ; $i++) {
        if ($a <= 3) {
          $countersHigh[]=$i;
          $a++;
        }

      }
    }
    if ($number>1) {
      $countersLow= array();
      $a=1;
      for ($i=$number-3; $i < $number ; $i++) {
        if ($i>=1){
          if ($a <= 3) {
            $countersLow[]=$i;
            $a++;
          }
        }

      }
    }
    $blogPosts = BlogPost::query()->orderBy('id','desc')->skip(3*($number-1))->take(3)->get();
    return $this->render('index.twig',[
      'blogPosts'=>$blogPosts,
      'links' => $links,
      'number' => $number,
      'countersHigh' => $countersHigh,
      'countersLow' => $countersLow
  ]);
  }

}
 ?>
