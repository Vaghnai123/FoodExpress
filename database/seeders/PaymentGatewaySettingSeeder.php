<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentGatewaySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['key' => 'stripe_rate', 'value' => '1'],
            ['key' => 'stripe_currency', 'value' => 'USD'],
            ['key' => 'stripe_country', 'value' => 'US'],
            ['key' => 'stripe_status', 'value' => '1'],
            ['key' => 'stripe_logo', 'value' => '/uploads/media_69f04af4cb3f8.jpg'],
            ['key' => 'paypal_app_id', 'value' => 'APP-80W284485P519543T'],
            ['key' => 'paypal_secret_key', 'value' => 'EDdSaU9tbohpWbfBg26OYPQU_6rtBPPTYct5NtgfTsl_TrsvB6HoE27TmVvHQV3on308LRZJUHmqrG2E'],
            ['key' => 'paypal_api_key', 'value' => 'AQpMp8UGjoIkIKw8k5nUMEsi5oYbOhXEe2mEIdYL3UnDUsVGpBsO1dDFYWaPHS4FDDV9OHGDOP63CYaX'],
            ['key' => 'paypal_rate', 'value' => '1'],
            ['key' => 'paypal_currency', 'value' => 'USD'],
            ['key' => 'paypal_country', 'value' => 'US'],
            ['key' => 'paypal_account_mode', 'value' => 'sandbox'],
            ['key' => 'paypal_status', 'value' => '1'],
            ['key' => 'paypal_logo', 'value' => '/uploads/media_69ef4a6a10a35.png'],
            ['key' => 'razorpay_logo', 'value' => '/uploads/media_69f04a7606257.jpg'],
            ['key' => 'stripe_api_key', 'value' => 'pk_test_51TN40ARvb4NBMMIQXDxjVEf0Rqq5c7tfcGMOJPMRbRJVNv4QUJqEJ89k9vzco7cwyRYnZSqqMex3MbP05f8xcPlw00KfbQRzPN'],
            ['key' => 'stripe_secret_key', 'value' => 'sk_test_51TN40ARvb4NBMMIQOLvf8oViylqr7491R5kGZPuif8jc1ctxCfzMGtJz6r3GKb1TvWgyqUHvS4AEcndRugNeC8fR00L2PoSIbZ'],
            ['key' => 'razorpay_status', 'value' => '1'],
            ['key' => 'razorpay_country', 'value' => 'IN'],
            ['key' => 'razorpay_currency', 'value' => 'INR'],
            ['key' => 'razorpay_rate', 'value' => '94.44'],
            ['key' => 'razorpay_api_key', 'value' => 'rzp_test_K7CipNQYyyMPiS'],
            ['key' => 'razorpay_secret_key', 'value' => 'zSBmNMorJrirOrnDrbOd1ALO'],
        ];

        foreach ($data as &$item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
        }

        DB::table('payment_gateway_settings')->truncate();
        DB::table('payment_gateway_settings')->insert($data);
    }
}
