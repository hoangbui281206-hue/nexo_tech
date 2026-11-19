<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Mailer;
use App\Models\Order;

class OrderController extends BaseController
{
    /**
     * Đặt hàng
     */
    public function checkout(): void
    {
        $this->requireLogin();

        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            $_SESSION['flash'] = 'Giỏ hàng đang trống.';
            $this->redirect('/cart');
            return;
        }

        $customerName = trim(
            (string) ($_POST['customer_name'] ?? '')
        );

        $phone = trim(
            (string) ($_POST['phone'] ?? '')
        );

        $address = trim(
            (string) ($_POST['address'] ?? '')
        );

        $paymentMethod = trim(
            (string) ($_POST['payment_method'] ?? 'cod')
        );

        if (
            $customerName === ''
            || $phone === ''
            || $address === ''
        ) {
            $_SESSION['flash'] =
                'Vui lòng điền đầy đủ thông tin nhận hàng.';

            $this->redirect('/cart');
            return;
        }

        if (!in_array(
            $paymentMethod,
            ['cod', 'online'],
            true
        )) {
            $paymentMethod = 'cod';
        }

        try {

            $orderModel = new Order();

            $userId = (int) ($_SESSION['user']['id'] ?? 0);

            // Lưu đơn hàng vào database
            $orderId = $orderModel->create(
                $userId,
                $cart,
                $customerName,
                $phone,
                $address,
                $paymentMethod
            );

            // Lấy email tài khoản khách hàng
            $customerEmail = $orderModel->getUserEmail(
                $userId
            );

            // Xóa giỏ hàng sau khi tạo đơn thành công
            unset($_SESSION['cart']);

            /*
             * GỬI EMAIL XÁC NHẬN ĐƠN HÀNG
             */

            try {

                if (
                    $customerEmail !== null
                    && filter_var(
                        $customerEmail,
                        FILTER_VALIDATE_EMAIL
                    )
                ) {

                    // Chống lỗi HTML khi hiển thị dữ liệu
                    $safeName = htmlspecialchars(
                        $customerName,
                        ENT_QUOTES,
                        'UTF-8'
                    );

                    $safePhone = htmlspecialchars(
                        $phone,
                        ENT_QUOTES,
                        'UTF-8'
                    );

                    $safeAddress = htmlspecialchars(
                        $address,
                        ENT_QUOTES,
                        'UTF-8'
                    );

                    // Danh sách sản phẩm
                    $productRows = '';

                    $total = 0;

                    foreach ($cart as $item) {

                        $productName = htmlspecialchars(
                            (string) ($item['name'] ?? 'Sản phẩm'),
                            ENT_QUOTES,
                            'UTF-8'
                        );

                        $price = (float) ($item['price'] ?? 0);

                        $quantity = (int) ($item['quantity'] ?? 0);

                        $subtotal = $price * $quantity;

                        $total += $subtotal;

                        $productRows .= '
                            <tr>
                                <td style="padding:12px;border-bottom:1px solid #eeeeee;">
                                    ' . $productName . '
                                </td>

                                <td style="padding:12px;text-align:center;border-bottom:1px solid #eeeeee;">
                                    ' . $quantity . '
                                </td>

                                <td style="padding:12px;text-align:right;border-bottom:1px solid #eeeeee;">
                                    ' . number_format($price, 0, ',', '.') . ' đ
                                </td>

                                <td style="padding:12px;text-align:right;border-bottom:1px solid #eeeeee;">
                                    ' . number_format($subtotal, 0, ',', '.') . ' đ
                                </td>
                            </tr>
                        ';
                    }

                    // Phương thức thanh toán
                    $paymentText = $paymentMethod === 'online'
                        ? 'Thanh toán trực tuyến - Chờ thanh toán'
                        : 'Thanh toán khi nhận hàng (COD)';

                    // Trạng thái đơn hàng
                    $statusText = 'Chờ xác nhận';

                    // Tiêu đề email
                    $subject =
                        'Xác nhận đơn hàng #' . $orderId
                        . ' - NEXO TECH STORE';

                    // Nội dung email
                    $body = '
                    <!DOCTYPE html>
                    <html lang="vi">

                    <head>
                        <meta charset="UTF-8">
                        <title>Xác nhận đơn hàng</title>
                    </head>

                    <body style="
                        margin:0;
                        padding:20px;
                        background:#f4f4f4;
                        font-family:Arial,sans-serif;
                        color:#333333;
                    ">

                        <div style="
                            max-width:700px;
                            margin:0 auto;
                            background:#ffffff;
                            padding:25px;
                            border-radius:10px;
                        ">

                            <div style="
                                text-align:center;
                                padding:15px;
                                background:#222831;
                                border-radius:8px;
                            ">
                                <h1 style="
                                    color:#ffffff;
                                    margin:0;
                                ">
                                    NEXO TECH STORE
                                </h1>
                            </div>

                            <h2 style="color:#e91e63;">
                                Đặt hàng thành công!
                            </h2>

                            <p>
                                Xin chào
                                <strong>' . $safeName . '</strong>,
                            </p>

                            <p>
                                Cảm ơn bạn đã tin tưởng và mua hàng
                                tại NEXO TECH STORE.
                            </p>

                            <p>
                                Đơn hàng của bạn đã được ghi nhận
                                thành công.
                            </p>

                            <div style="
                                background:#f8f8f8;
                                padding:15px;
                                border-radius:8px;
                                margin:20px 0;
                            ">
                                <h3 style="margin-top:0;color:#e91e63;">
                                    Mã đơn hàng: #' . $orderId . '
                                </h3>

                                <p>
                                    <strong>Người nhận:</strong>
                                    ' . $safeName . '
                                </p>

                                <p>
                                    <strong>Số điện thoại:</strong>
                                    ' . $safePhone . '
                                </p>

                                <p>
                                    <strong>Địa chỉ nhận hàng:</strong>
                                    ' . $safeAddress . '
                                </p>

                                <p>
                                    <strong>Phương thức thanh toán:</strong>
                                    ' . $paymentText . '
                                </p>

                                <p>
                                    <strong>Trạng thái đơn hàng:</strong>
                                    ' . $statusText . '
                                </p>
                            </div>

                            <h3>Chi tiết sản phẩm</h3>

                            <table style="
                                width:100%;
                                border-collapse:collapse;
                            ">

                                <thead>
                                    <tr style="background:#f0f0f0;">

                                        <th style="
                                            padding:12px;
                                            text-align:left;
                                        ">
                                            Sản phẩm
                                        </th>

                                        <th style="padding:12px;">
                                            SL
                                        </th>

                                        <th style="
                                            padding:12px;
                                            text-align:right;
                                        ">
                                            Đơn giá
                                        </th>

                                        <th style="
                                            padding:12px;
                                            text-align:right;
                                        ">
                                            Thành tiền
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    ' . $productRows . '
                                </tbody>

                            </table>

                            <div style="
                                text-align:right;
                                margin-top:25px;
                            ">
                                <h2 style="color:#e91e63;">
                                    Tổng tiền:
                                    ' . number_format($total, 0, ',', '.') . ' đ
                                </h2>
                            </div>

                            <hr style="border:0;border-top:1px solid #eeeeee;">

                            <p>
                                Chúng tôi sẽ sớm xử lý đơn hàng
                                của bạn.
                            </p>

                            <p>
                                Cảm ơn bạn đã mua sắm tại
                                <strong>NEXO TECH STORE</strong>.
                            </p>

                            <div style="
                                text-align:center;
                                margin-top:25px;
                                color:#888888;
                                font-size:13px;
                            ">
                                © NEXO TECH STORE
                            </div>

                        </div>

                    </body>
                    </html>
                    ';

                    // Gửi email đến Gmail khách hàng
                    $sent = Mailer::send(
                        $customerEmail,
                        $customerName,
                        $subject,
                        $body
                    );

                    if (!$sent) {
                        error_log(
                            'Không gửi được email đơn hàng #'
                            . $orderId
                            . ' đến ' . $customerEmail
                        );
                    }

                } else {

                    error_log(
                        'Không tìm thấy email hợp lệ cho tài khoản #'
                        . $userId
                    );
                }

            } catch (\Throwable $mailError) {

                // Lỗi email không ảnh hưởng đơn hàng
                error_log(
                    'Lỗi gửi email đơn hàng #'
                    . $orderId . ': '
                    . $mailError->getMessage()
                );
            }

            // Chuyển hướng theo phương thức thanh toán
            if ($paymentMethod === 'online') {

                $_SESSION['flash'] =
                    'Đơn hàng #' . $orderId
                    . ' đã được tạo. Vui lòng tiếp tục thanh toán.';

                $this->redirect('/payment/' . $orderId);
                return;
            }

            $_SESSION['flash'] =
                'Đặt hàng thành công! Mã đơn hàng của bạn là #'
                . $orderId;

            $this->redirect('/my-orders');
            return;

        } catch (\Throwable $e) {

            $_SESSION['flash'] =
                'Không thể đặt hàng: ' . $e->getMessage();

            $this->redirect('/cart');
            return;
        }
    }

    /**
     * Danh sách đơn hàng của khách
     */
    public function myOrders(): void
    {
        $this->requireLogin();

        $orderModel = new Order();

        $orders = $orderModel->getByUserId(
            (int) $_SESSION['user']['id']
        );

        $this->view(
            'orders/my-orders',
            compact('orders')
        );
    }

    /**
     * Chi tiết đơn hàng của khách
     */
    public function myOrderDetail(): void
    {
        $this->requireLogin();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {

            $_SESSION['flash'] =
                'Mã đơn hàng không hợp lệ.';

            $this->redirect('/my-orders');
            return;
        }

        $orderModel = new Order();

        $order = $orderModel->findByUser(
            $id,
            (int) $_SESSION['user']['id']
        );

        if (!$order) {

            $_SESSION['flash'] =
                'Không tìm thấy đơn hàng hoặc bạn không có quyền xem.';

            $this->redirect('/my-orders');
            return;
        }

        $items = $orderModel->getItems($id);

        $this->view(
            'orders/my-order-detail',
            compact('order', 'items')
        );
    }
}
