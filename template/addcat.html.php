<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Add Category</h1>
    <div class="col-xl-114">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Add A Category</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </a>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">Category name : 
                <form action="" method="POST">
                    <input type="text" value="" name="catname" autocomplete="off" required />
                    <input class="btn btn-secondary" type="submit" name="submit" value="Add" />
                </form> 
            </div>
            <?php echo $message;?>
        </div>
    </div>
</div>

