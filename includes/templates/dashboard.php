<?php
/**
 * PrintKK dashboard.
 * @var array $resData
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="printkk-base-box">
    <img src="<?php echo esc_url( printkk_admin_image_url().'logo.png' ); ?>" alt="PrintKk" class="printkk-logo">
</div>
<div class="printkk-base-box printkk-statistics">
    <div class="printkk-statistics-orders">
        <div class="printkk-statistics-title">Orders</div>
        <div class="printkk-statistics-content">
            <div class="printkk-statistics-content-item">
                <div class="printkk-statistics-content-item-number">$ <?php echo esc_html($resData['totalPrice']) ?></div>
                <div class="printkk-statistics-content-item-words">Total <span><?php echo esc_html($resData['totalOrder']) ?></span> ORDERS</div>
            </div>
            <div class="printkk-statistics-content-item">
                <div class="printkk-statistics-content-item-number">$ <?php echo esc_html($resData['todayPrice']) ?></div>
                <div class="printkk-statistics-content-item-words"><span><?php echo esc_html($resData['todayOrder']) ?></span> ORDERS today</div>
            </div>
            <div class="printkk-statistics-content-item">
                <div class="printkk-statistics-content-item-number">$ <?php echo esc_html($resData['lastTwentyEightDaysPrice']) ?></div>
                <div class="printkk-statistics-content-item-words"><span><?php echo esc_html($resData['lastTwentyEightDaysOrder']) ?></span> ORDERS last 28 days</div>
            </div>
            <div class="printkk-statistics-content-item">
                <div class="printkk-statistics-content-item-number">$ <?php echo esc_html($resData['pendingPrice']) ?></div>
                <div class="printkk-statistics-content-item-words">Pending <span><?php echo esc_html($resData['pendingOrder']) ?></span> ORDERS</div>
            </div>
        </div>
    </div>
    <div class="printkk-statistics-products">
        <div class="printkk-statistics-title">Products</div>
        <div class="printkk-statistics-content">
            <div class="printkk-statistics-content-item">
                <div class="printkk-statistics-content-item-number"><?php echo esc_html($resData['onSaleProduct']) ?></div>
                <div class="printkk-statistics-content-item-words">On Sale</div>
            </div>
            <div class="printkk-statistics-content-item">
                <div class="printkk-statistics-content-item-number"><?php echo esc_html($resData['totalSales']) ?></div>
                <div class="printkk-statistics-content-item-words">Sale Volume</div>
            </div>
        </div>
    </div>
</div>
<div class="printkk-base-box printkk-title">
    PrintKK Orders
    <span class="tips">
        ?
    </span>
    <div class="tips-message">Only the last 50 orders are shown here, please return to PrintKK for more information.</div>
</div>
<table class="printkk-base-box printkk-orders">
    <thead>
        <tr>
            <th>Order</th>
            <th>Date</th>
            <th>From</th>
            <th>Status</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($resData['orderList'] as $order) {?>
        <tr>
            <td><?php echo esc_html($order['id']) ?></td>
            <td><?php echo esc_html($order['createTime']) ?></td>
            <td><?php echo esc_html($order['fullName']) ?></td>
            <td><?php echo esc_html($order['orderStatus']) ?></td>
            <td><?php echo esc_html($order['orderPriceTotal']) ?></td>
            <td><a href="https://dashboard.printkk.com/order/order-management/order-details?orderId=<?php echo esc_html($order['id']) ?>" target="_blank">Open in PrintKK </a></td>
        </tr>
    <?php }?>
    </tbody>
</table>
<div class="printkk-base-box printkk-title"> Quick links</div>
<div class="printkk-base-box printkk-quick-links">
    <div class="printkk-quick-links-item" onclick="printkk_href('https://dashboard.printkk.com/dashboard')">
        <div class="printkk-quick-links-item-content">
            <img src="<?php echo esc_url( printkk_admin_image_url().'dashboard.jpg' )?>">
            <div class="printkk-quick-links-item-title">Dashboard</div>
        </div>
    </div>
    <div class="printkk-quick-links-item" onclick="printkk_href('https://dashboard.printkk.com/file-library/images')">
        <div class="printkk-quick-links-item-content">
            <img src="<?php echo esc_url( printkk_admin_image_url().'library.jpg' )?>">
            <div class="printkk-quick-links-item-title">File library</div>
        </div>
    </div>
    <div class="printkk-quick-links-item" onclick="printkk_href('https://dashboard.printkk.com/designs/my-designs')">
        <div class="printkk-quick-links-item-content">
            <img src="<?php echo esc_url( printkk_admin_image_url().'designs.jpg' )?>">
            <div class="printkk-quick-links-item-title">My designs</div>
        </div>
    </div>
    <div class="printkk-quick-links-item" onclick="printkk_href('https://dashboard.printkk.com/stores/settings')">
        <div class="printkk-quick-links-item-content">
            <img src="<?php echo esc_url( printkk_admin_image_url().'stores.jpg' )?>">
            <div class="printkk-quick-links-item-title">Stores</div>
        </div>
    </div>
    <div class="printkk-quick-links-item" onclick="printkk_href('https://dashboard.printkk.com/orders/my-orders')">
        <div class="printkk-quick-links-item-content">
            <img src="<?php echo esc_url( printkk_admin_image_url().'orders.jpg' )?>">
            <div class="printkk-quick-links-item-title">Orders</div>
        </div>
    </div>
    <div class="printkk-quick-links-item" onclick="printkk_href('https://dashboard.printkk.com/dashboard')">
        <div class="printkk-quick-links-item-content">
            <img src="<?php echo esc_url( printkk_admin_image_url().'cart.jpg' )?>">
            <div class="printkk-quick-links-item-title">Carts</div>
        </div>
    </div>
</div>
