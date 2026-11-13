# AGENT.md — Elezone WordPress Theme

> **این فایل مرجع کامل پروژه است.** هر Agent یا توسعه‌دهنده‌ای که این قالب را برمی‌دارد، باید اول این فایل را بخواند.
>
> **📁 موقعیت این فایل:** `C:\Users\ArshamCoder\Desktop\custom-template\Elezone-Wordpress-Template\AGENT.md`
> **📁 موقعیت قالب:** `C:\Users\ArshamCoder\Desktop\custom-template\Elezone-Wordpress-Template\elezone-wp-theme\`
> **📁 مخزن Git:** `https://github.com/arshambh/Elezone-Wordpress-Template`
>
> این فایل **داخل قالب نیست** و نباید zip شود — سند پروژه است.

---

## ⚠️ قوانین الزامی (MANDATORY — قابل نقض نیست)

> **این قوانین بر تمام کارهای آینده روی این قالب حاکم است. هر Agent یا توسعه‌دهنده‌ای که این فایل را می‌خواند، موظف به رعایت آن‌هاست. نقض این قوانین = رد شدن کار.**

### قانون ۱ — رنگ‌بندی و اطلاعات برند از Customizer

**این قالب تک‌زبانه فارسی است و نیازی به ترجمه ندارد.** هدف از Customizer فقط این است که ادمین بتواند **ظاهر و اطلاعات برند** را بدون دست زدن به کد تغییر دهد.

#### مواردی که **باید** از Customizer خوانده شوند (اجباری)

1. **رنگ‌ها** — تمام ۳۹ رنگ در پنل `Elezone - Colors` (General, Header, Intro Band, CTA, Footer, Buttons, Social, Cards & Boxes, Footer Extras)
2. **لوگو** — هدر و فوتر در پنل `Elezone - Logo`
3. **اطلاعات تماس** — تلفن، موبایل، ایمیل، آدرس، ساعات کاری، نقشه در پنل `Elezone - Contact & Social`
4. **شبکه‌های اجتماعی** — واتساپ، تلگرام، اینستاگرام، فیسبوک
5. **محتوای معرفی** — `intro_title`, `intro_text`, `cta_text`, `cta_phone`

#### مواردی که **hardcoded** می‌مانند (نیازی به Customizer ندارند)

- **برچسب‌های UI** — متن دکمه‌ها، عنوان سکشن‌ها، placeholderها، متن‌های خالی‌بودن
- **متن‌های ساختاری** — مثل «ثبت نظر»، «راه‌های ارتباطی دیگر»، «همه پروژه‌ها»، «صفحه اصلی» در breadcrumb
- **پیام‌های سیستمی** — success/error فرم، no-results، 404
- **متن‌های نمونه Starter Content**

#### روش افزودن مقدار جدید به Customizer (فقط برای ۶ مورد بالا)

1. فیلد در `inc/customizer.php` در پنل مربوطه ثبت شود
2. default در `elezone_defaults()` در `functions.php` اضافه شود
3. با `elezone_get_option( '<key>' )` در partial مصرف شود
4. sanitize مناسب: `esc_url_raw` (URL) / `sanitize_email` (ایمیل) / `sanitize_textarea_field` (textarea) / `sanitize_text_field` (بقیه)
5. لیست فیلدهای پنل در `AGENT.md` به‌روز شود

#### درباره‌ی `esc_html_e()` و ترجمه

این قالب **تک‌زبانه است** و نیازی به فایل ترجمه ندارد. اما:
- `esc_html_e( 'متن', 'elezone' )` در کد فعلی **بی‌خطر است** و می‌تواند بماند — کارکردش مثل `echo 'متن'` است چون فایل ترجمه بارگذاری نمی‌شود
- **حذف آن اولویت ندارد** و ریسک بی‌مورد دارد؛ فقط اگر فایل دستکاری شد به `esc_html( 'متن' )` یا `echo 'متن'` تغییر کند
- فایل‌های `languages/fa_IR.po` و `.mo` می‌توانند بمانند (بی‌خطر) یا حذف شوند (تصمیم ادمین)

#### نمونه‌ی صحیح (اطلاعات برند)

```php
// ✅ درست
$address = elezone_get_option( 'address' );
if ( $address ) {
    echo '<p>' . esc_html( $address ) . '</p>';
}
```

#### نمونه‌ی ممنوع (اطلاعات برند hardcoded)

```php
// ❌ ممنوع
<p>استان تهران، سعادت‌آباد، خیابان آزادگان</p>
<a href="tel:09304567896">09304567896</a>
<a href="#"><i class="fab fa-whatsapp"></i></a>
```

#### نمونه‌ی مجاز (برچسب UI hardcoded)

```php
// ✅ مجاز و طبیعی
<button class="btn btn-warning">ارسال پیام</button>
<h3>راه‌های ارتباطی دیگر</h3>
<input placeholder="نام">
```

### قانون ۲ — افزونه‌های الزامی هنگام نصب

**قالب Elezone برای کارکرد کامل به افزونه‌های زیر نیاز دارد. هنگام فعال‌سازی قالب، کاربر باید حتماً از نصب و فعال‌سازی این افزونه‌ها مطلع شود.**

| افزونه | نسخه حداقلی | کاربرد در قالب | وضعیت |
|---|---|---|---|
| **Contact Form 7** (`contact-form-7`) | **6.2.5** (حداقل) | موتور فرم صفحه‌ی «تماس با ما» (`page-contact.php`) | **الزامی** |
| **WP Mail SMTP** (`wp-mail-smtp`) | 3.0 | افزایش تحویل‌پذیری ایمیل‌های فرم تماس | 🟡 توصیه‌شده (اعلان ندارد — در README/مستندات ذکر شده) |

#### پیاده‌سازی اعلان (MANDATORY)

- فایل `inc/required-plugins.php` مسئول تشخیص و اعلان است.
- اگر CF7 **نصب نباشد** → اعلان قرمز با دکمه‌ی «نصب Contact Form 7» (لینک مستقیم به `update.php?action=install-plugin`).
- اگر CF7 **نصب باشد ولی فعال نباشد** → همان اعلان با دکمه‌ی «فعال‌سازی Contact Form 7» (لینک مستقیم به `plugins.php?action=activate`).
- اگر CF7 **فعال باشد** → هیچ اعلانی نمایش داده نمی‌شود.
- این اعلان باید **در همه‌ی صفحات پیشخوان** نمایش داده شود (نه فقط صفحه‌ی قالب) — از `admin_notices` استفاده کن.
- علاوه بر آن، یک اعلان جدا در صفحه‌ی **نمایش → پوسته‌ها** با پیام فعال‌سازی قالب نمایش داده شود.

#### قوانین توسعه

1. **هنگام افزودن هر افزونه‌ی الزامی جدید** (به هر دلیلی در آینده):
   - تابع `elezone_required_<slug>_active()` بساز
   - اعلان مربوطه را به `elezone_required_plugin_notice()` اضافه کن
   - به جدول بالا در `AGENT.md` اضافه کن
