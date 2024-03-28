<?php

namespace App\Http\Controllers;

use App\Models\UserRequest;
use Common\Core\BaseController;
use Illuminate\Http\Request;
use Common\Database\Datasource\Datasource;

class UserRequestController extends BaseController
{

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_id' => ['required', 'integer', 'exists:titles,id'],
            'description' => ['nullable', 'string', 'max:255'],
            'season_no' => ['nullable', 'integer',],
            'episode_no' => ['nullable', 'integer']
        ]);

        return response()->json(UserRequest::create(array_merge(
            $data,
            [
                'user_id' => $request->user()->id
            ]
        )));
    }

    public function index()
    {
        $data = request()->all();

        $pagination = (new Datasource(
            UserRequest::query()->with('title'),
            $data
        ))->paginate();

        return $this->success(['pagination' => $pagination]);
    }


    public function destroy(UserRequest $userRequest)
    {
        $userRequest->delete();

        return response()->json([]);
    }
}
