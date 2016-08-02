<?php


class Url
{
    public $key_page = 'page';
    public $key_modules = array('panel');
    public $module = 'front';
    public $main = 'index';
    public $cpage = 'index';
    public $c = 'login';
    public $a = 'index';
    public $params = array();
    public $paramsRaw = array();
    public $stringRaw;


    public function __construct()
    {
        $this->process();
    }















    public function process()
    {
        $uri = $_SERVER['REQUEST_URI'];
        if (!empty($uri)) {
            //categories/id/1?key=value
            $uriQ = explode('?', $uri);
            $uri = $uriQ[0];
            if (count($uriQ) > 1) {
                $this->stringRaw = $uriQ[1];
                $uriRaw = explode('&', $uriQ[1]);
                if (count($uriRaw) > 1) {
                    foreach ($uriRaw as $key => $row) {
                        $this->splitRaw($row);
                    }
                } else {
                    $this->splitRaw($uriRaw[0]);
                }
            }
        }
        $uri = Helper::clearString($uri, PAGE_EXT);
        $firstChar = substr($uri, 0, 1);
        if ($firstChar == '/') {
            $uri = substr($uri, 1);
        }
        $lastChar = substr($uri, -1);
        if ($lastChar == '/') {
            $uri = substr($uri, 0, -1);
        }
        if (!empty($uri)) {
            $uri = explode('/', $uri);
            $first = array_shift($uri);
            if (in_array($first, $this->key_modules)) {
                $this->module = $first;
                $first = array_shift($uri);
            }
            $this->main = $first;
            $this->cpage = $this->main;
            if (count($uri) > 1) {
                $pairs = array();
                foreach ($uri as $key => $value) {
                    //panel/c/something/a/something
                    $pairs[] = $value;
                    if (count($pairs) > 1) {
                        if (!Helper::isEmpty($pairs[1])) {
                            //page/index
                            if ($pairs[0] == $this->key_page) {
                                $this->cpage = $pairs[1];
                            } else if ($pairs[0] == 'c') {
                                $this->c = $pairs[1];
                            } else if ($pairs[0] == 'a') {
                                $this->a = $pairs[1];
                            }
                            $this->params[$pairs[0]] = $pairs[1];
                        }
                        $pairs = array();
                    }

                }
            }

        }
    }














    public static function clearString($string = null, $array = null)
    {
        if (!empty($string) && !self::isEmpty($array)) {
            $array = self::makeArray($array);
            foreach ($array as $key => $value) {
                $string = str_replace($value, '', $string);
            }
            return $string;
        }
    }















    public static function isEmpty($value = null)
    {
        return empty($value) && !is_numeric($value) ? true : false;
    }















    // ?page=param&id=3&mod=
    public function  splitRaw($item = null)
    {
        if (!empty($item) && !is_array($item)) {
            $itemRaw = explode('=', $item);
            if (count($itemRaw) > 1 && !Helper::isEmpty($itemRaw[1])) {
                $this->paramsRaw[$itemRaw[0]] = $itemRaw[1];
            }
        }
    }















// array(
//       'page' => 'index',
//       'id'   =>  3
//)
//getRaw('page');

    public function  getRaw($param = null)
    {
        if (!empty($param) && array_key_exists($param, $this->paramsRas)) {
            return $this->paramsRaw[$param];
        }

    }
















    /**
     * @param null $param
     * @return mixed
     * @description
     *
     * /page/id/26
     * $this->objUrl->get('id') = 26;
     */
    public function get($param = null)
    {
        if (!empty($param) && array_key_exists($param, $this->params)) {
            return $this->params[$param];
        }

    }
















    public function href($main = null, $params = null)
    {
        if (!empty($main)) {
            $out = array($main);
            if (!empty($params) && is_array($params)) {
                foreach ($params as $key => $value) {
                    $out[] = $value;
                }
            }
            return '/' . implode('/', $out) . PAGE_EXT;
        }

    }















    public function  getCurrent($exclude = null, $extension = null)
    {
        //page/id/23 getCurrent(array('id', 'pg'))
        $out = array();
        if ($this->module != 'front') {
            $out[] = $this->module;
        }
        $out[] = $this->main;
        if (!empty($this->params)) {
            if (!empty($exclude)) {
                $exclude = Helper::makeArray($exclude);
                foreach ($this->params as $key => $value) {
                    if (!in_array($key, $exclude)) {
                        $out[] = $key;
                        $out[] = $value;
                    }
                }
            } else {
                foreach ($this->params as $key => $value) {
                    $out[] = $key;
                    $out[] = $value;
                }
            }
        }
        $url = '/'.implode('/', $out);
        $url .= $extension ? PAGE_EXT : null;
        return $url;
    }
}