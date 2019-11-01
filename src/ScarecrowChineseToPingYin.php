<?php
namespace ScarecrowChineseToPY;

class ScarecrowChineseToPingYin{
    protected $engine = '';

    public function __construct()
    {
        $this->engine = new ScarecrowGetData();
    }

    public function getPingYin($utf8Data, $format='utf8') {
        if($format=='utf8'){
            $sGBK = iconv('UTF-8', 'GBK', $utf8Data);
        }else{
            $sGBK = $utf8Data;
        }

        $aBuf = [];
        $relData = [
            'pyStr'     =>  '',
            'hpyStr'    =>  '',
            'hStr'      =>  '',
            'hexStr'    =>  ''
        ];
        for ($i=0, $iLoop=strlen($sGBK); $i<$iLoop; $i++) {
            $iChr = ord($sGBK{$i});

            if ($iChr>=172 && $iChr < 248 && ord($sGBK{$i+1}) > 160 && ord($sGBK{$i+1} < 256) ) {
                $iChr = ($iChr<<8) + ord($sGBK{++$i});
                $hexStr = dechex($iChr);

                $data = $this->engine->getHexContent($hexStr);
                $relData['hStr']    .= $data['head'];
                $relData['pyStr']   .= $data['py'];
                $relData['hpyStr']  .= $data['hpy'];
                $relData['hexStr']  .= $data['hex'];
            } else {
                $data = [
                    'hex'   =>  $sGBK{$i},
                    'py'    =>  ' ',
                    'head'  =>  ' ',
                    'hpy'   =>  ' '
                ];
                $relData['hStr']    .= $sGBK{$i};
                $relData['pyStr']   .= $sGBK{$i};
                $relData['hpyStr']  .= $sGBK{$i};
                $relData['hexStr']  .= $sGBK{$i};

            }
            $aBuf[] = $data;
        }
        $relData['dataList'] = $aBuf;
        return $relData;
    }
}