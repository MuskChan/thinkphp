<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;
use Carbon\Carbon;

class Payment extends Controller
{
    protected $config = [
        'app_id' => '2016080200152136',
        // 服务器端回调
        'notify_url' => 'http://thinkphp.muskchan.com/index.php/index/payment/notify',
        'return_url' => 'http://thinkphp.muskchan.com/index.php/index/payment/aliPayReturn',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAnrazB2xYQp8VE2hyaIp6PPQPes7cTeu+zjSSEZwKIL8eZQfBOPsdih2I10fP9fCCJfi79d5iJrkJy2LQNywFDxHiuWCK1pDUnvDXZqMNvaXTDQFxAccW6oZoz4cuCG30kZbpG9+lDPP6XY+IenMsiHvQhz7b90B0WiQl+NxnpeNl6QWAna363Y/r5kufLJAfLj8iBM6N4OFiYYN8FgY7IHU3nYpUTwKUlEZ8fbeSOX2smSfpZbyqUHL4MpQttqiaTwdcH8irepzF/DO7S2wRzfIOPg2u2eT454vz2OBCdhprMuUUlmG7B/reAAK+zCNIDlJ3DM5vFHSwbbVMLdp7ewIDAQAB',
        // 加密方式： **RSA2**
        'private_key' => 'MIIEowIBAAKCAQEAr1VqbTZDPjXctAhOM2LLronXLD8kOCUr8WninEoUJs8U0+9DEdnKs6NkyKoaDKk/ILL3lzmVg9KAJsPFfQoXabCFPZqgVeBdZPDLXX20SuRLHpyIEYz3wXYl9nRseUl9GEX55KBVHbUZ4kDT2mnZtQa9820GBcvUwZvrrPETnEw93cHogx0ua9uHTa2UkFwXjtZjghQbl7avkp1hh5sbkB8Zh0HVQEKqRuym49vTAR10XZFzd68DKMT3wGfNuw0r+pE49sP6Qfzjnr8ZwLN0cT6K/gTCjBGwhaQ6kwVi4qlzxocsKGVd3Fq6ZnHiDEMe/3KG794kh4xXdmIlALEWTwIDAQABAoIBAQCihi2x8GOibfEYHL7IWSLutizzgdAED0jNbdY2A2DsnHX1AksMZ/LCU4ofi7W72MKAgASLdEBIwj4yMLSGdG1BdfP8J7HKCMDpyV7pWZVe+oE7beOfSSl7dhY4frDyOJGxh2PdblWXxQCqPmdihU3dxNMcqwmzI78ifHKYi5se+/AffqImYoqvv8kAA0Nw6eGvcJ0pgwASdMXg84mfxI9+ViVjdo9mEFpNOCZDCFkVpI+dzCyioI/ziNEBeFFK3/csAIgUpRya63yz5QmwdNjgTOLSkLsSNo1zDmGjCXtaw18Yzn4Wiwy7+YY1J8m6zMrkF9eSjfCoulMSu4XFh/eRAoGBANytBJ6H3Kxwvai9uNp/SPf8+2OE3u42r0aWLq30dzdXTSA4OzY+6yB1qWsqqW/ryjuzhGugpezoa7qGzacTt6BvPLY8tJ9TSxi8gBYu69qLX20VMCcbVR7L52AC9WwSci0EYsuW7VNi6ZTKb135CSzbU3tLtnaHDbeL1kn08275AoGBAMtmVs31FGYbnziWkih0CmKSbFCqsQarwwKgr7SEdjuvawVzeCLH0AiezkdHEa1QZA9EnXhPVV4O/YJpBp0OKQ6bHO9tgaxW6Xy1BZ2wL6QGEWcX22oYDaL1XyFPlAs1V4b2ip1wsP0S1SzhSOh36jip9O56bwKc/gZm5G7e5VmHAoGALLFZ4yWO+tmmf7tU6eOnipoQ69noMISgwQH/mDmPv4SN2T2qOFVL13odAthUEpfFkIvOAOI7WJzF3LQaiIEEyphcymfHCRGcfvkGU/fSyqM5g2UsKG9vsNoJFTfkLqwZtaZSv/rkO+QnfHv3TCf4xL3yzWDLJnw5ufe3Qak7eDkCgYB75fYAdUacwDyn6shTTgQ5cTn7lU5KYvxiMGF3U6z1xHArnN/UR+TIK3w53Oe+rBaXWlOVwrWcmwL/mlxF9Sc7V28zxX/U7AhER7yJBpaukmetZdHo+Yfs+QyerOvgO/j6JFnhd5DIR92E/iI8QTdylsy1K+1NKTZvzeNeSfZpJwKBgHI5ilSYR39uSnzinPjqI1ntaJ9C77t+dGOAudS1PlPbz9rsmCaLqGz558F2gOGDfsS6zM7IVh4wYS4T6g/BUoR7c8bkMNtq2IMF9ClevjvVpf9MbsV4S7IBW3OuDmgAL5WzeMhxNZGob+60wE4kWcvBVZRODerBxtOyjQ/dDZcb',
        // 使用公钥证书模式，请配置下面两个参数，同时修改ali_public_key为以.crt结尾的支付宝公钥证书路径，如（./cert/alipayCertPublicKey_RSA2.crt）
        // 'app_cert_public_key' => './cert/appCertPublicKey.crt', //应用公钥证书路径
        // 'alipay_root_cert' => './cert/alipayRootCert.crt', //支付宝根证书路径
        'log' => [ // optional
            'file' => './logs/alipay.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
    ];

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $order = [
            'out_trade_no' => Carbon::now()->toDateTimeString(),
            'total_amount' => '1',
            'subject' => '租金',
        ];

        $alipay = Pay::alipay($this->config)->web($order);

        return $alipay->send();// laravel 框架中请直接 `return $alipay`
    }

    // 前端回调页面
    public function aliPayReturn()
    {
        $data = Pay::alipay($this->config)->verify(); // 是的，验签就这么简单！

        // 订单号：$data->out_trade_no
//        dump($data->out_trade_no);
//        dump($data->trade_no);
//        dump($data->total_amount);
//        // 支付宝交易号：$data->trade_no
//        // 订单总金额：$data->total_amount

        // 查询
        $result = Pay::alipay($this->config)->find($data->out_trade_no); // 返回 `Yansongda\Supports\Collection` 实例，可以通过 `$result->xxx` 访问服务器返回的数据。
        if ($result->code == '10000') {
            $order_model = new \app\index\model\Order;
            $order_model->save($result->total_amount);
            $this->success('支付成功', 'Index/index', '', 0);
        } else {
            $this->error('支付失败', 'Index/index');
        }
    }

    // 服务器端回调
    public function notify()
    {
        $alipay = Pay::alipay($this->config);

        try{
            $data = $alipay->verify(); // 是的，验签就这么简单！

            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况

            Log::debug('Alipay notify', $data->all());
        } catch (\Exception $e) {
            // $e->getMessage();
        }

        return $alipay->success()->send();// laravel 框架中请直接 `return $alipay->success()`
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
