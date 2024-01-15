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

        <div class="row mb-10">
            <table class="table">
                <h5>Ongoing Auctions</h5>
                <tbody>
                    <!-- #region -->
                    <?php
                    $numColumns = 3; // Number of columns
                    $rowCount = 0;   // Initialize row count

                    foreach ($auctions as $auction) :
                        $startDate = strtotime($auction['startDate']);
                        $currentTime = time();

                        if ($currentTime >= $startDate) { // Auction has started
                            $date = strtotime($auction['endDate']);
                            $left_time = $date - $currentTime;

                            $day = floor($left_time / (60 * 60 * 24));
                            $left_time %= (60 * 60 * 24);

                            $hour = floor($left_time / (60 * 60));
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

                            // Open a new row for the first column
                            if ($rowCount % $numColumns == 0) {
                                echo '<tr>';
                            }
                    ?>
                            <td>
                                <!-- Display ongoing auction details here -->
                                <img width="150px" height="150" src="<?php echo '../img/auctions/' . $auction['auctionimage']; ?>" alt="Auction Image"><br>
                                <strong>Auction Name: </strong> <?php echo htmlspecialchars($auction['title'], ENT_QUOTES, 'UTF-8'); ?><br>
                                <strong>Category: </strong> <?php echo htmlspecialchars($auction['catname'], ENT_QUOTES, 'UTF-8'); ?><br>
                                <strong>Start Date: </strong> <?php echo isset($auction['startDate']) ? date('Y-m-d', strtotime($auction['startDate'])) : ''; ?>
                                <p><strong>End Date: </strong> <?php echo isset($auction['endDate']) ? date('Y-m-d', strtotime($auction['endDate'])) : ''; ?></p>

                                <?php if (!$isAuctionExpired) : ?>
                                    <p><a href="/user/userviewlots?aucId=<?php echo $auction['aucId'] ?>"><button class="btn btn-primary" type="submit">View Lots</button></a></p>
                                <?php else : ?>
                                    <p><button class="btn btn-primary" type="submit" disabled>Auction Ended</button></p>
                                    <?php endif; ?>&nbsp;
                            </td>
                        <?php
                            // Close the row after the last column
                            if ($rowCount % $numColumns == $numColumns - 1) {
                                echo '</tr>';
                            }

                            // Increment the row count
                            $rowCount++;
                        }
                    endforeach;

                    // If the last row is not complete, close it
                    if ($rowCount % $numColumns != 0) {
                        echo '</tr>';
                    }

                    if ($rowCount == 0) :
                        ?>
                        <tr>
                            <td colspan="<?php echo $numColumns; ?>">No Ongoing Auctions</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="row mb-10">
            <table class="table">
                <h5>Upcoming Auctions</h5>
                <tbody>
                    <!-- #region -->
                    <?php
                    $numColumns = 3; // Number of columns
                    $rowCount = 0;   // Initialize row count

                    foreach ($auctions as $auction) :
                        $startDate = strtotime($auction['startDate']);
                        $currentTime = time();

                        if ($currentTime < $startDate) { // Auction hasn't started yet
                            // Open a new row for the first column
                            if ($rowCount % $numColumns == 0) {
                                echo '<tr>';
                            }
                    ?>
                            <td>
                                <!-- Display upcoming auction details here -->
                                <img width="150px" height="150" src="<?php echo '../img/auctions/' . $auction['auctionimage']; ?>" alt="Auction Image"><br>
                                <strong>Auction Name: </strong> <?php echo htmlspecialchars($auction['title'], ENT_QUOTES, 'UTF-8'); ?><br>
                                <strong>Category: </strong> <?php echo htmlspecialchars($auction['catname'], ENT_QUOTES, 'UTF-8'); ?><br>
                                <strong>Start Date: </strong> <?php echo isset($auction['startDate']) ? date('Y-m-d', strtotime($auction['startDate'])) : ''; ?>
                                <p><strong>End Date: </strong> <?php echo isset($auction['endDate']) ? date('Y-m-d', strtotime($auction['endDate'])) : ''; ?></p>

                                <!-- Add any additional details or buttons for upcoming auctions here -->
                            </td>
                        <?php
                            // Close the row after the last column
                            if ($rowCount % $numColumns == $numColumns - 1) {
                                echo '</tr>';
                            }

                            // Increment the row count
                            $rowCount++;
                        }
                    endforeach;

                    // If the last row is not complete, close it
                    if ($rowCount % $numColumns != 0) {
                        echo '</tr>';
                    }

                    if ($rowCount == 0) :
                        ?>
                        <tr>
                            <td colspan="<?php echo $numColumns; ?>">No Upcoming Auctions</td>
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