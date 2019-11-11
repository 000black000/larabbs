<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;//引入图片验证码
use App\Http\Requests\Api\CaptchaRequest;//引入表单验证

class CaptchasController extends Controller
{
    public function index(CaptchaBuilder $captchaBuilder)
    {
		$key = 'captcha-' . str_random(15);
		$captcha = $captchaBuilder->build();
		$expiredAt = now()->addMinutes(5);
		\Cache::put($key, ['code' => $captcha->getPhrase()], $expiredAt);

		return $this->response->array([
			'captcha_key' => $key,
			'expired_at' => $expiredAt->toDateTimeString(),
			'captcha_image_content' => $captcha->inline()
		])->setStatusCode(201);

    }
}
