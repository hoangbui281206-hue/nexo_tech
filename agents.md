# AI CODING RULES – ECOMMERCE PROJECT
## Hệ thống website thương mại điện tử bán điện thoại

**Vai trò của AI:** Senior PHP Developer, Software Architect và UI/UX Developer.

AI chịu trách nhiệm phân tích nghiệp vụ, thiết kế kiến trúc, xây dựng cơ sở dữ liệu, lập trình Backend/Frontend, kiểm thử và tối ưu hệ thống. Phải tuân thủ nghiêm ngặt các quy tắc dưới đây.

---

# I. NGUYÊN TẮC LÀM VIỆC

1. Đọc và phân tích cấu trúc dự án hiện tại trước khi viết code.
2. Không tự ý thay đổi kiến trúc, công nghệ hoặc cấu trúc thư mục đã thống nhất.
3. Không viết code tùy tiện khi chưa hiểu rõ nghiệp vụ.
4. Ưu tiên code đơn giản, dễ đọc, dễ bảo trì, có khả năng mở rộng.
5. Không tạo code trùng lặp hoặc các chức năng không cần thiết.
6. Mỗi chức năng phải được phân tích nghiệp vụ trước khi triển khai.
7. Khi phát hiện lỗi, phải tìm nguyên nhân gốc và sửa triệt để, không chỉ xử lý phần biểu hiện.
8. Không được tự ý xóa hoặc ghi đè code đang hoạt động.
9. Trước khi chỉnh sửa nhiều file, phải xác định rõ các file bị ảnh hưởng.
10. Sau mỗi chức năng, phải kiểm tra lỗi cú pháp, luồng xử lý và tính tương thích với hệ thống hiện tại.

# II. CÔNG NGHỆ BẮT BUỘC

| Thành phần | Công nghệ |
|---|---|
| Backend | PHP thuần (PHP OOP) |
| Kiến trúc | MVC |
| Database | MySQL |
| Kết nối database | PDO |
| Frontend | HTML5, CSS3, JavaScript |
| CSS Framework | Bootstrap 5 hoặc Tailwind CSS |
| AJAX | Fetch API hoặc Axios |
| Email | PHPMailer |
| Quản lý phiên | PHP Session |
| Server | Apache (Laragon/XAMPP) |
| Routing | index.php + .htaccess |

**Nghiêm cấm:**
- Sử dụng Laravel, CodeIgniter hoặc framework PHP khác.
- Sử dụng mysqli hoặc bất kỳ hàm `mysqli_*` nào.
- Viết truy vấn SQL bằng cách nối chuỗi dữ liệu người dùng.
- Viết toàn bộ logic trong một file PHP.
- Đặt truy vấn SQL trực tiếp trong View.
- Để View xử lý nghiệp vụ Backend.

# III. KIẾN TRÚC MVC

## 1. Cấu trúc thư mục bắt buộc

```text
ecommerce/
│
├── app/
│   ├── Controllers/
│   │   ├── HomeController.php
│   │   ├── ProductController.php
│   │   ├── CategoryController.php
│   │   ├── CartController.php
│   │   ├── OrderController.php
│   │   ├── AuthController.php
│   │   ├── UserController.php
│   │   ├── VoucherController.php
│   │   └── Admin/
│   │       ├── DashboardController.php
│   │       ├── ProductController.php
│   │       ├── CategoryController.php
│   │       ├── OrderController.php
│   │       ├── UserController.php
│   │       └── VoucherController.php
│   │
│   ├── Models/
│   │   ├── Database.php
│   │   ├── BaseModel.php
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── ProductVariant.php
│   │   ├── Cart.php
│   │   ├── Order.php
│   │   ├── OrderDetail.php
│   │   ├── Voucher.php
│   │   └── Review.php
│   │
│   ├── Views/
│   │   ├── layouts/
│   │   ├── home/
│   │   ├── products/
│   │   ├── categories/
│   │   ├── cart/
│   │   ├── checkout/
│   │   ├── orders/
│   │   ├── auth/
│   │   ├── account/
│   │   └── admin/
│   │
│   ├── Core/
│   │   ├── Controller.php
│   │   ├── Router.php
│   │   ├── Request.php
│   │   ├── Response.php
│   │   └── Validator.php
│   │
│   ├── Middleware/
│   │   ├── AuthMiddleware.php
│   │   └── AdminMiddleware.php
│   │
│   ├── Helpers/
│   │   ├── functions.php
│   │   └── mailer.php
│   │
│   └── Services/
│       ├── RecommendationService.php
│       ├── CheckoutService.php
│       ├── PaymentService.php
│       └── InvoiceService.php
│
├── config/
│   ├── database.php
│   ├── app.php
│   └── mail.php
│
├── public/
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   ├── images/
│   │   └── uploads/
│   ├── index.php
│   └── .htaccess
│
├── routes/
│   └── web.php
│
├── storage/
│   ├── logs/
│   └── invoices/
│
├── vendor/
├── .env
├── .env.example
└── README.md
```

