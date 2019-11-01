<?php
namespace ScarecrowChineseToPY;
/**
 * Created by PhpStorm.
 * User: 13666
 * Date: 2019/10/31
 * Time: 20:09
 */

class ScarecrowGetData{
    //字典路径
    protected $dataPath = "";

    public function __construct()
    {
        $this->dataPath = __DIR__ . '/data/dict.dat';
    }

    /**
     * 根据16进制获取对应的拼音
     * @param $hexStr
     * @return array
     */
    public function getHexContent($hexStr) {
        $position = $this->getHexStrPosition($hexStr);
        $data = $this->getPositionData($position);
        return $this->contentToDataArr($data);
    }

    /**
     * 处理数据
     * @param $str
     * @return array
     */
    protected function contentToDataArr($str) {
        $str = trim(trim($str, ','), "{}");
        $strList = explode(',', $str);
        $data = [
            'hex'   =>  trim($strList[0] ?? '','"'),
            'py'    =>  trim($strList[1] ?? '', '" '),
        ];
        $data['head'] = mb_strtoupper(substr($data['py'],0,1));
        $data['hpy'] = $data['head'] . substr($data['py'],1);
        return $data;
    }

    /**
     * 数据定位
     * @param $hexStr
     * @return mixed
     */
    protected function getHexStrPosition($hexStr) {
        $hexStr = mb_strtolower(trim($hexStr));
        $arrCode = preg_split('/(?<!^)(?!$)/u', $hexStr);
        $oneHuanSuan = 1536;
        $twoHuanSuan = 96;
        $treeHuanSuan = 16;
        $fourHuanSuan = 19;

        $codeList = [
            '0'   =>  0,
            '1'   =>  1,
            '2'   =>  2,
            '3'   =>  3,
            '4'   =>  4,
            '5'   =>  5,
            '6'   =>  6,
            '7'   =>  7,
            '8'   =>  8,
            '9'   =>  9,
            'a'   =>  10,
            'b'   =>  11,
            'c'   =>  12,
            'd'   =>  13,
            'e'   =>  14,
            'f'   =>  15,
        ];

        $positon = (($codeList[$arrCode[0]] - 11) * $oneHuanSuan + $codeList[$arrCode[1]] * $twoHuanSuan + ($codeList[$arrCode[2]] - 10) * $treeHuanSuan + $codeList[$arrCode[3]]) * $fourHuanSuan;
        return $positon * 3;
    }

    /**
     * 数据获取
     * @param $position
     * @return string
     */
    protected function getPositionData($position) {
        $f = fopen($this->dataPath, 'rb');
        fseek($f, $position);
        $str = fread($f, 57);
        return $this->decodeData($str);
    }

    /**
     * 数据解码
     * @param $str
     * @return string
     */
    protected function decodeData($str) {
        $arr = explode(' ', $str);
        foreach($arr as &$v){
            $v = pack("H*", $v);
        }
        return join('', $arr);
    }
}