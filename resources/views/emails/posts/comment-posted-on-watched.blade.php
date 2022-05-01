@component('mail::message')
# Comment was posted on post you're watching

Hi {{ $user->name }}

Someone has commented on your blog post

@component('mail::button', ['url' => route('posts.show', ['post' => $comment->commentable->id]) ])
View The Blog Post
@endcomponent

@component('mail::button', ['url' => route('users.show', ['user' => $comment->user->id]) ])
View {{ $comment->user->name }} profile
@endcomponent

@component('mail::panel')
{{ $comment->content }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
