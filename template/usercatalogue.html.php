<?php
require '../database.php';
?>

<div class="intro-section" style="background-image: url('../users/images/background.jpg');">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-7 mx-auto text-center aos-init aos-animate" data-aos="fade-up">
                <h1>Place Bids</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit, nihil.</p>
                <p><a href="/user/catalogue" class="btn btn-primary">Explore Now</a></p>
            </div>
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">

        <?php require 'filterHeading.html.php'; ?>

        <div class="row mb-8">
            <table class="table">
                <tbody>
                    <?php foreach ($auctions as $auction) : ?>
                        <?php
                        $date = strtotime($auction['endDate']);
                        $left_time = $date - time();

                        $day = floor($left_time / (60 * 60 * 24));
                        $left_time %= (60 * 60 * 24);

                        $hour = floor($left_time / (60 * 60));  // Fix: Correct the division here
                        $left_time %= (60 * 60);

                        $minute = floor($left_time / 60);
                        $left_time %= 60;

                        if ($day > 0) {
                            $showTime = "$day ds $hour hrs $minute ms";
                        } elseif ($hour > 0) {
                            $showTime = "$hour hrs $minute ms";
                        } elseif ($minute > 0) {
                            $showTime = "$minute ms";
                        } else {
                            $showTime = 'Auction Expired';
                        }

                        $isAuctionExpired = $left_time <= 0;

                        ?>
                        <tr>
                            <td>
                                <img width="150px" height="150" src="<?php echo '../img/auctions/' . $auction['img']; ?>" alt="Auction Image">

                            </td>
                            <td>
                                <p><strong>Auction Item: </strong> <?php echo htmlspecialchars($auction['title'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <p><strong>Item Description: </strong><?php echo limitWords(htmlspecialchars($auction['description'], ENT_QUOTES, 'UTF-8'), 30); ?></p>
                                <p><strong>Estimated Price: </strong><?php echo '£' . limitWords(htmlspecialchars($auction['price'], ENT_QUOTES, 'UTF-8'), 30); ?></p>
                            </td>
                            <td>
                                <p>Bidding Ends:<br><strong class="text-black"><?php echo $showTime ?></strong></p>
                                <?php if (!$isAuctionExpired) : ?>
                                    <p><a href="/user/bidpage?aucId=<?php echo $auction['aucId'] ?>"><button class="btn btn-primary" type="submit">Place Bid</button></a></p>
                                <?php else : ?>
                                    <p><button class="btn btn-primary" type="submit" disabled>Bid Expired</button></p>
                                    <?php endif; ?>&nbsp;
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (count($auctions) === 0) : ?>
                        <tr>
                            <td colspan="6">No Auctioned Items</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php require 'filterOptions.html.php'; ?>

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
                    if ($auctionCounter >= 4) {
                        break; // Exit the loop if 4 auctions have been displayed
                    }
                ?>
                    <div class="col-7 col-md-3">
                        <div class="item">
                            <div>
                                <strong class="price"><?php echo '$' . $auction['price'] ?></strong>
                                <a href="item-single.html"><img width="150px" src="<?php echo '../img/auctions/' . $auction['img']; ?>" alt="Image" class="img-fluid"></a>
                            </div>
                            <div class="p-4">
                                <h3><a href="item-single.html"><?php echo htmlspecialchars($auction['title'], ENT_QUOTES, 'UTF-8'); ?></a></h3>
                                <div class="d-flex mb-2">
                                    <span><?php echo htmlspecialchars($auction['catname'], ENT_QUOTES, 'UTF-8'); ?></span>
                                </div>
                                <a href="bidpage?aucId=<?php echo $auction['aucId'] ?>" class="btn btn-bid">Submit a Bid</a>
                            </div>
                        </div>
                    </div>
                <?php
                    $auctionCounter++;
                endforeach;
                ?>
            </div>
        </div>
    </div>


    <?php
    // Function to limit the number of words
    function limitWords($text, $limit)
    {
        $words = explode(" ", $text);
        $limitedWords = array_slice($words, 0, $limit);
        $limitedText = implode(" ", $limitedWords);
        if (count($words) > $limit) {
            $limitedText .= '...';
        }
        return $limitedText;
    }
    ?>