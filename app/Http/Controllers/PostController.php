<?php

namespace App\Http\Controllers;



use App\{Post, Category};

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Category $category = null, Request $request)
    {
      list($orderColumn, $orderDirection) = $this->getListOrder($request->get('orden'));

      $posts = Post::query()
          ->scopes($this->getListScopes($category, $request))
          ->orderBy($orderColumn, $orderDirection)
          ->paginate();

        $posts->appends(request()->intersect(['orden']));


      $categoryItems = $this->getCategoryItems();

      return view('posts.index', compact('posts', 'category', 'categoryItems'));
    }
    
    protected function getCategoryItems()
    {
        return Category::orderBy('name')->get()->map(function ($category) {
            return [
                'title' => $category->name,
                'full_url' => route('posts.index', $category)
            ];
        })->toArray();
    }

    public function show(Post $post, $slug)
    {
        if ($post->slug != $slug) {
            return redirect($post->url, 301);
        }

        return view('posts.show', compact('post'));
    }

   protected function getListScopes(Category $category, Request $request)
   {
       $scopes = [];

       if ($category->exists) {
           $scopes['category'] = [$category];
       }

       $routeName = $request->route()->getName();

       if ($routeName == 'posts.pending') {
           $scopes[] = 'pending';
       }

       if ($routeName == 'posts.completed') {
           $scopes[] = 'completed';
       }

       return $scopes;
   }    

  public function getListOrder($order)   
  {
      if ($order == 'recientes') {
        return ['created_at', 'desc'];
      }

      if ($order == 'antiguos') {
             return ['created_at', 'asc'];
      }     

      return ['created_at', 'desc'];      

  }
}
