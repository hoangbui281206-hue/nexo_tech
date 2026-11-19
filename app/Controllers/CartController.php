<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Product;


class CartController extends BaseController
{
    /**
     * Hiển thị giỏ hàng
     */
    public function index(): void
    {
        $this->requireLogin();

        $cart = $_SESSION['cart'] ?? [];

        $this->view('cart/index', compact('cart'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add(): void
    {
        $this->requireLogin();

        $id = (int) ($_POST['product_id'] ?? 0);

        $product = (new Product())->find($id);

        if (!$product || (int) $product['stock'] < 1) {
            $_SESSION['flash'] = 'Sản phẩm không tồn tại hoặc đã hết hàng.';
            $this->redirect('/products');
        }

        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = [
                'name' => $product['name'],
                'price' => (float) (
                    $product['sale_price'] ?: $product['price']
                ),
                'image' => $product['image'],
                'quantity' => 0
            ];
        }

        $_SESSION['cart'][$id]['quantity']++;

        $_SESSION['flash'] = 'Đã thêm sản phẩm vào giỏ hàng.';

        $this->redirect('/cart');
    }

    /**
     * Cập nhật số lượng sản phẩm
     */
    public function update(): void
    {
        $this->requireLogin();

        $id = (int) ($_POST['product_id'] ?? 0);

        $quantity = max(
            1,
            min(20, (int) ($_POST['quantity'] ?? 1))
        );

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = $quantity;
        }

        $this->redirect('/cart');
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function remove(): void
    {
        $this->requireLogin();

        $id = (int) ($_POST['product_id'] ?? 0);

        unset($_SESSION['cart'][$id]);

        $this->redirect('/cart');
    }
}
