<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Category</h1>
    <div class="col-xl-114">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Edit this Category</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">Category name : 
                <form action="" method="POST">
                    <input type="hidden" name="catId" value="<?php echo $category['catId'] ?>" />
                    <input type="text" value="<?php echo $category['catname']?>" name="catname" autocomplete="off" required />
                    <input class="btn btn-secondary" type="submit" name="submit" value="Edit" />
                </form> 
            </div>
            <hr class="sidebar-divider">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Items in this Category</h6>
            </div>
            <div>
                <table class="table">
                    <tbody>
                        <?php foreach ($auctions as $auction): ?>
                            <tr>
                                <td>
                                    <img width="150px" height="150" src="<?php echo '../img/auctions/' . $auction['img']; ?>" alt="Auction Image">
                                    
                                </td>
                                <td>
                                    <p><strong>Auction Item: </strong> <?php echo htmlspecialchars($auction['title'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <p><strong>Item Description: </strong><?php echo limitWords(htmlspecialchars($auction['description'], ENT_QUOTES, 'UTF-8'), 20); ?></p>                                
                                <a href="editauction?aucId=<?php echo $auction['aucId'] ?>">Edit Item Info</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (count($auctions) === 0): ?>
                            <tr>
                                <td colspan="6">No Auctioned Items</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php echo $message;?>
        </div>
    </div>
</div>

<?php
// Function to limit the number of words
function limitWords($text, $limit) {
    $words = explode(" ", $text);
    $limitedWords = array_slice($words, 0, $limit);
    $limitedText = implode(" ", $limitedWords);
    if (count($words) > $limit) {
        $limitedText .= '...';
    }
    return $limitedText;
}
?>
