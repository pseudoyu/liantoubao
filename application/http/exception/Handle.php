<?php
namespace app\http\exception;
/**
 * Exception.php
 * @author Lazy 2018-09-23
 */
use Exception;
use think\facade\Request;
use think\exception\ValidateException;
use app\http\exception\Error;

class Handle extends \think\exception\Handle
{

    public function render(Exception $exce) {
        if($exce instanceof ValidateException || $exce instanceof Error)
            return $this->validate($exce);

        return parent::render($exce);
    }
    /**
     * 返回错误代码与错误信息数据
     * @author Lazy 2018-09-23
     */
    protected function parse($exce) {
        return [$exce->getCode() ?: 500, $exce->getMessage()];
    }
    /**
     * 处理常规错误与异常的返回
     * @author Lazy 2018-09-23
     * @param Exception $exce
     */
    protected function validate($exce) {
        list($code, $msg) = $this->parse($exce);
        if (Request::isAjax()) {
            return wrong($msg, $code);
        } else {
            $msg .= (strpos($msg, 'hints') === false ? ', hints: ' : '') . '[ code: ' . $code . ' ]';
            return response($msg, 500);
        }
    }
}