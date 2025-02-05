<div class="site-footer">
  <div class="inner first">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-12">
          <div class="widget">
            <h3 class="heading">About Tour</h3>
            <p>The traveler sees what he sees, the tourist sees what he has come to see.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="inner dark">
    <div class="container">
      <div class="row text-center">
        <div class="col-md-8 mb-3 mb-md-0 mx-auto">
          <p class="copyright">
            Copyright &copy;
            <script>document.write(new Date().getFullYear());</script>. All Rights Reserved.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="overlayer"></div>
<div class="loader">
    <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<script src="assets/js/jquery-3.4.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/jquery.animateNumber.min.js"></script>
<script src="assets/js/jquery.waypoints.min.js"></script>
<script src="assets/js/jquery.fancybox.min.js"></script>
<script src="assets/js/aos.js"></script>
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/daterangepicker.js"></script>
<script src="assets/js/typed.js"></script>

<script>
$(function() {
    // Initialize Owl Carousel for Popular Destinations
    $('.owl-3-slider').owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        dots: true,
        autoplay: true,
        center: false,
        items: 1,
        navText: ['<span class="icon-arrow_back">', '<span class="icon-arrow_forward">'],
        responsive:{
            600:{
                items: 2
            },
            1000:{
                items: 3
            }
        }
    });

    // Initialize Typed.js
    var slides = $('.slides'),
        images = slides.find('img');

    images.each(function(i) {
        $(this).attr('data-id', i + 1);
    });

    var typed = new Typed('.typed-words', {
		
        strings: [ <?php foreach ($sites as $site): ?>
                                    "<?php echo $site['name'] ?>.",
                                <?php endforeach; ?> ],
        typeSpeed: 80,
        backSpeed: 80,
        backDelay: 4000,
        startDelay: 1000,
        loop: true,
        showCursor: true,
        preStringTyped: (arrayPos, self) => {
            arrayPos++;
            $('.slides img').removeClass('active');
            $('.slides img[data-id="'+arrayPos+'"]').addClass('active');
        }
    });
});
</script>

<script src="assets/js/custom.js"></script>

</body>
</html>