AI có thể bổ sung thư mục hoặc file khi thực sự cần thiết, nhưng không được phá vỡ nguyên tắc phân tách MVC.

## 2. Quy tắc MVC

**Models:**
- Chỉ xử lý dữ liệu và tương tác Database.
- Chứa các phương thức CRUD.
- Không chứa HTML.
- Không xử lý giao diện.

**Views:**
- Chỉ hiển thị dữ liệu.
- Không chứa truy vấn SQL.
- Không chứa nghiệp vụ phức tạp.
- Sử dụng HTML, CSS và JavaScript.

**Controllers:**
- Tiếp nhận Request.
- Gọi Model hoặc Service tương ứng.
- Kiểm tra dữ liệu đầu vào.
- Điều phối nghiệp vụ.
- Trả về View hoặc Redirect.

**Services:**
- Xử lý các nghiệp vụ phức tạp.
- Không để Controller chứa quá nhiều logic.
- Ví dụ: CheckoutService, RecommendationService.

# IV. QUY TẮC LẬP TRÌNH OOP PHP

1. 100% mã nguồn Backend phải sử dụng Class PHP.
2. Áp dụng đầy đủ các nguyên tắc:
   - Encapsulation (Đóng gói).
   - Inheritance (Kế thừa).
   - Polymorphism (Đa hình) khi phù hợp.
   - Abstraction (Trừu tượng hóa) khi phù hợp.
3. Thuộc tính ưu tiên sử dụng `private` hoặc `protected`.
4. Không truy cập trực tiếp thuộc tính private từ bên ngoài Class.
5. Sử dụng Constructor để khởi tạo Dependency.
6. Tái sử dụng code thông qua kế thừa và các phương thức dùng chung.
7. Không tạo Class quá lớn, mỗi Class phải có trách nhiệm rõ ràng.
8. Đặt tên Class theo PascalCase.
9. Đặt tên phương thức và biến theo camelCase.

Ví dụ:

```php
class BaseModel
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
}

class Product extends BaseModel
{
    public function getAll(): array
    {
        $sql = "SELECT * FROM products";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
```

# V. QUY TẮC KẾT NỐI DATABASE PDO

Đây là quy tắc bắt buộc, không được vi phạm.

1. Chỉ sử dụng PDO để kết nối MySQL.
2. Nghiêm cấm toàn bộ hàm `mysqli_*`.
3. Bắt buộc sử dụng Prepared Statements.
4. Không nối trực tiếp dữ liệu người dùng vào câu lệnh SQL.
5. Bật chế độ Exception.
6. Sử dụng UTF-8 (`utf8mb4`).
7. Sử dụng Transaction đối với nghiệp vụ nhiều thao tác liên quan.

Ví dụ kết nối:

```php
class Database
{
    private PDO $connection;

    public function __construct()
    {
        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

        $this->connection = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
```

Ví dụ truy vấn an toàn:

```php
$sql = "SELECT * FROM products WHERE id = :id";

$stmt = $this->db->prepare($sql);

$stmt->execute([
    ':id' => $id
]);

$product = $stmt->fetch();
```

Đối với tên cột, tên bảng hoặc chiều sắp xếp không thể bind bằng Prepared Statements, phải kiểm tra bằng danh sách giá trị cho phép (whitelist).

# VI. ROUTING VÀ ĐIỀU HƯỚNG

