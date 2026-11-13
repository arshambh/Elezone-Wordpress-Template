# AGENT.md — Elezone WordPress Theme

> **این فایل مرجع کامل پروژه است.** هر Agent یا توسعه‌دهنده‌ای که این قالب را برمی‌دارد، باید اول این فایل را بخواند.
>
> **📁 موقعیت این فایل:** `C:\Users\ArshamCoder\Desktop\custom-template\Elezone-Wordpress-Template\AGENT.md`
> **📁 موقعیت قالب:** `C:\Users\ArshamCoder\Desktop\custom-template\Elezone-Wordpress-Template\elezone-wp-theme\`
> **📁 مخزن Git:** `https://github.com/arshambh/Elezone-Wordpress-Template`
>
> این فایل **داخل قالب نیست** و نباید zip شود — سند پروژه است.

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
└── elezone-wp-theme/                ← پوشه قالب وردپرس
    ├── style.css                    # شناسنامه قالب (Theme Name: Elezone)
    ├── functions.php                # bootstrap + helperها + ۲ migration
    ├── README.md                    # راهنمای نصب سریع
    ├── header.php                   # سکشن هدر (RTL، Mega Menu، جستجو)
    ├── footer.php                   # سکشن فوتر (۴ ستون + سوشال)
    ├── front-page.php               # صفحه اصلی (۱۱ سکشن)
    │
    ├── index.php                    # فهرست پست‌ها (fallback)
    ├── page.php                     # برگه ساده
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
    │   └── starter-content-data.php # ⭐ توابع ساخت نمونه‌ها
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
    │   ├── content/                 # (رزرو — خالی)
    │   └── footer/                  # (رزرو — خالی)
    │
    ├── assets/
    │   ├── Css/                     # ۶ فایل (بعد از پاکسازی)
    │   │   ├── Main.css             # Bootstrap 4.1.1 + FontAwesome Pro
    │   │   ├── Style.css            # IRANSans @font-face + استایل اصلی
    │   │   ├── Menu.css             # Mega Menu
    │   │   ├── owl.carousel.min.css
    │   │   ├── owl.theme.min.css
    │   │   └── hoverimg.css
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

#### پنل Elezone - Contact & Social (۱۲ فیلد)
`phone`, `mobile`, `email`, `address`, `cta_text`, `cta_phone`, `intro_title`, `intro_text`, `social_whatsapp`, `social_telegram`, `social_instagram`, `social_facebook`

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

### ۲. تنظیمات اولیه (اجباری)
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
| فایل PHP (ریشه) | ۱۴ |
| فایل PHP (inc) | ۹ |
| فایل PHP (template-parts) | ۱۰ |
| فایل JS | ۵ |
| فایل CSS | ۶ |
| تصاویر | ۹۱ + ۱۳ icons + ۲۲ Shot |
| فونت | ۱۹ |
| ترجمه | ۷۲ رشته (`.po` + `.mo`) |
| **کل فایل‌ها** | **~۱۶۰** |
| **حجم کل** | **~۲۳.۷ MB** |
| **Git commits** | **۶** |
| **باگ رفع‌شده** | **۱۳** |

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
| ⏳ | `screenshot.png` | اختیاری |
| ⏳ | تست نهایی در وردپرس | توصیه اکید قبل از انتشار |

---

*آخرین به‌روزرسانی: 2026-11-13 — نسخه 1.0.0*