2. **اعلان باید غیرقابل بستن (not dismissible)** باشد تا کاربر واقعاً متوجه شود (به‌جز اعلان صفحه‌ی themes که dismissible است).
3. **در `README.md`** و متن بازاریابی قالب، این افزونه‌ها باید به‌عنوان «نیازمندی‌ها» ذکر شوند.

#### چک‌لیست الزامی (قبل از هر انتشار)

- [ ] آیا در صفحه‌ی نصب/فعال‌سازی، افزونه‌های الزامی به کاربر اعلام می‌شود؟
- [ ] آیا اعلان install/activate درست کار می‌کند (نصب‌شده ولی غیرفعال → پیام فعال‌سازی)؟
- [ ] آیا در `README.md` ذکر شده؟

### قانون ۳ — ممنوعیت commit خودکار (MANDATORY — قابل نقض نیست)

**هر Agent یا توسعه‌دهنده‌ای که روی این پروژه کار می‌کند، حق ندارد بدون اجازه‌ی صریح کاربر commit، push، tag، یا هر عملیات Git دیگری انجام دهد.**

#### قوانین دقیق

1. **هرگز بدون دستور صریح کاربر** این کارها را انجام نده:
   - `git commit`
   - `git push`
   - `git add` (به‌جز حالتی که کاربر خودش گفته "stage کن")
   - `git tag`
   - `git reset --hard`
   - `git clean`
   - `git rebase`
   - `git merge`
   - `git stash pop/drop`
   - `git cherry-pick`
   - هر دستور دیگری که تاریخچه یا working tree را تغییر می‌دهد

2. **اعمال تغییرات فایل (write/edit) مجاز است** — این‌ها فقط روی دیسک کار می‌کنند و با git تعاملی ندارند.

3. **مشاهده‌ی وضعیت Git (read-only) مجاز است** — این دستورات بی‌خطرند:
   - `git status`
   - `git log`
   - `git diff`
   - `git show`
   - `git branch` (فقط برای دیدن لیست)

4. **قبل از هر commit، حتماً باید از کاربر بپرسی و تأیید بگیری:**
   - پیام commit پیشنهادی را نشان بده
   - لیست فایل‌های تغییر یافته را نشان بده
   - منتظر تأیید صریح بمان (مثلاً «بله commit کن»، «commit کن»، «انجام بده»)

5. **اگر کاربر در حین کار گفت «commit کن» یا «پروژه رو commit کن»** — این مجوز صریح است و می‌توانی انجام دهی.

6. **اگر فقط گفتی «کار تمام شد» بدون دستور commit** — این به معنی اجازه‌ی commit نیست. فقط فایل‌ها را تغییر بده و گزارش بده.

#### چک‌لیست الزامی (قبل از هر commit)

- [ ] آیا کاربر صریحاً گفته «commit کن» یا معادل آن؟
- [ ] آیا پیام commit را به کاربر نشان داده‌ام؟
- [ ] آیا لیست فایل‌های تغییر یافته را به کاربر نشان داده‌ام؟
- [ ] آیا تأیید صریح کاربر را گرفته‌ام؟

**اگر پاسخ هر یک از این سؤال‌ها «خیر» است → حق commit کردن نداری.**

### قانون ۴ — هر سکشن جدید باید به پنل Sections اضافه شود (MANDATORY — قابل نقض نیست)

**هر بار که یک سکشن جدید (partial یا بخش قابل نمایش) به قالب اضافه می‌شود، باید حتماً چک‌باکس نمایش/مخفی در پنل `Elezone - Sections` هم برای آن ثبت شود.**

#### قوانین دقیق

1. **هنگام ساخت هر partial جدید در `template-parts/`:**
   - یک کلید یکتا برایش انتخاب کن (مثلاً `hero`, `about_stats`, `contact_form`)
   - در فایل `inc/visibility.php`، در آرایه‌ی `$groups` و در گروه مربوطه (home / about / contact / یا گروه جدید) یک آیتم اضافه کن:
     ```php
     'my_new_section' => __( 'My New Section', 'elezone' ),
     ```
   - در ابتدای partial، guard اضافه کن:
     ```php
     if ( ! elezone_is_section_visible( 'my_new_section' ) ) {
         return;
     }
     ```

2. **هنگام ساخت یک صفحه‌ی جدید با Page Template (مثل `page-contact.php`):**
   - برای هر partial قابل نمایش در آن صفحه، کلید مستقل تعریف کن
   - گروه جدید در `$groups` بساز (مثلاً `'services_page' => [...]`)

3. **هنگام ادغام چند partial در یک سکشن واحد:**
   - می‌توان یک کلید مشترک برایشان تعریف کرد (مثلاً `projects_interior` که هم در `home` و هم در جای دیگر استفاده می‌شود)
   - یا برای هر یک کلید جداگانه بگذار

4. **پیش‌فرض همیشه `true` (نمایش داده شود)** — کاربران فعلی بدون تغییر رفتار، سکشن جدید را می‌بینند.

#### چک‌لیست الزامی (قبل از پایان هر کار روی سکشن)

- [ ] آیا partial جدید در `template-parts/` ساخته شد؟
- [ ] آیا در `inc/visibility.php` یک کلید `elezone_show_<name>` برایش تعریف شد؟
- [ ] آیا در ابتدای partial، guard `elezone_is_section_visible( '<name>' )` اضافه شد؟
- [ ] آیا پیش‌فرض آن در `add_setting` روی `true` است؟
- [ ] آیا در `AGENT.md` (بخش «نمایش/مخفی هر سکشن») لیست شد؟

**اگر پاسخ هر یک «خیر» است → کار ناقص است و نباید تحویل داده شود.**

#### نمونه‌ی صحیح

```php
// In inc/visibility.php:
'about' => array(
    'title' => __( 'About Page', 'elezone' ),
    'items' => array(
        'about_goals'   => __( 'Goals Column', 'elezone' ),
        'about_manager' => __( 'Manager Column', 'elezone' ),
        'about_stats'   => __( 'Stats Band', 'elezone' ),
        'about_awards'  => __( 'Awards Section', 'elezone' ),
    ),
),

// At top of template-parts/about/goals.php:
if ( ! elezone_is_section_visible( 'about_goals' ) ) {
    return;
}
```

---

## 📦 مشخصات پروژه

| مورد | مقدار |
|---|---|
| **نام تجاری** | `Elezone` |
| **Text Domain** | `elezone` |
| **نسخه** | `1.0.0` |
| **سازنده** | ArshamCoder |
| **نوع** | قالب شرکتی/معماری فارسی (RTL) |
| **پوشه قالب** | `elezone-wp-theme` |
| **پیشوند theme_mods** | `elezone_*` |
| **پیشوند توابع** | `elezone_*` |
| **پیشوند ثابت‌ها** | `ELEZONE_*` |
| **پیشوند کلاس‌ها** | `Elezone_*` |
| **وضعیت Git** | ۶ commit، همه push شده به `origin/main` |

