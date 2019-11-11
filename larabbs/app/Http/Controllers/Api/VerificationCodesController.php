<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\VerificationCodeRequest;

class verificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request)
    {
    	return $this->response()->array(['aa' => 'A','bb' => 'B','cc' => 'C']);
    }
}
