<?php
if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

use App\Addresses;
use App\Customer;
use App\ErrorMessage;
use App\Order;
use App\OrderItems;
use App\Product;

require_once "./views/layouts/header.php";
$order_id=$_SESSION['order_id'];
$customer_id=$_SESSION['customer_id'];
$customerName=Customer::getCustomerNameById($db,$customer_id);
$customerAddress=Addresses::getAdressByCustomerId($db,$customer_id);
$customerPhone=Customer::getCustomerPhoneById($db,$customer_id);
$customerEmail=Customer::getCustomerEmailById($db,$customer_id);
$order=Order::findByID($db,$order_id);
$order_details=OrderItems::getOrderById($db,$order_id);
$total=OrderItems::getTotalById($db,$order_id);
?>

<!--header area end-->
<section class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-9">
        
            <?php ErrorMessage::showMessege() ?>
    <div class="card">
        <div class="card-header pt-3">
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <h1 class="h5 mb-3">Shipping Address</h1>
                    <address>
                        <strong><?=$customerAddress['country']?></strong><br>
                        <?=$customerAddress['state']?>, <?=$customerAddress['city']?><br>
                        <?=$customerAddress['street1']?><?=$customerAddress['street2']?><br>
                        Type: <?=$customerAddress['type']?><br>
                        Phone: <?=$customerPhone?><br>
                        Email: <?=$customerEmail?>
                    </address>
                </div>



                <div class="col-sm-4 invoice-col">
                    <b>This invoice is registered under the name of:</b><?=$customerName?><br>
                    <b>Total:</b>$<?=$total['total_with_Shipping']?><br>
                    <b>Status:</b> <span class="text-success">Pendding</span>
                    <br>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-3">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th width="100">Price</th>
                        <th width="100">Qty</th>
                        <th width="100">Total</th>
                    </tr>
                </thead>
                        <?php $subtotal=0; ?>
                        <?php foreach($order_details as $item): ?>
                <tbody>

                    <tr><?php $productID=$item->getProductId()?>
                        <?php $product=Product::findNameByID($db,$productID);?>
                        <td><?=$product?></td>
                        <td>$<?=$item->getProductPrice()?></td>                                        
                        <td><?=$item->getQty()?></td>
                        <td>$<?=$item->getQty() * $item->getProductPrice() ?></td>
                    </tr>
                        <?php $subtotal+= $item->getQty() * $item->getProductPrice(); ?>
                        <?php endforeach;?> 
                    <tr>
                        <th colspan="3" class="text-right">Subtotal:</th>
                        <td>$<?=$subtotal?></td>
                    </tr>
                    
                    <tr>
                        <th colspan="3" class="text-right">Shipping:</th>
                        <td>$50.00</td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">Grand Total:</th>
                        <td>$<?=$item->getTotalWithShipping()?></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
</section>

<!--footer area start-->
<?php require_once "./views/layouts/footer.php"; ?>