---

## 🗂 ساختار پوشه‌ها

```
Elezone-Wordpress-Template/          ← ریشه مخزن Git
├── .git/
├── .gitignore                       ← اصلاح‌شده (Icon? → Icon)
├── AGENT.md                         ← این فایل
├── init-prompt.txt                  ← متن درخواست اولیه‌ی ساخت قالب
├── elezone-wp-theme.zip             ← zip آماده‌ی نصب (~۶۰ MB)
├── Sample-HTML/                     ← ⭐ مرجع اصلی HTML/CSS/JS که قالب از آن ساخته شده
│   ├── index.html                   # صفحه اصلی (۱۱ سکشن)
│   ├── Aboutus2.html                # درباره ما
│   ├── blog_grid.html               # گرید وبلاگ
│   ├── blog_destails.html           # جزئیات پست (تایپو در نام فایل: details)
│   ├── Contactus2.html              # تماس با ما
│   └── Css/ Fonts/ Img/ Js/         # دارایی‌های مرجع
└── elezone-wp-theme/                ← پوشه قالب وردپرس
    ├── style.css                    # شناسنامه قالب (Theme Name: Elezone)
    ├── functions.php                # bootstrap + helperها + ۲ migration
    ├── README.md                    # راهنمای نصب سریع
    ├── docs/
    │   └── CF7-SETUP.md             # راهنمای نصب و پیکربندی Contact Form 7
    ├── header.php                   # سکشن هدر (RTL، Mega Menu، جستجو)
    ├── footer.php                   # سکشن فوتر (۴ ستون + سوشال)
    ├── front-page.php               # صفحه اصلی (۱۱ سکشن)
    │
    ├── index.php                    # فهرست پست‌ها (fallback)
    ├── page.php                     # برگه ساده
    ├── page-contact.php             # ⭐ تماس با ما (Page Template)
    ├── page-about.php               # ⭐ درباره ما (Page Template)
    ├── single.php                   # پست تکی
    ├── single-project.php           # ⭐ صفحه جزئیات پروژه
    ├── single-service.php           # ⭐ صفحه جزئیات خدمت
    ├── archive.php                  # آرشیو عمومی
    ├── archive-project.php          # ⭐ آرشیو پروژه‌ها با فیلتر
    ├── archive-service.php          # ⭐ آرشیو خدمات
    ├── search.php                   # نتایج جستجو
    ├── searchform.php               # فرم جستجوی استاندارد
    ├── 404.php                      # صفحه خطا
    ├── comments.php                 # قالب نظرات
    │
    ├── inc/
    │   ├── theme-setup.php          # supports، menus، image sizes، sidebars
    │   ├── enqueue.php              # CSS/JS + inline style رنگ‌ها و لوگو
    │   ├── cpt.php                  # CPTها + taxonomy
    │   ├── customizer.php           # پنل Logo + Contact & Social
    │   ├── colors.php               # پنل رنگ‌ها (۳۹ رنگ در ۹ دسته)
    │   ├── project-meta.php         # متاباکس پروژه (مدت/شهر/متراژ/سنگ)
    │   ├── class-mega-menu-walker.php # Walker منوی هدر + Walker فوتر
    │   ├── starter-content.php      # ⭐ صفحه ادمین Starter + import تصویر
    │   ├── starter-content-data.php # ⭐ توابع ساخت نمونه‌ها
    │   ├── cf7-integration.php      # ⭐ یکپارچه‌سازی CF7 + اعتبارسنجی موبایل ایران
    │   ├── comment-phone.php        # ⭐ فیلد موبایل اجباری نظرات + ایمیل اختیاری
    │   ├── required-plugins.php     # ⭐ چک و اعلان افزونه‌های الزامی (CF7)
    │   ├── visibility.php           # ⭐ کلیدهای نمایش/مخفی سکشن‌ها (قانون ۴)
    │   ├── jalali-date.php          # تبدیل تاریخ شمسی برای نمایش در قالب
    │   ├── starter-generator.php    # ⭐ تولید داده نمونه دلخواه (v1.2.0)
    │   └── woocommerce.php          # ⭐ یکپارچه‌سازی WooCommerce (v1.1.0)
    │
    ├── template-parts/
    │   ├── header/offcanvas.php     # منوی موبایل آفلاین
    │   ├── home/                    # ۸ partial صفحه اصلی
    │   │   ├── hero-slider.php
    │   │   ├── benefits.php
    │   │   ├── brand-block.php
    │   │   ├── projects-carousel.php # reusable (interior/facade)
    │   │   ├── intro-band.php
    │   │   ├── services.php
    │   │   ├── cta-band.php
    │   │   └── blog-grid.php
    │   ├── cards/project-card.php   # کارت پروژه (variant-aware)
    │   ├── cards/product-card.php   # ⭐ کارت محصول WooCommerce (v1.1.0)
    │   ├── contact/                 # partialهای صفحه تماس
    │   │   ├── form.php             # فرم (nonce + honeypot + transient message)
    │   │   ├── info.php             # اطلاعات تماس از Customizer
    │   │   └── map.php              # نقشه اگر URL در Customizer پر باشد
    │   ├── about/                   # ⭐ جدید — partialهای صفحه درباره ما
    │   │   ├── goals.php            # ستون اهداف (لیست تیک‌دار)
    │   │   ├── manager.php          # ستون مدیریت (تصویر + سمت + سابقه + تحصیلات)
    │   │   ├── stats.php            # نوار آمار (number|label)
    │   │   └── awards.php           # جوایز و افتخارات
    │   ├── hero/                    # banner مشترک
    │   │   └── banner.php           # hero + breadcrumb (args-driven)
    │   ├── blog/                    # ⭐ جدید — partialهای صفحه وبلاگ
    │   │   ├── post-card.php        # کارت پست در گرید
    │   │   └── sidebar.php          # ستون کنار (دسته‌ها/آخرین/تبلیغ/برچسب‌ها)
    │   └── footer/                  # (رزرو — خالی)
    │
    ├── assets/
    │   ├── Css/                     # ۷ فایل (بعد از پاکسازی)
    │   │   ├── Main.css             # Bootstrap 4.1.1 + FontAwesome Pro
    │   │   ├── Style.css            # IRANSans @font-face + استایل اصلی
    │   │   ├── Menu.css             # Mega Menu
    │   │   ├── owl.carousel.min.css
    │   │   ├── owl.theme.min.css
    │   │   ├── hoverimg.css
    │   │   └── WooCommerce.css      # ⭐ استایل فروشگاه (v1.1.0)
    │   ├── Js/                      # ۵ فایل (بعد از پاکسازی)
    │   │   ├── bootstrap.min.js
    │   │   ├── Custom.js            # search, mobile menu, sticky
    │   │   ├── customizer.js        # دکمه‌های ریست رنگ
    │   │   ├── init.js              # راه‌اندازی Owl Carousel ⭐
    │   │   └── owl.carousel.js
    │   ├── Img/                     # ۹۱ + ۱۳ icons + ۲۲ Shot
    │   │   ├── Logo.png, logomiddle.png, 456.png, service.png
    │   │   ├── slide8.jpg, slide9.jpg
    │   │   ├── grid-img*.jpg, 1.jpg, 2.jpg, 4.jpg, 13.jpg, 14.jpg, 16.jpg
    │   │   ├── icons/               # ۱۳ آیکون (commit شده ✅)
    │   │   └── Shot/                # ۲۲ اسکرین‌شات دموها
    │   └── Fonts/                   # ۱۹ فایل (IRANSans + FontAwesome woff2)
    │
    ├── woocommerce/                 # ⭐ overrideهای WooCommerce (v1.1.0)
    │   ├── archive-product.php
    │   ├── content-product.php
    │   ├── content-single-product.php
    │   └── single-product.php
    └── languages/
        ├── fa_IR.po                 # ترجمه منبع (۵.۰۱ KB، ۷۲ رشته)
        └── fa_IR.mo                 # ✅ کامپایل‌شده (۴.۹۱۹ KB، magic 0x950412DE)
```

