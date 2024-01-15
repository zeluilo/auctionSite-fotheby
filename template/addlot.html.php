<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Create a Lot</h1>
    <div class="col-xl-114">
        <div class="card shadow mb-4">
            <!-- Card Body -->
            <section class="w-100 p-4 pb-4">
                <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
                    <div class="col-lg-6">
                        <div class="form-outline" data-mdb-input-init="">
                            <input type="text" class="form-control active" name="lotnum" value="<?php echo $newLotNum; ?>" readonly>
                            <label for="lotnum" class="form-label" style="margin-left: 0px;">Lot Num</label>
                            <div class="form-notch">
                                <div class="form-notch-leading" style="width: 9px;"></div>
                                <div class="form-notch-middle" style="width: 68px;"></div>
                                <div class="form-notch-trailing"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-outline" data-mdb-input-init="">
                            <input type="text" class="form-control active" name="lotname" value="" required>
                            <label for="validationDefault01" class="form-label" style="margin-left: 0px;">Lot Title</label>
                            <div class="form-notch">
                                <div class="form-notch-leading" style="width: 9px;"></div>
                                <div class="form-notch-middle" style="width: 68.8px;"></div>
                                <div class="form-notch-trailing"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-outline" data-mdb-input-init="">
                            <textarea type="text" class="form-control active" name="lotdesc" value="" required></textarea>
                            <label for="validationDefault02" class="form-label" style="margin-left: 0px;">Lot Description</label>
                            <div class="form-notch">
                                <div class="form-notch-leading" style="width: 9px;"></div>
                                <div class="form-notch-middle" style="width: 68px;"></div>
                                <div class="form-notch-trailing"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-outline" data-mdb-input-init="">
                            <input type="number" class="form-control active" name="price" value="" required>
                            <label for="validationDefault02" class="form-label" style="margin-left: 0px;">Lot Original Price</label>
                            <div class="form-notch">
                                <div class="form-notch-leading" style="width: 9px;"></div>
                                <div class="form-notch-middle" style="width: 68px;"></div>
                                <div class="form-notch-trailing"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-outline" data-mdb-input-init="">
                            <input type="number" class="form-control active" name="year" max="2024" value="" required>
                            <label for="validationDefault02" class="form-label" style="margin-left: 0px;">Lot Year of Production</label>
                            <div class="form-notch">
                                <div class="form-notch-leading" style="width: 9px;"></div>
                                <div class="form-notch-middle" style="width: 68px;"></div>
                                <div class="form-notch-trailing"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-outline" data-mdb-input-init="">
                            <input type="file" class="form-control" name="auct_pic" accept="image/*" required>
                            <label for="validationDefault05" class="form-label" style="margin-left: 0px;">Upload an Image</label>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <select class="form-control" name="auctionId">
                                <option selected></option>
                                <?php
                                foreach ($auction as $row) {
                                    echo '<option value="' . $row['aucId'] . '">' . $row['title'] . '</option>';
                                }
                                ?>
                            </select>
                            <label>Assign to an Auction</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <input class="btn btn-secondary" type="submit" name="submit" value="Add" />
                    </div>
                </form>
            </section>
        </div>
        <?php echo $message; ?>
    </div>
</div>