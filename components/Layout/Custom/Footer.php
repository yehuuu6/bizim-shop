<?php

namespace Components\Layout\Custom;

use Components\Component;

/**
 * Footer component
 */
class Footer extends Component
{
    public function __construct()
    {
        $body = <<<HTML
            <div class="cookie-container">
                <p>
                    Bu web sitesinde size daha iyi bir deneyim sunmak için çerezler kullanıyoruz. Daha fazla bilgi için <a class="link blue-text" href="/help-center/privacy-policy">Gizlilik Politikası</a>'nı inceleyebilirsiniz.
                </p>
                <button class="cookie-btn">Tamam</button>
            </div>
            <footer>
                <div class="first-part">
                    <div class="links">
                    <h3>Yardım</h3>
                    <ul>
                        <li><a href="/faq">Sıkça Sorulan Sorular</a></li>
                        <li><a href="/contact">İletişim</a></li>
                        <li><a href="/privacy-policy">Gizlilik Politikası</a></li>
                        <li><a href="/terms-of-service">Kullanım Koşulları</a></li>
                    </ul>
                    </div>
                    <div class="links">
                    <h3>Alışveriş</h3>
                    <ul>
                        <li><a href="/control-center/account">Hesabım</a></li>
                        <li><a href="/cart">Sepetim</a></li>
                        <li><a href="/wishlist">Favorilerim</a></li>
                        <li><a href="/control-center/account#orders">Siparişlerim</a></li>
                    </ul>
                    </div>
                    <div class="links">
                    <h3>Diğer</h3>
                    <ul>
                        <li><a href="/sell-us">Bize Sat</a></li>
                        <li><a href="/fix-my-product">Tamirat</a></li>
                        <li><a href="/feedbacks">Yorumlar</a></li>
                        <li><a href="/sponsorship">Sponsorluk</a></li>
                    </ul>
                    </div>
                </div>
                <hr />
                <div class="middle-part">
                    <a href="/" class="logo">
                    <img src="/global/imgs/logo.png" alt="" />
                    <h3>Bizim Shop</h3>
                    </a>
                    <ul class="category-links">
                        {$this->render_category_links()}
                    </ul>
                </div>
                <div class="last-part">
                    <div class="projects">
                    <div class="project">
                        <a target="_blank" href="https://github.com/yehuuu6/selftos"
                        >Selftos</a
                        >
                        <span>A highly hackable and open-source chat application</span>
                    </div>
                    <div class="project">
                        <a target="_blank" href="https://unturnedworkshop.com"
                        >Unturned Workshop</a
                        >
                        <span>A website dedicated for Unturned's modding community</span>
                    </div>
                    <div class="project">
                        <a target="_blank" href="https://basakftr.com">Başak FTR</a>
                        <span
                        >Official website of Başak Physiotherapy Clinic located in Ankara,
                        Türkiye</span
                        >
                    </div>
                    </div>
                    <div class="copyright-claimer">
                    <span>&copy; 2024 Bizim Shop & Aydın Tech</span>
                    <span>All rights reserved.</span>
                    </div>
                </div>
                </footer>
        HTML;

        // Render the component on the page
        parent::render($body);
    }

    private function render_category_links()
    {
        $sub_categories = get_all_sub_categories();
        $html = '';
        foreach ($sub_categories as $sub_category) {
            // Make sub_category url friendly
            $sub_category['slug'] = urlencode(urlencode($sub_category['slug']));
            $category_slug = urlencode(urlencode(get_category_slug($sub_category['cid'])));
            $html .= "<li><a href='/products/{$category_slug}/{$sub_category['slug']}'>{$sub_category['name']}</a></li>";
        }
        return $html;
    }
}
