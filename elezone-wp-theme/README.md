# قالب وردپرس Elezone

قالب شرکتی/معماری فارسی (RTL) که از یک طراحی استاتیک HTML تبدیل شده است[cite: 4].

- **نسخه:** 1.0.0 (+ Contact / About / Blog / WooCommerce / Generator)[cite: 4]
- **Text Domain:** `elezone`[cite: 4]
- **سازنده:** Elezone[cite: 4]

---

## 📦 نیازمندی‌ها و وضعیت فعال‌سازی

| افزونه / بخش | نسخه / وضعیت | نقش در قالب |
|---|---|---|
| **Contact Form 7** (`contact-form-7`) | 6.2.5+ (الزامی) | موتور فرم صفحه «تماس با ما» با اعتبارسنجی موبایل ایران و ساخت خودکار فرم `Elezone Contact`[cite: 4, 5] |
| **WP Mail SMTP** (`wp-mail-smtp`) | 3.0+ (توصیه‌شده) | بهبود تحویل ایمیل‌های خروجی و جلوگیری از رفتن به پوشه اسپم[cite: 4, 5] |
| **WooCommerce** | اختیاری / فروشگاه | فعال‌سازی آرشیو محصول، صفحه تک‌محصول، دیدگاه‌های محصول، سایدبارها و تولید محصول متغیر[cite: 4, 8, 9, 16, 17] |

> در صورت غیرفعال بودن WooCommerce، اعلان پیشخوان نمایش داده می‌شود و روی صفحه Themes قابل‌بستن است[cite: 17].

---

## ⚙️ معماری و ماژول‌های کلیدی بررسی‌شده

- **تبدیل تاریخ شمسی (`inc/jalali-date.php`):** تبدیل تاریخ میلادی به شمسی بدون وابستگی به افزونه با توابع `elezone_gregorian_to_jalali()` و `elezone_jalali_date()` (پشتیبانی از فرمت‌های `'j F Y'` و `'Y/m/d'`)[cite: 1].
- **دیدگاه‌ها (`comments.php`):** فرم دستی با ترتیب فیلدهای «نام و نام خانوادگی → شماره همراه → ایمیل (اختیاری) → پیام»، نمایش تاریخ شمسی از طریق `elezone_jalali_date()` و خواندن مقدار پیش‌فرض شماره همراه از کوکی `comment_author_phone`[cite: 1, 2].
- **فرم و اطلاعات تماس (`template-parts/contact/form.php`, `info.php`, `map.php`):** کنترل نمایش بر اساس `elezone_is_section_visible()` (`contact_form`، `contact_info`، `contact_map`)، فراخوانی شورت‌کد CF7 یا نمایش پیام راهنما برای مدیر/بازدیدکننده، خواندن اطلاعات تماس و شبکه‌های اجتماعی از Customizer و نمایش نقشه در صورت وجود آدرس جاسازی‌شده[cite: 6].
- **صفحه درباره ما (`template-parts/about/goals.php`, `manager.php`, `stats.php`, `awards.php`):** کنترل نمایش با `about_goals`، `about_manager`، `about_stats` و `about_awards` و خواندن اطلاعات از تنظیمات قالب (با fallback به `Img/image12.jpeg` و `Img/tandis.png` و تجزیه خطوط آمار با جداکننده `|`)[cite: 10].
- **صفحه اصلی (`template-parts/home/hero-slider.php`, `benefits.php`, `brand-block.php`, `intro-band.php`, `services.php`, `cta-band.php`, `blog-grid.php`):** کنترل نمایش با کلیدهای `hero`، `benefits`، `brand`، `intro`، `services`، `cta` و `blog` و واکشی CPTهای `slide`، `benefit`، `service` و نوشته‌های `post` همراه با مقادیر fallback[cite: 11, 12].
- **کارت‌ها، سایدبار وبلاگ و بنر (`template-parts/cards/project-card.php`, `post-card.php`, `blog/sidebar.php`, `hero/banner.php`):** نمایش متاهای پروژه (`project_duration`، `project_city`، `project_area`، `project_stone` بر اساس `project_variant`)، کارت و سایدبار وبلاگ (کنترل‌شده با `single_sidebar`) و بنر مشترک با breadcrumb[cite: 13].
- **قالب‌های جستجو، ۴۰۴، آرشیو و منوی موبایل (`search.php`, `404.php`, `archive.php`, `searchform.php`, `template-parts/header/offcanvas.php`):** نمایش نتایج جستجو، خطای ۴۰۴، آرشیو عمومی، فرم جستجو و منوی موبایل `#of-mobile-nav` برای جایگاه `primary`[cite: 15, 16].
- **تولید داده نمونه (`inc/starter-generator.php`):** ساخت ۱ تا ۱۰۰ آیتم (`post`، `page`، `project`، `service` و محصول متغیر `WC_Product_Variable` با ویژگی `pa_color`، ورییشن، قیمت، تخفیف، گالری و `pa_warranty`) و حذف تفکیکی آیتم‌های دارای متای `_elezone_generator`[cite: 16].
- **ووکامرس (`inc/woocommerce.php`, `woocommerce/archive-product.php`, `single-product.php`, `content-product.php`, `content-single-product.php`, `single-product-reviews.php`, `template-parts/cards/product-card.php`):** اعلام پشتیبانی از ووکامرس و گالری، جایگزینی wrapperهای اصلی و حذف موارد تکراری، ثبت سایدبارهای `elezone-shop-sidebar` و `elezone-product-sidebar`، کنترل بخش‌های صفحه محصول (`product_gallery`، `product_summary`، `product_tabs`، `product_page_related`)، نمایش دیدگاه‌های محصول با تاریخ شمسی و بستن لینک محصول قبل از فوتر کارت برای جلوگیری از تودرتویی تگ `<a>`[cite: 8, 9, 17].
- **سفارشی‌سازی (`inc/customizer.php`):** ثبت بخش‌های `Elezone - Logo`، `Elezone - Contact & Social`، `Elezone - About` و `Elezone - Blog`[cite: 17].

