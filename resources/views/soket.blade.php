<html>
<head>
    <title>放置文章标题</title>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" /> //这里是网页编码现在是gb2312
    <meta name="keywords" content="关键字" />
    <meta name="description" content="本页描述或关键字描述" />
</head>
<body>
这里就是正文内容
</body>
<script src="//cdn.bootcss.com/jquery/2.0.3/jquery.min.js"></script>
<script>
    /**
     * 与GatewayWorker建立websocket连接，域名和端口改为你实际的域名端口，
     * 其中端口为Gateway端口，即start_gateway.php指定的端口。
     * start_gateway.php 中需要指定websocket协议，像这样
     * $gateway = new Gateway(websocket://0.0.0.0:8282);
     */
    ws = new WebSocket("ws://192.168.10.10:8282");
    // 服务端主动推送消息时会触发这里的onmessage
    ws.onmessage = function(e){
         console.log(e);
        // json数据转换成js对象
        var data = eval("("+e.data+")");
        var type = data.type || '';

        switch(type){
            // Events.php中返回的init类型的消息，将client_id发给后台进行uid绑定
            case 'init':
                // 利用jquery发起ajax请求，将client_id发给后端进行uid绑定
                $.post('http://homestead.test/api/ws/send', {'client_id': data.client_id, 'token': "token1"}, function(data){}, 'json');
                break;
            // 当mvc框架调用GatewayClient发消息时直接alert出来
            default :
                alert(e.data);
        }
    };
</script>
</html>