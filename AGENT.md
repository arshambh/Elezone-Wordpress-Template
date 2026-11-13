# AGENT.md — Elezone WordPress Template

> **این فایل مرجع کامل پروژه است.** هر Agent یا توسعه‌دهنده‌ای که این قالب را برمی‌دارد، باید اول این فایل را بخواند.
>
> **📁 موقعیت این فایل:** `C:\Users\ArshamCoder\Desktop\custom-template\Elezone-Wordpress-Template\AGENT.md`
> **📁 موقعیت قالب:** `C:\Users\ArshamCoder\Desktop\custom-template\Elezone-Wordpress-Template\wp-theme\`
>
> این فایل **داخل قالب نیست** و نباید zip شود — سند پروژه است.

---

## 📦 مشخصات پروژه

| مورد | مقدار |
|---|---|
| **نام قالب** | `Elezone` |
| **Text Domain** | `elezone` |
| **نسخه** | `1.0.0` |
| **سازنده** | ArshamCoder |
| **نوع** | قالب شرکتی/معماری فارسی (RTL) |
| **مسیر پروژه** | `C:\Users\ArshamCoder\Desktop\custom-template\Elezone-Wordpress-Template\wp-theme` |
| **مسیر قدیمی (بازنشسته)** | `C:\Users\ArshamCoder\Desktop\custom-template\wp` (منبع HTML اولیه — دست نزن) |
| **پیشوند theme_mods** | `elezone_*` |
| **پیشوند توابع** | `elezone_*` |
| **پیشوند ثابت‌ها** | `ELEZONE_*` |
| **پیشوند کلاس‌ها** | `Elezone_*` |

---

## 🗂 ساختار پوشه‌ها

```
wp-theme/
├── style.css                       # شناسنامه قالب + text domain
├── functions.php                   # bootstrap، helperها، migration
├── README.md                       # راهنمای نصب سریع
├── AGENT.md                        # ← این فایل
├── header.php                      # سکشن هدر (RTL، Mega Menu، جستجو)
├── footer.php                      # سکشن فوتر (۴ ستون + سوشال)
├── front-page.php                  # صفحه اصلی (۱۱ سکشن)
│
├── index.php                       # فهرست پست‌ها (fallback)
├── page.php                        # برگه ساده
├── single.php                      # پست تکی
├── single-project.php              # ⭐ صفحه جزئیات پروژه
├── single-service.php              # ⭐ صفحه جزئیات خدمت
├── archive.php                     # آرشیو عمومی
├── archive-project.php             # ⭐ آرشیو پروژه‌ها با فیلتر
├── archive-service.php             # ⭐ آرشیو خدمات
├── search.php                      # نتایج جستجو
├── searchform.php                  # فرم جستجوی استاندارد
├── 404.php                         # صفحه خطا
├── comments.php                    # قالب نظرات
│
├── inc/
│   ├── theme-setup.php             # supports، menus، image sizes، sidebars
│   ├── enqueue.php                 # CSS/JS + inline style رنگ‌ها و لوگو
│   ├── cpt.php                     # CPTها + taxonomy
│   ├── customizer.php              # پنل Logo + Contact & Social
│   ├── colors.php                  # پنل رنگ‌ها (۳۹ رنگ در ۹ دسته)
│   ├── project-meta.php            # متاباکس پروژه (مدت/شهر/متراژ/سنگ)
│   ├── class-mega-menu-walker.php  # Walker منوی هدر + Walker فوتر
│   ├── starter-content.php         # ⭐ صفحه ادمین Starter + import تصویر
│   └── starter-content-data.php    # ⭐ توابع ساخت نمونه‌ها
│
├── template-parts/
│   ├── header/offcanvas.php        # منوی موبایل آفلاین
│   ├── home/                       # ۸ partial صفحه اصلی
│   │   ├── hero-slider.php
│   │   ├── benefits.php
│   │   ├── brand-block.php
│   │   ├── projects-carousel.php   # reusable (interior/facade)
│   │   ├── intro-band.php
│   │   ├── services.php
│   │   ├── cta-band.php
│   │   └── blog-grid.php
│   ├── cards/project-card.php      # کارت پروژه (variant-aware)
│   ├── content/                    # (رزرو — خالی)
│   └── footer/                     # (رزرو — خالی)
│
├── assets/
│   ├── Css/                        # ۱۱ فایل (Bootstrap 4.1.1 + FontAwesome + IRANSans)
│   ├── Js/                         # ۸ فایل (jQuery, Bootstrap, Owl, Custom, init, customizer)
│   ├── Img/                        # ۹۱ فایل + پوشه‌های icons/ و Shot/
│   └── Fonts/                      # ۱۹ فایل (IRANSans + FontAwesome woff2)
│
└── languages/
    ├── fa_IR.po                    # ترجمه فارسی (~۷۰ رشته) — در انتظار کامپایل
    └── fa_IR.mo                    # ⚠️ هنوز ساخته نشده — TODO
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
1. **Off-canvas mobile menu** (partial)
2. **Header** — Mega Menu + جستجو + sticky
3. **Hero Slider** — Owl Carousel
4. **Benefits strip** — ۶ آیتم
5. **Brand image block** — تصویر بزرگ
6. **Interior projects carousel** — ۵ کارت
7. **Intro band** — متن از Customizer
8. **Services** — ۳ خدمت
9. **CTA band** — دکمه تماس
10. **Facade projects carousel** — ۵ کارت
11. **Blog grid** — ۴ پست آخر وردپرس
12. **Footer** — ۴ ستون + سوشال

