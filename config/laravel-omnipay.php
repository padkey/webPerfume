<?php

return [
    // Cấu hình cho các cổng thanh toán tại hệ thống của bạn, các cổng không xài có thể xóa cho gọn hoặc không điền.
    // Các thông số trên có được khi bạn đăng ký tích hợp.

    'gateways' => [
        'MoMoAIO' => [
            'driver' => 'MoMo_AllInOne',
            'options' => [
                'accessKey' => 'lm2Vlmt6Nek0Ugqz',
                'secretKey' => '7WuFHv01aOMAiYwWW5zf6WQA84auopeN',
                'partnerCode' => 'MOMOC27G20200806',
                'testMode' => true,
            ],
        ],
        'MoMoQRCode' => [
            'driver' => 'MoMo_QRCode',
            'options' => [
                'accessKey' => 'lm2Vlmt6Nek0Ugqz',
                'secretKey' => '7WuFHv01aOMAiYwWW5zf6WQA84auopeN',
                'partnerCode' => 'MOMOC27G20200806',
                'testMode' => true,
            ],
        ],
        'MoMoAIA' => [
            'driver' => 'MoMo_AppInApp',
            'options' => [
                'accessKey' => 'lm2Vlmt6Nek0Ugqz',
                'secretKey' => '7WuFHv01aOMAiYwWW5zf6WQA84auopeN',
                'partnerCode' => 'MOMOC27G20200806',
                'publicKey' => '',
                'testMode' => true,
            ],
        ],
        'MoMoPOS' => [
            'driver' => 'MoMo_POS',
            'options' => [
                'accessKey' => 'lm2Vlmt6Nek0Ugqz',
                'secretKey' => '7WuFHv01aOMAiYwWW5zf6WQA84auopeN',
                'partnerCode' => 'MOMOC27G20200806',
                'publicKey' => '',
                'testMode' => true,
            ],
        ],
        'OnePayDomestic' => [
            'driver' => 'OnePay_Domestic',
            'options' => [
                'vpcMerchant' => '',
                'vpcAccessCode' => '',
                'vpcUser' => '',
                'vpcPassword' => '',
                'vpcHashKey' => '',
                'testMode' => true,
            ],
        ],
        'OnePayInternational' => [
            'driver' => 'OnePay_International',
            'options' => [
                'vpcMerchant' => '',
                'vpcAccessCode' => '',
                'vpcUser' => '',
                'vpcPassword' => '',
                'vpcHashKey' => '',
                'testMode' => true,
            ],
        ],
        'VTCPay' => [
            'driver' => 'VTCPay',
            'options' => [
                'websiteId' => '',
                'securityCode' => '',
                'testMode' => true,
            ],
        ],
        'VNPay' => [
            'driver' => 'VNPay',
            'options' => [
                'vnpTmnCode' => '',
                'vnpHashSecret' => '',
                'testMode' => true,
            ],
        ],
    ],
];
