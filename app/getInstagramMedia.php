<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class getInstagramMedia extends Model
{
    /**
  * @params string $instagram_id OAuth認証後、取得されたInstagramID
  * @params string $access_token OAuth認証後、取得されたaccess_token
  */

public function getMediaList($instagram_id, $access_token) {

  # 1回目のloopを回すため20に
  $count = 20;
  $max_id = null;
  $data = array();
  $status = true;

  while ($count == 20) {
    $media_api_url = 'https://api.instagram.com/v1/users/' . $instagram_id . '/media/recent?access_token=' . $access_token. '&count=20';

    # max_idがセットされていたら、パラメータに付与
    # ここでページングのような感じになる
    if (!is_null($max_id)) {
      $media_api_url .= '&max_id=' . $max_id;
    }

    $context = stream_context_create(array('http' => array('ignore_errors' => true)));
    $json = file_get_contents($media_api_url, false, $context);

    $status_code = $this->getStatusCode($http_response_header[0]);
    if ($status_code == 200) {
      # decodeした配列をpush
      $media_list = json_decode($json);
      array_push($data, $media_list->data);

      # 20投稿取れたらまだ次ページがあるのでループを続ける
      $count = count($media_list->data);
      if ($count == 20) {
        $max_id = $media_list->data[$count - 1]->id;
      }
    } else {
      # 1度でもstatus_codeが200以外だったら、何もしないのでfalseで返す
      $status = false;
      break;
    }
  }

  if ($status) {
    return $data;
  }

  return false;
}



/**
  * file_get_contets後、status_codeを取得する
  */
public function getStatusCode($http_response_header) {

  preg_match('/HTTP\/1\.[0|1|x] ([0-9]{3})/', $http_response_header, $matches);
  $status_code = $matches[1];

  return $status_code;
}
}