**همه‌ی سکشن‌ها fallback دارند:** اگر CPT خالی باشد، همان محتوای HTML اصلی نمایش داده می‌شود.

### ۳. Customizer

#### پنل ArshamDecor - Logo (بخش مستقل)
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

### ۵. Migration
تابع `elezone_migrate_legacy_settings()` در `functions.php`:
- یک‌بار اجرا می‌شود (`elezone_migration_done` flag)
- کلیدهای `arsham_*` را به `elezone_*` کپی می‌کند
- برای حفظ تنظیمات تستی قبل از rename تجاری

---

## 🔧 راه‌اندازی نصب

### ۱. آپلود قالب
```
wp-theme/ → zip (style.css در ریشه)
پیشخوان → نمایش → پوسته‌ها → افزودن → بارگذاری → جایگزینی
```

### ۲. تنظیمات اولیه (اجباری)
- **تنظیمات → پیوندهای یکتا → «نام نوشته» → ذخیره**  
  *(بدون این، آرشیو پروژه/خدمت ۴۰۴ می‌دهد)*

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

## 🐛 باگ‌هایی که رفع شدند (برای مرجع)

| # | باگ | رفع |
|---|---|---|
| 1 | اسلایدرها مخفی بودند (Owl هیچ‌جا init نمی‌شد) | `assets/Js/init.js` نوشته شد |
| 2 | `<html>` بدون `dir="rtl"` | در `header.php` اضافه شد |
| 3 | `<title>` خالی | `add_theme_support('title-tag')` |
| 4 | ۴ `<h1>` تکراری در صفحه اصلی | به `<h2>` تبدیل شد |
| 5 | `post_type=product` هاردکد در فرم جستجو | حذف شد |
| 6 | `<section>` تودرتو در سکشن معرفی | ساده‌سازی شد |
| 7 | آیکون فلش هاردکد در فوتر | Walker خودکار تزریق می‌کند |
| 8 | لینک‌های `.html` منو | `wp_nav_menu` جایگزین شد |
| 9 | Missing quote در migration function | رفع شد (call_id 204) |
| 10 | `starter-content.php` در functions.php require نشده بود | رفع شد (call_id 240) |

---

## 📝 TODO — کارهای باقی‌مانده

### 🔴 اولویت بالا

- [ ] **کامپایل `.po` به `.mo`**  
  فایل `languages/fa_IR.po` ساخته شد اما `.mo` کامپایل نشده.  
  بدون `.mo`، ترجمه‌های پیشخوان اعمال نمی‌شوند.  
  **راه‌حل‌ها:**
  - **A)** نصب پلاگین **Loco Translate** → Languages → Persian → Save (خودکار کامپایل می‌شود)
  - **B)** دستور: `msgfmt fa_IR.po -o fa_IR.mo` (نیاز به gettext در PATH)
  - **C)** آنلاین: جستجو «po to mo online»

- [ ] **تست کامل Starter Content**  
  باگ missing require رفع شد اما هنوز تأیید نهایی نشده:  
  1. آپلود مجدد قالب  
  2. نمایش → Elezone Starter  
  3. کلیک 🚀 نصب نمونه محتوا  
  4. بررسی صفحه اصلی (همه ۱۱ سکشن پر باشند)

