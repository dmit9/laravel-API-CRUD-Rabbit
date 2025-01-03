<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <title>Laravel</title>

</head>
<body>
<nav class="d-flex">
    <div class="mb-3">
        <h2><a href="/"> All users</a></h2>
    </div>

</nav>
<div class="d-flex flex-wrap ">
            <div class="d-flex">

                <ul>
                    <li>id: {{$user->id}}</li>
                    <li>name: {{$user->name}}</li>
                    <li>phone: {{$user->phone}}</li>
                    @foreach($positions as $position)
                        @if( $position->id == $user->position_id )
                            <li>position: {{$position->name}}</li>
                            <li>position_id: {{$position->id}}</li>
                        @endif
                    @endforeach
                    <li>registration_timestamp: {{$user->created_at}}</li>
                    <li>photo url: {{$user->photo}}</li>
                    <img width="200" height="200" src="{{asset('storage/' . $user->photo)}}">
                    <li>remember_token: {{$user->remember_token}}</li>
                </ul>
            </div>

</div>


</body>
</html>
