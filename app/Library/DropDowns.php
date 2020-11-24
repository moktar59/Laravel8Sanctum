<?php
namespace App\Library;

use DB;

class DropDowns
{
  public static function divisionList()
  {
    return DB::table('divisions')->select('id', 'name')->get();
  }

  public static function districtList($divisionId = null)
  {
    $query = DB::table('districts')->select('id', 'name', 'division_id');
    
    if ($divisionId) {
      $query = $query->where('division_id', $divisionId);
    }

    return $query->get();
  }

  public static function upazilaList($districtId = null)
  {
    $query = DB::table('thanas')->select('thana_id as id', 'thana_name as name', 'district_id');
    
    if ($districtId) {
      $query = $query->where('district_id', $districtId);
    }

    return $query->get();
  }

  public static function userList()
  {
    return DB::table('users')->pluck('name', 'id')->all();
  }
}