<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GatewayClient\Gateway;

class WorkermanController extends Controller
{
    //取区间
    public function qujian($number1,$number2)
    {
        return round($number1/$number2,2);
    }

    function randFloat($min=0, $max=1){
        return $min + mt_rand()/mt_getrandmax() * ($max-$min);
    }

    public function index()
    {
        $price = 100; // 总金额
        $people = 10; // 人数
        $no_people = $people; //未抢人数
        $min = 0.01; //最小红包

        $data = [];

        for($i = 0; $i <= $people; $i++)
        {
            if($people == $i)
            {
                $data[$i]["price"] = round($price, 2);
            }else{
                $data[$i]["price"] = round($this->randFloat($min, $this->qujian($price,$no_people)),2);
                $price = $price - $data[$i]["price"];
                $no_people--;
            }
            echo '第' . $i . '个人抢了' . $data[$i]["price"] . "红包</br>";
        }
        //print_r($data);
        $count = 0;
        foreach($data as $k => $v) {
            $count = $count + $v["price"];
        }
        $b = $data;
        for($i=0; $i<count($b); $i++){
            sort($b[$i]);
           // echo '第'.$i.'列 最小数='.$b[$i][0].' 最大数='.$b[$i][count($b[$i])-1].'<br>';
        }
        print_r($b);
echo "<br/>".$count;
        die;


        return view('soket');
    }

    public function send(Request $request)
    {

        // 设置GatewayWorker服务的Register服务ip和端口
        Gateway::$registerAddress = '0.0.0.0:1238';
        $request = $request->All();
        //绑定token链接
        Gateway::bindUid($request['client_id'], $request['token']);

        Gateway::sendToAll(json_encode($request));

    }

}
