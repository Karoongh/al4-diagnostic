<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<div class="al4-wrap" dir="rtl">
<header class="al4-header">
  <h1>عیب‌یابی حرفه‌ای گیربکس AL4 / DP0</h1>
  <p>ویژه مکانیک‌ها · ساده · مرحله‌به‌مرحله · موبایل‌فرندلی</p>
</header>

<div class="al4-tabs" id="al4-tabs">
  <button type="button" class="al4-tab active" data-tab="t1">شروع سریع</button>
  <button type="button" class="al4-tab" data-tab="t2">کد خطا</button>
  <button type="button" class="al4-tab" data-tab="t3">علائم</button>
  <button type="button" class="al4-tab" data-tab="t4">مقادیر</button>
  <button type="button" class="al4-tab" data-tab="t5">نتیجه</button>
</div>

<div class="al4-panel active" id="t1">
  <div class="al4-card">
    <h2><span class="num">1</span> مدل خودرو</h2>
    <div class="al4-field">
      <label>مدل را انتخاب کنید</label>
      <select id="model" name="model">
        <option value="">— انتخاب کنید —</option>
        <option value="megane2">مگان ۲</option>
        <option value="scenic2">سنیک ۲</option>
        <option value="clio">کلیو</option>
        <option value="laguna">لاگونا</option>
        <option value="modus">مدوس</option>
        <option value="peugeot">پژو ۲۰۶ / ۲۰۷ / ۳۰۷</option>
        <option value="citroen">سیتروئن C3 / C4 / C5</option>
        <option value="other">سایر مدل‌های AL4/DP0</option>
      </select>
    </div>
  </div>
  <div class="al4-card">
    <h2><span class="num">2</span> قبل از شروع</h2>
    <div class="al4-warn-box">خیلی از خطاها فقط به‌خاطر روغن کهنه، کم یا باتری ضعیف است.</div>
    <div class="al4-checks" id="prechecks">
      <label><input type="checkbox" name="prechecks[]" value="battery"> ولتاژ باتری بین ۱۱.۸ تا ۱۳.۲ ولت است</label>
      <label><input type="checkbox" name="prechecks[]" value="oil_level"> سطح روغن گیربکس چک شد</label>
      <label><input type="checkbox" name="prechecks[]" value="oil_cond"> رنگ، بو و براده فلزی در روغن بررسی شد</label>
      <label><input type="checkbox" name="prechecks[]" value="fuses"> فیوزهای گیربکس سالم هستند</label>
      <label><input type="checkbox" name="prechecks[]" value="connectors"> کانکتورها چک شدند</label>
      <label><input type="checkbox" name="prechecks[]" value="codes_noted"> کدهای خطا یادداشت شدند</label>
    </div>
  </div>
  <div class="al4-btn-row">
    <button type="button" class="al4-btn al4-btn-main" data-goto="t2">ادامه ←</button>
  </div>
</div>

<div class="al4-panel" id="t2">
  <div class="al4-card">
    <h2><span class="num">1</span> کدهای خطای رایج AL4</h2>
    <div class="al4-checks" id="error_codes">
      <label><input type="checkbox" name="codes[]" value="DF226"> <strong>DF226</strong> — فشار روغن</label>
      <label><input type="checkbox" name="codes[]" value="DF049"> <strong>DF049</strong> — تنظیم فشار (EVM)</label>
      <label><input type="checkbox" name="codes[]" value="DF018"> <strong>DF018</strong> — لغزش کانورتور</label>
      <label><input type="checkbox" name="codes[]" value="DF017"> <strong>DF017</strong> — سولنوئید دبی مبدل</label>
      <label><input type="checkbox" name="codes[]" value="DF012"> <strong>DF012</strong> — برق سولنوئیدها</label>
      <label><input type="checkbox" name="codes[]" value="DF020"> <strong>DF020</strong> — روغن پیر</label>
      <label><input type="checkbox" name="codes[]" value="DF038"> <strong>DF038</strong> — سنسور دور توربین</label>
      <label><input type="checkbox" name="codes[]" value="DF048"> <strong>DF048</strong> — سنسور سرعت خروجی</label>
      <label><input type="checkbox" name="codes[]" value="DF023"> <strong>DF023</strong> — سنسور دمای روغن</label>
      <label><input type="checkbox" name="codes[]" value="DF005"> <strong>DF005</strong> — اول این را رفع کنید</label>
    </div>
  </div>
  <div class="al4-btn-row">
    <button type="button" class="al4-btn al4-btn-sec" data-goto="t1">→ قبلی</button>
    <button type="button" class="al4-btn al4-btn-main" data-goto="t3">ادامه ←</button>
  </div>
