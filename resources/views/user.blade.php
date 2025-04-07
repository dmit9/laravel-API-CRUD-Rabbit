<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <title>Laravel</title>

</head>
<body>
<<<<<<< HEAD

<div class="container mb-3 mt-3">
    <nav class="d-flex">
        <div class="mb-3">
            <h2><a href="/"> All users</a></h2>
        </div>

    </nav>
    <div class="d-flex flex-wrap ">
        <div class="d-flex border border-secondary rounded">
            <ul>
                <li>id: {{$user->id}}</li>
                <li>name: {{$user->name}}</li>
                <li>phone: {{$user->phone}}</li>
                <li>position: {{$user->position->name}}</li>
                <li>position_id: {{$user->position->id}}</li>
                <li>registration_timestamp: {{$user->created_at}}</li>
                <li>photo url: {{$user->photo}}</li>
                <img width="200" height="200" src="{{asset('storage/' . $user->photo)}}" style="border-radius: 10%;">
                <li style="width: 300px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                    remember_token: {{$user->remember_token}}
                </li>

            <div class="d-flex gap-2 p-1">
                <a class="btn btn-sm btn-secondary" href="{{ route('user.edit', $user->id) }}">Edit</a>
                <form action="{{route('user.delete', $user->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <input type="submit" class="btn btn-secondary" value="Delete">
                </form>
            </div>
            </ul>
        </div>

    </div>
=======
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

>>>>>>> 32571635c3cf78df90e016052fa98bb7d2cef48a
</div>


</body>
</html>
