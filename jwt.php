<?php

class TokenJwt{


  public static function Sign($payload, $key, $expire = null){
    //header
    $header = ['algo' => 'HS256','type' => 'JWT'];
    if($expire){
      $header['expire'] = time() + $expire;
    }
    $header_encoded = base64_encode(json_encode($header));
    
    //payload
    $payload_encoded = base64_encode(json_encode($payload));

    //signature
    $signature = hash_hmac('SHA256',$header_encoded.$payload_encoded,$key);
    $signature_encoded = base64_encode($signature);

    return $header_encoded.'.'.$payload_encoded.'.'.$signature_encoded;
  }

  public static function verify($token,$key){

    $token_split = explode('.',$token);
    $signature = base64_encode(hash_hmac('SHA256',$token_split[0] . $token_split[1],$key));
    if($signature != $token_split[2]){
      echo 'Invalid Token';
      return false;
    }
    $header = json_decode(base64_decode($token_split[0]),true);
    if(isset($header['expire'])){
      if($header['expire'] < time()){
        echo 'Token expired';
        return false;
      }
    }

    $payload = json_decode(base64_decode($token_split[1]),true);
    return $payload;
  }

}