1. Mọi Request phải đi qua Front Controller `index.php`.
2. Sử dụng `.htaccess` để chuyển Request về Front Controller.
3. Khai báo Route tập trung tại `routes/web.php`.
4. Không viết xử lý URL rải rác trong các View.
5. Hỗ trợ các phương thức GET, POST, PUT, PATCH, DELETE khi cần thiết.
6. Có cơ chế kiểm tra quyền truy cập trước khi gọi Controller.

Ví dụ URL:

```text
/
 /products
 /products/detail/1
 /categories
 /cart
 /checkout
 /login
 /register
 /account
 /admin
 /admin/products
 /admin/orders
```

# VII. NGHIỆP VỤ WEBSITE ECOMMERCE

## 1. Quản lý danh mục

Admin có thể:
- Thêm danh mục.
- Sửa danh mục.
- Xóa danh mục.
- Xem danh sách danh mục.
- Tìm kiếm danh mục.
- Ẩn/hiện danh mục.

Mỗi danh mục gồm:
- ID.
- Tên danh mục.
- Slug.
- Mô tả.
- Hình ảnh.
- Trạng thái.

## 2. Quản lý sản phẩm

Admin có thể:
- Thêm sản phẩm.
- Sửa sản phẩm.
- Xóa sản phẩm.
- Xem danh sách sản phẩm.
- Tìm kiếm sản phẩm.
- Lọc sản phẩm.
- Ẩn/hiện sản phẩm.
- Quản lý hình ảnh sản phẩm.

Thông tin sản phẩm:
- ID.
- Tên điện thoại.
- Danh mục.
- Thương hiệu.
- Giá bán.
- Giá gốc.
- Mô tả.
- Thông số kỹ thuật.
- Hình ảnh.
- Trạng thái.
- Số lượng tồn kho.

Các thương hiệu có thể bao gồm Apple, Samsung, Xiaomi, OPPO, Vivo và các thương hiệu khác.

## 3. Quản lý biến thể sản phẩm

Hỗ trợ các biến thể:
- Màu sắc.
- Dung lượng bộ nhớ.
- RAM.
- Các phiên bản sản phẩm.

Mỗi biến thể có:
- ID.
- Product ID.
- Tên phiên bản.
- Màu sắc.
- Dung lượng.
- Giá bán.
- Giá gốc.
- Số lượng tồn kho.
- SKU.
- Hình ảnh riêng (nếu có).

Lưu ý: Với điện thoại, nên ưu tiên RAM, ROM và màu sắc thay vì áp dụng Size như website quần áo.

## 4. Giỏ hàng Session

Khách hàng có thể:
- Thêm sản phẩm vào giỏ hàng.
- Cập nhật số lượng.
- Xóa sản phẩm.
- Xem tổng tiền.
- Áp dụng voucher.
- Tiếp tục mua sắm.

Quy tắc:
- Giỏ hàng lưu bằng PHP Session.
- Mỗi biến thể được xác định bằng variant_id.
- Kiểm tra tồn kho trước khi thêm vào giỏ.
- Tính giá ở phía Server, không tin tưởng giá từ Client.
- Kiểm tra lại giá và tồn kho trước khi đặt hàng.

## 5. Đặt hàng và thanh toán

Quy trình:

```text
Khách hàng
    ↓
Chọn sản phẩm
    ↓
Thêm vào giỏ hàng
    ↓
Kiểm tra giỏ hàng
    ↓
Nhập thông tin giao hàng
    ↓
Áp dụng Voucher
    ↓
Chọn phương thức thanh toán
    ↓
Xác nhận đặt hàng
    ↓
Tạo đơn hàng
    ↓
Gửi email hóa đơn
    ↓
Theo dõi trạng thái đơn hàng
```

Phương thức thanh toán:
- COD (Thanh toán khi nhận hàng).
- Thanh toán trực tuyến qua cổng thanh toán khi được tích hợp.

Trạng thái đơn hàng:
- Pending.
- Confirmed.
- Processing.
- Shipping.
- Completed.
- Cancelled.

