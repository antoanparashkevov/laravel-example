<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\Blogpost;
use Illuminate\Http\Request;

class PostsController extends Controller
{
//    private $posts = [
//        1 => [
//            'title' => 'Intro to Laravel',
//            'content' => 'This is a short intro to Laravel',
//            'is_new' => true,
//            'has_comments' => true,
//        ],
//        2 => [
//            'title' => 'Intro to PHP',
//            'content' => 'This is a short intro to PHP',
//            'is_new' => false,
//        ],
//        3 => [
//            'title' => 'Intro to JavaScript',
//            'content' => 'This is a short intro to JavaScript',
//            'is_new' => false,
//        ]
//    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('posts.index', ['posts' => Blogpost::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)//StorePost instead Request
    {


        $validated = $request->validated();

        $post = Blogpost::create($validated);

        $request->session()->flash('status', 'The blog post was created!');


        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        return view('posts.show', ['post' => Blogpost::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        return view('posts.edit', ['post' => Blogpost::findOrFail($id)]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {


        $post = Blogpost::findOrFail($id);

        $validated = $request->validated();

        $post->fill($validated);

        $post->save();

        $request->session()->flash('status', 'Blog post was updated!');


        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $post = Blogpost::findOrFail($id);


        $post->delete();


        session()->flash('status', 'Blog post was deleted!');



        return redirect()->route('posts.index');


    }
}
