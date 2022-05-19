<?php

namespace App\Http\Controllers\Information;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class InformationService
{
    private $informationQuery;
    public function __construct(InformationQuery $informationQuery)
    {
        $this->informationQuery = $informationQuery;
    }

    public function editAdminUser($data){

       $auth = Auth::user();
       if(!$auth || $auth['id'] !=$data['id']){
           return response()->json([
               'message' => "Your are not authorised User!.",
           ],401);
         }
         $user =  $this->informationQuery->checkUser($auth['id'], $data['email']);

         if($user){
            return response()->json([
                'message' => "Email must be unique!.",
            ],401);
         }

         return $this->informationQuery->editAdminUser('id',$data['id'], [
           "first_name"=> $data['first_name'],
           "last_name"=> $data['last_name'],
           "username"=> $data['username'],
           "email"=>$data['email']
         ]);

   }

    public function updatePassword($data)
    {
        if( $data['id'] != Auth::id()){
            return response()->json([
              'message' => "You are not Authenticate Admin!",
            ], 401);
         }

         $admin = $this->informationQuery->getSingleUser('id', $data['id']);
        //  \Log::info($admin);
        //  return $admin['password'] ;

         if($admin){

            $checkOld =Hash::check($data['currentPassword'], $admin->password );
            $checkNew =Hash::check($data['newPassword'], $admin->password );

            if(!$checkOld){
              return response()->json([
                'message' => "Password does not match to our records!",
              ], 401);
            }
            if($checkNew){
              return response()->json([
                'updated' => "Password is already been taken!",
              ], 401);
            }

         }else{

                return response()->json([
                  'message' => "Password does not exists !",
                ], 401);

         }

        return $this->informationQuery->editAdminUser('id',$data['id'], [
            "password"=>Hash::make($data['newPassword'])
          ]);

    }

    public function statistics(){
        return $this->informationQuery->statistics();
    }

    public function getAllInfos($data){
      return $this->informationQuery->getAllInfos($data);
    }

    public function deleteInfo($data){
      return $this->informationQuery->deleteInfo($data);
    }

    public function deleteSingleInfo($data){
      return $this->informationQuery->deleteSingleInfo($data);
    }

    public function userDetails($data, $id){
      return $this->informationQuery->userDetails($data, $id);
    }
    
    
}
