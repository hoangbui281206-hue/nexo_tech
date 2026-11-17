<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Category;

class CategoryController extends BaseController
{
    /** Hiển thị trang danh mục */
    public function index(string $slug = ''): void
    {
        $category = $slug ? (new Category())->findBySlug($slug) : null;

        if (!$category) {
            $_SESSION['flash'] = 'Danh mục không tồn tại.';
            $this->redirect('/');
            return;
        }

        $products = (new Category())->getProducts($category['id'], 12);
        $productsCount = (new Category())->countByCategory($category['id']);

        $this->view('categories/show', compact('category', 'products', 'productsCount'));
    }

    /** Danh sách danh mục cho Admin */
    public function adminList(): void
    {
        $this->requireAdmin();
        $categories = (new Category())->allActive();
        $this->view('admin/categories', compact('categories'));
    }

    /** Hiển thị form thêm danh mục */
    public function createForm(): void
    {
        $this->requireAdmin();
        $this->view('admin/category-form');
    }

    /** Xử lý thêm danh mục */
    public function store(): void
    {
        $this->requireAdmin();

        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = isset($_POST['status']) ? 1 : 0;

        if ($name === '' || $slug === '') {
            $_SESSION['flash'] = 'Vui lòng nhập tên và slug danh mục.';
            $this->redirect('/admin/categories/create');
            return;
        }

        // Kiểm tra slug đã tồn tại
        $existing = (new Category())->findBySlug($slug);
        if ($existing) {
            $_SESSION['flash'] = 'Slug danh mục đã tồn tại.';
            $this->redirect('/admin/categories/create');
            return;
        }

        $sql = "INSERT INTO categories (name, slug, description, status) VALUES (:name, :slug, :description, :status)";
        $stmt = (new Category())->getConnection()->prepare($sql);
        $created = $stmt->execute([
            ':name' => $name,
            ':slug' => $slug,
            ':description' => $description,
            ':status' => $status
        ]);

        if (!$created) {
            $_SESSION['flash'] = 'Không thể tạo danh mục.';
        } else {
            $_SESSION['flash'] = 'Tạo danh mục thành công.';
        }
        $this->redirect('/admin/categories');
    }

    /** Hiển thị form sửa danh mục */
    public function editForm(int $id): void
    {
        $this->requireAdmin();
        
        $category = (new Category())->getConnection()->prepare("SELECT * FROM categories WHERE id = :id")->execute([':id' => $id])->fetch() ?: null;

        if (!$category) {
            $_SESSION['flash'] = 'Danh mục không tồn tại.';
            $this->redirect('/admin/categories');
            return;
        }

        $this->view('admin/category-form', compact('category'));
    }

    /** Xử lý cập nhật danh mục */
    public function update(): void
    {
        $this->requireAdmin();

        $id = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = isset($_POST['status']) ? 1 : 0;

        if ($id <= 0 || $name === '' || $slug === '') {
            $_SESSION['flash'] = 'Dữ liệu không hợp lệ.';
            $this->redirect('/admin/categories');
            return;
        }

        // Kiểm tra slug trùng lọc (trừ chính nó)
        $existing = (new Category())->findBySlug($slug);
        if ($existing && $existing['id'] != $id) {
            $_SESSION['flash'] = 'Slug danh mục đã tồn tại.';
            $this->redirect("/admin/categories/edit/$id");
            return;
        }

        $sql = "UPDATE categories SET name = :name, slug = :slug, description = :description, status = :status WHERE id = :id";
        $stmt = (new Category())->getConnection()->prepare($sql);
        $updated = $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':slug' => $slug,
            ':description' => $description,
            ':status' => $status
        ]);

        if (!$updated) {
            $_SESSION['flash'] = 'Không thể cập nhật danh mục.';
        } else {
            $_SESSION['flash'] = 'Cập nhật danh mục thành công.';
        }
        $this->redirect('/admin/categories');
    }

    /** Xóa danh mục */
    public function delete(): void
    {
        $this->requireAdmin();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['flash'] = 'ID danh mục không hợp lệ.';
            $this->redirect('/admin/categories');
            return;
        }

        // Kiểm tra xem có sản phẩm liên quan không
        $check = (new Category())->getConnection()->prepare("SELECT COUNT(*) FROM products WHERE category_id = :id")->execute([':id' => $id])->fetchColumn();

        if ($check > 0) {
            $_SESSION['flash'] = 'Không thể xóa danh mục vì vẫn có sản phẩm liên quan.';
            $this->redirect('/admin/categories');
            return;
        }

        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = (new Category())->getConnection()->prepare($sql);
        $deleted = $stmt->execute([':id' => $id]);

        if (!$deleted) {
            $_SESSION['flash'] = 'Không thể xóa danh mục.';
        } else {
            $_SESSION['flash'] = 'Xóa danh mục thành công.';
        }
        $this->redirect('/admin/categories');
    }
}
