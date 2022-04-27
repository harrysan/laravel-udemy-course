@forelse ($comments as $comment)
    <p>
        {{ $comment->content }}
    </p>
    
    @tags(['tags' => $comment->tags])
    @endtags
            
    {{-- <p class="text-muted">added {{ $comment->created_at->diffForHumans() }}</p> --}}
    @updated(['date' => $comment->created_at, 
                'name' => $comment->user->name, 
                'userId' => $comment->user->id])
    @endupdated
@empty
    <p>No comments yet!</p>
@endforelse