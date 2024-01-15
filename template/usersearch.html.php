<?php
require '../database.php';
?>
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

                    foreach ($auctionResults as $auction) :
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

                    foreach ($auctionResults as $auction) :
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