---

## 🔍 نکات و ایرادات بالقوه یافت‌شده در بررسی کد

1. **ناهمخوانی مستندات اولیه با کد:** در مستندات اولیه تعداد کلیدهای `Elezone - Sections` برابر ۲۲ در ۵ گروه و تعداد فایل‌های `woocommerce/` برابر ۴ ذکر شده بود، در حالی که در بخش‌های بررسی‌شده تنوع کلیدها و فایل‌های ووکامرس بیشتر است[cite: 4, 8, 9, 17].
2. **فیلد `_wp_comment_nonce` در فرم دیدگاه‌ها:** در `comments.php` و `woocommerce/single-product-reviews.php` این nonce تولید می‌شود اما پردازش استاندارد دیدگاه در وردپرس به صورت پیش‌فرض چنین کلید سفارشی را بررسی نمی‌کند[cite: 2, 9].
3. **فرم دیدگاه محصول (`woocommerce/single-product-reviews.php`):** در فرم ارسالی دیدگاه محصول کنترل انتخاب امتیاز (`rating`) دیده نمی‌شود در حالی که در نمایش دیدگاه‌های تأییدشده رندر می‌شود[cite: 9].
4. **شناسه تکراری در فرم جستجو:** `id="ajax-form-search"` و `id="search-form-text"` در `searchform.php` (و در هدر) به کار رفته‌اند که در صورت حضور هم‌زمان در یک صفحه می‌تواند باعث تداخل ID در DOM شود[cite: 15].
5. **تصاویر نمونه در `inc/starter-generator.php`:** تولید پست‌ها از `blog-img1.jpg` تا `blog-img4.jpg` استفاده می‌کند که باید وجود آن در `assets/Img/` بررسی شود و هنگام حذف آیتم‌ها با `wp_delete_post(..., true)` فایل‌های attachment ضمیمه‌شده به صورت خودکار پاک نمی‌شوند[cite: 16].
6. **مقادیر هاردکدشده:** در `template-parts/home/intro-band.php` متن ثابت «گروه فوق تخصصی، اِلِزون» و در `template-parts/home/cta-band.php` مقدار مستقیم `cta_phone` در `href="tel:..."` قرار گرفته است[cite: 11, 12].