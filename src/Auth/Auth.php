<?php

namespace Yr1688\Auth;

class Auth
{
    private $appKey = '';

    private $appSecret = '';

    private $callback_url = '';

    private $request_url = 'https://gw.open.1688.com/openapi/';

    private $auth_url = 'https://auth.1688.com/oauth/authorize';

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
        $this->appKey = $config['appKey'];
        $this->appSecret = $config['appSecret'];
        $this->callback_url = $config['callback_url'];
    }

    function auth()
    {
        $this->auth_url .= '?client_id=' . $this->appKey . '&site=1688&redirect_uri=' . urlencode($this->callback_url) . '&state=1';
        header($this->auth_url);
        exit;
    }


}
