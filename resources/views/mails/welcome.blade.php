<h1>Welcome {{$user->name}}</h1>
<div>

    <p>Thank you for creating your post "{{$post->title}}"</p>
    <p>{{$post->body}}</p>

    <p>We're excited to have you as part of our community!</p>
  
      @if($post->image)
        <img src="{{$message->embed('storage/'.$post->image)}}" alt="Post Image" width="300px">
      @else
        <img src="{{$message->embed('storage/posts_images/default.png')}}" alt="Default Post Image" width="300px">
      @endif
   <p>Best regards,</p>
   <p>The Blog Team</p>



   <p>Copyright © {{date('Y')}} | All rights reserved</p>
   <p>This is an automated message. Please do not reply to this email.</p>
</div>