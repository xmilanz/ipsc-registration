<?php
include "./header.php";
?>
<div class="article">
    <div class="row">
        <div class="col-lg-12">
            <div class="px-3 pb-3">
                <h1 class="p-3">Situace</h1>
            </div>
            <div class="portfolio-item row ps-4 pb-4">
                <?php for ($i = 1; $i <= $match_data['Zavod_stages']; $i++) {
                    echo /*html*/ "<div class='item col-lg-3 col-md-4 col-6 col-sm'>";
                    echo /*html*/ "<a href='./stages/stage$i.png' class='fancylight popup-btn' data-fancybox-group='light'>";
                    echo /*html*/ "<img class='img-fluid img-thumbnail' src='./stages/stage$i.png' alt='Stage $i'>";
                    echo /*html*/ "</a>";
                    echo /*html*/ "</div>";
                }; ?>
            </div>
            <div class="p-3"><a href="./stages/stages.pdf"><img src="./images/pdf.png" width="32px">Stáhnout vše</a></div>
        </div>
    </div>
</div>

<script>
    $('.portfolio-menu ul li').click(function() {
        $('.portfolio-menu ul li').removeClass('active');
        $(this).addClass('active');

        var selector = $(this).attr('data-filter');
        $('.portfolio-item').isotope({
            filter: selector
        });
        return false;
    });
    $(document).ready(function() {
        var popup_btn = $('.popup-btn');
        popup_btn.magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    });
</script>


<?php include "./footer.php"; ?>