</div>

<div class="al4-panel" id="t3">
  <div class="al4-card">
    <h2><span class="num">1</span> علائم مشاهده‌شده</h2>
    <div class="al4-checks" id="symptoms">
      <label><input type="checkbox" name="symptoms[]" value="harsh_cold"> لگد زدن در حالت سرد</label>
      <label><input type="checkbox" name="symptoms[]" value="slip"> لیز خوردن گیربکس</label>
      <label><input type="checkbox" name="symptoms[]" value="hot_lock"> قفل شدن وقتی داغ می‌شود</label>
      <label><input type="checkbox" name="symptoms[]" value="limp"> حالت اضطراری (Limp Mode)</label>
      <label><input type="checkbox" name="symptoms[]" value="intermittent"> خطای گاه‌به‌گاه</label>
      <label><input type="checkbox" name="symptoms[]" value="slow_reverse"> دنده عقب کند</label>
      <label><input type="checkbox" name="symptoms[]" value="delayed"> تأخیر در درگیر شدن دنده</label>
      <label><input type="checkbox" name="symptoms[]" value="no_lockup"> عدم قفل کانورتور</label>
      <label><input type="checkbox" name="symptoms[]" value="overheat"> گرم شدن بیش از حد</label>
      <label><input type="checkbox" name="symptoms[]" value="metal"> براده فلزی در روغن</label>
    </div>
  </div>
  <div class="al4-btn-row">
    <button type="button" class="al4-btn al4-btn-sec" data-goto="t2">→ قبلی</button>
    <button type="button" class="al4-btn al4-btn-main" data-goto="t4">ادامه ←</button>
  </div>
</div>

