<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;


class CommentController extends Controller
{
   
    public function show(Post $post)
    {
        $comments = $post->comments()->latest()->take(10)->get(); // Limite à 10 commentaires
        $totalComments = $post->comments()->count(); // Total des commentaires
    
        return view('posts.show', compact('post', 'comments', 'totalComments'));
    }
    

    // Method to add a comment
    public function store(Request $request, Post $post)
    {
        // Data validation
        $validated = $request->validate([
            'content' => 'required|string|max:1000', // Validation for comment content
        ]);

        // Create the comment and associate it with the post
        $comment = new Comment([
            'content' => $validated['content'],
            'user_id' => auth()->id(), // ID of authenticated user
        ]);

        // Save the comment to the database
        $post->comments()->save($comment);

        // Redirect user to the post page with comments
        return redirect()->route('posts.show', $post->id)->with('success', 'Comment added successfully!');
    }

  

  public function edit(Comment $comment)
    {
        // Check if user is the author of the comment
        if ($comment->user_id != auth()->id()) {
            return redirect()->route('posts.show', $comment->post)->with('error', 'You are not authorized to edit this comment.');
        }

        // Pass the comment to the view
        return view('posts.edit-comment', compact('comment'));
    }

public function update(Request $request, Comment $comment)
{
    // Validate comment content
    $request->validate([
        'content' => 'required|string|max:1000',
    ]);

    // Check if user is authorized to update the comment
    if ($comment->user_id != auth()->user()->id) {
        return redirect()->route('posts.show', $comment->post)->with('error', 'You do not have permission to edit this comment.');
    }

    // Update the comment
    $comment->update([
        'content' => $request->content,
    ]);

    return redirect()->route('posts.show', $comment->post)->with('success', 'Comment updated.');
}
  // Method to delete a comment
  public function destroy(Comment $comment)
  {
      // Check if user is the owner of the comment
      if ($comment->user_id != auth()->id()) {
          return redirect()->back()->with('error', 'You cannot delete this comment.');
      }

      // Delete the comment
      $comment->delete();

      // Redirect user to the post page
      return redirect()->back()->with('success', 'Comment deleted successfully!');
  }
  public function like(Comment $comment)
{
    $user = auth()->user();

    // Vérifier si l'utilisateur a déjà liké ce commentaire
    $like = Like::where('user_id', $user->id)
                ->where('comment_id', $comment->id)
                ->first();

    if ($like) {
        // Si l'utilisateur a déjà liké, il peut retirer son like
        $like->delete();
    } else {
        // Sinon, ajouter un nouveau like
        Like::create([
            'user_id' => $user->id,
            'comment_id' => $comment->id
        ]);
    }

    return back(); // Revenir à la page précédente ou recharger la vue
}



}