---

## 🎯 قابلیت‌های پیاده‌شده

### ۱. ساختار محتوا
- **CPT `project`** — با taxonomy `project_type` (`interior` / `facade`)
- **CPT `service`**
- **CPT `slide`** — برای اسلایدر هیرو
- **CPT `benefit`** — برای نوار مزایا
- **متاباکس اختصاصی پروژه:** `project_duration`, `project_city`, `project_area`, `project_stone`

### ۲. صفحه اصلی (۱۱ سکشن)
1. Off-canvas mobile menu (partial)
2. Header — Mega Menu + جستجو + sticky
3. Hero Slider — Owl Carousel
4. Benefits strip — ۶ آیتم
5. Brand image block — تصویر بزرگ
6. Interior projects carousel — ۵ کارت
7. Intro band — متن از Customizer
8. Services — ۳ خدمت
9. CTA band — دکمه تماس
10. Facade projects carousel — ۵ کارت
11. Blog grid — ۴ پست آخر وردپرس
12. Footer — ۴ ستون + سوشال

**همه سکشن‌ها fallback دارند:** اگر CPT خالی باشد، همان محتوای HTML اصلی نمایش داده می‌شود.

### ۲.۰. فرم نظرات (نظرات پست وبلاگ)

**فرم نظر وردپرس** با استایل دقیق مطابق `Sample-HTML/blog_destails.html`:

- **ترتیب فیلدها:** نام و نام خانوادگی → شماره همراه → ایمیل (اختیاری) → متن نظر
- **فیلد وب‌سایت (URL) حذف شده**
- **موبایل اجباری** با اعتبارسنجی ایران (regex: `^(?:\+98|0098|0)?9\d{9}$`)
- **ایمیل اختیاری** (با `option_require_name_email` غیرفعال)
- **موبایل در کوکی** (`comment_author_phone`) ذخیره می‌شود تا بازدیدکننده‌ی بعدی دوباره تایپ نکند
- **موبایل به‌عنوان comment_meta** با کلید `phone` ذخیره می‌شود
- **پیاده‌سازی:** `inc/comment-phone.php` (اعتبارسنجی + فیلتر `comment_form_fields`)
- **CSS:** بلوک Comments در `Style.css` (`.comment-form-phone`, `#respond .comment-form-phone input`)

### ۲.۱. صفحه تماس با ما (`page-contact.php`)

- **Template Name:** «تماس با ما» — از ادیتور Page قابل انتخاب (Page Attributes → Template)
- **ترکیب partialها:**
  - `template-parts/hero/banner.php` — hero + breadcrumb (args: `title`، `crumbs[]`)
  - `template-parts/contact/form.php` — فرم با nonce + honeypot + پیام transient
  - `template-parts/contact/info.php` — آدرس/ساعات/تلفن/ایمیل/شبکه‌ها از Customizer
  - `template-parts/contact/map.php` — نقشه Google (فقط اگر `elezone_map_embed` پر باشد)
- **فرم تماس:** POST به `admin-post.php` → action `elezone_contact` → `elezone_handle_contact_submission()`
- **امنیت:** nonce + honeypot (`elezone_contact_website`) + rate-limit ۳۰ ثانیه‌ای per IP + sanitize کامل
- **Redirect:** پیام از transient (کلید `elezone_contact_msg_<ip_hash>`) خوانده می‌شود و با `?elezone_contact=success|error` نمایش داده می‌شود

### ۳. Customizer

#### پنل Elezone - Logo (بخش مستقل)
- `elezone_logo_header` — آپلود لوگوی هدر
- `elezone_logo_width` — عرض (۴۰–۳۲۰px، پیش‌فرض ۱۲۰)
- `elezone_logo_position` — `start` / `center` / `end`
- `elezone_logo_footer` — آپلود لوگوی فوتر (خالی = استفاده از هدر)
- `elezone_logo_width_footer` — عرض فوتر (۴۰–۴۰۰px، پیش‌فرض ۱۵۰)

**ترتیب اولویت:** Logo section → Site Identity → `Img/Logo.png` پیش‌فرض

#### پنل Elezone - Colors (۳۹ رنگ در ۹ دسته)
| دسته | تعداد | نمونه |
|---|---|---|
| General | ۵ | Primary, Body bg/text, Link/Hover |
| Header | ۹ | Outer/Inner, Sticky, Menu, Submenu |
| Intro Band | ۱ | Intro background |
| CTA | ۴ | Background, Text, Button |
| Footer | ۵ | Background, Text, Link, Heading |
| Buttons | ۲ | Primary button bg/text |
| Social | ۴ | WhatsApp, Telegram, Instagram, Facebook |
| Cards & Boxes | ۵ | sbox, card body, line |
| Footer Extras | ۴ | newsletter, copyright, intro text |

**دکمه‌های ریست:**
- **↺ تکی** کنار هر فیلد → مقدار آن رنگ را خالی می‌کند
- **↺ Reset all colors** بالای پنل → همه را صفر می‌کند (با `confirm`)

#### پنل Elezone - Blog (۴ فیلد متنی + ۱ تصویر)
`blog_page_banner_title` (پیش‌فرض: وبلاگ), `blog_page_tagline` (پیش‌فرض: مقالات سایت), `blog_page_title` (پیش‌فرض: دسته مقالات مربوط به مهندسی سازه), `single_page_banner_title` (پیش‌فرض: جزئیات مطالب), `blog_sidebar_ad_image` (تصویر تبلیغات sidebar)

