<?php

// +----------------------------------------------------------------------
// | date: 2016-11-12
// +----------------------------------------------------------------------
// | CodeHelp.php: 响应的code
// +----------------------------------------------------------------------
// | Author: yangyifan <yangyifanphp@gmail.com>
// +----------------------------------------------------------------------

namespace Yangyifan\Response;

class CodeHelp
{
    /**
     * 成功相关
     */
    const SUCCESS						    = 10000;    // 成功
    const SIGN_SUCCESS					    = 10001;    // 签到成功
    const ADD_GOLD_SUCCESS				    = 10002;    // 增加积分成功
    const THE_DAY_IS_THE_FIFST_TIME_LOGIN	= 10003;    // 当日第一次登陆

    /**
     * 失败相关
     */
	const NORMAL_ERROR					= 20000;    // 报错
    const TIME_OUT				        = 20001;    // 请求超时
	const UN_LOGIN						= 20002;    // 未登陆
	const FATAL_ERROR					= 20003;	// 致命错误
	const HTTP_REQUEST_METHOD_ERROR		= 20004;	// 请求 Method 错误
	const HTTP_REQUEST_PARAM_ERROR		= 20005;	// 请求参数错误
	const APP_IS_TOO_OLD		        = 20006;	// APP 提示更新
	const APP_NEED_TO_UPDATE		    = 20007;	// APP 需要强制更新
    const UN_AUTHORIZED					= 20008;    // 授权失败
    const TO_MANY_REQUESTS				= 20009;    // 请求次数超过限制
    const USER_NOT_EXISTS				= 20010;    // 用户不存在
    const FORBIDDEN 				    = 20011;    // 用户无权限访问该资源
    const PAY_ERROR 				    = 20012;    // 支付失败

    /**
     * 得到错误状态描述
     *
     * @return array
     */
	protected static function errMsg()
    {
		return [
			self::NORMAL_ERROR					=>	'接口错误！',
			self::TIME_OUT					    =>	'请求超时！',
			self::UN_LOGIN						=>	'未登陆！',
			self::SUCCESS						=>	'成功！',
			self::FATAL_ERROR					=>	'接口错误,请联系管理员！',
			self::HTTP_REQUEST_METHOD_ERROR		=>	'Api 请求方式错误！',
			self::HTTP_REQUEST_PARAM_ERROR		=>	'Api 请求参数错误！',
			self::APP_IS_TOO_OLD		        =>	'APP 提示更新！',
			self::APP_NEED_TO_UPDATE		    =>	'APP 需要强制更新！',
			self::UN_AUTHORIZED		            =>	'授权失败！',
			self::TO_MANY_REQUESTS		        =>	'请求次数超过限制！',
			self::USER_NOT_EXISTS		        =>	'用户不存在！',
			self::FORBIDDEN		                =>	'用户无权限访问该资源！',
			self::PAY_ERROR		                =>	'支付失败！',
		];
	}

    /**
     * 获得错误状态描述
     *
     * @param $code
     * @return mixed
     */
	public static function getErrorMsg($code)
    {
		$msgArray = self::errMsg();
		return $msgArray[$code];
	}
}