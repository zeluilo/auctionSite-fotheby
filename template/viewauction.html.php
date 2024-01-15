<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">List All Auctions</h1>
    <div class="col-xl-114">
        <div class="card shadow mb-1">
            <div>
                <table class="table">
                    <thead>

                    </thead>
                    <tbody>
                        <?php foreach ($catalogues as $auction) : ?>
                            <tr>
                                <td>
                                    <img width="150px" height="150" src="<?php echo '../img/auctions/' . $auction['img']; ?>" alt="Auction Image">

                                </td>
                                <td>
                                    <p><strong>Auction Name: </strong> <?php echo htmlspecialchars($auction['title'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <p><strong>Item Category: </strong> <?php echo htmlspecialchars($auction['catname'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <p><strong>Auction Event Description: </strong><?php echo limitWords(htmlspecialchars($auction['description'], ENT_QUOTES, 'UTF-8'), 10); ?></p>
                                </td>

                                <td>
                                    <p><strong>Starts:</strong> <?php echo isset($auction['startDate']) ? date('Y-m-d', strtotime($auction['startDate'])) : ''; ?></p>
                                    <p><strong>Ends:</strong> <?php echo isset($auction['endDate']) ? date('Y-m-d', strtotime($auction['endDate'])) : ''; ?></p>
                                    <a href="editauction?aucId=<?php echo $auction['aucId'] ?>">Edit Item Info</a>
                                    &nbsp;
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (count($catalogues) === 0) : ?>
                            <tr>
                                <td colspan="6">No Auctioned Items</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
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