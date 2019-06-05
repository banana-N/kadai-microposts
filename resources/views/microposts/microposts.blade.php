<ul class="media-list">
    @foreach ($microposts as $micropost)
        <li class="media mb-3">
            <img class="mr-2 rounded" src="{{ Gravatar::src($micropost->user->email, 50) }}" alt="">
            <div class="media-body">
                <?php
                // echo 'ログインしているユーザID：';
                // echo Auth::id();
                // echo '<br />';
                // echo 'この記事ID：';
                // echo $micropost->id;
                // echo '<br />';
                // echo 'この記事のユーザID：';
                // echo $micropost->user_id;
                // echo '<pre>';
                // // var_dump($micropost);
                // echo '</pre>';
                ?>
                <div>
                    {!! link_to_route('users.show', $micropost->user->name, ['id' => $micropost->user->id]) !!} <span class="text-muted">posted at {{ $micropost->created_at }}</span>
                </div>
                <div>
                    <p class="mb-0">{!! nl2br(e($micropost->content)) !!}</p>
                </div>
                <div>
                    @if (Auth::id() == $micropost->user_id)
                        {!! Form::open(['route' => ['microposts.destroy', $micropost->id], 'method' => 'delete']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    @endif
                </div>
                <?php
                // echo '<pre>';
                // // var_dump($micropost);
                // echo '記事ID：';
                // echo $micropost->id;
                // echo '</pre>';
                ?>
                @include('user_favorite.favorite_button', ['user' => $user,'micropost_id' => $micropost->id])
            </div>
        </li>
    @endforeach
</ul>
{{ $microposts->render('pagination::bootstrap-4') }}