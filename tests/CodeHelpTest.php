<?php

// +----------------------------------------------------------------------
// | date: 2016-11-12
// +----------------------------------------------------------------------
// | CodeHelpTest.php: 测试code
// +----------------------------------------------------------------------
// | Author: yangyifan <yangyifanphp@gmail.com>
// +----------------------------------------------------------------------

use PHPUnit\Framework\TestCase;

use Yangyifan\Response\CodeHelp;

class CodeHelpTest extends TestCase
{
    public function testCodeMsg()
    {
        $this->assertEquals(CodeHelp::getErrorMsg(CodeHelp::NORMAL_ERROR), "接口错误");
    }
}