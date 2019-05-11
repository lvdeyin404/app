<?php
namespace app\common\lib;

use app\common\exception\ApiException;

/**
 * aes 加密 解密类库
 * @by singwa
 * Class Aes
 * @package app\common\lib
 */
class Aes {

    private $key = null;
    private $iv = null;

    /**
     *
     * @param $key 		密钥
     * @return String
     */
    public function __construct() {
        // 需要小伙伴在配置文件app.php中定义aeskey
        $this->key = config('salt.AES_PRIVATE_KEY');
        $this->iv = config('salt.iv');
    }

    /**
     * 加密
     * @param String input 加密的字符串
     * @param String key   解密的key
     * @return HexString
     */
    public function encrypt($input = '') {
        try{
            $data = openssl_encrypt($input, 'AES-256-CBC',$this->key, OPENSSL_RAW_DATA, $this->iv);
        }catch (\Exception $e){
            throw new ApiException($e->getMessage(), '500');
        }
        $data = base64_encode($data);
        return $data;

    }
//    /**
//     * 填充方式 pkcs5
//     * @param String text 		 原始字符串
//     * @param String blocksize   加密长度
//     * @return String
//     */
//    private function pkcs5_pad($text, $blocksize) {
//        $pad = $blocksize - (strlen($text) % $blocksize);
//        return $text . str_repeat(chr($pad), $pad);
//    }

    /**
     * 解密
     * @param String input 解密的字符串
     * @param String key   解密的key
     * @return String
     */
    public function decrypt($sStr) {
        $data = openssl_decrypt(base64_decode($sStr), 'AES-256-CBC', $this->key, OPENSSL_RAW_DATA, $this->iv);
        return $data;
    }

}