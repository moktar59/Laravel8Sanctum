<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
    public function list(Request $request)
    {
        $query = DB::table('users')
                    ->leftJoin('addresses', 'users.id', '=', 'addresses.user_id')
                    ->select('users.id', 'users.email', 'users.name', 'users.user_type')
                    ->addSelect('addresses.*');

        if ($request->name) {
            $query = $query->where('users.name', 'like', "%{$request->name}%");
        }

        if ($request->division_id) {
            $query = $query->where('addresses.division_id', $request->division_id);
        }

        if ($request->district_id) {
            $query = $query->where('addresses.district_id', $request->district_id);
        }

        if ($request->upazilla_id) {
            $query = $query->where('addresses.upazilla_id', $request->upazilla_id);
        }

        $records = $query->paginate('5');

        return response()->json([
            'status_code' => 200,
            'data' => $records
        ]);

    }
}
