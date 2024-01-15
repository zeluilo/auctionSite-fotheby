<?php
$isLoggedInOrRegistered = isset($_SESSION['userDetails']);

// Check if the logged-in user's checkAdmin is "USER"
$isUser = $isLoggedInOrRegistered && $_SESSION['userDetails']['checkAdmin'] === 'USER';
$isSeller = $isLoggedInOrRegistered && $_SESSION['userDetails']['checkAdmin'] === 'SELLER';
require '../database.php';



$date = strtotime($auctions['endDate']);
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
    $showTime = 'lot Expired';
}

$islotExpired = $left_time <= 0;

?>

<div class="intro-section" style="background-image: url('<?php echo '../img/auctions/' . $auctions['img']; ?>');">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-7 mx-auto text-center aos-init aos-animate" data-aos="fade-up">
                <h1><?php echo $auctions['title'] ?></h1>
                <p>
                    <a href="/user/userviewlots?aucId=<?php echo $auctions['aucId'] ?>" class="btn btn-primary">Auction Lots</a>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">
            <p class="caption">Bidding Starts:</p>
            <?php
            function customDateFormat($dateString)
            {
                if ($dateString === null) {
                    return '-';
                }

                $date = new DateTime($dateString);
                $formattedDate = $date->format('jS F Y');
                return $formattedDate;
            }

            echo customDateFormat($auctions['startDate'] ?? null);
            ?>
        <div class="row mb-12">
            <div class="col-md-9 order-2">
                <div class="d-flex">
                    <div class="dropdown mr-1 ml-md-auto">
                        <a href="?sort=upcoming&aucId=<?php echo $aucId; ?>" class="btn btn-secondary btn-sm">Newest</a>
                    </div>
                    <div class="btn-group">
                        <a href="?sort=latest&aucId=<?php echo $aucId; ?>" class="btn btn-secondary btn-sm">Upcoming</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-5">
                        <div class="float-md-left mb-4">
                            <a href="/user/catalogue">
                                <h2 class="text-black h5">Shop All</h2>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row mb-8">

                    <table class="table">
                        <h5>Bidding Ends: <strong class="text-black"><?php echo '  ' . $showTime ?></strong></h5>

                        <tbody>

                            <?php foreach ($lots as $lot) : ?>
                                <tr>
                                    <td>
                                        <img width="150px" height="150" src="<?php echo '../img/lots/' . $lot['lotimage']; ?>" alt="lot Image">

                                    </td>
                                    <td>
                                        <p><strong>Lot Num: </strong> <?php echo htmlspecialchars($lot['lotnum'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <p><strong>Lot Item: </strong> <?php echo htmlspecialchars($lot['lotname'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <p><strong>Item Description: </strong><?php echo limitWords(htmlspecialchars($lot['lotdesc'], ENT_QUOTES, 'UTF-8'), 30); ?></p>
                                        <p><strong>Estimated Price: </strong><?php echo '£' . limitWords(htmlspecialchars($lot['price'], ENT_QUOTES, 'UTF-8'), 30); ?></p>
                                    </td>
                                    <td>
                                        <?php if (!$islotExpired) : ?>
                                            <p><a href="/user/bidpage?lotId=<?php echo $lot['lotId'] ?>"><button class="btn btn-primary" type="submit">Place Bid</button></a></p>
                                        <?php else : ?>
                                            <p><button class="btn btn-primary" type="submit" disabled>Bid Expired</button></p>
                                            <?php endif; ?>&nbsp;
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (count($lots) === 0) : ?>
                                <tr>
                                    <td colspan="6">No Current Lots</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-3 order-1 mb-5 mb-md-0">

                <div class="border p-4 rounded mb-4">
                    <div class="mb-4">
                        <h3 class="mb-3 h6 text-uppercase text-black d-block">Filter by </h3>
                    </div>
                    <a href="?sort=asc&aucId=<?php echo $aucId; ?>" class="d-flex color-item align-items-center">
                        <span class="text-black">Name, A to Z</span>
                    </a>
                    <a href="?sort=desc&aucId=<?php echo $aucId; ?>" class="d-flex color-item align-items-center">
                        <span class="text-black">Name, Z to A</span>
                    </a>
                </div>

                <div class="border p-4 rounded mb-4">
                    <div class="mb-4">
                        <h3 class="mb-3 h6 text-uppercase text-black d-block">Filter by Price</h3>
                    </div>
                    <a href="?sort=0-350&aucId=<?php echo $aucId; ?>" class="d-flex color-item align-items-center">
                        <span class="text-black">£0-£350</span>
                    </a>
                    <a href="?sort=350-650&aucId=<?php echo $aucId; ?>" class="d-flex color-item align-items-center">
                        <span class="text-black">£350-£650</span>
                    </a>
                    <a href="?sort=650-1000&aucId=<?php echo $aucId; ?>" class="d-flex color-item align-items-center">
                        <span class="text-black">£650-£1000</span>
                    </a>
                    <a href="?sort=1000&aucId=<?php echo $aucId; ?>" class="d-flex color-item align-items-center">
                        <span class="text-black">£1000+</span>
                    </a>
                </div>

            </div>
        </div>
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