<div class="al4-panel" id="t4">
  <div class="al4-card">
    <h2><span class="num">1</span> شرایط تست</h2>
    <div class="al4-field">
      <label>دمای روغن هنگام تست</label>
      <select id="oil_temp" name="oil_temp">
        <option value="">— انتخاب کنید —</option>
        <option value="cold">زیر ۴۰ درجه</option>
        <option value="low">۴۰ تا ۶۰ درجه</option>
        <option value="ideal">۶۰ تا ۹۰ درجه (ایده‌آل)</option>
        <option value="high">۹۰ تا ۱۱۰ درجه</option>
        <option value="critical">بالای ۱۱۰ درجه</option>
      </select>
    </div>
    <div class="al4-field">
      <label>ولتاژ باتری</label>
      <select id="battery" name="battery">
        <option value="">— انتخاب کنید —</option>
        <option value="low">زیر ۱۱.۸ ولت</option>
        <option value="ok">۱۱.۸ تا ۱۳.۲ ولت</option>
        <option value="high">بالای ۱۳.۲ ولت</option>
      </select>
    </div>
  </div>
  <div class="al4-card">
    <h2><span class="num">2</span> مقاومت شیرهای برقی</h2>
    <div class="al4-grid2">
      <div class="al4-field">
        <label>EVM — استاندارد: ۱ ± ۰.۱۲ اهم</label>
        <select id="res_evm" name="res_evm">
          <option value="">اندازه‌گیری نکردم</option>
          <option value="ok">در محدوده (سالم)</option>
          <option value="short">اتصال کوتاه</option>
          <option value="open">مدار باز</option>
          <option value="out">خارج از محدوده</option>
        </select>
      </div>
      <div class="al4-field">
        <label>EVLU — استاندارد: ۱ ± ۰.۱۲ اهم</label>
        <select id="res_evlu" name="res_evlu">
          <option value="">اندازه‌گیری نکردم</option>
          <option value="ok">در محدوده (سالم)</option>
          <option value="short">اتصال کوتاه</option>
          <option value="open">مدار باز</option>
          <option value="out">خارج از محدوده</option>
        </select>
      </div>
      <div class="al4-field">
        <label>EVS — استاندارد: ۴۰ ± ۲ اهم</label>
        <select id="res_evs" name="res_evs">
          <option value="">اندازه‌گیری نکردم</option>
          <option value="ok">در محدوده (سالم)</option>
          <option value="short">اتصال کوتاه</option>
          <option value="open">مدار باز</option>
          <option value="out">خارج از محدوده</option>
        </select>
      </div>
      <div class="al4-field">
        <label>دبی مبدل — استاندارد: ۴۰ ± ۴ اهم</label>
        <select id="res_flow" name="res_flow">
          <option value="">اندازه‌گیری نکردم</option>
          <option value="ok">در محدوده (سالم)</option>
          <option value="short">اتصال کوتاه</option>
          <option value="open">مدار باز</option>
          <option value="out">خارج از محدوده</option>
        </select>
      </div>
    </div>
  </div>
  <div class="al4-card">
    <h2><span class="num">3</span> تست فشار خط</h2>
    <div class="al4-field">
      <label>مقایسه مانومتر و دیاگ</label>
      <select id="press_compare" name="press_compare">
        <option value="">اندازه‌گیری نکردم</option>
        <option value="match">تقریباً یکی (اختلاف < ۰.۵ بار)</option>
        <option value="diff">اختلاف بیشتر از ۰.۵ بار</option>
        <option value="sensor_high">موتور خاموش ولی دیاگ > ۰.۲ بار</option>
      </select>
    </div>
    <div class="al4-field">
      <label>پایداری فشار EVM</label>
      <select id="press_stable" name="press_stable">
        <option value="">انجام ندادم</option>
        <option value="stable">پایدار (اختلاف < ۰.۲ بار)</option>
        <option value="unstable">ناپایدار (اختلاف > ۰.۲ بار)</option>
      </select>
    </div>
  </div>
  <div class="al4-card">
    <h2><span class="num">4</span> تست Stall</h2>
    <div class="al4-field">
      <label>دور نقطه‌ی توقف</label>
      <select id="stall" name="stall">
        <option value="">انجام ندادم</option>
        <option value="ok">حدود ۲۳۰۰ ± ۱۵۰ دور</option>
        <option value="low">پایین‌تر از محدوده</option>
        <option value="high">بالاتر یا صدای غیرعادی</option>
      </select>
    </div>
  </div>
  <div class="al4-btn-row">
    <button type="button" class="al4-btn al4-btn-sec" data-goto="t3">→ قبلی</button>
    <button type="button" class="al4-btn al4-btn-main" id="al4-run-btn">شروع تشخیص هوشمند</button>
  </div>
</div>

<div class="al4-panel" id="t5">
  <div id="al4-result" class="al4-res"></div>
  <div class="al4-card" style="margin-top:12px">
    <h2>بعد از تعمیر</h2>
    <div class="al4-steps">
      <div class="al4-step">پاک کردن خطاها از حافظه کامپیوتر</div>
      <div class="al4-step">صفر کردن یادگیری‌ها (RZ005)</div>
      <div class="al4-step">اگر روغن عوض شد: ثبت تاریخ + CF074</div>
      <div class="al4-step">سوئیچ را ببندید و دوباره باز کنید</div>
      <div class="al4-step">تست جاده با همه وضعیت‌های دسته‌دنده</div>
      <div class="al4-step">دوباره کدها را بخوانید</div>
    </div>
  </div>
  <div class="al4-btn-row">
    <button type="button" class="al4-btn al4-btn-sec" data-goto="t4">→ ویرایش</button>
    <button type="button" class="al4-btn al4-btn-main" id="al4-reset-btn">شروع مجدد</button>
  </div>
</div>

<p class="al4-footer-note">این ابزار راهنماست و جایگزین دیاگ و دفترچه تعمیرات نیست.</p>
</div>
