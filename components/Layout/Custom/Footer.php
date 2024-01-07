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
                <div class="footer-row">
                    <div class="footer-item">
                        <h3 class="footer-title">Yardım Merkezi</h3>
                        <ul class="no-list-style">
                            <li><a class="no-decoration" href="/help-center/about-us">Hakkımızda</a></li>
                            <li><a class="no-decoration" href="/help-center/contact-us">İletişim</a></li>
                            <li><a class="no-decoration" href="/help-center/terms-of-use">Kullanım Şartları</a></li>
                            <li><a class="no-decoration" href="/help-center/privacy-policy">Gizlilik Politikası</a></li>
                        </ul>
                    </div>
                    <div class="footer-item">
                        <h3 class="footer-title">Katkıda Bulunun</h3>
                        <ul class="no-list-style">
                            <li><a class="no-decoration" href="#">Sponsorluk</a></li>
                            <li><a class="no-decoration" href="#">Destek</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-powered">
                    <div class="footer-item gap-10">
                        <img class="no-drag wide-img" src="/global/imgs/footer/OpenAI_Logo.png" alt="Open AI GPT-3 Logo">
                        <p>Bazı içerikler ve kod örnekleri, <a class="link dark-blue-text" target="_blank" href="https://openai.com/blog/chatgpt">OpenAI GPT-3</a> tarafından sağlanmıştır.</p>
                    </div>
                    <div class="footer-item gap-10">
                        <img class="no-drag wide-img" src="/global/imgs/footer/Discord_Logo.png" alt="Discord Logo">
                        <p>Öneri ve istekleriniz için <a class="link dark-blue-text" target="_blank" href="https://discord.gg/4ZyAb3sZVS">Discord</a> sunucumuza katılabilirsiniz!</p>
                    </div>
                </div>
                <div class="footer-copyright medium-text">
                    <p>© 2024 Bizim
                    <span class="blue-text bold-text">Shop</span> tüm hakları saklıdır.</p>
                </div>
            </footer>
        HTML;

        // Render the component on the page
        parent::render($body);
    }
}