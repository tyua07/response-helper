<?php

namespace Yangyifan\Response;

use Yangyifan\Library\UtilityLibrary;

class ResponseHelper
{
    /**
     * code
     *
     * @var int|string
     */
    protected $code;

    /**
     * 响应提示信息
     *
     * @var int|string
     */
    protected $message;

    /**
     * 响应的数据
     *
     * @var \stdClass
     */
    protected $data;

    /**
     * 需要增加的积分字段
     *
     * @var int
     */
    protected $score;

    /**
     * 设置的 Header
     *
     * @var array
     */
    protected $headers;

    /**
     * 响应
     *
     * @var \Illuminate\Contracts\Routing\ResponseFactory|null|\Symfony\Component\HttpFoundation\Response
     */
    protected $response;

    /**
     * 构造函数
     *
     * ResponseLibraryHelper constructor.
     * @param string    $code     状态码
     * @param int       $message  提示文字
     * @param string    $data     数据
     * @param int       $score    需要增加积分
     * @prams array     $headers  需要设置的Header数组
     * @prams \Illuminate\Http\Response     $response  response 实例
     * @return \Illuminate\Http\Response
     */
    public function __construct($code = CodeHelp::SUCCESS, $message = '',  $data = [], $score = 0, $headers = [], $response = null)
    {
        $this->code     = $code;
        $this->message  = $message;
        $this->data     = UtilityLibrary::isArray($data) ? $data : new \stdClass();// 防止空数组让客户端解析失败
        $this->score    = $score;
        $this->headers  = $headers;
        $this->response = $response ? $response : response();

        // 设置 header
        $this->setHeader();

        return $this->response;
    }

    /**
     * 防止空数组让客户端解析失败
     *
     * @param $data
     * @return \stdClass
     */
    protected function parseData($data)
    {
        if ( UtilityLibrary::isArray($data)) {
            foreach ( $data as $key => &$value ) {
                if (is_array($value)) {
                    $value = $this->parseData($value);
                }
            }

            return $data;
        }

        return new \stdClass();
    }

    /**
     * 批量设置Http Header信息
     *
     * @return $this
     */
    private function setHeader()
    {
        if ( count($this->headers) > 0 ) {
            foreach ( $this->headers as $key => $value) {
                $this->response->header($key, $value);
            }
        }
        return $this;
    }

    /**
     * 构造 xml 响应
     */
    private function macroXml()
    {
        $headers = $this->headers;

        \Response::macro('xml', function(array $vars, $status = 200, $xml = null) use ($headers)
        {
            if (is_null($xml)) {
                $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><response/>');
            }
            foreach ($vars as $key => $value) {
                if (is_array($value)) {
                    \Response::xml($value, $status, $xml->addChild($key));
                } else {
                    $xml->addChild($key, $value);
                }
            }
            if (empty($headers)) {
                $headers['Content-Type'] = 'application/xml';
            }
            return \Response::make($xml->asXML(), $status, $headers);
        });
    }

    /**
     * 获得 Response 内容
     *
     * @return array
     */
    public function getResponseContents()
    {
        return [
            'code'      => $this->code,
            'message'   => $this->message ,
            'data'      => $this->data ,
            'score'     => $this->score,
        ];
    }

    /**
     * 成功响应
     *
     * @param string $message 提示文字
     * @param array $data 响应的数据
     * @return \Illuminate\Http\Response
     */
    public static function successResponse($message = '', array $data = [])
    {
        return (new self(CodeHelp::SUCCESS, $message, $data))->json();
    }

    /**
     * 增加爪币成功响应
     *
     * @param string $message 提示文字
     * @param array $data 响应的数据
     * @return \Illuminate\Http\Response
     */
    public static function scoreSuccessResponse($message = '', array $data = [])
    {
        return (new self(CodeHelp::ADD_GOLD_SUCCESS, $message, $data))->json();
    }

    /**
     * 失败响应
     *
     * @param string $message 提示文字
     * @param string $code 错误状态码
     * @param array $data 响应的数据
     * @return \Illuminate\Http\Response
     */
    public static function errorResponse($message = '', $code = CodeHelp::NORMAL_ERROR, array $data = [])
    {
        return (new self($code, $message, $data))->json();
    }

    /**
     * __call
     *
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        $name = strtolower($name);

        if ( !method_exists($this, $name)) {
            if ( in_array($name, ['xml', 'json']) ) {

                if ($name == 'xml') {
                    $this->macroXml();
                }

                return $this->response->$name($this->getResponseContents());
            } else if ( in_array($name, [ 'jsonp']) ) {
                return $this->response
                    ->json($this->getResponseContents())
                    ->setCallback($_REQUEST['callback']);
            }

        }
    }


}