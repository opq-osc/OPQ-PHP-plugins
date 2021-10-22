<?php
// 应用公共文件
/**
 * 返回成功JSON响应信息
 * @param string $msg 消息内容
 * @param array $data 数据内容
 * @param int $code 返回code
 */
function success($msg, $data = [],$code=1)
{
    $result = array(
        'msg' => $msg,
        'data' => $data,
        'code' => $code
    );
    return json($result);
}

/**
 * 返回失败JSON响应信息
 * @param string $msg 消息内容
 * @param array $data 数据内容
 * @param int $code 返回code
 */
function error($msg, $data = [],$code=0)
{
    $result = array(
        'msg' => $msg,
        'data' => $data,
        'code' => $code
    );
    //apilog('请求失败日志',json_encode($result,JSON_UNESCAPED_UNICODE));
    return json($result);
}