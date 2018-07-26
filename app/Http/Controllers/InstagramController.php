<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use MetzWeb\Instagram\Instagram;

class InstagramController extends Controller
{
    # 共通で使うので、constructに格納
    private $instagram;

    function __construct() {
        # configからAppの値を取得し、インスタンス化
        $this->instagram = new Instagram(array(
            'apiKey' => config('instagram.client_id'),
            'apiSecret' => config('instagram.client_secret'),
            'apiCallback' => config('instagram.callback_url')
        ));
    }

    /**
     * Instagramで登録、ログインを押された際の処理
     */
    public function instagramLogin() {
        return redirect($this->instagram->getLoginUrl(array(
            # アクセスする権限をここで指定可能
            # ただし、対応していない権限も存在しているので、その場合はURLを生で書くようにする
            'basic'
        )));
    }

    /**
     * Instagramで登録、ログインを押された後にリダイレクトされた際の処理
     * Instagramの情報を取得できる
     */
    public function instagramCallback(Request $request) {
        # URLにcodeが入っているので取得
        $code = $request->code;

        # 取得したcodeを利用し、OAhtu認証
        $data = $this->instagram->getOAuthToken($code);
        $this->instagram->setAccessToken($data);

        # OAuth認証が完了したので、$instagram->"method"で好きなAPIが叩けるようになっている
        # 今回はInstagramでログイン機能なので、getUser()を使用
        $user_data = $this->instagram->getUser();

        echo '<pre>';
        var_dump($user_data);
        echo '</pre>';
    }
}
