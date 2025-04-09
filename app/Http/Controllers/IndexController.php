<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\V1\TokenController;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Tinify\Source;
use Illuminate\Support\Str;
use function Tinify\setKey;

class IndexController extends Controller
{
    public function index(Request $request)
    {
               // $users = UserResource::collection(User::paginate(6));
        // Получаем параметры сортировки из запроса
        $sortField = $request->query('sort', 'id'); // По умолчанию сортируем по 'id'
        $sortDirection = $request->query('direction', 'desc'); // По умолчанию 'desc' (от новых к старым)
        $positions = Position::all();
        if($paramFilter = $request->query('_name')){
            $paramFilter = preg_replace("#([%_?+])#","\\$1",$paramFilter);
            $users = User::with('position')->where('name', 'LIKE', '%'.$paramFilter.'%')->orderBy($sortField, $sortDirection)->paginate(50);
        } else {
            // Запрос с сортировкой
//        $users = User::orderBy($sortField, $sortDirection)->paginate(6);
            $users = User::with('position')->orderBy($sortField, $sortDirection)->paginate(5);
        }
        return view('index', compact('users', 'positions', 'sortField', 'sortDirection'));
    }

    public function show(User $user)
    {
        $positions = Position::all();
        return view('user', compact('user', 'positions'));
    }


    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = Str::random(15) . '.jpg';

            $image = Image::make($photo->getPathname())
                ->fit(70, 70, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg', 90);

            $tempPath = storage_path('app/public/images/temp/' . $filename);
            $image->save($tempPath);

            setKey('1BC4cXMKstgLxcKJbWV6qnkfkzTzJ1VK');
            $source = Source::fromFile($tempPath);
            $optimizedPath = 'images/users/' . $filename;

            $finalStoragePath = storage_path('app/public/' . $optimizedPath);
            $source->toFile($finalStoragePath);
       //     $source->toFile(storage_path('app/public/' . $optimizedPath));
            unlink($tempPath);

            $publicStoragePath = public_path('storage/' . $optimizedPath);
            $publicDir = dirname($publicStoragePath);
            if (!file_exists($publicDir)) {
                mkdir($publicDir, 0755, true);
            }
            copy($finalStoragePath, $publicStoragePath);
            $data['photo'] =  $optimizedPath;
        //    $data['photo'] = $optimizedPath;
        }

        $user = User::create($data);

        $token = $user->createToken('registration_token', ['create-user'])->plainTextToken;
        $expiresAt = \Illuminate\Support\Carbon::now()->addMinutes(40);
        $user->tokens()->where('token', hash('sha256', explode('|', $token)[1]))->update([
            'expires_at' => $expiresAt,
        ]);

        $user->update(['remember_token' => $token]);

        return redirect()->route('index')->with('success', 'User created successfully');
    }

    public  function  edit(User $user)
    {
        $positions = Position::all();
        return view('edit', compact('user','positions'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = Str::random(15) . '.jpg';

            $image = Image::make($photo->getPathname())
                ->fit(70, 70, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg', 90);

            $tempPath = storage_path('app/public/images/temp/' . $filename);
            $image->save($tempPath);

            setKey('1BC4cXMKstgLxcKJbWV6qnkfkzTzJ1VK');
            $source = Source::fromFile($tempPath);
            $optimizedPath = 'images/users/' . $filename;

            $finalStoragePath = storage_path('app/public/' . $optimizedPath);
            $source->toFile($finalStoragePath);
            unlink($tempPath);

            $publicStoragePath = public_path('storage/' . $optimizedPath);
            $publicDir = dirname($publicStoragePath);
            if (!file_exists($publicDir)) {
                mkdir($publicDir, 0755, true);
            }
            copy($finalStoragePath, $publicStoragePath);
            $data['photo'] =  $optimizedPath;
        }

        $user->update($data);

        return view('user', compact('user'));
    }

    public function delete(User $user)
    {
        $user->delete();

        return redirect()->route('index');
    }
    
    public function rabbit()
    {
     //   return redirect()->route('rabbit');
        return view('rabbit');

    }


}
