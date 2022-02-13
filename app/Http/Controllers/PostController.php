<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->paginate(5);

        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'content' => ['required', 'min:10']
        ]);

        $image = $request->file('image');
        $image->storeAs('post', $image->hashName(), 'public');

        $store = Post::create([
            'image' => $image->hashName(),
            'title' => $request->title,
            'content' => $request->content
        ]);

        if ($store) {
            return redirect()->route('post.index')
                ->with(['success' => 'Post berhasil disimpan!']);
        } else {
            return redirect()->route('post.index')
                ->with(['error' => 'Terjadi kesalahan.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        return response()->json(compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'content' => ['required', 'min:10']
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageData = $image->hashName();
            $image->storeAs('post', $imageData, 'public');

            Storage::delete('public/post/' . $post->image);
        } else {
            $imageData = $post->image;
        }

        $update = $post->update([
            'image' => $imageData,
            'title' => $request->title,
            'content' => $request->content
        ]);

        if ($update) {
            return redirect()->route('post.index')
                ->with(['success' => 'Post berhasil diubah!']);
        } else {
            return redirect()->route('post.index')
                ->with(['error' => 'Terjadi kesalahan.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        Storage::delete('public/post/' . $post->image);

        $delete = $post->delete();

        if ($delete) {
            return redirect()->route('post.index')
                ->with(['success' => 'Post berhasil dihapus!']);
        } else {
            return redirect()->route('post.index')
                ->with(['error' => 'Terjadi kesalahan.']);
        }
    }
}
