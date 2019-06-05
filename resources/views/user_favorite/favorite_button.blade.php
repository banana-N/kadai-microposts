@if(Auth::id() != $micropost->user_id)

  @if (Auth::user()->is_favorite($micropost->id))
        {!! Form::open(['route' => ['favorites.unfavorite', $micropost->id], 'method' => 'delete']) !!}
            {!! Form::submit('Unfavorite', ['class' => "btn btn-danger btn-x"]) !!}
        {!! Form::close() !!}
    @else
        {!! Form::open(['route' => ['favorites.favorite', $micropost->id], 'method' => 'post']) !!}
            {!! Form::submit('Favorite', ['class' => "btn btn-info btn-x"]) !!}
        {!! Form::close() !!}
    @endif
@elseif (Auth::id() != $user->id)


@endif