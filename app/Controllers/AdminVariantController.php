<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Product;
use App\Models\ProductVariant;
use Throwable;

class AdminVariantController extends BaseController
{
    /**
 * Trang quản lý biến thể
 * Bao gồm form thêm và danh sách biến thể
 */
public function index(): void
{
    $variantModel = new ProductVariant();
    $productModel = new Product();

    // Lấy toàn bộ biến thể
    $variants = $variantModel->allAdmin();

    // Lấy danh sách điện thoại để hiển thị trong dropdown
    $products = $productModel->all();

    $this->view(
        'admin/variants',
        compact('variants', 'products')
    );
}

/**
 * Mở trang thêm biến thể
 * Form thêm nằm chung trang quản lý biến thể
 */
public function createForm(): void
{
    $this->index();
}

    /**
     * Lưu biến thể mới
     */
    public function store(): void
    {
        $data = $this->getFormData();

        $error = $this->validateData($data);

        if ($error !== null) {
            $_SESSION['flash'] = $error;
            $this->redirect('/admin/variants/create');
            return;
        }

        $imagePath = null;

        try {
            $data['image'] = $this->uploadImage();
            $imagePath = $data['image'];

            $variantModel = new ProductVariant();

            $variantModel->create($data);

            $_SESSION['flash'] = 'Thêm biến thể thành công!';

        } catch (Throwable $e) {

            // Xóa ảnh vừa tải nếu lưu dữ liệu thất bại
            if ($imagePath !== null) {
                $this->removeImage($imagePath);
            }

            error_log($e->getMessage());

            $_SESSION['flash'] =
                'Không thể thêm biến thể. Vui lòng kiểm tra dữ liệu.';
        }

        $this->redirect('/admin/variants');
    }

    /**
     * Form sửa biến thể
     */
    public function editForm(string $id = '0'): void
    {
        if (!ctype_digit($id) || (int) $id <= 0) {
            $_SESSION['flash'] = 'ID biến thể không hợp lệ.';
            $this->redirect('/admin/variants');
            return;
        }

        $variantModel = new ProductVariant();

        $variant = $variantModel->find((int) $id);

        if (!$variant) {
            $_SESSION['flash'] = 'Không tìm thấy biến thể.';
            $this->redirect('/admin/variants');
            return;
        }

        $productModel = new Product();

        $products = $productModel->all();

        $this->view(
            'admin/edit-variant',
            compact('variant', 'products')
        );
    }

    /**
     * Cập nhật biến thể
     */
    public function update(): void
    {
        $id = trim((string) ($_POST['id'] ?? ''));

        if (!ctype_digit($id) || (int) $id <= 0) {
            $_SESSION['flash'] = 'ID biến thể không hợp lệ.';
            $this->redirect('/admin/variants');
            return;
        }

        $variantModel = new ProductVariant();

        $variant = $variantModel->find((int) $id);

        if (!$variant) {
            $_SESSION['flash'] = 'Không tìm thấy biến thể.';
            $this->redirect('/admin/variants');
            return;
        }

        $data = $this->getFormData();

        $error = $this->validateData($data);

        if ($error !== null) {
            $_SESSION['flash'] = $error;
            $this->redirect('/admin/variants/edit/' . (int) $id);
            return;
        }

        $oldImage = $variant['image'] ?? null;
        $newImage = null;

        try {
            // Mặc định giữ ảnh cũ
            $data['image'] = $oldImage;

            // Chỉ upload khi người dùng chọn ảnh mới
            if (
                isset($_FILES['image']) &&
                $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE
            ) {
                $newImage = $this->uploadImage();
                $data['image'] = $newImage;
            }

            $variantModel->update((int) $id, $data);

            // Xóa ảnh cũ sau khi cập nhật thành công
            if ($newImage !== null && $oldImage !== null) {
                $this->removeImage($oldImage);
            }

            $_SESSION['flash'] = 'Cập nhật biến thể thành công!';

        } catch (Throwable $e) {

            // Nếu cập nhật thất bại thì xóa ảnh mới vừa upload
            if ($newImage !== null) {
                $this->removeImage($newImage);
            }

            error_log($e->getMessage());

            $_SESSION['flash'] =
                'Không thể cập nhật biến thể. Vui lòng kiểm tra dữ liệu.';
        }

        $this->redirect('/admin/variants');
    }

