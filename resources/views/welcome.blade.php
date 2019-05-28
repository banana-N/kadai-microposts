@extends('layouts.app')

@section('content')
    @if(Auth::check())
    <?php 
    $user = Auth::user()->name;
    if($user == 'test'){
        echo "テストユーザ";
    }elseif($user == 'admin'){
        echo 'アドミンユーザ';
    }
    ?>
        {{ Auth::user()->name }}
    @else
    <div class="center jumbotron">
        <div class="text-center">
            <h1>Welcome to the Microposts</h1>
            {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
        </div>
    </div>
    @endif
    
    <?php echo '<pre>'; var_dump(Auth::user()); echo '</pre>'; ?>
    <?php  ?>
@endsection