<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Address;
use DB;

class UserController extends Controller
{
    public function list(Request $request)
    {
        $query = DB::table('users')
                    ->leftJoin('addresses', 'users.id', '=', 'addresses.user_id')
                    ->leftJoin('divisions', 'addresses.division_id', '=', 'divisions.id')
                    ->leftJoin('districts', 'addresses.district_id', '=', 'districts.id')
                    ->leftJoin('thanas', 'addresses.upazila_id', '=', 'thanas.thana_id')
                    ->select('users.id', 'users.email', 'users.name', 'users.user_type')
                    ->addSelect('divisions.name as division_name', 'districts.name as district_name', 'thanas.thana_name as upazila_name');

        if ($request->search_text) {
            $query = $query->where('users.name', 'like', "%{$request->search_text}%");
        }

        if ($request->division_id) {
            $query = $query->where('addresses.division_id', $request->division_id);
        }

        if ($request->district_id) {
            $query = $query->where('addresses.district_id', $request->district_id);
        }

        if ($request->upazilla_id) {
            $query = $query->where('addresses.upazila_id', $request->upazila_id);
        }

        $records = $query->paginate('5');

        return response()->json([
            'status_code' => 200,
            'data' => $records
        ]);

    }

    public function saveUserAddress(Request $request)
    {
        $userAddress = new Address();

        $userAddress->user_id = $request->user_id;
        $userAddress->division_id = $request->division_id;
        $userAddress->district_id = $request->district_id;
        $userAddress->upazila_id = $request->upazila_id;
        $userAddress->address = $request->address;

        $userAddress->save();

        return response()->json([
            'status_code' => 200,
            'message' => 'Successfully saved'
        ]);
    }

    public function testCache()
    {
        Cache::put('testKey', 'Testing Redis Cache');

        if (Cache::has('testKey')) {
            return Cache::get('testKey');
        } else {
            return "Failed to retrieve cache";
        }
    }

    public function userListDropDown()
    {
        $list = DB::table('users')->pluck('name', 'id');
    }
}
