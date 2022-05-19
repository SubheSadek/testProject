<?php

namespace App\Http\Controllers\Information;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;

class InformationController extends Controller
{

    private $informationService;
    public function __construct(InformationService $informationService)
    {
        $this->informationService = $informationService;
    }
    public function editAdminUser(Request $request){
        $data = $request->all();
        return $this->informationService->editAdminUser($data);
   }
   public function statistics(Request $request){
        return $this->informationService->statistics();
    }


   public function editAdminPassword(Request $request){
        $data = $request->all();
        return $this->informationService->updatePassword($data);
    }

    public function getAllInfos(Request $request){
        return $this->informationService->getAllInfos($request->all());
    }

    public function deleteInfo(Request $request){
        $request->validate([
            'user_id' => 'required',
        ]);
        return $this->informationService->deleteInfo($request->all());
    }
    public function deleteSingleInfo(Request $request){
        $request->validate([
            'id' => 'required',
        ]);
        return $this->informationService->deleteSingleInfo($request->all());
    }

    public function userDetails(Request $request, $id){
        return $this->informationService->userDetails($request->all(), $id);
    }

    

}
