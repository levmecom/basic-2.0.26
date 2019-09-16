<?php
/**
 * @link http://levme.com/
 * @copyright Copyright (c) 2008 levme.com Software LLC
 * @license http://levme.com/license/
 */
namespace levmecom\aalevme;

use Yii;
use yii\helpers\StringHelper;

class baseLevHelpers {

    public static function stget($key, $identifier = '') {
        $identifier = $identifier ?: Yii::$app->controller->module->getUniqueId();
        $settings = json_decode(Yii::$app->cache->get('__settings__'), true);
        if ($key === null) {
            return !isset($settings[$identifier]) ? false : $settings[$identifier];
        }else {
            return !isset($settings[$identifier][$key]) ? false : $settings[$identifier][$key];
        }
    }

    public static function arrv($key, $arr = [], $default = null) {
        return isset($arr[$key]) ? $arr[$key] : ($default !== null ? $default : $key);
    }

    /**
     * 例：$moduleUniqueId = '123/1234/12345';
     * return [
     *  '123/1234/12345',
     *  '123/1234',
     *  '123',
     * ]
     *
     * @param string $moduleUniqueId 直接传入数组不能$reset并缺少第一项
     * @param string $pre
     * @param bool $reset
     * @return array
     */
    public static function moduleUniqueIdArray($moduleUniqueId, $pre = '/', $reset = true) {
        static $res;
        if ($reset) {
            $res = [];
        }
        if (!is_array($moduleUniqueId)) {
            return self::moduleUniqueIdArray(StringHelper::explode($moduleUniqueId, $pre, true, true), $pre, $reset);
        }
        $res[] = implode($pre, $moduleUniqueId);
        array_pop($moduleUniqueId);
        if ($moduleUniqueId) {
            return self::moduleUniqueIdArray($moduleUniqueId, $pre, false);
        }else {
            return $res;
        }
    }

    /**
     * 根据页面地址设置分页数量
     * @param int $default
     * @return int
     */
    public static function pageSize($default = 20) {

        $uniqueId = 'setPageSize_'.str_ireplace('/', '_', Yii::$app->requestedAction->uniqueId);
        if (Yii::$app->request->get('setPageSize')) {
            Yii::$app->cache->set($uniqueId, intval(Yii::$app->request->get('setPageSize')) ?: $default);
            $queryParams = Yii::$app->request->getQueryParams();
            unset($queryParams['setPageSize']);
            Yii::$app->request->setQueryParams($queryParams);
        }
        $pageSize = Yii::$app->cache->get($uniqueId) ?: $default;
        return $pageSize;
    }

    // 过滤掉emoji表情
    public static function emojiDel($str)
    {
        $str = preg_replace_callback(
            '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);

        return $str;
    }

    /**
     * @param array $array eg: ['uid'=>1, 'touid'=>3, '$childkey'=>['uid'=>2, 'touid'=>3]]
     * @param string $key eg: 'uid,touid'
     * @param string $childKey
     * @param array $ed
     * @return string eg: '1','2','3'
     *
     */
    public static function inSqlArray($array, $key = '', $childKey = '', $ed = [], $stripTags = true, $floatval = false) {
        return self::inSql($array, $key, $childKey, $ed, $stripTags, $floatval, true);
    }
    public static function inSql($array, $key = '', $childKey = '', $ed = [], $stripTags = true, $floatval = false, $isarr = false) {
        $_arr = [];
        $keyarr = explode(',', $key);
        if ($childKey) {
            foreach ($array as $v) {
                foreach ($keyarr as $key) {
                    if (isset($v[$key]) && ($v[$key] || is_numeric($v[$key])) && !in_array($v[$key], $ed)) {
                        $ed[$key.''] = $v[$key];
                        $_arr[] = $v[$key];
                    }
                    if (isset($v[$childKey]))
                    foreach ($v[$childKey] as $r) {
                        if (isset($r[$key]) && ($v[$key] || is_numeric($v[$key])) && !in_array($r[$key], $ed)) {
                            $ed[$key.''] = $r[$key];
                            $_arr[] = $r[$key];
                        }
                    }
                }
            }
        }else if ($key) {
            foreach ($array as $v) {
                foreach ($keyarr as $key) {
                    if (isset($v[$key]) && ($v[$key] || is_numeric($v[$key])) && !in_array($v[$key], $ed)) {
                        $ed[$key.''] = $v[$key];
                        $_arr[] = $v[$key];
                    }
                }
            }
        }else {
            foreach ($array as $v) {
                $v = $stripTags ? static::stripTags($v) : $v;
                $v = $floatval ? floatval($v) : $v;
                if (($v || (!$floatval && is_numeric($v))) && !in_array($v, $ed)) {
                    $ed[] = $v;
                    $_arr[] = $v;
                }
            }
        }
        if ($isarr) return $_arr;
        return $_arr ? "'".implode("','", $_arr)."'" : '';
    }

    /**
     * @param $string
     * @param $length
     * @param string $dot
     * @return mixed|string
     */
    public static function cutString($string, $length, $dot = ' ...') {
        if(strlen($string) <= $length) {
            return $string;
        }

        $string = trim(strip_tags($string));

        $pre = chr(1);
        $end = chr(1);
        $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), $string);

        $strcut = '';
        if(strtolower(\Yii::$app->charset) == 'utf-8') {

            $n = $tn = $noc = 0;
            while($n < strlen($string)) {

                $t = ord($string[$n]);
                if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                    $tn = 1; $n++; $noc++;
                } elseif(194 <= $t && $t <= 223) {
                    $tn = 2; $n += 2; $noc += 2;
                } elseif(224 <= $t && $t <= 239) {
                    $tn = 3; $n += 3; $noc += 2;
                } elseif(240 <= $t && $t <= 247) {
                    $tn = 4; $n += 4; $noc += 2;
                } elseif(248 <= $t && $t <= 251) {
                    $tn = 5; $n += 5; $noc += 2;
                } elseif($t == 252 || $t == 253) {
                    $tn = 6; $n += 6; $noc += 2;
                } else {
                    $n++;
                }

                if($noc >= $length) {
                    break;
                }

            }
            if($noc > $length) {
                $n -= $tn;
            }

            $strcut = substr($string, 0, $n);

        } else {
            $_length = $length - 1;
            for($i = 0; $i < $length; $i++) {
                if(ord($string[$i]) <= 127) {
                    $strcut .= $string[$i];
                } else if($i < $_length) {
                    $strcut .= $string[$i].$string[++$i];
                }
            }
        }

        $strcut = str_replace(array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

        $pos = strrpos($strcut, chr(1));
        if($pos !== false) {
            $strcut = substr($strcut,0,$pos);
        }
        return $strcut.$dot;
    }

}