### 🟡 اولویت متوسط

- [ ] **`screenshot.png`** (۱۲۰۰×۹۰۰)  
  برای پیش‌نمایش قالب در **نمایش → پوسته‌ها**.  
  بدون این، کارت قالب خاکستری است.  
  ساخت با ابزار: GIMP / Figma / Canva / `chrome --screenshot`

- [ ] **تغییر نام پوشه** از `wp-theme` به `elezone`  
  برای انتشار تجاری نهایی.  
  **هشدار:** باعث صفر شدن theme_mods می‌شود — باید migration دیگری اضافه شود یا تنظیمات دستی بازسازی شوند.

- [ ] **بررسی `.po` کامل**  
  رشته‌های موجود در `.po` شامل برچسب‌های CPT، منوها، پنل‌های Customizer است.  
  اگر رشته‌ای جا افتاده، با `_x()` یا `_n()` اضافه شود.

### 🟢 اولویت پایین / اختیاری

- [ ] **`archive-benefit.php`** و **`archive-slide.php`**  
  فعلاً این CPTها `public: false` هستند (فقط در پیشخوان) — اگر آرشیو عمومی خواستید، تغییر دهید.

- [ ] **گسترش پنل رنگ‌ها** — رنگ‌های بیشتر (مثلاً hover دکمه‌ها، رنگ لینک‌های فعال)

- [ ] **پشتیبانی از Gutenberg**  
  اضافه کردن `add_theme_support('align-wide')`، `responsive-embeds` (دومی هست)، `editor-styles`

- [ ] **`custom-logo` پیش‌فرض**  
  با وجود پنل Logo اختصاصی، هنوز `add_theme_support('custom-logo')` هم فعال است.  
  تصمیم بگیرید کدام اولویت داشته باشد یا هر دو را نگه دارید.

- [ ] **دکمه ریست برای لوگو**  
  الان فقط رنگ‌ها دکمه ریست دارند. اگر خواستید برای لوگو هم اضافه کنید، در `customizer.js` آرایه‌ی `PREFIX` را گسترش دهید.

- [ ] **`template-parts/footer/`** — پوشه خالی است، اگر فوتر پیچیده‌تر شد، به partialها بشکنید.

- [ ] **`template-parts/content/`** — پوشه خالی است، اگر `content.php` / `content-none.php` جدا خواستید، اینجا بسازید.

- [ ] **`AGENTS.md`** (جمع) در ریشه‌ی `Elezone-Wordpress-Template/`  
  اگر چند قالب دیگر هم در این پوشه هستند، یک AGENTS.md والد بسازید که همه را فهرست کند.

---

## 🔐 نکات مهم برای توسعه‌دهنده

### ۱. مسیر فونت‌ها
`@font-face`ها در `assets/Css/Style.css` و `assets/Css/Main.css` از مسیر نسبی `../Fonts/` استفاده می‌کنند. **هرگز `assets/` را از حالت `Css/` و `Fonts/` همسطح خارج نکنید.**

### ۲. jQuery
قالب از **jQuery خود وردپرس** استفاده می‌کند (نه `assets/Js/jquery.min.js`). فایل موجود فقط برای مرجع است.

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

---

## 📊 آمار پروژه

| مورد | تعداد |
|---|---|
| فایل PHP (ریشه) | ۱۴ |
| فایل PHP (inc) | ۹ |
| فایل PHP (template-parts) | ۱۰ |
| فایل JS | ۸ |
| فایل CSS | ۱۱ |
| تصاویر | ۹۱ + ۲ پوشه |
| فونت | ۱۹ |
| **کل فایل‌ها** | **~۱۶۵** |
| **حجم کل** | **~۲۴ MB** |

---

## 🎁 مرحله بعدی پیشنهادی

از بین موارد TODO بالا، ترتیب پیشنهادی:

1. **کامپایل `.mo`** (اولویت بالا — سریع با Loco Translate)
2. **`screenshot.png`** (سریع، ارزش نمایشی بالا)
3. **تست کامل Starter Content** (بعد از fix امروز)
4. **گسترش رنگ‌ها** اگر چیزی جا افتاده
5. **تغییر نام پوشه** (آخرین کار قبل از انتشار)

---

*آخرین به‌روزرسانی: 2026-11-13 — نسخه 1.0.0*