#### پنل Elezone - About (۱۴ فیلد + ۲ تصویر)
`about_goals_tagline`, `about_goals_title`, `about_goals_items` (textarea، هر خط یک آیتم), `about_manager_tagline`, `about_manager_name`, `about_manager_position`, `about_manager_experience`, `about_manager_education`, `about_manager_image` (image), `about_stats_items` (textarea، فرمت `number|label`), `about_awards_tagline`, `about_awards_title`, `about_awards_text`, `about_awards_image` (image)

#### پنل Elezone - Sections (۱۶ چک‌باکس → ۲۲ پس از اضافه شدن Blog)

**گروه Home** (۹): `hero`, `benefits`, `brand`, `projects_interior`, `intro`, `services`, `cta`, `projects_facade`, `blog`

**گروه About** (۴): `about_goals`, `about_manager`, `about_stats`, `about_awards`

**گروه Contact** (۳): `contact_form`, `contact_info`, `contact_map`

**گروه Blog Grid Page** (۲): `blog_page_banner`, `blog_page_grid`

**گروه Single Blog Post** (۴): `single_banner`, `single_sidebar`, `single_content`, `single_share`

#### پنل Elezone - Contact & Social (۱۵ فیلد — شامل cf7_form_id)
`phone`, `mobile`, `email`, `address`, `business_hours`, `map_embed`, `cf7_form_id`, `cta_text`, `cta_phone`, `intro_title`, `intro_text`, `social_whatsapp`, `social_telegram`, `social_instagram`, `social_facebook`

### ۴. Starter Content
**نمایش → Elezone Starter**
- 🚀 **نصب نمونه محتوا** — ۲۵ آیتم با یک کلیک:
  - ۲ اسلاید، ۶ مزیت، ۳ خدمت، ۵ پروژه داخلی، ۵ پروژه نما، ۴ پست
- 🗑️ **حذف نمونه‌ها** — فقط آیتم‌های علامت‌دار `_elezone_starter=1` حذف می‌شوند
- تصاویر از `assets/Img/` به کتابخانه رسانه کپی می‌شوند با متای `_elezone_source_image`

### ۵. Migrationها

#### `elezone_migrate_legacy_settings()`
- یک‌بار اجرا (`elezone_migration_done` flag)
- کلیدهای `arsham_*` را به `elezone_*` کپی می‌کند
- برای حفظ تنظیمات تستی قبل از rename تجاری

#### `elezone_migrate_from_old_theme_folder()`
- یک‌بار اجرا (`elezone_folder_migration_done` flag)
- `theme_mods_wp-theme` را به `theme_mods_elezone-wp-theme` کپی می‌کند
- برای حفظ تنظیمات بعد از rename پوشه
- در نصب تازه، به‌خاطر flag هیچ کاری نمی‌کند

---

## 🔧 راه‌اندازی نصب

### ۱. آپلود قالب
```
elezone-wp-theme/ → zip (style.css در ریشه)
پیشخوان → نمایش → پوسته‌ها → افزودن → بارگذاری → جایگزینی
```

### ۲. نصب افزونه‌های الزامی
- **Contact Form 7** — **الزامی**. هنگام فعال‌سازی قالب، اعلانی در پیشخوان ظاهر می‌شود با دکمه‌ی «نصب» یا «فعال‌سازی».
- بدون این افزونه، فرم صفحه‌ی «تماس با ما» کار نمی‌کند (نقشه و اطلاعات تماس کار می‌کنند، ولی فرم تماس نمایش داده نمی‌شود).
- پس از نصب و فعال‌سازی، یک بار به پیشخوان برو تا فرم «Elezone Contact» خودکار ساخته شود.

### ۳. تنظیمات اولیه (اجباری)
- **تنظیمات → پیوندهای یکتا → «نام نوشته» → ذخیره**
  *(بدون این، آرشیو پروژه/خدمت ۴۰۴ می‌دهد)*
- **تنظیمات → عمومی → زبان سایت = فارسی**
- **کاربران → پروفایل خود → زبان = فارسی**

### ۳. منوها (اجباری)
**نمایش → فهرست‌ها** — سه منو:

| منو | جایگاه |
|---|---|
| Primary | `Primary (Mega Menu)` |
| Footer Demos | `Footer - Demos column` |
| Footer Quick | `Footer - Quick links column` |

### ۴. محتوای نمونه (توصیه)
**نمایش → Elezone Starter → 🚀 نصب نمونه محتوا**

### ۵. شخصی‌سازی
**نمایش → سفارشی‌سازی:**
- `Elezone - Logo` — لوگوی هدر/فوتر مستقل
- `Elezone - Colors` — ۳۹ رنگ
- `Elezone - Contact & Social` — تلفن/آدرس/سوشال

---

## 🛒 یکپارچه‌سازی WooCommerce (v1.1.0)

> قوانین ۱، ۲ و ۴ در این بخش رعایت شده‌اند.

### فایل‌های افزوده‌شده

| فایل | نقش |
|---|---|
| `inc/woocommerce.php` | ماژول کامل: theme support، wrapperها، sidebar فروشگاه، enqueue شرطی، اعلان الزامی WooCommerce |
| `template-parts/cards/product-card.php` | کارت محصول با حفظ کامل hookهای WC |
| `woocommerce/archive-product.php` | آرشیو محصولات (shop/category/tag) با banner و sidebar |
| `woocommerce/content-product.php` | آیتم حلقه با `wc_product_class()` |
| `woocommerce/single-product.php` | پوستهٔ صفحهٔ محصول |
| `woocommerce/content-single-product.php` | محتوای محصول با حفظ کامل hookها |
| `assets/Css/WooCommerce.css` | استایل فروشگاه بر پایهٔ توکن‌های رنگ قالب |

### کلیدهای نمایش/مخفی جدید (قانون ۴)

**گروه Shop Archive:**
- `shop_page_banner` — partial `template-parts/hero/banner` در `archive-product.php`
- `shop_page_sidebar` — `elezone_wc_shop_sidebar()` در `archive-product.php` (با استفاده از ساختار و کلاس‌های سایدبار وبلاگ)
- `shop_page_grid` — بلوک `woocommerce_product_loop_start()` … `woocommerce_product_loop_end()` در `archive-product.php`

**گروه Single Product:**
- `product_page_banner` — partial `template-parts/hero/banner` در `single-product.php`
- `product_page_sidebar` — `elezone_wc_product_sidebar()` در `single-product.php` (سایدبار ستون چپ با ساختار وبلاگ؛ اگر غیرفعال باشد، `col-12` استفاده می‌شود)
- `product_page_related` — `remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 )` روی `template_redirect`

**سایدبار جدید ثبت‌شده:** `elezone-product-sidebar` (در `widgets_init`). اگر ویجت نداشته باشد، به `product_search` fallback می‌کند.

### سازگاری WooCommerce