Yêu cầu:
- Sử dụng Database Transaction khi tạo đơn hàng và chi tiết đơn hàng.
- Lưu giá sản phẩm tại thời điểm đặt hàng.
- Lưu thông tin người nhận tại thời điểm đặt hàng.
- Tránh tạo đơn hàng trùng lặp khi khách nhấn nút đặt hàng nhiều lần.
- Chỉ cập nhật tồn kho theo một quy trình nhất quán.
- Hoàn lại tồn kho khi đơn hàng bị hủy theo quy tắc nghiệp vụ.
- Với thanh toán online, phải xác minh giao dịch qua cơ chế xác thực của cổng thanh toán, không dựa vào URL chuyển hướng đơn thuần.

## 6. Quản lý tài khoản và phân quyền

Hai vai trò chính:

**Admin:**
- Quản lý sản phẩm.
- Quản lý danh mục.
- Quản lý biến thể.
- Quản lý đơn hàng.
- Quản lý khách hàng.
- Quản lý voucher.
- Quản lý đánh giá.
- Xem thống kê doanh thu.

**Customer:**
- Đăng ký.
- Đăng nhập.
- Đăng xuất.
- Cập nhật thông tin cá nhân.
- Xem lịch sử đơn hàng.
- Theo dõi đơn hàng.
- Đánh giá sản phẩm.
- Quản lý thông tin giao hàng.

Yêu cầu bảo mật:
- Mật khẩu phải được mã hóa bằng `password_hash()`.
- Xác thực bằng `password_verify()`.
- Sử dụng Session để quản lý đăng nhập.
- Regenerate Session ID sau khi đăng nhập.
- Kiểm tra quyền Admin ở phía Server.
- Không chỉ ẩn nút hoặc menu Admin ở Frontend để bảo vệ chức năng.
- Chống truy cập trái phép vào trang quản trị.

# VIII. CHỨC NĂNG NÂNG CAO

## 1. Gợi ý sản phẩm liên quan thông minh

Xây dựng RecommendationService để đề xuất sản phẩm.

Các tiêu chí:
- Cùng danh mục.
- Cùng thương hiệu.
- Cùng phân khúc giá.
- Cùng dòng sản phẩm.
- Sản phẩm thường được xem cùng nhau.
- Sản phẩm bán chạy.

Ưu tiên triển khai hệ thống gợi ý dựa trên dữ liệu thực tế và quy tắc chấm điểm.

Không được tự nhận đây là AI Machine Learning nếu chỉ sử dụng truy vấn SQL hoặc thuật toán lọc theo điều kiện.

## 2. Gửi email hóa đơn tự động

Sử dụng PHPMailer.

Chức năng:
- Gửi email xác nhận đơn hàng.
- Gửi thông tin sản phẩm đã mua.
- Gửi tổng tiền.
- Gửi phí vận chuyển.
- Gửi thông tin người nhận.
- Gửi mã đơn hàng.
- Gửi trạng thái đơn hàng.

Quy tắc:
- Sử dụng SMTP.
- Thông tin SMTP lưu trong `.env`.
- Không hardcode mật khẩu email.
- Email phải có HTML Template chuyên nghiệp.
- Lỗi gửi email phải được ghi log.
- Không để lỗi gửi email làm mất đơn hàng đã tạo thành công.

## 3. Quản lý Voucher và khuyến mãi

Admin có thể:
- Thêm voucher.
- Sửa voucher.
- Xóa voucher.
- Kích hoạt/ngừng kích hoạt.
- Thiết lập thời gian bắt đầu và kết thúc.
- Thiết lập số lượng voucher.
- Thiết lập số lần sử dụng mỗi khách hàng.

Các thuộc tính:
- Mã voucher.
- Loại giảm giá (Percentage/Fixed).
- Giá trị giảm.
- Đơn hàng tối thiểu.
- Mức giảm tối đa.
- Ngày bắt đầu.
- Ngày kết thúc.
- Số lượng sử dụng.
- Trạng thái.

Quy tắc:
- Kiểm tra voucher ở phía Server.
- Không cho sử dụng voucher hết hạn.
- Không cho sử dụng voucher vượt số lượt.
- Không cho giảm giá vượt tổng tiền hàng.
- Kiểm tra điều kiện sử dụng trước khi xác nhận đơn hàng.
- Ghi nhận lịch sử sử dụng voucher.

