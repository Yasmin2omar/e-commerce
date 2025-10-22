<?php
use App\Product;
use App\Database;

$db = Database::getInstance($config)->getConnection();

$search = $_GET['search'] ?? '';

if (!empty($search)) {
    $stmt = $db->prepare("
        SELECT * FROM products
        WHERE name LIKE :search 
        OR description LIKE :search
    ");
    $stmt->execute(['search' => "%$search%"]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $products = [];
    foreach ($rows as $row) {
        $products[] = new Product(
            $row['id'],
            $row['name'],
            $row['price'],
            $row['description'],
            $row['stock'],
            $row['category_id'],
            $row['image'] ?? ''
        );
    }
} else {
    $products = Product::getAll($db);
}

require_once __DIR__ . "/layouts/header.php";
?>

<!-- Navbar Breadcrumb -->
<div class="navbar-nav pl-2">
    <ol class="breadcrumb p-0 m-0 bg-white">
        <li class="breadcrumb-item"><a href="#">Products</a></li>
        <li class="breadcrumb-item active">List</li>
    </ol>
</div>

<ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
            <img src="img/avatar5.png" class="img-circle elevation-2" width="40" height="40" alt="">
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
            <h4 class="h4 mb-0"><strong>Admin</strong></h4>
            <div class="mb-3">admin@example.com</div>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item"><i class="fas fa-user-cog mr-2"></i> Settings</a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item"><i class="fas fa-lock mr-2"></i> Change Password</a>
            <div class="dropdown-divider"></div>
            <a href="index.php?page=logout_controller" class="dropdown-item text-danger">
								<i class="fas fa-sign-out-alt mr-2"></i> Logout							
			</a>
        </div>
    </li>
</ul>
</nav>

<!-- Sidebar -->
<?php require_once __DIR__ . "/layouts/nav.php"; ?>

<!-- Content Wrapper -->
<div class="content-wrapper">

    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="index.php?page=create-product" class="btn btn-primary">New Product</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">

                <div class="card-header">
                    <div class="card-tools">
                        <form method="GET" action="index.php">
                            <input type="hidden" name="page" value="products">
                            <div class="input-group" style="width: 250px;">
                                <input type="text" name="search" class="form-control float-right"
                                    placeholder="Search by name or description"
                                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th width="80">Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($products)): ?>
                            <?php foreach ($products as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p->getID()) ?></td>
                                <td><img src="/project3-e-commerce-main/<?= htmlspecialchars($p->getImage()) ?>"
                                        width="70" class="img-thumbnail"></td>
                                <td><?= htmlspecialchars($p->getName()) ?></td>
                                <td><?= htmlspecialchars($p->getDescription()) ?></td>
                                <td><?= htmlspecialchars($p->getCategoryId()) ?></td>
                                <td>$<?= htmlspecialchars($p->getPrice()) ?></td>
                                <td><?= htmlspecialchars($p->getStock()) ?></td>
                                <td>
                                    <a href="index.php?page=edit_product&id=<?= htmlspecialchars($p->getID()) ?>"
                                        class="text-primary mr-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="index.php?page=remove_product_controller&id=<?= htmlspecialchars($p->getID()) ?>" style="display:inline;">
                                        <button type="submit" name="remove" class="btn btn-link text-danger p-0 delete-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">No products found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    <ul class="pagination pagination m-0 float-right">
                        <li class="page-item"><a class="page-link" href="#">«</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">»</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </section>
</div>

<?php require_once __DIR__ . "/layouts/footer.php"; ?>

<!-- Scripts -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="js/adminlte.min.js"></script>
<script src="js/demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.delete-btn').forEach(btn => {

    btn.addEventListener('click', function(e) {
        const confirmDelete = confirm("Are you sure you want to delete this product?");
        if (!confirmDelete) e.preventDefault();
    });
});
</script>