# قالب وردپرس Elezone

قالب شرکتی/معماری فارسی (RTL) که از یک طراحی استاتیک HTML تبدیل شده است.

- **نسخه:** 1.0.0 (+ Contact / About / Blog / WooCommerce / Generator)
- **Text Domain:** `elezone`
- **سازنده:** ArshamCoder

---

## 📦 نیازمندی‌ها

| افزونه | نسخه حداقلی | وضعیت | کاربرد |
|---|---|---|---|
| **Contact Form 7** (`contact-form-7`) | 6.2.5 | 🔴 **الزامی** | موتور فرم صفحه‌ی «تماس با ما» |
| **WP Mail SMTP** (`wp-mail-smtp`) | 3.0 | 🟡 توصیه‌شده | افزایش تحویل‌پذیری ایمیل فرم |
| **WooCommerce** | — | 🟡 اختیاری | برای فعال‌سازی فروشگاه (v1.1.0) |

> هنگام فعال‌سازی قالب، برای CF7 یک اعلان غیرقابل‌بست در پیشخوان ظاهر می‌شود با دکمه‌ی «نصب» یا «فعال‌سازی». جزئیات بیشتر: `docs/CF7-SETUP.md`

---

## 🚀 نصب

1. پوشه‌ی این قالب را zip کنید (به‌طوری که `style.css` در ریشه‌ی zip باشد).
2. پیشخوان → نمایش → پوسته‌ها → افزودن → بارگذاری پوسته → zip را انتخاب کنید.
3. فعال‌سازی.
4. **Contact Form 7** را نصب و فعال کنید (از اعلان پیشخوان).
5. تنظیمات → پیوندهای یکتا → روی «نام نوشته» ذخیره کنید (بدون این، آرشیو پروژه/خدمت ۴۰۴ می‌دهد).
6. تنظیمات → عمومی → زبان سایت = فارسی.
7. کاربران → پروفایل خود → زبان = فارسی.

---

## ⚙️ تنظیمات پس از فعال‌سازی

### منوها (اجباری)
**نمایش → فهرست‌ها** — سه منو:
- `Primary (Mega Menu)`
- `Footer - Demos column`
- `Footer - Quick links column`

### Customizer (`نمایش → سفارشی‌سازی`)

| پنل | توضیح |
|---|---|
| **Elezone - Logo** | لوگوی مستقل هدر/فوتر + عرض (۴۰–۴۰۰px) + موقعیت (start/center/end) |
| **Elezone - Colors** | ۳۹ رنگ در ۹ دسته (General, Header, Intro, CTA, Footer, Buttons, Social, Cards, Footer Extras) + دکمه‌های ریست تکی و کلی |
| **Elezone - Blog** | عنوان بنر وبلاگ، شعار، عنوان گرید، بنر جزئیات، تصویر تبلیغ sidebar |
| **Elezone - About** | ۱۴ فیلد (اهداف، مدیریت، آمار، جوایز) + ۲ تصویر |
| **Elezone - Sections** | ۲۲ چک‌باکس نمایش/مخفی در ۵ گروه (Home, About, Contact, Blog, Single) |
| **Elezone - Contact & Social** | تلفن، موبایل، ایمیل، آدرس، ساعات کاری، نقشه، CF7 form id، CTA، Intro، ۴ شبکه اجتماعی |

### تنظیمات → خواندن
یک صفحه‌ی ثابت به‌عنوان صفحه اصلی انتخاب کنید (یا خالی بگذارید تا `front-page.php` مستقیم لود شود).

---

## 🎨 محتوای نمونه

**نمایش → Elezone Starter**

- **🚀 نصب نمونه محتوا** — ۲۵ آیتم با یک کلیک (۲ اسلاید، ۶ مزیت، ۳ خدمت، ۵ پروژه داخلی، ۵ پروژه نما، ۴ پست)
- **🗑️ حذف نمونه‌ها** — فقط آیتم‌های علامت‌دار `_elezone_starter=1`
- **🎲 تولید داده نمونه دلخواه** (v1.2.0) — پست/برگه/پروژه/خدمت/محصول متغیر با رنگ و ورییشن

---

## 🛒 WooCommerce (v1.1.0)

پس از نصب و فعال‌سازی WooCommerce، این قالب به‌طور خودکار:

- shop archive را با بنر و سایدبار نمایش می‌دهد
- صفحه‌ی محصول را با سایدبار ستون چپ override می‌کند
- ۶ کلید نمایش/مخفی جدید در پنل Sections اضافه می‌کند (`shop_page_banner`, `shop_page_sidebar`, `shop_page_grid`, `product_page_banner`, `product_page_sidebar`, `product_page_related`)
- سایدبار اختصاصی `elezone-product-sidebar` را ثبت می‌کند

فایل‌های override در `woocommerce/` — بدون دست‌کاری مستقیم قالب اصلی.

---

## 📁 ساختار

```
elezone-wp-theme/
├── style.css / functions.php / README.md
├── header.php / footer.php / front-page.php
│
├── index.php / page.php / search.php / 404.php / comments.php
├── page-contact.php         ⭐ تماس با ما
├── page-about.php           ⭐ درباره ما
├── single.php / single-project.php / single-service.php
├── archive.php / archive-project.php / archive-service.php
├── searchform.php
│
├── inc/                     (۱۶ فایل)
│   ├── theme-setup.php / enqueue.php / cpt.php
│   ├── customizer.php / colors.php / visibility.php
│   ├── project-meta.php / class-mega-menu-walker.php
│   ├── starter-content.php / starter-content-data.php / starter-generator.php
│   ├── cf7-integration.php / comment-phone.php / required-plugins.php
│   ├── jalali-date.php / woocommerce.php
│
├── template-parts/          (۲۱ partial)
│   ├── header/offcanvas.php
│   ├── home/  (۸ فایل)
│   ├── about/ (۴ فایل)
│   ├── contact/ (۳ فایل)
│   ├── blog/ (۲ فایل)
│   ├── cards/ (project-card, product-card)
│   ├── hero/banner.php
│   └── footer/ (خالی — رزرو)
│
├── woocommerce/             ⭐ overrideهای WC (۴ فایل)
├── assets/                  Css (۷) / Js (۵) / Img / Fonts (۱۹)
├── languages/               fa_IR.po + .mo
└── docs/CF7-SETUP.md
```

---

## 🔧 نکات فنی

- **Bootstrap 4.1.1** داخل `assets/Css/Main.css` گنجانده شده است.
- **IRANSans** `@font-face`ها در `Style.css`/`Main.css` مسیر `../Fonts/` را می‌گیرند — ساختار پوشه‌ها را تغییر ندهید.
- **jQuery** از خود وردپرس استفاده می‌شود (`jquery.min.js` در `assets/Js/` حذف شده).
- **`assets/Js/init.js`** اسلایدرهای Owl را راه‌اندازی می‌کند.
- **`Custom.js`** به کلاس‌های `.menu_sticky`، `.m_search`، `.explain-menu`، `.search_wrap` وابسته است.
- **ترتیب enqueue** (در `inc/enqueue.php`): Main → Style → Menu → owl-carousel → owl-theme → hoverimg → style.css → WooCommerce.css (فقط در صفحات WC).
- **رنگ‌ها** همه از Customizer خوانده می‌شوند و به‌صورت CSS variable در `<head>` تزریق می‌شوند (`--elezone-*`).

---

## 📞 پشتیبانی

- **GitHub:** https://github.com/arshambh/Elezone-Wordpress-Template
- **AGENT.md** (ریشه مخزن) — مرجع کامل پروژه، قوانین الزامی و تاریخچه‌ی باگ‌ها