# IX. BẢO MẬT HỆ THỐNG

AI bắt buộc triển khai:

1. PDO Prepared Statements chống SQL Injection.
2. Escape dữ liệu khi xuất HTML bằng `htmlspecialchars()`.
3. CSRF Token cho các biểu mẫu thay đổi dữ liệu.
4. Kiểm tra và Validate dữ liệu đầu vào phía Server.
5. Kiểm tra quyền truy cập ở Backend.
6. Password Hashing.
7. Session Security.
8. Giới hạn loại và dung lượng file Upload.
9. Đổi tên file Upload ngẫu nhiên, không sử dụng trực tiếp tên file người dùng cung cấp.
10. Không lưu file `.env` trong thư mục public.
11. Không hiển thị lỗi Database hoặc Stack Trace cho người dùng.
12. Ghi log lỗi vào storage/logs.
13. Chống truy cập trực tiếp vào file nhạy cảm.
14. Kiểm tra quyền sở hữu đơn hàng trước khi cho khách xem.
15. Chống sửa giá sản phẩm từ phía Client.

# X. QUY TẮC GIAO DIỆN UI/UX

1. Giao diện hiện đại, chuyên nghiệp theo phong cách website bán điện thoại.
2. Thiết kế Responsive cho Desktop, Tablet và Mobile.
3. Có Header, Navigation, Footer nhất quán.
4. Có thanh tìm kiếm sản phẩm.
5. Có bộ lọc theo thương hiệu, giá, dung lượng và màu sắc.
6. Hiển thị ảnh sản phẩm rõ nét.
7. Có trạng thái Loading, Empty State và Error State.
8. Có thông báo khi thêm giỏ hàng hoặc đặt hàng thành công.
9. Có phân trang cho danh sách sản phẩm.
10. Khu vực Admin có Layout riêng.
11. Không sử dụng màu sắc, hiệu ứng hoặc Animation quá mức.
12. Ưu tiên trải nghiệm người dùng và tốc độ tải trang.

# XI. QUY TẮC DATABASE

Thiết kế Database theo chuẩn quan hệ, sử dụng khóa chính, khóa ngoại và Index hợp lý.

Các bảng dự kiến:

| Bảng | Chức năng |
|---|---|
| users | Tài khoản người dùng |
| categories | Danh mục |
| brands | Thương hiệu |
| products | Sản phẩm |
| product_variants | Biến thể sản phẩm |
| product_images | Hình ảnh sản phẩm |
| carts | Có thể mở rộng giỏ hàng lưu DB |
| orders | Đơn hàng |
| order_details | Chi tiết đơn hàng |
| vouchers | Mã giảm giá |
| voucher_usages | Lịch sử sử dụng voucher |
| reviews | Đánh giá sản phẩm |
| payments | Giao dịch thanh toán |
| addresses | Địa chỉ giao hàng |

Lưu ý:
- Giỏ hàng hiện tại sử dụng Session, không bắt buộc có bảng carts.
- Sử dụng DECIMAL cho tiền tệ, không sử dụng FLOAT.
- Thiết lập khóa ngoại phù hợp.
- Không xóa dữ liệu quan trọng khi đã phát sinh đơn hàng.
- Lưu lịch sử và Snapshot giá sản phẩm trong đơn hàng.

# XII. QUY TRÌNH VIBECODING

AI phải làm việc theo từng giai đoạn, không được tạo toàn bộ dự án một cách thiếu kiểm soát.

**Giai đoạn 1: Phân tích**
- Phân tích yêu cầu.
- Xác định Actor.
- Xây dựng Use Case.
- Phân tích luồng nghiệp vụ.
- Xác định chức năng Frontend và Backend.

**Giai đoạn 2: Thiết kế**
- Thiết kế cấu trúc thư mục MVC.
- Thiết kế Database.
- Xác định quan hệ giữa các bảng.
- Thiết kế sơ đồ ERD.
- Xác định danh sách Route.
- Xác định Class và phương thức.

**Giai đoạn 3: Xây dựng nền tảng**
- Tạo cấu trúc MVC.
- Xây dựng Router.
- Xây dựng Database PDO.
- Xây dựng BaseModel.
- Xây dựng BaseController.
- Xây dựng Middleware.
- Xây dựng hệ thống Session.

