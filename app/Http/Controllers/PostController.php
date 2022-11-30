<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request\UsersPostRequest;
use App\Models\Visit;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $post = \App\Models\Post::where('user_id',$user->id)->orderby('id','desc')->paginate(5);
//        $post = Post::paginate(5)->where('user_id',$user->id);
//        $post = Post::paginate(10);

        return view('home',compact('user','post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'image' => 'sometimes|image:gif,jpeg,png,jpg',
        ]);


        if ($validator-> passes()){
            $post = new Post();
            $post->name = $request->name;
            $post->user_id = Auth::id();
            $post->description = $request->description;
            $post->status = 'publish';
            $post->save();

            if ($request->image){
                $ext = $request->image->getClientOriginalExtension();
                $newFileName = time().'.'.$ext;
                $request->image->move(public_path().'/uploads/posts/',$newFileName);
                $post->image = $newFileName;
                $post->save();
            }

            $request->session()->flash('success','Post Created SuccessFully');

            return redirect()->route('post.index');
        }
        else{
            return redirect()->route('post.create')->withErrors($validator)-> withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('edit',['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'image' => 'sometimes|image:gif,jpeg,png,jpg',
        ]);


        if ($validator-> passes()){
            $post = Post::find($id);
            $post->name = $request->name;
            $post->user_id = Auth::id();
            $post->description = $request->description;
            $post->status = 'publish';
            $post->save();

            if ($request->image){
                $oldImage = $post->image;
                $ext = $request->image->getClientOriginalExtension();
                $newFileName = time().'.'.$ext;
                $request->image->move(public_path().'/uploads/posts/',$newFileName);
                $post->image = $newFileName;
                $post->save();
                File::delete(public_path().'/uploads/posts/',$oldImage);
            }

            $request->session()->flash('success','Post Updated SuccessFully');

            return redirect()->route('post.index');
        }
        else{
            return redirect()->route('post.create')->withErrors($validator)-> withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        $post = Post::findOrFail($id);
        File::delete(public_path().'/uploads/posts/',$post->image);
        $post->delete();

        $request->session('success','Employee Deleeted Successfully');

        return redirect()->route('post.index');

    }
    public function show($id)
    {
        $user = Auth::user();
        $post = Post::find($id);
        
        
        // visits to the table
        
        $visit = new Visit();
        $visit->ip= $this->get_client_ip();
        $visit->post_id=$post->id;
        $visit->save();

        return view('showComment',compact('post', 'user'));
    }
    
    public function visits($id)
    {
        $post = Post::find($id);
        return view('visits')->with('post',$post);
    }
    
    public function get_client_ip() 
    {
        
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

}
