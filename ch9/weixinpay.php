<?php
define('APPID', 'wxf8b4f85f3a794e77');
define('APPSECRET', '4333d426b8d01a3fe64d53f36892df');
define('PAYSIGNKEY', '2Wozy2aksie1puXUBpWD8oZxiD1DfQuEaiC7KcRATv1Ino3mdopKaPGQQ7TtkNySuAmCaDCrw4xhPY5qKTBl7Fzm0RgR3c0WaVYIXZARsxzHV2x7iwPPzOz94dnwPWSn');
define('PARTNERID', '1900000109');
define('PARTNERKEY', '8934e7d15453e97507ef794cf7b0519d');

define('APPID', '���ں�id');
define('APPSECRET', '���ں���ԿKey');
define('PAYSIGNKEY', '֧��ǩ��');
define('PARTNERID', '�Ƹ�ͨ�̻�id');
define('PARTNERKEY', '�Ƹ�ͨ�̻���ԿKey');
//echo getAppId();
//echo getTimeStamp();
//for($i=0;$i<100;$i++){
//$l = strlen(getNonceStr());
//if($l == 31){
//	echo "������\n";
//}else{
//	//echo "û�д�\n";
//}
//}
//echo getPackage("�޻���",5);
//echo getSign('abc', '123', '345');
/**
 * ��ȡ���ں�����
 */
function getAppId(){
    return APPID;
}

/**
 * ��ȡʱ���
 */
function getTimeStamp(){
    return strval(time());
}

/**
 * ��ȡ����ַ���
 */
function getNonceStr(){
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $len = strlen($chars);
    $noceStr = "";
    for ($i = 0; $i < 32; $i++) {
        $noceStr .= substr($chars, rand(0, $len-1), 1); // 
    }
    return $noceStr;
}
/**
 * ��ȡ�����
 * @return type
 */
function getANumber(){
    $timeStamp = time();
    return $timeStamp*(date('dHis',$timeStamp)+  rand());
}
/**
 * ��ȡ��չ��
 * @param type $goodsDesc ��Ʒ����
 * @param type $totalFee �ܷ���
 * @return type
 */
function getPackage($goodsDesc, $totalFee){
    $banktype = "WX";
    $fee_type = "1";//�������ͣ�����1ΪĬ�ϵ������
    $input_charset = "GBK";//�ַ��������ｫͳһʹ��GBK
    $notify_url = "http://www.qq.com";//֧���ɹ���֪ͨ�õ�ַ
    //$out_trade_no = getANumber();//�����ţ��̻���Ҫ��֤���ֶζ��ڱ��̻���Ψһ��
    $out_trade_no = 111;
    $partner = PARTNERID;//�����̻���
    $spbill_create_ip = $_SERVER['REMOTE_ADDR'];//�û��������ip�������Ҫ��ǰ�˻�ȡ��
    $partnerKey = PARTNERKEY;//���ֵ����������ֵ��һ���ǣ�ǩ����Ҫ�����������ɵĴ����ַ������ܺ����������key����Ҫ�̻��úñ���ġ�

    //���ȵ�һ������ԭ������ǩ����ע�����ﲻҪ���κ��ֶν��б��롣�����ǽ���������key=value�����ֵ���������������ַ���,������ַ������ƴ����key=XXXX������������ֶι̶������ֻ��Ҫ�������˳��������򼴿ɡ�
    $signString = "bank_type=".$banktype."&body=".$goodsDesc."&fee_type=".$fee_type."&input_charset=".$input_charset."&notify_url=".$notify_url."&out_trade_no=".$out_trade_no."&partner=".$partner."&spbill_create_ip=".$spbill_create_ip."&total_fee=".$totalFee."&key=".$partnerKey;

    $md5SignValue = strtoupper(md5($signString));
    //Ȼ��ڶ�������ÿ����������url���롣
    $banktype = urlencode($banktype);
    $goodsDesc=urlencode($goodsDesc);
    $fee_type=urlencode($fee_type);
    $input_charset = urlencode($input_charset);
    $notify_url = urlencode($notify_url);
    $out_trade_no = urlencode($out_trade_no);
    $partner = urlencode($partner);
    $spbill_create_ip = urlencode($spbill_create_ip);
    $totalFee = urlencode($totalFee);


    //Ȼ��������һ�������ﰴ��key��value����sign������ֵ��������������е��ַ���,����ٴ���sign=value
    $completeString = "bank_type=".$banktype."&body=".$goodsDesc."&fee_type=".$fee_type."&input_charset=".$input_charset."&notify_url=".$notify_url."&out_trade_no=".$out_trade_no."&partner=".$partner."&spbill_create_ip=".$spbill_create_ip."&total_fee=".$totalFee;
    $completeString = $completeString . "&sign=".$md5SignValue;

    return $completeString;

}

/**
 * ��ȡ΢��ǩ����ʽ sha1
 */
function getSignType(){
    return "SHA1";
}

/**
 * ��ȡ΢��ǩ��
 * @param type $oldNonceStr ����ַ���
 * @param type $oldPackageString ��չ��
 * @param type $oldTimeStamp ʱ���
 * @return type
 */
function getSign($oldNonceStr, $oldPackageString, $oldTimeStamp){
    $keyvaluestring = "appid=".APPID."&appkey=".PAYSIGNKEY."&noncestr=".$oldNonceStr."&package=".$oldPackageString."&timestamp=".$oldTimeStamp;
    return sha1($keyvaluestring);
}
/**
 * �������ڲ�ѯ������json�ַ���
 * @param String $appid ���ں�id
 * @param String $out_trade_no ������Ψһ������
 * @param String $appkey ֧��ǩ��
 * @param String $partner �Ƹ�ͨ�̻���ݱ�ʶ
 * @param String $partnerkey �Ƹ�ͨ�̻�Ȩ����ԿKey
 * @param String $timestamp ʱ���
 * @return String 
 */
function genOrderQuery($appid,$out_trade_no,$appkey,$partner,$partnerkey,$timestamp) {
    $sign = md5("out_trade_no={$out_trade_no}&partner={$partner}&key={$partnerkey}");
    $app_signature = md5("appid={appid}&appkey={$appkey}&package={package}&timestamp={timestamp}");
    $postArray = array(
        'appid' => $appid,
        'package' => "out_trade_no={$out_trade_no}&partner={$partner}&sign={$sign}",
        'timestamp' => $timestamp,
        'app_signature' => $app_signature,
        'sign_method' => 'sha1',
    );
    return json_encode($postArray);
}
$appid = 'wwwwb4f85f3a797777';
$out_trade_no = 11122;
$partner = 1900090055;
$timestamp=1369745073;
$appkey = '';
$partnerkey = '';
echo genOrderQuery($appid,$out_trade_no,$appkey,$partner,$partnerkey,$timestamp);
?>