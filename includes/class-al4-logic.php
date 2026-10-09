<?php
/**
 * منطق تشخیص هوشمند گیربکس AL4 / DP0
 * بر اساس راهنمای تعمیرات رنو و داده‌های فنی PSA
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class AL4_Logic {

    public function diagnose( $d ) {
        $issues   = array();
        $steps    = array();
        $warnings = array();
        $severity = 0;

        $codes    = isset( $d['codes'] ) ? (array) $d['codes'] : array();
        $symptoms = isset( $d['symptoms'] ) ? (array) $d['symptoms'] : array();
        $pre      = isset( $d['prechecks'] ) ? (array) $d['prechecks'] : array();

        if ( count( $pre ) < 4 ) {
            $warnings[] = 'بررسی‌های اولیه کامل نشده. خیلی از خطاها ناشی از روغن یا باتری ضعیف است.';
        }
        if ( isset( $d['battery'] ) && $d['battery'] === 'low' ) {
            $issues[]  = array( 'sev' => 'high', 'title' => 'ولتاژ باتری پایین', 'desc' => 'تست‌های الکتریکی معتبر نیستند. اول باتری و سیستم شارژ را درست کنید.' );
            $severity = max( $severity, 2 );
        }
        if ( isset( $d['oil_temp'] ) && $d['oil_temp'] === 'cold' ) {
            $warnings[] = 'دمای روغن خیلی پایین است. تست فشار در زیر ۴۰ درجه اعتبار کمی دارد.';
        }
        if ( isset( $d['oil_temp'] ) && $d['oil_temp'] === 'critical' ) {
            $warnings[] = 'دمای روغن بالای ۱۱۰ درجه است. خطر آسیب به قطعات هیدرولیک.';
        }

        if ( in_array( 'metal', $symptoms, true ) ) {
            $issues[]  = array( 'sev' => 'critical', 'title' => 'براده فلزی در روغن', 'desc' => 'فقط عوض کردن سولنوئید کافی نیست. منشأ براده باید پیدا شود.' );
            $severity = 3;
            $steps[]   = 'بررسی منشأ براده فلزی (کلاچ‌ها، بوش‌ها، پمپ)';
            $steps[]   = 'تعویض همه سولنوئیدها + سرویس یا تعویض بلوک هیدرولیک';
        }

        if ( in_array( 'DF226', $codes, true ) || in_array( 'DF049', $codes, true ) ) {
            $issues[]  = array( 'sev' => 'high', 'title' => 'مشکل تنظیم فشار روغن (DF226 / DF049)', 'desc' => 'سولنوئید تنظیم فشار (EVM/EPC)، نشتی بوش‌های بلوک هیدرولیک یا روغن کهنه.' );
            $severity = max( $severity, 2 );
            $steps[]   = 'بررسی سطح و حال روغن';
            $steps[]   = 'تست فشار خط با مانومتر';
            $steps[]   = 'اندازه‌گیری مقاومت EVM (باید ۱ ± ۰.۱۲ اهم باشد)';

            if ( in_array( $d['res_evm'] ?? '', array( 'short', 'open', 'out' ), true ) ) {
                $issues[]  = array( 'sev' => 'critical', 'title' => 'EVM معیوب از نظر الکتریکی', 'desc' => 'مقاومت خارج از محدوده. سولنوئید تنظیم فشار را عوض کنید (ترجیحاً هر دو عدد).' );
                $severity = 3;
            }
            if ( ( $d['press_stable'] ?? '' ) === 'unstable' ) {
                $issues[]  = array( 'sev' => 'high', 'title' => 'فشار EVM ناپایدار', 'desc' => 'اختلاف دو قرائت > ۰.۲ بار. EVM و روغن را عوض کنید.' );
                $severity = max( $severity, 2 );
            }
            if ( ( $d['press_compare'] ?? '' ) === 'sensor_high' ) {
                $issues[]  = array( 'sev' => 'high', 'title' => 'سنسور فشار خراب', 'desc' => 'موتور خاموش ولی دیاگ > ۰.۲ بار نشان می‌دهد.' );
                $severity = max( $severity, 2 );
            }
            if ( ( $d['press_compare'] ?? '' ) === 'diff' ) {
                $issues[]  = array( 'sev' => 'high', 'title' => 'اختلاف مانومتر و دیاگ', 'desc' => 'اختلاف > ۰.۵ بار. سنسور فشار را عوض کنید.' );
                $severity = max( $severity, 2 );
            }
        }

        if ( in_array( 'DF018', $codes, true ) ) {
            $issues[]  = array( 'sev' => 'high', 'title' => 'لغزش کانورتور هنگام قفل (DF018)', 'desc' => 'سولنوئید EVLU، کانورتور گشتاور یا روغن.' );
            $severity = max( $severity, 2 );
            $steps[]   = 'تست نقطه‌ی توقف (Stall) — دور باید ۲۳۰۰ ± ۱۵۰ باشد';
            $steps[]   = 'اندازه‌گیری مقاومت EVLU (باید ۱ ± ۰.۱۲ اهم باشد)';

            if ( in_array( $d['res_evlu'] ?? '', array( 'short', 'open', 'out' ), true ) ) {
                $issues[]  = array( 'sev' => 'critical', 'title' => 'EVLU معیوب از نظر الکتریکی', 'desc' => 'سولنوئید قفل کانورتور را عوض کنید.' );
                $severity = 3;
            }
            if ( ( $d['stall'] ?? '' ) === 'high' ) {
                $issues[]  = array( 'sev' => 'high', 'title' => 'دور توقف خارج از محدوده یا صدای غیرعادی', 'desc' => 'کانورتور + EVLU + روغن را عوض کنید.' );
                $severity = max( $severity, 2 );
            }
        }

        if ( ( in_array( 'DF049', $codes, true ) && in_array( 'DF018', $codes, true ) )
            || ( in_array( 'DF018', $codes, true ) && in_array( 'DF005', $codes, true ) ) ) {
            $issues[]  = array( 'sev' => 'critical', 'title' => 'ترکیب مهم کدها', 'desc' => 'سولنوئید EVM + EVLU + روغن را با هم عوض کنید.' );
            $severity = 3;
            $steps[]   = 'تعویض همزمان EVM + EVLU + روغن';
        }

        if ( in_array( 'DF017', $codes, true ) ) {
            $issues[]  = array( 'sev' => 'high', 'title' => 'سولنوئید دبی مبدل (DF017)', 'desc' => 'مدار اتصال کوتاه. مسیر روغن به رادیاتور.' );
            $severity = max( $severity, 2 );
            $steps[]   = 'چک کانکتور و مقاومت سولنوئید دبی مبدل (۴۰ ± ۴ اهم)';
        }

        if ( in_array( 'DF012', $codes, true ) ) {
            $issues[]  = array( 'sev' => 'high', 'title' => 'برق سولنوئیدها نمی‌رسد (DF012)', 'desc' => 'سیم‌کشی داخلی گیربکس یا رابط الکتریکی-هیدرولیکی.' );
            $severity = max( $severity, 2 );
            $steps[]   = 'اول DF017 را رفع کنید، بعد سراغ DF012 بروید';
        }

        if ( in_array( 'DF020', $codes, true ) ) {
            $issues[]  = array( 'sev' => 'medium', 'title' => 'روغن گیربکس پیر شده (DF020)', 'desc' => 'تعویض روغن و صفر کردن شمارنده.' );
            $severity = max( $severity, 1 );
            $steps[]   = 'تعویض روغن + ثبت تاریخ + فرمان CF074';
        }

        if ( in_array( 'DF038', $codes, true ) ) {
            $issues[]  = array( 'sev' => 'high', 'title' => 'سنسور دور توربین (DF038)', 'desc' => 'سیگنال نمی‌دهد یا نویز دارد.' );
            $severity = max( $severity, 2 );
            $steps[]   = 'چک کانکتور، سیم و مقاومت سنسور دور توربین (۳۰۰ ± ۴۰ اهم)';
        }

        if ( in_array( 'DF048', $codes, true ) ) {
            $issues[]  = array( 'sev' => 'high', 'title' => 'سنسور سرعت خروجی (DF048)', 'desc' => 'اطلاعات سرعت خودرو مشکل دارد.' );
            $severity = max( $severity, 2 );
            $steps[]   = 'چک کانکتور، سیم و مقاومت سنسور سرعت خروجی (۱۲۰۰ ± ۲۰۰ اهم)';
        }

        if ( in_array( 'DF023', $codes, true ) ) {
            $issues[]  = array( 'sev' => 'medium', 'title' => 'سنسور دمای روغن (DF023)', 'desc' => 'مدار سنسور دما مشکل دارد.' );
            $severity = max( $severity, 1 );
            $steps[]   = 'چک کانکتور و مقاومت سنسور دما';
        }

        if ( in_array( 'DF005', $codes, true ) ) {
            $warnings[] = 'DF005 وجود دارد. طبق راهنمای رنو اول این را رفع کنید.';
        }

        if ( in_array( 'harsh_cold', $symptoms, true ) && ! in_array( 'DF226', $codes, true ) && ! in_array( 'DF049', $codes, true ) ) {
            $issues[]  = array( 'sev' => 'high', 'title' => 'لگد زدن در حالت سرد', 'desc' => 'احتمال قوی مشکل فشار (DF226).' );
            $severity = max( $severity, 2 );
            $steps[]   = 'خواندن کدهای خطا با دیاگ';
            $steps[]   = 'بررسی روغن و تست فشار خط';
        }
        if ( in_array( 'hot_lock', $symptoms, true ) ) {
            $issues[]  = array( 'sev' => 'high', 'title' => 'قفل شدن هنگام داغ شدن', 'desc' => 'احتمال DF017 — سولنوئید دبی مبدل.' );
            $severity = max( $severity, 2 );
            $steps[]   = 'بررسی سولنوئید دبی مبدل و مسیر خنک‌کاری روغن';
        }
        if ( in_array( 'limp', $symptoms, true ) ) {
            $issues[]  = array( 'sev' => 'high', 'title' => 'حالت اضطراری (Limp Mode)', 'desc' => 'معمولاً مشکل تنظیم فشار.' );
            $severity = max( $severity, 2 );
            $steps[]   = 'خواندن و یادداشت کدهای خطا';
            $steps[]   = 'بررسی سولنوئید تنظیم فشار';
        }
        if ( in_array( 'intermittent', $symptoms, true ) ) {
            $issues[]  = array( 'sev' => 'medium', 'title' => 'خطای گاه‌به‌گاه', 'desc' => 'شل بودن کانکتور، سیم یا نشتی داخلی.' );
            $severity = max( $severity, 1 );
            $steps[]   = 'بررسی دقیق کانکتورها و سیم‌کشی';
        }
        if ( in_array( 'slow_reverse', $symptoms, true ) ) {
            $issues[]  = array( 'sev' => 'medium', 'title' => 'دنده عقب کند / بی‌قدرت', 'desc' => 'نصب اشتباه بلوک یا یادگیری انجام نشده.' );
            $severity = max( $severity, 1 );
            $steps[]   = 'بررسی نصب بلوک هیدرولیک و تنظیم سوپاپ دستی';
            $steps[]   = 'صفر کردن یادگیری‌ها (RZ005)';
        }
        if ( in_array( 'no_lockup', $symptoms, true ) ) {
            $issues[]  = array( 'sev' => 'high', 'title' => 'عدم قفل کانورتور', 'desc' => 'سولنوئید EVLU یا خود کانورتور.' );
            $severity = max( $severity, 2 );
            $steps[]   = 'تست Stall و مقاومت EVLU';
        }
        if ( in_array( 'overheat', $symptoms, true ) ) {
            $issues[]  = array( 'sev' => 'high', 'title' => 'گرم شدن بیش از حد', 'desc' => 'سولنوئید دبی مبدل، رادیاتور روغن یا سطح روغن.' );
            $severity = max( $severity, 2 );
            $steps[]   = 'بررسی سطح روغن، رادیاتور روغن و سولنوئید دبی';
        }

        if ( in_array( $d['res_evm'] ?? '', array( 'short', 'open' ), true ) ) {
            $issues[]  = array( 'sev' => 'critical', 'title' => 'EVM معیوب (مقاومت)', 'desc' => 'مقاومت صفر یا باز. تعویض سولنوئید تنظیم فشار.' );
            $severity = 3;
        }
        if ( in_array( $d['res_evlu'] ?? '', array( 'short', 'open' ), true ) ) {
            $issues[]  = array( 'sev' => 'critical', 'title' => 'EVLU معیوب (مقاومت)', 'desc' => 'مقاومت صفر یا باز. تعویض سولنوئید قفل کانورتور.' );
            $severity = 3;
        }
        if ( in_array( $d['res_evs'] ?? '', array( 'short', 'open' ), true ) ) {
            $issues[]  = array( 'sev' => 'high', 'title' => 'شیر تعویض دنده (EVS) معیوب', 'desc' => 'مقاومت خارج از محدوده.' );
            $severity = max( $severity, 2 );
        }
        if ( in_array( $d['res_flow'] ?? '', array( 'short', 'open' ), true ) ) {
            $issues[]  = array( 'sev' => 'critical', 'title' => 'سولنوئید دبی مبدل معیوب', 'desc' => 'مقاومت صفر یا باز.' );
            $severity = 3;
        }

        if ( $severity >= 3 ) {
            $verdict = 'مشکل جدی تشخیص داده شد'; $vclass = 'bad'; $conf = 'بالا';
        } elseif ( $severity === 2 ) {
            $verdict = 'احتمال بالای وجود ایراد'; $vclass = 'warn'; $conf = 'بالا';
        } elseif ( $severity === 1 ) {
            $verdict = 'مشکل محتمل است — نیاز به بررسی بیشتر'; $vclass = 'warn'; $conf = 'متوسط';
        } elseif ( empty( $codes ) && empty( $symptoms ) && empty( $d['res_evm'] ) && empty( $d['res_evlu'] ) && empty( $d['press_compare'] ) && empty( $d['stall'] ) ) {
            $verdict = 'اطلاعات کافی وارد نشده است'; $vclass = 'info'; $conf = 'پایین';
            $warnings[] = 'حداقل یک کد خطا، علامت یا مقدار اندازه‌گیری وارد کنید.';
        } else {
            $verdict = 'ایراد مشخصی بر اساس داده‌های واردشده مشاهده نشد'; $vclass = 'ok'; $conf = 'متوسط تا بالا';
            $steps[] = 'اگر علائم ادامه دارد، تست‌های دینامیکی و بررسی هیدروبلاک توصیه می‌شود';
        }

        $uniq_steps = array_values( array_unique( $steps ) );

        $code_info = array(
            'DF226' => 'فشار روغن با مقدار کامپیوتر نمی‌خواند ← EVM/EPC، نشتی بوش، روغن کهنه',
            'DF049' => 'مشکل تنظیم فشار ← EVM',
            'DF018' => 'لغزش کانورتور هنگام قفل ← EVLU، کانورتور، روغن',
            'DF017' => 'اتصال کوتاه سولنوئید دبی مبدل',
            'DF012' => 'برق سولنوئیدها نمی‌رسد ← سیم‌کشی داخلی',
            'DF020' => 'روغن پیر شده ← تعویض روغن + صفر کردن شمارنده',
            'DF038' => 'سنسور دور توربین ← مقاومت ۳۰۰±۴۰ اهم',
            'DF048' => 'سنسور سرعت خروجی ← مقاومت ۱۲۰۰±۲۰۰ اهم',
            'DF023' => 'سنسور دمای روغن',
            'DF005' => 'اول این را رفع کنید',
        );

        $code_meanings = array();
        foreach ( $codes as $c ) {
            if ( isset( $code_info[ $c ] ) ) {
                $code_meanings[ $c ] = $code_info[ $c ];
            }
        }

        return array(
            'verdict'       => $verdict,
            'vclass'        => $vclass,
            'confidence'    => $conf,
            'issues'        => $issues,
            'warnings'      => $warnings,
            'steps'         => $uniq_steps,
            'code_meanings' => $code_meanings,
        );
    }
}
