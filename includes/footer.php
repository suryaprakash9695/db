    <section class="footer3 cid-s48P1Icc8J" once="footers" id="footer3-i">
        <div class="container">
            <div class="media-container-row align-center mbr-white">
                <div class="row social-row">
                    <div class="social-list align-right pb-2">
                        <div class="soc-item">
                            <a href="https://github.com/Saavanx/wecare_iitm" target="_blank" rel="noopener">
                                <span class="mbr-iconfont mbr-iconfont-social socicon-github socicon"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row row-copirayt">
                    <p class="mbr-text mb-0 mbr-fonts-style mbr-white align-center display-7">Made With ❤️ by Team ENIGMA&nbsp;</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Scripts -->
    <script src="assets/web/assets/jquery/jquery.min.js"></script>
    <script src="assets/popper/popper.min.js"></script>
    <script src="assets/tether/tether.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/smoothscroll/smooth-scroll.js"></script>
    <script src="assets/parallax/jarallax.min.js"></script>
    <script src="assets/mbr-tabs/mbr-tabs.js"></script>
    <script src="assets/dropdown/js/nav-dropdown.js"></script>
    <script src="assets/dropdown/js/navbar-dropdown.js"></script>
    <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>
    <script src="assets/theme/js/script.js"></script>
    
    <?php if (isset($page_specific_scripts)): ?>
    <!-- Page specific scripts -->
    <?php foreach ($page_specific_scripts as $script): ?>
    <script src="<?php echo $script; ?>"></script>
    <?php endforeach; ?>
    <?php endif; ?>
    </body>
</html> 