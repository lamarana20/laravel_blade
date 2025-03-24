<?php

namespace App\Http\Controllers;

use App\Events\UserSubscribed;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Mail\WelcomeMail;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(['auth','verified'], except: ['index', 'show']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     
        $posts = Post::latest()->paginate(12);
        return view('posts.index', compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return back()->withErrors(['auth' => 'Vous devez être connecté pour créer un post.']);
        }

        // Validation des champs
         $request->validate([
            'title' => ['required', 'min:3', 'max:25500'],
            'body' => ['required', 'min:3', 'max:255000'],
            'image' => ['nullable', 'image', 'file', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
        ]);

        // Gestion de l'image
        $path =  null;
        if ($request->hasFile('image')) {
            $path = Storage::disk('public')->put('posts_images', $request->file('image'));
        }
       
        //send mail
       


        // Création du post

      $post = Auth::user()->posts()->create([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $path,
        ]);
        
        // send mail
        
        return back()->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        
        return view('posts.show', ['post' => $post]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);

        // Validation
        $fields = $request->validate([
            'title' => ['required', 'min:3'],
            'body' => ['required', 'min:3'],
            'image' => ['nullable', 'image', 'file', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
        ]);

        // Gestion de l'image
        $path = $post->image ?? null;
        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $path = Storage::disk('public')->put('posts_images', $request->file('image'));
        }

        // Mise à jour du post
        $post->update([
            'title' => $fields['title'],
            'body' => $fields['body'],
            'image' => $path,
        ]);

        return redirect()->route('dashboard')->with('update', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('update', $post); // Correction : `delete` au lieu de `update`

        // Suppression de l'image si elle existe
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        // Suppression du post
        $post->delete();

        return back()->with('delete', 'Post deleted successfully');
    }
  
 

  
}
