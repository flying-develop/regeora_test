<?php

namespace App\Http\Controllers;

use App\Http\Helpers\PatientHelper;
use App\Http\Requests\PatientAddFormRequest;
use Illuminate\Http\JsonResponse;

class PatientController extends Controller
{

    public function add(PatientAddFormRequest $request): JsonResponse
    {
        $patient = PatientHelper::add($request->all());

        return response()->json([
            'status' => 'success',
            'patient' => $patient
        ]);
    }

    public function list(): JsonResponse
    {

        return response()->json(PatientHelper::patients());

    }

}