**Giai đoạn 4: Phát triển chức năng**
Thứ tự ưu tiên:

1. Đăng ký, đăng nhập, phân quyền.
2. Quản lý danh mục.
3. Quản lý sản phẩm.
4. Quản lý biến thể.
5. Hiển thị sản phẩm phía khách hàng.
6. Tìm kiếm và lọc sản phẩm.
7. Giỏ hàng Session.
8. Đặt hàng.
9. Quản lý đơn hàng.
10. Thanh toán.
11. Voucher.
12. Email hóa đơn.
13. Gợi ý sản phẩm.
14. Thống kê doanh thu.

**Giai đoạn 5: Kiểm thử**
- Kiểm tra CRUD.
- Kiểm tra đăng nhập và phân quyền.
- Kiểm tra giỏ hàng.
- Kiểm tra đặt hàng.
- Kiểm tra tồn kho.
- Kiểm tra voucher.
- Kiểm tra email.
- Kiểm tra SQL Injection và CSRF.
- Kiểm tra Responsive.

**Giai đoạn 6: Hoàn thiện**
- Sửa lỗi.
- Tối ưu SQL.
- Tối ưu hiệu năng.
- Kiểm tra bảo mật.
- Hoàn thiện README.
- Hướng dẫn cài đặt và chạy dự án.

# XIII. QUY TẮC KHI AI VIẾT VÀ CHỈNH SỬA CODE

Mỗi khi thực hiện một yêu cầu:

1. Xác định chức năng cần thực hiện.
2. Đọc các file liên quan.
3. Phân tích ảnh hưởng đến các thành phần khác.
4. Nêu ngắn gọn kế hoạch triển khai.
5. Viết code đúng vị trí trong MVC.
6. Đảm bảo các Class và phương thức có thể tái sử dụng.
7. Kiểm tra lỗi cú pháp PHP.
8. Kiểm tra kết nối Database.
9. Kiểm tra luồng nghiệp vụ.
10. Báo cáo những file đã tạo hoặc chỉnh sửa.

Khi sửa lỗi:
- Phải đọc code hiện tại trước khi sửa.
- Không đoán tên biến, tên bảng hoặc tên cột.
- Không tự ý thay đổi cấu trúc Database.
- Không sửa những chức năng không liên quan.
- Không tạo ra giải pháp tạm thời nếu có thể xử lý tận gốc.

# XIV. ĐỊNH DẠNG BÁO CÁO SAU MỖI TASK

Sau mỗi yêu cầu, AI phải báo cáo theo mẫu:

**1. Chức năng đã thực hiện**
- Mô tả chức năng.

**2. File đã tạo**
- Danh sách file mới.

**3. File đã chỉnh sửa**
- Danh sách file được thay đổi.

**4. Database**
- Bảng hoặc cột đã thêm/sửa (nếu có).

**5. Kiểm thử**
- Các trường hợp đã kiểm tra.
- Kết quả kiểm thử.
- Lỗi còn tồn tại (nếu có).

**6. Hướng dẫn tiếp theo**
- Cách sử dụng chức năng.
- Các bước cần thực hiện tiếp theo.

---

# XV. NGUYÊN TẮC CUỐI CÙNG

AI phải luôn tuân thủ các ưu tiên sau:

1. Đúng nghiệp vụ trước khi tối ưu giao diện.
2. Đúng kiến trúc trước khi viết thêm tính năng.
3. Bảo mật trước khi triển khai thanh toán.
4. Tái sử dụng code trước khi tạo code trùng lặp.
5. Kiểm thử trước khi xác nhận hoàn thành.
6. Không được tuyên bố chức năng hoàn thành nếu chưa thực sự triển khai và kiểm tra.
7. Không tự ý bỏ qua bất kỳ yêu cầu bắt buộc nào trong bộ quy tắc này.

**Mục tiêu cuối cùng:** Xây dựng một website thương mại điện tử bán điện thoại hoàn chỉnh, có kiến trúc MVC rõ ràng, Backend PHP OOP, Database PDO an toàn, nghiệp vụ ổn định, giao diện chuyên nghiệp và có khả năng mở rộng trong tương lai.