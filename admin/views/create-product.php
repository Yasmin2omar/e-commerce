<?php

use App\Category;

require_once __DIR__."./layouts/header.php";
$categories=Category::getAll($db);

?>
				<div class="navbar-nav pl-2">
					<ol class="breadcrumb p-0 m-0 bg-white">
						<li class="breadcrumb-item"><a href="index.php?page=blogs">Products</a></li>
						<li class="breadcrumb-item active">Create</li>
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
							<img src="img/avatar5.png" class='img-circle elevation-2' width="40" height="40" alt="">
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
							<h4 class="h4 mb-0"><strong>Mohit Singh</strong></h4>
							<div class="mb-3">example@example.com</div>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item">
								<i class="fas fa-user-cog mr-2"></i> Settings								
							</a>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item">
								<i class="fas fa-lock mr-2"></i> Change Password
							</a>
							<div class="dropdown-divider"></div>
							<a href="index.php?page=logout_controller" class="dropdown-item text-danger">
								<i class="fas fa-sign-out-alt mr-2"></i> Logout							
							</a>							
						</div>
					</li>
				</ul>
			</nav>
			<!-- /.navbar -->
			<!-- Main Sidebar Container -->
						<?php require_once __DIR__."./layouts/nav.php"; ?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Create Product</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="index.php?page=blogs" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content --> <form method="post" action="index.php?page=store_product" enctype="multipart/form-data">
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
						<div class="card">
							<div class="card-body">								
								<div class="row">
                                   
									<div class="col-md-6">
										<div class="mb-3">
											<label for="name">Product Name</label>
											<input type="text" name="name" id="name" class="form-control" >	
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="name">Category_id</label>
											<select name="category_id" id="category_id" class="form-control">
                                            <?php foreach($categories as $categorie):?>
                                            <option value="<?=$categorie->getID()?>"><?=$categorie->getName()?></option>
                                            <?php endforeach;?>
                                        </select>	
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="name">Price	</label>
											<input type="number" name="price" id="name" class="form-control" >	
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="name">Description</label>
											<input type="text" name="description" id="name" class="form-control" >	
										</div>
									</div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="stock">Stock Status</label>
                                            <select name="stock" id="stock" class="form-control">
                                                <option value="In Stock">In Stock</option>
                                                <option value="Out of Stock">Out of Stock</option>
                                            </select>
                                        </div>
                                    </div>

									<div class="col-md-6">
										<div class="mb-3">
											<label for="name">Image</label>
											<input type="file" name="image" id="name" class="form-control" >	
										</div>
									</div>
								</div>
							</div>							
						</div>
						<div class="pb-5 pt-3">
							<button type="submit" name="create" class="btn btn-primary">Create</button>
						</div>
					</div>
                    
					<!-- /.card -->
				</section>
                                    </form>
				<!-- /.content -->
			</div>
			<!-- /.content-wrapper -->
			<?php require_once __DIR__."./layouts/footer.php"; ?>

		</div>
		<!-- ./wrapper -->
		<!-- jQuery -->
		<script src="plugins/jquery/jquery.min.js"></script>
		<!-- Bootstrap 4 -->
		<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- AdminLTE App -->
		<script src="js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="js/demo.js"></script>
	</body>
</html>