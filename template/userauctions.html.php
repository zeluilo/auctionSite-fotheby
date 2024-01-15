<div class="site-section">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-7 mb-5 text-center mx-auto">
                <span class="caption">Auctions</span>
                <h2 class="text-black">Current <strong>Auctions</strong></h2>
            </div>
        </div>
        <div class="row auctions-entry">
            <?php
            $auctionCounter = 0; // Counter to track the number of auctions displayed
            foreach ($auctioncats as $auction) :
                $startDate = strtotime($auction['startDate']);
                $currentTime = time();

                // Check if the auction has started (start date has passed)
                if ($currentTime >= $startDate) {
                    if ($auctionCounter >= 4) {
                        break; // Exit the loop if 4 auctions have been displayed
                    }
            ?>
                    <div class="col-7 col-md-3">
                        <div class="item">
                            <div>
                                <a href="item-single.html"><img width="150px" src="<?php echo '../img/auctions/' . $auction['auctionimage']; ?>" alt="Image" class="img-fluid"></a>
                            </div>
                            <div class="p-4">
                                <h3><a href="item-single.html"><?php echo htmlspecialchars($auction['title'], ENT_QUOTES, 'UTF-8'); ?></a></h3>
                                <div class="d-flex mb-2">
                                    <span><?php echo htmlspecialchars($auction['catname'], ENT_QUOTES, 'UTF-8'); ?></span>
                                </div>
                                <a href="userviewlots?aucId=<?php echo $auction['aucId'] ?>" class="btn btn-bid">View Lots</a>
                            </div>
                        </div>
                    </div>
            <?php
                    $auctionCounter++;
                }
            endforeach;

            // Display a message if no auctions have started
            if ($auctionCounter == 0) :
            ?>
                <div class="col-md-12 text-center">
                    <p>No current auctions available.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
