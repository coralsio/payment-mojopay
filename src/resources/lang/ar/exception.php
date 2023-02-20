<?php

return [
    'request_did_not_contain' => 'لم يحتوي الطلب على رأس مسمى "Mojopay-Signature".',
    'signature_found_header_named' => 'التوقيع: :name الموجود في العنوان المسمى `Mojopay-Signature غير صالح. تأكد من أن `services.mojopay.webhook_signing_secret`
                                         يتم تعيين مفتاح التكوين على القيمة التي وجدتها في لوحة معلومات Mojopay. إذا كنت تقوم بالتخزين المؤقت للتهيئة ، فحاول تشغيل `php artisan clear: cache` لحل المشكلة',
    'stripe_secret_not_set' => 'لم يتم تعيين سر توقيع شريط Mojopay. تأكد من تكوين `mojopay.settings` على النحو المطلوب.',
    'invalid_two_checked_payload' => 'غير صالح الحمولة Mojopay. يرجى المراجعة WebhookCall: :arg',
    'invalid_two_checked_invoice' => 'رمز فاتورة Mojopay غير صالح. يرجى المراجعةWebhookCall: :arg',
    'invalid_two_checked_subscription' => 'مرجع اشتراك Mojopay غير صالح. يرجى المراجعة WebhookCall: :arg',
    'invalid_two_checked_customer' => 'عميل غير صالح للتسجيل يرجى المراجعة WebhookCall: :arg',


];