<?php

// +----------------------------------------------------------------------
// | date: 2016-11-12
// +----------------------------------------------------------------------
// | ResponseHelpTest.php: 测试响应
// +----------------------------------------------------------------------
// | Author: yangyifan <yangyifanphp@gmail.com>
// +----------------------------------------------------------------------

use PHPUnit\Framework\TestCase;

use Yangyifan\Response\CodeHelp;
use Yangyifan\Response\ResponseHelper;
use Illuminate\Http\Response;

class ResponseHelpTest extends TestCase
{
    private $code;
    private $msg;
    private $data;
    private $target;
    private $href;

    //设置数据
    public function setUp()
    {
        $this->code     = CodeHelp::SUCCESS;
        $this->msg      = '';
        $this->data     = [];
        $this->target   = false;
        $this->href     = '';
    }

    //测试响应json
    public function testResponseForJson()
    {
        $this->assertJsonStringEqualsJsonString(json_encode([
            'code'      => $this->code,
            'msg'       => $this->msg,
            'data'      => $this->data,
            'target'    => $this->target,
            'href'      => $this->href,
        ]), json_encode((new ResponseHelper($this->code, $this->msg, $this->data, $this->target, $this->href, [], [], new Response()))->getResponseContents()));
    }
}