- فقط از `wc_get_product()` / `wc_get_products()` / `WC_Product_Query` استفاده می‌شود — هیچ `WP_Query( post_type=product )` یا کوئری مستقیم `$wpdb`.
- تمام `do_action()`های WooCommerce در template overrideها حفظ شده‌اند (hooks-first).
- `wc-cart-fragments` فقط در صفحات فروشگاه/سبد/تسویه/حساب کاربری لود می‌شود.
- اعلان نصب/فعال‌سازی WooCommerce در همهٔ صفحات پیشخوان (غیرقابل بستن، به‌جز صفحهٔ پوسته‌ها).

### نکات باز

- فایل CSS از `var(--elezone-*, fallback)` استفاده می‌کند؛ در صورت تفاوت نام متغیرها در `assets/Css/Style.css`، فقط بلوک `.woocommerce { --ez-*: ... }` ابتدای فایل باید هم‌تراز شود.
- آرگومان‌های `template-parts/hero/banner.php` فرض شده `title` و `crumbs` هستند (طبق AGENT.md)؛ در صورت تفاوت، فراخوانی‌ها در `archive-product.php` و `single-product.php` اصلاح شود.

---

## 🎲 تولید داده نمونه دلخواه (v1.2.0)

> صفحهٔ **نمایش → Elezone Starter** حالا یک پنل «تولید داده نمونه دلخواه» هم دارد.

### فایل جدید

`inc/starter-generator.php` — UI، handler و ۵ generator:

| هدف | post_type | ویژگی |
|---|---|---|
| پست | `post` | دستهٔ «نمونه»، تصویر شاخص |
| برگه | `page` | متن نمونه |
| پروژه | `project` | متا: مدت، شهر، متراژ، سنگ؛ ترم `project_type` |
| خدمت | `service` | متن نمونه |
| **محصول (متغیر)** | `product` | رنگ‌ها به‌صورت `pa_color` با ورییشن‌های مستقل، گارانتی `pa_warranty`، قیمت، تخفیف، موجودی، SKU، تصویر مجزا |

### آنچه هر محصول می‌گیرد

- نام فارسی از پیش‌تعریف‌شده
- توضیح کوتاه + مشخصات فنی
- دسته‌بندی محصول
- **ویژگی رنگ** با ۱ تا ۷ ورییشن، هر کدام با قیمت، تخفیف، موجودی، SKU و تصویر اختصاصی
- **ویژگی گارانتی** (اختیاری) با مقدار ۱۲/۲۴/۳۶ ماه
- ۳ محصول اول featured
- در صورت نبود WooCommerce، اعلان داده و محصول ساخته نمی‌شود

### سازگاری

- تمام محصولات از `WC_Product_Variable` / `WC_Product_Variation` / `WC_Product_Attribute` استفاده می‌کنند — هیچ `wp_insert_post( post_type=product )`.
- ویژگی‌ها (`pa_color` / `pa_warranty`) با `wc_create_attribute()` ساخته می‌شوند و در صورت وجود، از دیتابیس خوانده می‌شوند.
- `WC_Product_Variable::sync()` بعد از ساخت ورییشن‌ها صدا زده می‌شود.
- همهٔ آیتم‌ها با `_elezone_starter = 1` و `_elezone_generator = '<target>'` مارک می‌شوند.
- دکمهٔ «حذف نمونه‌ها» حالا `product` و `page` را هم پاک می‌کند (تغییر در `starter-content.php`).

---

## 🐛 باگ‌هایی که رفع شدند (مرجع کامل)

| # | باگ | نحوه پیدا کردن | رفع |
|---|---|---|---|
| 1 | اسلایدرها مخفی بودند (Owl هیچ‌جا init نمی‌شد) | بررسی `Custom.js`/`Menu.js` | `assets/Js/init.js` نوشته شد |
| 2 | `<html>` بدون `dir="rtl"` | بازبینی HTML | در `header.php` اضافه شد |
| 3 | `<title>` خالی | بازبینی | `add_theme_support('title-tag')` |
| 4 | ۴ `<h1>` تکراری در صفحه اصلی | بازبینی SEO | `<h2>` + `<h1 sr-only>` |
| 5 | `post_type=product` هاردکد در فرم جستجو | بازبینی | حذف شد |
| 6 | `<section>` تودرتو در سکشن معرفی | بازبینی | ساده‌سازی |
| 7 | آیکون فلش هاردکد در فوتر | بازبینی | Walker خودکار تزریق می‌کند |
| 8 | لینک‌های `.html` منو | بازبینی | `wp_nav_menu` |
| 9 | Missing quote در migration keys (`'social_whatsapp` → `social_whatsapp'`) | `php -l` | رفع شد |
| 10 | `starter-content.php` در `functions.php` require نشده بود | `search_regex` | ۲ خط require اضافه شد |
| 11 | `Menu.js` حذف شد ولی هنوز در `enqueue.php` لود می‌شد | `findstr` | enqueue حذف شد |
| 12 | **`.gitignore` الگوی `Icon?`** — ۱۳ آیکون بی‌صدا از گیت خارج شدند | `git status` + `check-ignore` | `Icon?` → `Icon` |
| 13 | **۱۳ آیکون در گیت نبودند** | `git ls-tree` | commit جداگانه `3462b4e` |
| 14 | **`Contactus2.html`** فیلدهای نام و ایمیل خارج از `<form>` بودند | خواندن نمونه قبل از پیاده‌سازی | هر دو فیلد داخل `<form>` (بازسازی ساختار) |
| 15 | **`customizer.php`** فیلد `address` با `sanitize_text_field` به‌جای `sanitize_textarea_field` sanitize می‌شد | بازبینی کد | sanitize بر اساس `type` فیلد تعیین می‌شود |
| 16 | **`single-project.php`** و **`archive-project.php`** از سایز تصویر `arsham-project-card` استفاده می‌کردند که در `theme-setup.php` ثبت نشده (ثبت‌شده `elezone-project-card` است) → تصویر به سایز `full` fallback می‌کرد | بازبینی `single-project.php` | `arsham-project-card` → `elezone-project-card` در هر دو فایل |
| 17 | **`customizer.php`** فیلدهای ایمیل (`email` و `contact_recipient`) با `sanitize_text_field` sanitize می‌شدند به‌جای `sanitize_email` | بازبینی sanitize switch | branch جدید: `in_array( $key, array( 'email', 'contact_recipient' ), true )` → `sanitize_email` |
| 18 | **`AGENT.md`** با ساختار واقعی پوشه‌ها عقب بود: `inc/` ۱۰ اعلام شده ولی ۱۴ فایل دارد (`visibility.php` و `jalali-date.php` در درخت نیامده بودند)؛ PHP ریشه ۱۶ اعلام شده ولی ۱۸ فایل دارد؛ `template-parts/content/` ذکر شده ولی وجود ندارد؛ `docs/CF7-SETUP.md` وجود داشت ولی مستند نشده بود | مقایسه `directory_tree` با AGENT.md در 2026-11-13 | درخت، آمار و همین جدول به‌روز شدند |

