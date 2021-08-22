<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
//ELQUENT ORM read after model creation
use App\Models\Post;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/post/{id}', 'App\Http\Controllers\PostController@index');

use App\Http\Controllers\TestController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\DB;

Route::get('/test', [TestController::class,'index']);

Route::resource('/post', PostController::class);


Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return view('hello');
});

Route::get('/hi', function () {
    return "<h1>view('hello')</h1>";
});

Route::get('/test/{id}', function ($id) {
    return "this is test # ".$id;
});

Route::get('/test/{id}/{name}', function ($id, $name) {
    return "this is test # ".$id. " ". $name;
});

Route::get('/users/to/log/url',array('as'=>'users.home', function () {
    $url = route('users.home');
    return "This is ".$url;
}));


Route::get('/contact', [PageController::class,'contact_page']);
//Route::get('/contact', 'App\Http\Controllers\PostController@contact_page');

Route::get('/show_post/{id}', [PageController::class,'show_post']);


// new routes database row quary insertion 

Route::get('/rowsqlinsert', function () {
    DB::insert('insert into posts(title,content) values(?,?)',['PHP with Laravel','Laravel is the best PHP frame work ']);
});

// new routes database row quary reading 
Route::get('/rowsqlread/{id}', function ($id) {

    
    $result = DB::select('select * from posts where id = ?', [$id]);
    

    foreach($result as $posts){
        return $posts->title;
    }
}); 

// new routes database row quary update 
Route::get('/rowsqlupdate/{id}', function ($id) {
    $updated = DB::update('update posts set title = "Updated Title 4" where id = ?', [$id]);
    return $updated;
});

// new routes database row quary Delete
Route::get('rowsqldelete/{id}', function ($id) {
    $deleted = DB::delete('delete from posts where id = ?', [$id]);
    return $deleted;

    
}); 


Route::get('/ormread', function () {
    $posts = Post::all();

    foreach($posts as $post){
        return $post->title;
    }
});
//ELQUENT ORM find after model creation
Route::get('/ormfind/{id}', function ($id) {
    $post = Post::find($id);

    return $post->title;
});
//ELQUENT ORM find after model creation
Route::get('/ormfindwhere/{title}', function ($title) {
    $posts = Post::where('title',$title)->orderBy('title','desc')->take(1)->get();
    return $posts;
});

Route::get('ormfindmore/{id}', function ($id) {
    $posts = Post::findOrFail($id);
    return $posts->title;
    // $posts = Post::where('users_count','<',50)->firstOrFail();
    // return $posts;
});
//ELQUENT ORM Insert
Route::get('/orminsert', function () {
    $post = new Post;
    $post->title='new orm title';
    $post ->content='new content';
    //time()
    $post->created_at=time();
    $post->save();
});

//ELQUENT ORM Insert
Route::get('/orminsert/{id}', function ($id) {
    $post = Post::find($id);
    $post->title='updated orm updated title';
    $post ->content='updated orm update content';
    //time()
    $post->created_at=time();
    $post->save();
});
//ELQUENT ORM create using model
Route::get('/ormcreate', function () {
    Post::create(['title'=>'the create method','content'=>'the create method contentt']);
});
//ELQUENT ORM Delete method
Route::get('ormdelete/{id}', function ($id) {
    $post = Post::find($id);
    $post->delete();
});
//ELQUENT ORM Destroy Delete method
Route::get('/ormdestroy/{id}', function ($id) {
    Post::destroy($id);
});
//ELQUENT ORM soft Delete method
Route::get('ormsoftdelete/{id}', function ($id) {
    Post::find($id)->delete();

});

//ELQUENT ORM soft read Deleted method
Route::get('readormsoftdelete/{id}', function ($id) {
    //$post = Post::withTrashed()->where('id',$id)->get();
    $post = Post::onlyTrashed()->where('id',$id)->get();
    return $post;
});
//ELQUENT ORM soft Delete restore deleted item
Route::get('/ormrestore/{id}', function ($id) {
    Post::withTrashed()->where('id',$id)->restore();

});
//ELQUENT ORM permanent Delete deleted item
Route::get('/forcedelete/{id}', function ($id) {
    $posts =Post::onlyTrashed()->where('id',$id)->forceDelete();
    return $posts;
});
//ELQUENT Relation ships 
Route::get('/post/{id}/user', function ($id) {
    return User::find($id)->users;
    //print_r(User::find($id)->post->content, true);
}); 