    /**
     * Xóa biến thể
     */
    public function delete(): void
    {
        $id = trim((string) ($_POST['id'] ?? ''));

        if (!ctype_digit($id) || (int) $id <= 0) {
            $_SESSION['flash'] = 'ID biến thể không hợp lệ.';
            $this->redirect('/admin/variants');
            return;
        }

        try {
            $variantModel = new ProductVariant();

            $variant = $variantModel->find((int) $id);

            if (!$variant) {
                $_SESSION['flash'] = 'Không tìm thấy biến thể.';
                $this->redirect('/admin/variants');
                return;
            }

            $variantModel->delete((int) $id);

            // Xóa ảnh sau khi xóa biến thể thành công
            if (!empty($variant['image'])) {
                $this->removeImage($variant['image']);
            }

            $_SESSION['flash'] = 'Xóa biến thể thành công!';

        } catch (Throwable $e) {
            error_log($e->getMessage());

            $_SESSION['flash'] = 'Không thể xóa biến thể.';
        }

        $this->redirect('/admin/variants');
    }

    /**
     * Lấy dữ liệu từ form
     */
    private function getFormData(): array
    {
        return [
            'product_id' => (int) ($_POST['product_id'] ?? 0),

            'sku' => trim(
                (string) ($_POST['sku'] ?? '')
            ),

            'color' => trim(
                (string) ($_POST['color'] ?? '')
            ),

            'ram' => trim(
                (string) ($_POST['ram'] ?? '')
            ),

            'storage' => trim(
                (string) ($_POST['storage'] ?? '')
            ),

            'price' => trim(
                (string) ($_POST['price'] ?? '')
            ),

            'sale_price' => trim(
                (string) ($_POST['sale_price'] ?? '')
            ),

            'stock' => trim(
                (string) ($_POST['stock'] ?? '0')
            ),

            'image' => null,

            'status' => (int) ($_POST['status'] ?? 1)
        ];
    }

    /**
     * Kiểm tra dữ liệu nhập
     */
    private function validateData(array $data): ?string
    {
        if ($data['product_id'] <= 0) {
            return 'Vui lòng chọn sản phẩm.';
        }

        // Kiểm tra sản phẩm có tồn tại
        $productModel = new Product();

        if (!$productModel->find($data['product_id'])) {
            return 'Sản phẩm được chọn không tồn tại.';
        }

        if (
            $data['sku'] === '' ||
            $data['color'] === '' ||
            $data['ram'] === '' ||
            $data['storage'] === ''
        ) {
            return 'Vui lòng nhập đầy đủ thông tin biến thể.';
        }

        if (
            !is_numeric($data['price']) ||
            (float) $data['price'] <= 0
        ) {
            return 'Giá bán phải lớn hơn 0.';
        }

        if ($data['sale_price'] !== '') {
            if (
                !is_numeric($data['sale_price']) ||
                (float) $data['sale_price'] < 0 ||
                (float) $data['sale_price'] > (float) $data['price']
            ) {
                return 'Giá khuyến mãi không hợp lệ.';
            }
        }

        if (!ctype_digit((string) $data['stock'])) {
            return 'Số lượng tồn kho phải là số nguyên không âm.';
        }

        if (!in_array($data['status'], [0, 1], true)) {
            return 'Trạng thái không hợp lệ.';
        }

        // Chuyển giá khuyến mãi rỗng thành NULL
        if ($data['sale_price'] === '') {
            $data['sale_price'] = null;
        }

        return null;
    }

    /**
     * Upload ảnh biến thể
     */
    private function uploadImage(): ?string
    {
        if (
            !isset($_FILES['image']) ||
            $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE
        ) {
            return null;
        }

        $file = $_FILES['image'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new \RuntimeException('Lỗi tải ảnh lên.');
        }

        if ($file['size'] > 3 * 1024 * 1024) {
            throw new \RuntimeException('Ảnh không được vượt quá 3MB.');
        }

        $imageInfo = getimagesize($file['tmp_name']);

        if ($imageInfo === false) {
            throw new \RuntimeException('File không phải ảnh hợp lệ.');
        }

        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp'
        ];

        $mime = $imageInfo['mime'];

        if (!isset($allowedTypes[$mime])) {
            throw new \RuntimeException(
                'Chỉ chấp nhận ảnh JPG, PNG hoặc WEBP.'
            );
        }

        $uploadDir = BASE_PATH . '/public/uploads/variants/';

        if (
            !is_dir($uploadDir) &&
            !mkdir($uploadDir, 0755, true) &&
            !is_dir($uploadDir)
        ) {
            throw new \RuntimeException(
                'Không tạo được thư mục lưu ảnh.'
            );
        }

        $fileName = bin2hex(random_bytes(16))
            . '.'
            . $allowedTypes[$mime];

        $destination = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new \RuntimeException('Không lưu được ảnh.');
        }

        return 'uploads/variants/' . $fileName;
    }

    /**
     * Xóa ảnh đã upload
     */
    private function removeImage(string $imagePath): void
    {
        // Chỉ cho phép xóa ảnh thuộc thư mục variants
        if (!str_starts_with($imagePath, 'uploads/variants/')) {
            return;
        }

        $filePath = BASE_PATH . '/public/' . $imagePath;

        if (is_file($filePath)) {
            unlink($filePath);
        }
    }
}
