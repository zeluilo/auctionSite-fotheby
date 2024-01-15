<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Auction</h1>
    <div class="col-xl-114">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Edit An Auction</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </a>
                </div>
            </div>
            <!-- Card Body --> 
            <section class="w-100 p-4 pb-4">
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li role="presentation" class="nav-item"><a class="nav-link active" href="#edit" aria-controls="students" role="tab" data-toggle="tab">Edit Auction Info</a></li>
                <li role="presentation" class="nav-item"><a class="nav-link" href="#about" aria-controls="modules" role="tab" data-toggle="tab">Change Auction Image</a></li>
            </ul>
                <div class="row gutters">
                    <div class="col-xl-5">
                        <div class="card h-200">
                            <div class="card-body">
                                <div class="account-settings">
                                    <div class="user-profile">
                                        <div class="user-avatar">
                                            <p><strong>Auction Name: </strong> <?php echo $auction['title'] ?></p>
                                            <img width="410px" height="250" src="<?php echo '../img/auctions/' . $auction['img']; ?>" alt="Auction Image">
                                        </div>
                                    </div>
                                    &nbsp;
                                    <div class="about">
                                        <h5>Auction Item Details</h5>
                                        <p><strong>Auction ID: </strong> 00<?php echo isset($auction['aucId']) ? $auction['aucId'] : ''; ?></p>
                                        <p><strong>Exp Date:</strong> <?php echo isset($auction['endDate']) ? date('Y-m-d', strtotime($auction['endDate'])) : ''; ?></p>
                                    </div>
                                    <!-- <?php if($auction['status'] == 'Withdrawn') { ?>
                                        <a href="deletestudent?aucId=<?php echo $auction['aucId'] ?>"><button class="btn btn-danger" type="button">Delete Student Record</button></a>
                                    <?php } ?> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7">
                        <div class="card h-100">
                            <div class="card-body">
                                <form class="col-xl-12" action="/admin/editauction" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="aucId" value="<?php echo $auction['aucId'] ?>"/>
                                        <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="edit">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <h6 class="mb-2 text-primary">Auction Item Details</h6>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <label >Auction Name</label>
                                                    <input type="text" name="title" class="form-control" value="<?php echo $auction['title'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <label>Item Description</label>
                                                    <textarea class="form-control" name="description" required><?php echo $auction['description']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Start Date</label>
                                                    <input class="form-control" type="datetime-local" name="startDate" value="<?php echo date('Y-m-d\TH:i', strtotime($auction['startDate'])) ?>" min="<?php echo date('Y-m-d\TH:i'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Expiry Date</label>
                                                    <input class="form-control" type="datetime-local" name="endDate" value="<?php echo date('Y-m-d\TH:i', strtotime($auction['endDate'])) ?>" min="<?php echo date('Y-m-d\TH:i'); ?>">
                                                </div>
                                            </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="useremail">Item Category</label>
                                                    <select name="catId" class="form-control">
                                                        <?php foreach ($categories as $category): ?>
                                                            <option value="<?php echo $category['catId']; ?>" <?php if($auction['catId'] == $category['catId']) echo 'selected'; ?>>
                                                                <?php echo $category['catname']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>                                                
                                                </div>
                                            </div>
                                        </div>

                                        <div role="tabpanel" class="tab-pane" id="about">
                                            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                                <h1>Change Image</h1>
                                                <div class="user-profile">
                                                    <div class="user-avatar">
                                                        <p><strong>Auction Item: </strong> <?php echo $auction['title'] ?></p>
                                                        <img width="410px" height="250" src="<?php echo '../img/auctions/' . $auction['img']; ?>" alt="Auction Image">
                                                        <label for="validationDefault05" class="form-label" style="margin-left: 0px;">Upload an Image</label>
                                                        <input type="file" class="form-control" name="auct_pic" accept="image/*" value="<?php echo '../img/auctions/' . $auction['img']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row gutters">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="text-right">
                                                    <button type="submit" name="submit" class="btn btn-secondary">Update Auction</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <hr class="sidebar-divider">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Lots in this Auction</h6>
            </div>
            <div>
                <table class="table">
                    <tbody>
                        <?php foreach ($lots as $lot): ?>
                            <tr>
                                <td>
                                    <img width="150px" height="150" src="<?php echo '../img/lots/' . $lot['lotimage']; ?>" alt="Auction Image">
                                    
                                </td>
                                <td>
                                    <p><strong>Lot Item: </strong> <?php echo htmlspecialchars($lot['lotname'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <p><strong>Item Description: </strong><?php echo limitWords(htmlspecialchars($lot['lotdesc'], ENT_QUOTES, 'UTF-8'), 20); ?></p>                                
                                <a href="editlot?lotId=<?php echo $lot['lotId'] ?>">Edit Item Info</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (count($lots) === 0): ?>
                            <tr>
                                <td colspan="6">No Lot Items</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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