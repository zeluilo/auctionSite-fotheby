<?php
require '../database.php';
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">List of Categories</h1>
    <div class="col-xl-114">
        <div class="card shadow mb-1">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Category List</h6>
            </div>
            <!-- Card Body -->
            <div>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Category</th>
                        <th scope="col">No. of Auctions</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Date Updated</th>
                        <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $rowNum = 1; ?>
                        <?php foreach ($categories as $category): ?>
                            <?php
                            $catId = $category['catId']; // Assuming the category ID field is 'catId'
                            $sql1 = "SELECT COUNT(*) as totalAuctions FROM auction WHERE catId = :catId";
                            $query1 = $pdo->prepare($sql1);
                            $query1->bindParam(':catId', $catId, PDO::PARAM_INT);
                            $query1->execute();
                            $result1 = $query1->fetch(PDO::FETCH_OBJ);
                            $totalAuctions = $result1->totalAuctions;
                            ?>
                            <tr>
                                <td><?php echo $rowNum; ?></td>
                                <td><?php echo htmlspecialchars($category['catname'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo $totalAuctions; ?></td>
                                <td><?php echo htmlspecialchars($category['datecreate'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($category['dateupdate'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><a href="editcategory?catId=<?php echo $category['catId'] ?>"><i class="fas fa-eye"></i></a>
                                &nbsp;
                                    <a href="deletecategory?catId=<?php echo $category['catId'] ?>"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php $rowNum++; ?>
                        <?php endforeach; ?>
                        <?php if (count($categories) === 0): ?>
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