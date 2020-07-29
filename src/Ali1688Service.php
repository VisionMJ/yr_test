<?php

namespace Yr1688;

use GuzzleHttp\Client;
use Yr1688\Auth\Auth;

/**
 * Class
 */
class Ali1688Service extends Auth
{

    /**
     * Ali1688Service constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     * 返回http请求客户端
     * @return Client
     */
    static function getHttpClient()
    {
        return new Client();
    }


    /**
     * 公共请求处理
     * @param array $post_data
     * @param $api
     * @return \Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(array $post_data, $api)
    {
        $http_client = self::getHttpClient();
        $res_url = $this->sign($post_data, $api);
        try {
            $res = $http_client->post($res_url);
            if (isset($res['errorCode'])) {
                throw new \Exception($res['errorMessage'], $res['errorCode']);
            }
            return $res;

        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

    }

    /**
     * 请求前签名以及数据处理
     * @param $post_data
     * @param $api
     * @return string
     */
    function sign($post_data, $api)
    {

        $apiInfo = 'param2/1/com.alibaba.trade/' . $api . '/' . $this->appKey;

        $code_arr = array(
            'access_token' => 'f5f85ff1-89a5-4191-a328-2e47cba4c451',
            'webSite' => '1688',
        );
        $code_arr = array_merge($code_arr, $post_data);
        $aliParams = array();
        foreach ($code_arr as $key => $val) {
            $aliParams[] = $key . $val;
        }
        sort($aliParams);
        $sign_str = join('', $aliParams);
        $sign_str = $apiInfo . $sign_str;
        $code_sign = strtoupper(bin2hex(hash_hmac("sha1", $sign_str, $this->appSecret, true)));
        $sign = '';
        foreach ($post_data as $key => $val) {
            $sign .= "&$key=$val";
        }
        $res_url = $this->request_url . $apiInfo . '?access_token=' . $this->access_token . $sign . '_aop_signature=' . $code_sign;
        return $res_url;
    }

}
