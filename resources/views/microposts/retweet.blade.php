<ul class="media-list">
@foreach ($microposts->is_retweeting() as $micropost)
    <?php $user = $micropost->user; ?>
    <li class="media">
        <div class="media-left">
            <img class="media-object img-rounded" src="{{ Gravatar::src($user->email, 50) }}" alt="">
        </div>
        <div class="media-body">
            <div>
                {!! link_to_route('users.show', $user->name, ['id' => $user->id]) !!} <span class="text-muted">posted at {{ $micropost->created_at }}</span>
            </div>
            <div>
                <p>{!! nl2br(e($micropost->content)) !!}</p>
            </div>
            <div>
                @if (Auth::user()->id != $user->id)
                    @if (Auth::user()->is_favoring($micropost->id))
                        {!! Form::open(['route' => ['user.unfavorite', $micropost->id], 'method' => 'delete']) !!}
                            {{Form::image('images/staryellow4.jpg')}}
                        {!! Form::close() !!}
                    @else
                        {!! Form::open(['route' => ['user.favorite', $micropost->id]]) !!}
                            {{Form::image('images/smallstar2.jpg')}}
                        {!! Form::close() !!}
                    @endif
                @endif
            </div>
            <div>
                @if (Auth::user()->id == $micropost->user_id)
                    {!! Form::open(['route' => ['microposts.destroy', $micropost->id], 'method' => 'delete']) !!}
                        {{Form::image('images/gomi.jpg')}}
                    {!! Form::close() !!}
                @endif
            </div>
            <div>
                @if (Auth::user()->id != $user->id)
                    @if (Auth::user()->is_retweeting($micropost->id))
                        {!! Form::open(['route' => ['user.unretweet', $micropost->id], 'method' => 'delete']) !!}
                            {{Form::image('images//retweet.png')}}
                        {!! Form::close() !!}
                    @else
                        {!! Form::open(['route' => ['user.retweet', $micropost->id]]) !!}
                            {{Form::image('images/unretweet.png')}}
                        {!! Form::close() !!}
                    @endif
                @endif
            </div>
        </div>
    </li>
@endforeach
</ul>
{!! $microposts->render() !!}