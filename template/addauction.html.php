<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Add Auction</h1>
    <div class="col-xl-114">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Add An Auction</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </a>
                </div>
            </div>
            <!-- Card Body --> 
        <section class="w-100 p-4 pb-4">
            <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
                <div class="col-md-6">
                    <div class="form-outline" data-mdb-input-init="">
                            <input type="text" class="form-control active" name="title" value="" required>
                            <label for="validationDefault01" class="form-label" style="margin-left: 0px;">Item Title</label>
                        <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 68.8px;"></div><div class="form-notch-trailing"></div></div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                    <select class="form-control" name="catId" required >
                            <?php
                            foreach ($category as $row) {
                                echo '<option value="' . $row['catId'] . '">' . $row['catname'] . '</option>';
                            }
                            ?>
                        </select>
                        <label>Item Category</label>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-outline" data-mdb-input-init="">
                        <textarea type="text" class="form-control active" name="description" value="" required></textarea>
                        <label for="validationDefault02" class="form-label" style="margin-left: 0px;">Item Description</label>
                    <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 68px;"></div><div class="form-notch-trailing"></div></div></div>
                </div>
                <div class="col-lg-6">
                    <div class="form-outline" data-mdb-input-init="">
                    <input type="number" class="form-control active" name="price" value="" required>
                        <label for="validationDefault02" class="form-label" style="margin-left: 0px;">Item Original Price</label>
                    <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 68px;"></div><div class="form-notch-trailing"></div></div></div>
                </div>
                <div class="col-md-6">
                    <div class="form-outline" data-mdb-input-init="">
                        <input type="date" class="form-control" name="endDate" min="<?php echo date('Y-m-d'); ?>" required>
                        <label for="validationDefault05" class="form-label" style="margin-left: 0px;">End Date for Auction</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-outline" data-mdb-input-init="">
                        <input type="file" class="form-control" name="auct_pic" accept="image/*" required>
                        <label for="validationDefault05" class="form-label" style="margin-left: 0px;">Upload an Image</label>
                    </div>
                </div>
                <div class="col-12">
                    <input class="btn btn-secondary" type="submit" name="submit" value="Add" />
                </div>
                </form>
        </section>
            </div>
            <?php echo $message;?>
        </div>
</div>

      
