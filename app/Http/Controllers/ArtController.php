<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
//use phpDocumentor\Reflection\DocBlock\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\DB;


class ArtController extends Controller
{

    //Set admin state
    public function setAdminState()
    {

        if (!Auth::check()) {
            $admin = 0;
        } elseif (Auth::check()) {
            $admin = 0;
            if (Auth::user()->admin == 1) {
                $admin = 1;
            }
        }
        return $admin;
    }

    public function returnAllPosts($admin){
        if($admin == 1)
        {
            //Alle posts met hidden
            $artItems = Post::orderBy('id', 'DESC')->get();
        }
        else
        {
            //Zonder hidden
            $artItems = Post::orderBy('id', 'DESC')->where('hidden',0)->get();
        }

        return $artItems;

    }

    //Homepage show all posts
    public function index()
    {
        $admin = $this->setAdminState();
        $artItems = $this->returnAllPosts($admin);
        return view('art-items.index', compact('artItems', 'admin'));
    }

    //Show details of 1 post
    public function show($id)
    {
        $artItem = Post::find($id);
        $admin = $this->setAdminState();
        $comments = Comment::all()->where('post_id', $id);
        return view('art-items.details', compact('artItem', 'admin', 'comments'));
    }

    //Upload post
    public function upload()
    {
        $tags = Tag::all();
        return view('art-items.upload', compact('tags'));
    }

    //Show all user's own posts
    public function profile()
    {
        $artItems = Post::all()->where("user_id", '=', Auth::id());
        $admin = $this->setAdminState();
        return view('profile', compact('artItems', 'admin'));
    }


    /**
     * Store a new blog post.
     *
     * @param Request $request
     * @return Response
     */

    //Store post (save to DB)
    public function store(Request $request)
    {

        //CREATE NEW POST
        if ($request->hasFile('image')) {

            $validatedData = $request->validate([
                'name' => ['required', 'max:255'],
                'tags' => ['required'],
                'image' => 'required|file|max:1014',
                'description' => ['required', 'max:255']
            ]);

            $extension = $request->image->extension();
            $request->image->storeAs('/public', $validatedData['name'] . "." . $extension);
            $url = $validatedData['name'] . "." . $extension;

            $post = new Post();

            $post->name = $request->name;
            $post->image = $url;
            $post->tags = $request->tags;
            $post->user_id = Auth::id();
            $post->description = $request->description;

            $post->save();

            $id = $request->id;

            $artItem = $post;
            $admin = $this->setAdminState();
            $comments = Comment::all()->where('post_id', $id);
            return view('art-items.details', compact('artItem','comments','admin'));
        }


        //UPDATE POST
        if ($request->state == "update") {

            $validatedData = $request->validate([
                'name' => ['required', 'max:255'],
                'description' => ['required', 'max:255']
            ]);

            $id = $request->id;

            Post::where('id', $id)->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

            $artItem = Post::find($id);
            $comments = Comment::all()->where('post_id', $id);
            $admin = $this->setAdminState();
            return view('art-items.details', compact('artItem', 'comments','admin'));

        }

        //DELETE POST
        if ($request->state == "delete") {

            $id = $request->id;

            Post::where('id', $id)->delete();

            $admin = $this->setAdminState();
            $artItems = $this->returnAllPosts($admin);
            return view('art-items.index', compact('artItems','admin'));

        }

        //POST COMMENT
        if($request->state == "comment") {
            $validatedData = $request->validate([
                'description' => ['required', 'max:255']
            ]);

            $id = $request->id;

            $comment = new Comment();

            $comment->user_id = Auth::id();
            $comment->post_id = $id;
            $comment->description = $request->description;

            $comment->save();

            $artItem = Post::find($id);
            $admin = $this->setAdminState();
            $comments = Comment::all()->where('post_id', $id);
            return view('art-items.details', compact('artItem', 'admin', 'comments'));
        }

        abort(500, 'Could not upload image :(');


    }

    //Search for post
    public function search()
    {
        return view('art-items.search');
    }

    //Search for post
    public function searchSubmit(Request $request)
    {

        //Niks ingevuld
        if($request-> name == NULL && $request-> description == NULL){
            $searched = "nothing";
            return view('art-items.search', compact('searched'));
        }

        //Alleen naam ingevuld
        if($request-> name == !NULL && $request-> description == NULL){
            $name = $request->name;
            $posts = Post::where('name','like','%'.$name.'%')->get();

            $searched = "name";
            return view('art-items.search', compact('searched', 'posts'));
        }

        //Alleen description ingevuld
        if($request-> name == NULL && $request-> description == !NULL){
            $description = $request->description;
            $posts = Post::where('description','like','%'.$description.'%')->get();

            $searched = "description";
            return view('art-items.search', compact('searched', 'posts'));
        }

        //Naam en description ingevuld
        if($request-> name == !NULL && $request-> description == !NULL){
            $name = $request->name;
            $description = $request->description;
            $posts = Post::where('name','like','%'.$name.'%')->where('description','like','%'.$description.'%')->get();

            $searched = "name and description";
            return view('art-items.search', compact('searched', 'posts'));
        }

    }



    //Edit post
    public function edit($id)
    {
        $artItem = Post::find($id);
        return view('art-items.edit', compact('artItem'));
    }

    //Delete post
    public function delete($id)
    {
        $artItem = Post::find($id);
        return view('art-items.delete', compact('artItem'));
    }

    public function hide(Request $request, $id)
    {
        $id = $request->id;
        $updateHidden = $request->updatehidden;

        Post::where('id', $id)->update(['hidden' => $updateHidden]);


        $admin = $this->setAdminState();

        if ($admin == 0)
        {
            //From profile
            $artItems = Post::all()->where("user_id", '=', Auth::id());
            $view = view('profile', compact('artItems', 'admin'));
        }
        else
        {
            //From homepage (admin)
            $artItems = $this->returnAllPosts($admin);
            $view = view('art-items.index', compact('artItems', 'admin'));
        }

        return $view;
    }

}

