<?php
/**
 * 微信相关功能
 *
 * @param $var
 * @param string $value
 * @param int $time
 * @param string $path
 * @param string $domain
 * @param bool $s
 */
    // 获取access_token
    $access_token = $this->wechat->access_token;
    $wesign = $this->wechat->wesign;
    //var_dump($access_token);
    //var_dump($wesign);
?>

<!-- 载入官方组件库 -->
<script src="https://res.wx.qq.com/open/js/jweixin-1.3.2.js"></script>

<!-- 微信环境中的业务内容 -->
<script>
    // 微信用户信息
    var is_subscribe = '<?php echo $this->session->wechat_subscribe ?>';
    console.log(is_subscribe);

    // 未关注微信公众号时的逻辑
    if (is_subscribe != 1)
    {
        console.log('未关注');
        //document.getElementById('follow-guide').style.display = 'none';
    }

    // 全局声明微信组件功能
    var wechat_scan, wechat_locate;
    
    // 微信扫描内容解析
    function parse_scaned(content)
    {
        // 条码/二维码内容
        var content;

        // 需跳转到的页面内容
        var url;

        // 根据内容类型执行不同业务逻辑
        if (content.indexOf('EAN_') === 0)
        {
            var code = content.split(',')[1]; // 获取条码
            url = base_url + 'item?barcode=' + code; // 转到商品搜索页
        }
        else if (content.indexOf('http', 0) === 0)
        {
            url = content; // 转到所属页面
        }
        else
        {
            url = base_url + 'item?name=' + content; // 转到商品搜索页
        }

        // 页面跳转
        location.href = url;
    }

    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: '<?php echo WECHAT_APP_ID ?>', // 必填，公众号的唯一标识
        timestamp: <?php echo $wesign['timestamp'] ?>, // 必填，生成签名的时间戳
        nonceStr: '<?php echo $wesign['noncestr'] ?>', // 必填，生成签名的随机串
        signature: '<?php echo $this->wechat->wechat_sign_generate($wesign) ?>',// 必填，签名，见附录1
        jsApiList: [
            'hideMenuItems',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'scanQRCode',
            'getLocation',
            'getNetworkType',
            'openAddress', // 获取微信收货地址
        ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });

    wx.ready(function(){
        // 隐藏部分按钮
        wx.hideMenuItems({
        menuList:[
        'menuItem:share:qq', 'menuItem:share:QZone', 'menuItem:share:facebook', 'menuItem:copyUrl', 'menuItem:readMode', 'menuItem:openWithQQBrowser', 'menuItem:openWithSafari', 'menuItem:share:email',
        ] // 要隐藏的菜单项，只能隐藏“传播类”和“保护类”按钮，所有menu项见附录3
        });

        <?php
        // 分享到微信时的形象图URL
        $url_page_figure = empty($item['url_image'])? MEDIA_URL.'/icon/jinlai_client/64x64.png': $this->media_root.$item['url_image'];
        ?>

        // 分享到朋友圈
        wx.onMenuShareTimeline({
            title: '<?php echo $title ?>', // 分享标题
            link: '<?php echo CURRENT_URL ?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: '<?php echo $url_page_figure ?>', // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
                alert('分享成功');
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
                alert('未完成分享');
            }
        });

        // 分享给朋友
        wx.onMenuShareAppMessage({
            title: '<?php echo $title ?>', // 分享标题
            desc: '<?php echo $description ?>', // 分享描述
            link: '<?php echo CURRENT_URL ?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: '<?php echo $url_page_figure ?>', // 分享图标
            type: '', // 分享类型，music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
                alert('分享成功');
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
                alert('未完成分享');
            }
        });

        // 调起扫一扫
        wechat_scan = function (){
            wx.scanQRCode({
                needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                scanType: ['qrCode','barCode'], // 可以指定扫二维码还是一维码，默认二者都有
                success: function (res){
                    var result = res.resultStr; // 当needResult为1时，扫码返回的结果
                    parse_scaned(result);
                    
                    //TODO 若为条形码，输出条码；若为二维码，转到URL
                    //alert(JSON.stringify(res));
                },
                cancel:function(){
                    alert('微信扫码调用失败');
                }
            });
            return false;
        };

        // 获取地理位置及网络类型
        wechat_locate = function (){
            console.log('wechat_locate');
            wx.getLocation({
                type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
                success: function (res) {
                    var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                    var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                    alert(longitude + ',' +latitude);
                    //var speed = res.speed; // 速度，以米/每秒计
                    //var accuracy = res.accuracy; // 位置精度
                    $.ajax({
                        url : 'https://restapi.amap.com/v3/geocode/regeo?output=json&location=' + longitude + ',' + latitude + '&key=cc372b3833813f873834e638ba608fcc',
                        type : 'get',
                        dataType : 'json',
                        success:function(res){
                            $(".maptext").find('span').text(res.regeocode.addressComponent.district);
                            $(".curCity").text(res.regeocode.addressComponent.city);
                        },
                        error:function(){
                            alert("获取地理位置失败!");
                        }
                    });
                },
                cancel: function () {
                    alert('我们需要获取您的位置，以向您推荐附近的优质商品、商家');
                }
            });

            wx.getNetworkType({
                success: function (res) {
                    var networkType = res.networkType; // 返回网络类型2g，3g，4g，wifi
                    alert(networkType);
                }
            });
            return false;
        };
    }); // end wx.ready
</script>