---

## 📝 TODO — کارهای باقی‌مانده

### 🔴 اولویت بالا

- [ ] **تست کامل در وردپرس** (قبل از انتشار تجاری)
  1. Zip پوشه `elezone-wp-theme` (بدون `.git` و `AGENT.md`)
  2. آپلود → جایگزینی
  3. **تنظیمات → پیوندهای یکتا** → «نام نوشته» → ذخیره
  4. **تنظیمات → عمومی → زبان سایت = فارسی**
  5. **نمایش → فهرست‌ها** → ۳ منو (`Primary`, `Footer Demos`, `Footer Quick`)
  6. **نمایش → Elezone Starter** → 🚀 نصب نمونه محتوا
  7. بررسی ۱۱ سکشن صفحه اصلی (همه پر باشند)
  8. بررسی `/projects/` و `/services/` و صفحات تکی
  9. بررسی ۳۹ رنگ + دکمه‌های ریست
  10. بررسی لوگوی هدر/فوتر + اندازه + موقعیت
  11. بررسی ترجمه فارسی (برچسب‌های پیشخوان)

### 🟡 اولویت متوسط

- [ ] **افزودن اعلان برای WP Mail SMTP** (توصیه‌شده، نه الزامی)
  در حال حاضر CF7 به `wp_mail()` پیش‌فرض وردپرس تکیه می‌کند که در بسیاری از هاست‌ها به spam می‌رود یا ارسال نمی‌شود.
  **کار موردنیاز:**
  - تابع `elezone_required_wpmailsmtp_active()` بساز
  - به `elezone_required_plugin_notice()` branch دوم اضافه کن (با رنگ زرد/آبی به‌جای قرمز، چون توصیه است)
  - دکمه‌های «نصب WP Mail SMTP» / «فعال‌سازی»
  - به جدول قانون ۲ (به‌عنوان 🟡 توصیه‌شده) اضافه شود

- [ ] **`screenshot.png`** (۱۲۰۰×۹۰۰)
  برای پیش‌نمایش قالب در **نمایش → پوسته‌ها**. بدون این، کارت قالب خاکستری است.
  **راه‌ها:**
  - خودت از صفحه اصلی سایت اسکرین‌شات بگیر → برش ۱۲۰۰×۹۰۰
  - Chrome headless (اگر Chrome/Edge داری)
  - `screely.com` یا `bannerbear.com` (آنلاین)

- [ ] **انتشار تجاری نهایی**
  - ساخت Release با tag `v1.0.0` در GitHub
  - آپلود در مخزن قالب (ThemeForest، راست‌چین، …)
  - آماده‌سازی `screenshot.png` و توضیحات بازاریابی

### 🟢 اولویت پایین / اختیاری

- [ ] **`archive-benefit.php`** و **`archive-slide.php`**
  فعلاً این CPTها `public: false` هستند (فقط در پیشخوان) — اگر آرشیو عمومی خواستید، تغییر دهید.

- [ ] **گسترش بیشتر پنل رنگ‌ها**
  رنگ‌های اضافه: hover دکمه‌ها، رنگ لینک‌های فعال، رنگ shadowها، رنگ icon در منو.

- [ ] **پشتیبانی از Gutenberg**
  اضافه کردن `add_theme_support('align-wide')`، `editor-styles`.

- [ ] **دکمه ریست برای لوگو**
  در `customizer.js` آرایه `PREFIX` را گسترش دهید تا `elezone_logo_*` را هم شامل شود.

- [ ] **`template-parts/footer/`** و **`template-parts/content/`**
  پوشه‌های خالی — اگر فوتر پیچیده‌تر یا محتوا modular شد، به partialها بشکنید.

- [ ] **`AGENTS.md` جمع** (در ریشه `custom-template/`)
  اگر چند قالب دیگر هم در این پوشه هستند، یک AGENTS.md والد بسازید.

- [ ] **گسترش `fa_IR.po`**
  رشته‌های اضافه اگر اضافه شد (مثلاً پیام‌های Starter Content).

---

## 🔐 نکات مهم برای توسعه‌دهنده

> ⚠️ **قبل از هر تغییر، بخش «قوانین الزامی» در بالای این فایل را بخوان. قانون ۱ (رنگ‌بندی و اطلاعات برند از Customizer) الزامی است و نقض آن = رد شدن کار.**

### ۰. Customizer — رنگ‌ها و اطلاعات برند
**فقط این ۶ مورد** به Customizer می‌روند: رنگ‌ها، لوگو، اطلاعات تماس، شبکه‌های اجتماعی، مقصد فرم، محتوای معرفی (intro/CTA). **برچسب‌های UI و متن‌های ساختاری hardcoded می‌مانند.**

مسیر ۴ مرحله‌ای برای مقدار Customizer جدید:
1. **تعریف** در `inc/customizer.php`
2. **default** در `elezone_defaults()` (functions.php)
3. **مصرف** با `elezone_get_option()`
4. **مستندسازی** در `AGENT.md`

### ۱. مسیر فونت‌ها
`@font-face`ها در `assets/Css/Style.css` و `assets/Css/Main.css` از مسیر نسبی `../Fonts/` استفاده می‌کنند. **هرگز `assets/` را از حالت `Css/` و `Fonts/` همسطح خارج نکنید.**

### ۲. jQuery
قالب از **jQuery خود وردپرس** استفاده می‌کند. `assets/Js/jquery.min.js` حذف شده — دیگر لازم نیست.

### ۳. ترتیب enqueue
ترتیب در `inc/enqueue.php` دقیقاً مطابق `index.html` اصلی است:
```
Main.css → Style.css → Menu.css → owl-carousel → owl-theme → hoverimg → style.css (قالب)
```

### ۴. کلاس‌های JS
`assets/Js/Custom.js` به این کلاس‌ها وابسته است:
- `.menu_sticky` → `my_sticky` برای sticky
- `.m_search` → تاگل جستجو
- `.explain-menu` → منوی موبایل (توسط وردپرس خودکار تزریق می‌شود)
- `.search_wrap` → فرم جستجو

### ۵. پیشوند theme_mods
هنگام اضافه کردن فیلد جدید در Customizer:
- **کد:** `elezone_*`
- **کلید تنظیم:** `elezone_<fieldname>`
- **دسترسی:** `get_theme_mod('elezone_<fieldname>', default)`

### ۶. Starter Content markers
هر آیتم ساخته‌شده با Starter Content:
- `_elezone_starter = '1'` در پست
- `_elezone_source_image = '<filename>'` در attachment
- `_elezone_starter_image = '1'` در attachment

اگر marker را پاک کنی، حذف خودکار هم پاک نمی‌شود.

