
این پکیج برای اتصال به درگاه بانک های ایرانی ساخته شده است.

(این پکیج با نسخه های * ۴ تا ۸ لاراول* سازگار است.)

درگاه های قابل استفاده:
 1. ملت
 2. سداد (ملی)
 3. سامان
 4. پارسیان
 5. پاسارگاد
 6. زرین پال
 7. پی پال
 8. آسان پرداخت
 9. پی (pay.ir)
----------


**Installation**:

دستورات زیر را در ترمینال و در پوشه پروژه خود اجرا کنید:

مرحله اول: 

    composer require mratwan/bankgateway
    
مرجله دوم : `provider` و `facade` را در فایل config/app.php اضافه کنید.

    'providers' => [
      ...
      MrAtwan\BankGateway\GatewayServiceProvider::class, // <-- add this line at the end of provider array
    ],


    'aliases' => [
      ...
      'Gateway' => MrAtwan\BankGateway\Gateway::class, // <-- add this line at the end of aliases array
    ]

مرحله سوم:  

    php artisan vendor:publish --provider=MrAtwan\BankGateway\GatewayServiceProvider

مرحله چهارم: 

    php artisan migrate


تنظیمات و اطلاعات درگاه ها در فایل config/gateway.php اضافه شده اند. حال می توانید در این فایل اطلاعات درگاه های خود را وارد کنید.

شما می توانید برای ارتباط با بانک از راه های مختلفی استفاده کنید: (Facade , Service container):

    try {
       
       $gateway = \Gateway::make(new \Mellat());

       // $gateway->setCallback(url('/path/to/callback/route')); You can also change the callback
       $gateway
            ->price(1000)
            // setShipmentPrice(10) // optional - just for paypal
            // setProductName("My Product") // optional - just for paypal
            ->ready();

       $refId =  $gateway->refId(); // شماره ارجاع بانک
       $transID = $gateway->transactionId(); // شماره تراکنش

      // در اینجا
      //  شماره تراکنش  بانک را با توجه به نوع ساختار دیتابیس تان 
      //  در جداول مورد نیاز و بسته به نیاز سیستم تان
      // ذخیر کنید .
      
       return $gateway->redirect();
       
    } catch (\Exception $e) {
       
       	echo $e->getMessage();
    }

برای فراخوانی درگاه می توانید از روش های زیر استفاده کنید:
 1. Gateway::make(new Mellat());
 2. Gateway::mellat()
 3. app('gateway')->make(new Mellat());
 4. app('gateway')->mellat();

به جای MELLAT در کدهای بالا می توانید از نام درگاه های دیگر هم استفاده کنید.

در متد `price` شما باید قیمت را به ریال وارد کنید. 

و در متد callback به این صورت عمل نمایید:

    try { 
       
       $gateway = \Gateway::verify();
       $trackingCode = $gateway->trackingCode();
       $refId = $gateway->refId();
       $cardNumber = $gateway->cardNumber();
       
        // تراکنش با موفقیت سمت بانک تایید گردید
        // در این مرحله عملیات خرید کاربر را تکمیل میکنیم
    
    } catch (\MrAtwan\BankGateway\Exceptions\RetryException $e) {
    
        // تراکنش قبلا سمت بانک تاییده شده است و
        // کاربر احتمالا صفحه را مجددا رفرش کرده است
        // لذا تنها فاکتور خرید قبل را مجدد به کاربر نمایش میدهیم
        
        echo $e->getMessage() . "<br>";
        
    } catch (\Exception $e) {
       
        // نمایش خطای بانک
        echo $e->getMessage();
    }