<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;


class WechatController extends Controller
{
    /**
     * ����΢�ŵ�������Ϣ
     *
     * @return string
     */
    public function serve()
    {

        $officialAccount = \EasyWeChat::officialAccount();
        dd($officialAccount);
        Log::info("request arrived.");
        $app = app('wechat.official_account');
        $app->server->push(function($message){
            return "��ӭ��ע overtrue��";
        });

        return $app->server->serve();
    }
}
