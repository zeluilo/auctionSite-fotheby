<div class="col-md-3 order-1 mb-5 mb-md-0">
    <div class="border p-4 rounded mb-4">
        <h3 class="mb-3 h6 text-uppercase text-black d-block">Categories</h3>
        <ul class="list-unstyled mb-0">
            <?php foreach ($categories as $category) : ?>
                <?php
                $catId = $category['catId']; // Assuming the category ID field is 'catId'
                $sql1 = "SELECT COUNT(*) as totalAuctions FROM auction WHERE catId = :catId";
                $query1 = $pdo->prepare($sql1);
                $query1->bindParam(':catId', $catId, PDO::PARAM_INT);
                $query1->execute();
                $result1 = $query1->fetch(PDO::FETCH_OBJ);
                $totalAuctions = $result1->totalAuctions;
                ?>
                <li class="mb-1">
                    <a href="filterCategory?catId=<?php echo $category['catId'] ?>" class="d-flex">
                        <span><?php echo htmlspecialchars($category['catname'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <span class="text-black ml-auto"> (<?php echo $totalAuctions; ?>)</span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>


    <div class="border p-4 rounded mb-4">
        <div class="mb-4">
            <h3 class="mb-3 h6 text-uppercase text-black d-block">Filter by </h3>
        </div>
        <a href="?sort=asc" class="d-flex color-item align-items-center">
            <span class="text-black">Name, A to Z</span>
        </a>
        <a href="?sort=desc" class="d-flex color-item align-items-center">
            <span class="text-black">Name, Z to A</span>
        </a>   
    </div>

</div>
</div>