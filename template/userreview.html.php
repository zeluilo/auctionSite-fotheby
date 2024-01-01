<div class="section-bg style-1" style="background-image: url('../users/images/background.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 text-center mx-auto">
                <span class="caption text-white">Testimonials</span>
                <h2 class=" text-center mb-5 text-white">Happy <strong>Clients</strong></h2>
            </div>
        </div>
        <div class="owl-slide owl-carousel owl-testimonial owl-loaded owl-drag">
            <div class="owl-stage-outer">
                <div class="owl-stage" style="transform: translate3d(-2280px, 0px, 0px); transition: all 0.25s ease 0s; width: 6841px;">
                    <div class="owl-item cloned" style="width: 540.005px; margin-right: 30px;">
                        <div class="ftco-testimonial-1">
                            <?php
                            $auctionCounter = 0; // Counter to track the number of auctions displayed
                            foreach ($auction_cat_bids as $user) :
                                if ($auctionCounter >= 4) {
                                    break; // Exit the loop if 4 auctions have been displayed
                                }
                            ?>
                                <div class="ftco-testimonial-vcard d-flex align-items-center mb-4">
                                    <img src="../users/images/person_3.jpg" alt="Image" class="img-fluid mr-3">
                                    <div>
                                        <h3><?php echo $user['firstname'] . " " . $user['lastname']; ?></h3>
                                    </div>
                                </div>
                                <div>
                                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Neque, mollitia. Possimus mollitia nobis libero quidem aut tempore dolore iure maiores, perferendis, provident numquam illum nisi amet necessitatibus. A, provident aperiam!</p>
                                </div>
                            <?php
                                $auctionCounter++;
                            endforeach;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .section-bg.style-1 {
        position: relative;
    }

    .section-bg.style-1:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #f37121;
        opacity: .9;
        z-index: 0;
    }

    .section-bg {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        padding: 4rem 0;
    }

    .text-white {
        color: #fff !important;
    }

    .ftco-testimonial-1 .ftco-testimonial-vcard img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }

    .owl-carousel .owl-item img {
        display: block;
        width: 100%;
    }

    .mr-3 {
        margin-right: 1rem !important;
    }

    .img-fluid {
        max-width: 100%;
        height: auto;
    }

    img {
        vertical-align: middle;
        border-style: none;
    }

    .ftco-testimonial-1 .ftco-testimonial-vcard h3 {
        font-size: 1.2rem;
        display: block;
        margin-bottom: 0;
        color: white;
    }

    .ftco-testimonial-1 span {
        color: rgba(255, 255, 255, 0.5);
    }

    .section-bg.style-1 p {
        color: rgba(255, 255, 255, 0.5);
    }

    .ftco-testimonial-1 p {
        color: #fff;
        font-size: 20px;
    }
</style>