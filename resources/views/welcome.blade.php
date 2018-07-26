@extends('layouts.app')

@section('content')

    @if (Auth::check())
        <div class="row">
            <aside class="col-xs-8 col-md-8 col-lg-4">
                <h1>Timeline</h1>
                
            </aside>
            <div class="col-xs-12 col-md-12 col-lg-12">
                @if (count($microposts) > 0)
                    @include('microposts.microposts', ['microposts' => $microposts])
                @endif
            </div>
            
        </div>
        
        <div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card-columns insta-card">
            </div>
        </div>
    </div>
</div>
        
    @else
        <div id="cover">
        <div class="jumbotron">
            <div class="text-center">
                <h1>Welcome, microposts!</h1>
                {!! link_to_route('signup.get', 'Sign up now!', null, ['class' => 'btn btn-lg btn-primary btn-ghost']) !!}
            </div>
        </div>
        </div>
    @endif
    
        <footer>
            <div class="text-center text-muted">© 2016 Micropost.</div>
        </footer>
@endsection


    