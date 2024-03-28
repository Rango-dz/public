<?php

namespace App\Http\Controllers;

use App\Models\WhiteListedDomain;
use Common\Core\BaseController;
use Illuminate\Http\Request;
use Common\Database\Datasource\Datasource;

class WhiteListedDomainController extends BaseController
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:100']
        ]);

        return response()->json(['data' => WhiteListedDomain::create($data)]);
    }

    public function index()
    {
        $pagination = (new Datasource(
            new WhiteListedDomain(),
            request()->all()
        ))->paginate();

        return $this->success(['pagination' => $pagination]);
    }

    public function destroy(WhiteListedDomain $whiteListedDomain)
    {
        $whiteListedDomain->delete();

        return response()->json(['data' => []]);
    }
}
