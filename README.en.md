# ScarecrowChineseToPinYin

#### 介绍
PHP版本的中文转拼音

开发基础数据版本在百度云

##使用方式:
### namespace ScarecrowChineseToPY;
### include '../src/ScarecrowChineseToPingYin.php';
### include '../src/ScarecrowGetData.php';
### $a = new ScarecrowChineseToPingYin();
### var_dump($a->getPingYin('测试数据'));

##返回数据格式
### [
###     pyStr:拼音字符串,
###     hpyStr:每个单词首字母大写的拼音字符串,
###     hStr:首字母大写字符串，
###     hexStr:16进制字符串,
###     dataList:[  每一个字的详细信息
###         hex:16进制,
###         py:拼音,
###         head:首字母大写,
###         hpy:首字母大写的拼音
### ]