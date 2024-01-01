<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">List of Registered Users</h1>
    <div class="col-xl-114">
        <div class="card shadow mb-1">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">User List</h6>
            </div>
            <!-- Card Body -->
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Number</th>
                            <th scope="col">Address</th>
                            <th scope="col">Date Registered</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $rowNum = 1; ?>
                        <?php foreach ($users as $user): ?>
                            <?php if ($user['checkAdmin'] === 'USER'): ?>
                                <tr>
                                    <td><?php echo $rowNum; ?></td>
                                    <td><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($user['number'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($user['address'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($user['datecreate'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <a href="edituser?userId=<?php echo $user['userId'] ?>"><i class="fas fa-eye"></i></a>
                                        &nbsp;
                                        <a href="deleteuser?userId=<?php echo $user['userId'] ?>"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php $rowNum++; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php if ($rowNum === 1): ?>
                            <tr>
                                <td colspan="6">No current users</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
