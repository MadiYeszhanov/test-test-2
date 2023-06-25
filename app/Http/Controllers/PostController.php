<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\BlockRequest;
use App\Http\Requests\Post\PostRequest;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        return response()->json([
            'posts' => Post::with('user')
                ->where('blocked_at', null)
                ->orderByDesc('id')->get()
        ]);
    }

    public function show(Post $post){
        return response()->json([
            'post' => $post
        ]);
    }

    public function create(PostRequest $postRequest){
        $data = $postRequest->validated();
        $user = $postRequest->user();

        $data['published_at'] = Carbon::now();
        $data['user_id'] = $user->id;

        $post = Post::create($data);

        return response()->json([
            'message' => 'Пост создан',
            'post' => $post
        ]);
    }

    public function update(PostRequest $postRequest, Post $post){
        $data = $postRequest->validated();
        $post->update($data);

        return response()->json([
            'message' => 'Пост обновлен',
            'post' => $post
        ]);
    }

    public function destroy(Post $post){
        $post->delete();

        return response()->json([
            'message' => 'Пост удален'
        ]);
    }

    public function block(BlockRequest $blockRequest, Post $post){
        if ($post->blocked_at == null){
            $data = $blockRequest->validated();
            $data['blocked_at'] = Carbon::now();
            $data['status'] = 'blocked';

            $post->update($data);

            return response()->json([
                'message' => 'Пост заблокирован',
                'post' => $post
            ]);
        }
        else {
            return response()->json([
                'message' => 'Пост уже заблокирован',
            ], 400);
        }
    }

    public function my(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'posts' => Post::where('user_id', $user->id)
                ->orderByDesc('id')->get()
                ->makeVisible(['blocked_at', 'blocked_comment'])
        ]);
    }

    public function recent(Request $request)
    {
        return response()->json([
            'users' => User::with('posts')
                ->whereHas('posts')
                ->withCount('posts')
                ->orderByDesc('posts_count')
                ->get()->map(function ($item) {
                    $item->setRelation('posts', $item->posts->take(3));
                    return $item;
                })
        ]);
    }
}
