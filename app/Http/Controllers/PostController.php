<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Post',
            'post' => Post::all(),
        ];
        return view('page.post',$data);
    }

    public function addPost(Request $request)
    {
        $request->validate([
            'foto' => 'image|mimes:jpg,png,jpeg'
        ]);
        // if($request->file('foto')){
        //     $foto = $request->file('foto')->store('img-outlet');
        // }else{
        //     $foto='';
        // }

        $request->file('foto')->move('img-post/',$request->file('foto')->getClientOriginalName());
        $foto = 'img-post/'.$request->file('foto')->getClientOriginalName();
        
        $data = [
            'caption' => $request->caption,
            'content' => $request->content,
            'foto' => $foto,
            'admin' => Auth::user()->id
        ];
        Post::create($data);

        
        return redirect(route('post'))->with('success','Data berhasil dibuat');
    }


    public function editPost(Request $request)
    {
        $request->validate([
            'foto' => 'image|mimes:jpg,png,jpeg'
        ]);
        if($request->file('foto')){
            $request->file('foto')->move('img-post/',$request->file('foto')->getClientOriginalName());
            $foto = 'img-post/'.$request->file('foto')->getClientOriginalName();
            $data = [
                'caption' => $request->caption,
                'content' => $request->content,
                'foto' => $foto,
                'admin' => Auth::user()->id
            ];
        }else{
            $data = [
                'caption' => $request->caption,
                'content' => $request->content,
                'admin' => Auth::user()->id
            ];
        }
        
        
        Post::where('id',$request->id)->update($data);
        
        return redirect(route('post'))->with('success','Data berhasil diedit');
    }

}