### ۷. `.gitignore` — دام `Icon?`
الگوی `Icon?` در `.gitignore` (خط ۱۶ اصلی) یک دام کلاسیک بود:
- قصد: فایل متادیتای macOS `Icon\r` را ignore کند
- واقعیت: `?` هر کاراکتر تک‌حرف را match می‌کند → `icons` هم گرفتار شد
- **راه‌حل:** الگو را به `Icon` دقیق تغییر دادیم
- **درس:** بعد از هر `git add`، با `git ls-tree -r HEAD --name-only <path>` مطمئن شو فایل‌های مهم در commit هستند

### ۸. Migrationها — یک‌بار اجرا
هر دو migration با flag یک‌بار اجرا می‌شوند:
- `elezone_migration_done` — arsham_* → elezone_*
- `elezone_folder_migration_done` — wp-theme → elezone-wp-theme

اگر نیاز به re-run داشتید، flag را از دیتابیس حذف کنید:
```php
delete_option( 'elezone_migration_done' );
delete_option( 'elezone_folder_migration_done' );
```

---

## 📊 آمار پروژه

| مورد | تعداد |
|---|---|
| فایل PHP (ریشه) | ۱۸ |
| فایل PHP (inc) | ۱۶ |
| فایل PHP (template-parts) | ۲۱ |
| فایل PHP (woocommerce override) | ۴ |
| فایل JS | ۵ |
| فایل CSS | ۷ |
| تصاویر | ۹۱ + ۱۳ icons + ۲۲ Shot |
| فونت | ۱۹ |
| ترجمه | ۷۲ رشته (`.po` + `.mo`) |
| **کل فایل‌ها** | **~۱۷۸** |
| **حجم کل** | **~۲۳.۹ MB** |
| **Git commits** | **۶ (working tree تمیز — همه push شده)** |
| **باگ رفع‌شده** | **۱۸** |

---

## 📜 تاریخچه‌ی Git

```
3462b4e fix: add missing benefit/service icons folder (HEAD -> main)
f3d65ad chore: rename theme folder wp-theme -> elezone-wp-theme
2468987 build: add compiled fa_IR.mo translation file
8aa8bb8 fix: remove Menu.js enqueue after cleanup
ce72038 chore: remove unused CSS/JS assets
e965176 feat: complete Elezone v1.0.0 release
222d435 init2 (origin/main, origin/HEAD)
5e639e9 init
```

**همه روی `origin/main` push شده:**
`https://github.com/arshambh/Elezone-Wordpress-Template`

---

## 🎁 وضعیت نهایی

| # | قابلیت | وضعیت |
|---|---|---|
| ۱ | کد قالب (۲۰ PHP + ۵ JS + ۶ CSS) | ✅ |
| ۲ | Starter Content (۲۵ آیتم) | ✅ |
| ۳ | ۳۹ رنگ در ۹ دسته + ریست | ✅ |
| ۴ | لوگوی مستقل هدر/فوتر + اندازه + موقعیت | ✅ |
| ۵ | صفحات single + archive پروژه و خدمت | ✅ |
| ۶ | متاباکس پروژه | ✅ |
| ۷ | ترجمه فارسی (`.po` + `.mo` معتبر) | ✅ |
| ۸ | AGENT.md + .gitignore | ✅ |
| ۹ | پاکسازی ۸ فایل بلااستفاده | ✅ |
| ۱۰ | rename + ۲ migration | ✅ |
| ۱۱ | ۱۳ آیکون benefit/service در گیت | ✅ |
| ۱۲ | Git: ۶ commit push شده | ✅ |
| ۱۳ | صفحه تماس با ما (`page-contact.php` + ۳ partial + هندلر) | ✅ |
| ۱۴ | Customizer: +۳ فیلد (`business_hours`, `map_embed`, `contact_recipient`) | ✅ |
| ۱۵ | رفع باگ sanitize `address` + بازسازی ساختار فرم | ✅ |
| ۱۶ | رفع باگ سایز تصویر `arsham-project-card` → `elezone-project-card` (در `single-project.php` و `archive-project.php`) | ✅ |
| ۱۷ | رفع باگ sanitize ایمیل در `customizer.php` (`email` + `contact_recipient` → `sanitize_email`) | ✅ |
| ۱۸ | صفحه درباره ما (`page-about.php` + ۴ partial + ۱۴ فیلد Customizer) | ✅ |
| ۱۹ | گرید وبلاگ (`index.php` بازنویسی + `post-card.php` + pagination) | ✅ |
| ۲۰ | جزئیات وبلاگ (`single.php` بازنویسی + `sidebar.php` + شمارنده بازدید + دکمه‌های اشتراک) | ✅ |
| ۲۱ | پنل Sections گسترش یافت به ۲۲ چک‌باکس در ۵ گروه | ✅ |
| ۲۲ | یکپارچه‌سازی WooCommerce v1.1.0 (`inc/woocommerce.php` + ۴ override + `product-card.php` + `WooCommerce.css` + ۶ کلید Section) | ✅ |
| ۲۳ | تولید داده نمونه دلخواه v1.2.0 (`inc/starter-generator.php` — پست/برگه/پروژه/خدمت/محصول متغیر) | ✅ |
| ⏳ | `screenshot.png` | اختیاری |
| ⏳ | تست نهایی در وردپرس | توصیه اکید قبل از انتشار |

---

*آخرین به‌روزرسانی: 2026-11-13 — نسخه 1.0.0 + افزودن Contact Page (آماده برای v1.1.0)*

> **📌 هم‌ترازسازی مستندات با ساختار واقعی (2026-11-13):** پس از بازبینی `directory_tree`، موارد زیر اصلاح شد: `inc/` از ۱۰ به ۱۴ فایل (افزودن `visibility.php` و `jalali-date.php` که در درخت نیامده بودند)، PHP ریشه از ۱۶ به ۱۸ فایل، حذف `template-parts/content/` از درخت (در واقعیت وجود ندارد)، و افزودن `docs/CF7-SETUP.md`. آمار در جدول «📊 آمار پروژه» و ردیف ۱۸ در جدول باگ‌ها به‌روز شد.
>
> **📌 هم‌ترازسازی دوم (2026-11-13، بازبینی کامل با `git status` تمیز):** موارد باقی‌مانده اصلاح شدند: `inc/` از ۱۴ به **۱۶** فایل (افزودن `starter-generator.php` و `woocommerce.php`)، `assets/Css/` از ۶ به **۷** (افزودن `WooCommerce.css`)، `template-parts/` از ۲۰ به **۲۱** (افزودن `cards/product-card.php`)، افزودن پوشه‌ی `woocommerce/` با ۴ override به درخت، افزودن `Sample-HTML/` (مرجع اصلی ساخت قالب) و `init-prompt.txt` و `elezone-wp-theme.zip` به درخت ریشه، و به‌روزرسانی ردیف Git در آمار (working tree تمیز). دو ردیف ۲۲ و ۲۳ (WooCommerce و Generator) هم به جدول «وضعیت نهایی» اضافه شدند.
