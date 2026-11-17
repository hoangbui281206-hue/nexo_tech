<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Product;

class ProductController extends BaseController
{
    /**
     * Danh sách sản phẩm
     */
    public function index(): void
    {
        $keyword = trim(
            (string) ($_GET['keyword'] ?? '')
        );

        $stock = trim(
            (string) ($_GET['stock'] ?? '')
        );

        $minPriceInput = str_replace(
            ['.', ',', ' '],
            '',
            trim((string) ($_GET['min_price'] ?? ''))
        );

        $maxPriceInput = str_replace(
            ['.', ',', ' '],
            '',
            trim((string) ($_GET['max_price'] ?? ''))
        );

        $minPrice = $minPriceInput !== ''
            ? (float) $minPriceInput
            : 0;

        $maxPrice = $maxPriceInput !== ''
            ? (float) $maxPriceInput
            : 0;

        $productModel = new Product();

        $products = $productModel->filter(
            $keyword,
            $stock,
            $minPrice,
            $maxPrice
        );

        $this->view(
            'products/index',
            compact(
                'products',
                'keyword',
                'stock',
                'minPrice',
                'maxPrice'
            )
        );
    }

    /**
     * Chi tiết sản phẩm
     *
     * ID được Router truyền từ URL:
     * /products/{id}
     */
    
    public function show(string $id = '0'): void
    {
        // Kiểm tra ID hợp lệ
        if (!ctype_digit($id)) {
            http_response_code(404);
            $_SESSION['flash'] = 'Mã sản phẩm không hợp lệ.';
            $this->redirect('/products');
            return;
        }
        
        $id = (int) $id;

        if ($id <= 0) {
            $_SESSION['flash'] = 'Mã sản phẩm không hợp lệ.';
            $this->redirect('/products');
            return;
        }

        $productModel = new Product();
        $product = $productModel->find($id);

        if (!$product) {
            $_SESSION['flash'] = 'Không tìm thấy sản phẩm.';
            $this->redirect('/products');
            return;
        }

        $this->view(
            'products/show',
            compact('product')
        );
    }
}