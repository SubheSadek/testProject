<?php

namespace App\Http\Controllers\Information;

use App\Models\Information;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class InformationQuery
{
    public function  statistics()
    {
        $info = Information::distinct('user_id')->count();
        return $info;
    }

    public function checkUser($id,$email)
    {
        return User::where('id','!=',$id)->where('email',$email)->first();
    }

    public function editAdminUser($key, $value, $user){
        return User::where($key, $value)->update($user);
    }
    public function getSingleUser($key, $value){
        return User::where($key, $value)->first();
    }

    public function getAllInfos($data){
        $str = $data["str"] ?? null;
        $str = "%".$str."%";
        $perPage = $data["perPage"] ?? 10;
        \DB::statement("SET SQL_MODE=''");
        return Information::when($str, function($q) use($str){
            $q->where('user_id', 'like', $str);
        })->orderByDesc('id')->groupBy('user_id')->paginate($perPage);
    }

    public function deleteInfo($data){
        $user_id = $data["user_id"] ?? null;
        return Information::where('user_id',$user_id)->delete();
    }

    public function deleteSingleInfo($data){
        $id = $data["id"] ?? null;
        return Information::where('id',$id)->delete();
    }

    public function userDetails($data, $user_id){
        $str = $data["str"] ?? null;
        $str = "%".$str."%";
        $perPage = $data["perPage"] ?? 10;
        
        return Information::when($str, function($q) use($str){
            $q->where('event', 'like', $str);
            $q->orWhere('app_platform', 'like', $str);
            $q->orWhere('app_version_code', 'like', $str);
            $q->orWhere('device', 'like', $str);
        })->where('user_id', $user_id)->orderByDesc('created_at')->paginate($perPage);
    }
    
}
