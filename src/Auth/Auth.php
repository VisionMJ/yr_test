<?php

namespace Yr1688\Auth;

class Auth
{
    protected $appKey = '';

    protected $appSecret = '';

    protected $access_token = '';

    protected $callback_url = '';

    protected $request_url = 'https://gw.open.1688.com/openapi/';

    protected $auth_url = 'https://auth.1688.com/oauth/authorize';

    /**
     * 授权并且记录授权的code
     * Auth constructor.
     * @param $config
     */
    public function __construct(array $config)
    {
        $this->setConfig($config);
    }

    /**
     * 设置配置属性
     * @param $config
     */
    function setConfig(array $config)
    {
        $this->appKey = $config['appKey'] ?? '';
        $this->appSecret = $config['appSecret'] ?? '';
        $this->callback_url = $config['callback_url'] ?? '';
        $this->access_token = $config['access_token'] ?? '';
        if ($this->access_token == '') {
//            $this->auth();
        }
    }

    /**
     * 授权
     */
    function auth()
    {
        $this->auth_url .= '?client_id=' . $this->appKey . '&site=1688&redirect_uri=' . urlencode($this->callback_url) . '&state=1';
        header($this->auth_url);
        exit;
    }


}
