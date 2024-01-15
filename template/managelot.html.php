<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">List of lots</h1>
    <div class="col-xl-114">
        <div class="card shadow mb-1">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Lot List</h6>
            </div>
            <!-- Card Body -->
            <div>
                <?php
                // Sort the lots by lot_datecreate in descending order
                usort($lots, function ($a, $b) {
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
                        <?php foreach ($lots as $lot) : ?>
                            <tr>
                                <td><?php echo $rowNum; ?></td>
                                <td><?php echo htmlspecialchars($lot['lotname'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <?php
                                    if (!empty($lot['auctionId'])) {
                                        // Fetch the auction title based on auctionId
                                        echo htmlspecialchars($auctionTitles[$lot['auctionId']], ENT_QUOTES, 'UTF-8');
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td><?php echo '£' . htmlspecialchars($lot['price'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($lot['year'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo isset($lot['datecreate']) ? date('Y-m-d', strtotime($lot['datecreate'])) : ''; ?></td>
                                <td><?php echo isset($lot['datecreate']) ? date('Y-m-d', strtotime($lot['datecreate'])) : ''; ?></td>
                                <td>
    <a href="editlot?lotId=<?php echo $lot['lotId'] ?>"><i class="fas fa-eye"></i></a>
    &nbsp;
    <?php
    if (empty($lot['auctionId'])) {
        echo '<a href="deletelot?lotId=' . $lot['lotId'] . '"> <i class="fas fa-trash"></i></a>';
    } else {
        echo '<span style="color: red;">Cannot Delete (Assigned Auction)</span>';
    }
    ?>
</td>
                            </tr>
                            <?php $rowNum++; ?>
                        <?php endforeach; ?>
                        <?php if (count($lots) === 0) : ?>
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