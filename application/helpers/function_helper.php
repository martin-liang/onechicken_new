<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/16
 * Time: 13:36
 */

/**
 * curlGet 方法
 * @param string $link
 * @return mixed
 */

function curlGet($link)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_TIMEOUT, 50);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);

    return $result;
}



function ajaxReturn($data,$type='') {
    if(func_num_args()>2) {// 兼容3.0之前用法
        $args           =   func_get_args();
        array_shift($args);
        $info           =   array();
        $info['data']   =   $data;
        $info['info']   =   array_shift($args);
        $info['status'] =   array_shift($args);
        $data           =   $info;
        $type           =   $args?array_shift($args):'';
    }
    if(empty($type)) $type  =  '';
    switch (strtoupper($type)){
        case 'JSON' :
            // 返回JSON数据格式到客户端 包含状态信息
            header('Content-Type:application/json; charset=utf-8');
            exit(json_encode($data));
        case 'XML'  :
            // 返回xml格式数据
            header('Content-Type:text/xml; charset=utf-8');
            exit(xml_encode($data));
        case 'JSONP':
            // 返回JSON数据格式到客户端 包含状态信息
            header('Content-Type:application/json; charset=utf-8');
            $handler  =   isset($_GET[C('VAR_JSONP_HANDLER')]) ? $_GET[C('VAR_JSONP_HANDLER')] : C('DEFAULT_JSONP_HANDLER');
            exit($handler.'('.json_encode($data).');');
        case 'EVAL' :
            // 返回可执行的js脚本
            header('Content-Type:text/html; charset=utf-8');
            exit($data);
        default     :
            // 用于扩展其他返回格式数据
            tag('ajax_return',$data);
    }
}

function C($name=null, $value=null) {
    static $_config = array();
    // 无参数时获取所有
//    if (empty($name)) {
//        if(!empty($value) && $array = S('c_'.$value)) {
//            $_config = array_merge($_config, array_change_key_case($array));
//        }
//        return $_config;
//    }
    // 优先执行设置获取或赋值
    if (is_string($name)) {
        if (!strpos($name, '.')) {
            $name = strtolower($name);
            if (is_null($value))
                return isset($_config[$name]) ? $_config[$name] : null;
            $_config[$name] = $value;
            return;
        }
        // 二维数组设置和获取支持
        $name = explode('.', $name);
        $name[0]   =  strtolower($name[0]);
        if (is_null($value))
            return isset($_config[$name[0]][$name[1]]) ? $_config[$name[0]][$name[1]] : null;
        $_config[$name[0]][$name[1]] = $value;
        return;
    }
    // 批量设置
//    if (is_array($name)){
//        $_config = array_merge($_config, array_change_key_case($name));
//        if(!empty($value)) {// 保存配置值
//            S('c_'.$value,$_config);
//        }
//        return;
//    }
    return null; // 避免非法参数
}

function tag($tag, &$params=NULL) {
    // 系统标签扩展
    $extends    = C('extends.' . $tag);
    // 应用标签扩展
    $tags       = C('tags.' . $tag);
    if (!empty($tags)) {
        if(empty($tags['_overlay']) && !empty($extends)) { // 合并扩展
            $tags = array_unique(array_merge($extends,$tags));
        }elseif(isset($tags['_overlay'])){ // 通过设置 '_overlay'=>1 覆盖系统标签
            unset($tags['_overlay']);
        }
    }elseif(!empty($extends)) {
        $tags = $extends;
    }
    if($tags) {
        if(APP_DEBUG) {
            G($tag.'Start');
            trace('[ '.$tag.' ] --START--','','INFO');
        }
        // 执行扩展
        foreach ($tags as $key=>$name) {
            if(!is_int($key)) { // 指定行为类的完整路径 用于模式扩展
                $name   = $key;
            }
            B($name, $params);
        }
        if(APP_DEBUG) { // 记录行为的执行日志
            trace('[ '.$tag.' ] --END-- [ RunTime:'.G($tag.'Start',$tag.'End',6).'s ]','','INFO');
        }
    }else{ // 未执行任何行为 返回false
        return false;
    }
}