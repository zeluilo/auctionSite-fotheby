<?php
require '../database.php';
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Search Results</h1>
    <div class="col-xl-114">
        <div class="card shadow mb-1">

            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Searched Auctions</h6>
            </div>
            <div>
                <?php
                // Sort the auctions by auction_auction_datecreate in descending order
                usort($auctionResults, function ($a, $b) {
                    return strtotime($b['auction_datecreate']) - strtotime($a['auction_datecreate']);
                });
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Auction Title</th>
                            <th scope="col">Item Category</th>
                            <th scope="col">No. of Lots</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">Date Created</th>
                            <th scope="col">Date Updated</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $rowNum = 1; ?>
                        <?php foreach ($auctionResults as $auction): ?>
                            <?php
                            $aucId = $auction['aucId']; // Assuming the category ID field is 'aucId'
                            $sql1 = "SELECT COUNT(*) as totallotResults FROM lot WHERE auctionId = :aucId";
                            $query1 = $pdo->prepare($sql1);
                            $query1->bindParam(':aucId', $aucId, PDO::PARAM_INT);
                            $query1->execute();
                            $result1 = $query1->fetch(PDO::FETCH_OBJ);
                            $totallotResults = $result1->totallotResults;
                            ?>
                            <tr>
                                <td><?php echo $rowNum; ?></td>
                                <td><?php echo htmlspecialchars($auction['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($auction['catname'], ENT_QUOTES, 'UTF-8'); ?></td>                                
                                <td><?php echo $totallotResults; ?></td>
                                <td><?php echo isset($auction['startDate']) ? date('Y-m-d', strtotime($auction['startDate'])) : ''; ?></td>
                                <td><?php echo isset($auction['auction_datecreate']) ? date('Y-m-d', strtotime($auction['auction_datecreate'])) : ''; ?></td>
                                <td><?php echo isset($auction['auction_dateupdate']) ? date('Y-m-d', strtotime($auction['auction_dateupdate'])) : ''; ?></td>
                                <td>
                                    <?php
                                    $currentDate = time();
                                    $startDate = strtotime($auction['startDate']);
                                    
                                    if ($currentDate < $startDate) {
                                        echo "Upcoming";
                                    } elseif ($currentDate >= $startDate) {
                                        echo "Ongoing";
                                    } else {
                                        echo "Ended";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="editauction?aucId=<?php echo $auction['aucId'] ?>"><i class="fas fa-eye"></i></a>
                                    &nbsp;
                                    <a href="deleteauction?aucId=<?php echo $auction['aucId'] ?>"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php $rowNum++; ?>
                        <?php endforeach; ?>
                        <?php if (count($auctionResults) === 0): ?>
                            <tr>
                                <td colspan="6">Table is Empty :(</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Searched Lots</h6>
            </div>
            <div>
                <?php
                // Sort the lotResults by lot_datecreate in descending order
                usort($lotResults, function ($a, $b) {
                    return strtotime($b['datecreate']) - strtotime($a['datecreate']);
                });
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Lot Item</th>
                            <th scope="col">Assigned Auction</th>
                            <th scope="col">Est. Price</th>
                            <th scope="col">Year of Production</th>
                            <th scope="col">Date Created</th>
                            <th scope="col">Date Updated</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $rowNum = 1; ?>
                        <?php foreach ($lotResults as $lot) : ?>
                            <tr>
                                <td><?php echo $rowNum; ?></td>
                                <td><?php echo htmlspecialchars($lot['lotname'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <?php
                                    if (!empty($lot['aucId'])) {
                                        // Fetch the auction title based on auctionId
                                        echo htmlspecialchars($auctionTitles[$lot['aucId']], ENT_QUOTES, 'UTF-8');
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td><?php echo '£' . htmlspecialchars($lot['price'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($lot['year'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($lot['datecreate'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($lot['dateupdate'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <a href="editlot?lotId=<?php echo $lot['lotId'] ?>"><i class="fas fa-eye"></i></a>
                                    &nbsp;
                                    <a href="deletelot?lotId=<?php echo $lot['lotId'] ?>"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php $rowNum++; ?>
                        <?php endforeach; ?>
                        <?php if (count($lotResults) === 0) : ?>
                            <tr>
                                <td colspan="6">Table is Empty :(</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
