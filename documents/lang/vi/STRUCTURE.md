# CẤU TRÚC MÃ NGUỒN

_Mọi sự thay đổi cấu trúc của mã nguồn sẽ được cập nhật trong tài liệu này._

> Cấu trúc thư mục mã nguồn của dự án được chia làm 2 thành phần:
> - #Cấu trúc thư mục cơ sở.
> - #Cấu trúc mã nguồn dựa trên Framework.

## #Cấu trúc thư mục cơ sở:

```text
boilerplate/
├── docker/    -> Chứa tất cả các cấu hình cài đặt, kịch bản xây dựng môi trường Phát triển/Sản xuất cho dự án dựa trên Docker.
└── documents/ -> Chứa tất cả các tài liệu định nghĩa/mô tả cho dự án.
```

## #Cấu trúc mã nguồn dựa trên Framework:
**(Ở đây là Laravel Framework)**

- Cấu trúc thư mục gốc của Laravel Framework được mô tả trên trang chủ: https://laravel.com/docs/10.x/structure
- 
- Còn dưới đây là cây mô tả cấu trúc đã được cập nhật dựa trên Laravel Framework:

```text
laravel/
├── app/
│   ├── Console/                                        -> Chứa tất cả các Artisan Command tùy chỉnh.
│   ├── Constants/                                      -> Chứa các hằng số(Constant) tự định nghĩa.
│   ├── Enums/                                          -> Chứa các lớp Enum.
│   ├── Events/                                         -> Chứa các lớp sự kiện(Event).
│   │   ├── Core/BaseEvent
│   │   └── ...Event extends Core\BaseEvent
│   ├── Exceptions/...Exception                         -> Chứa trình xử lý ngoại lệ(Exception Handler) của ứng dụng và mọi Ngoại lệ(Exception) do ứng dụng đưa ra.
│   ├── Helpers/                                        -> Chứa trình trợ giúp(Helper) tùy chỉnh:
│   │   ├── Global/...Helper.php  (Tự động tải)             - Các tệp trong thư mục này có tên bao gồm `xxxHelper.php` ở cuối sẽ được `HelperServiceProvider` tự động tải (vì vậy chúng có sẵn như là chức năng toàn cầu).
│   │   └── ...Helper.php         (Phải tải thủ công)       - Nếu bạn không muốn một tệp trợ giúp cụ thể được tải trên toàn cầu, hãy đặt chúng bên ngoài thư mục `Helpers/Global`.
│   ├── Http/                                           -> Chứa bộ điều khiển(Controller), phần mềm trung gian(Middleware) và yêu cầu biểu mẫu(FormRequest) của ứng dụng.
│   │   ├── Controllers/                                    - Các bộ điều khiển(Controller).
│   │   │   ├── Core/BaseController                             + Bộ điều khiển cơ sở(Base Controller) cho toàn bộ hệ thống.
│   │   │   ├── Admin/
│   │   │   │   ├── Core/BaseAdminController                    + Bộ điều khiển cơ sở(Base Controller) dành cho miền Quản trị(Admin-CMS).
│   │   │   │   └── ...Controller
│   │   │   │          extends Core\BaseAdminController
│   │   │   ├── Api/
│   │   │   │   ├── Admin/
│   │   │   │   │   ├── Core/BaseApiAdminController             + Bộ điều khiển cơ sở(Base controller) dành cho miền API Quản trị(Admin-CMS-App).
│   │   │   │   │   └── ...Controller
│   │   │   │   │          extends Core\BaseApiAdminController
│   │   │   │   └── Front/
│   │   │   │       ├── Core/BaseApiFrontController             + Bộ điều khiển cơ sở(Base controller) dành cho miền API Web LDP(Front-Client-App).
│   │   │   │       └── ...Controller
│   │   │   │              extends Core\BaseApiFrontController
│   │   │   └── Front/
│   │   │       ├── Core/BaseFrontController                    + Bộ điều khiển cơ sở(Base controller) dành cho miền Web LDP(Front-Web).
│   │   │       └── ...Controller
│   │   │              extends Core\BaseFrontController
│   │   ├── Middleware/                                     - Các phần mềm trung gian.
│   │   ├── Parameters/                                     - Các Lược đồ(Schema) Tham số(Parameter) của Swagger.
│   │   ├── Requests/                                       - Các yêu cầu biểu mẫu - Các Lược đồ(Schema) yêu cầu biểu mẫu của Swagger.
│   │   │   ├── Core                                            + Định nghĩa các yêu cầu biểu mẫu cơ sở(Base-FormRequest) tương ứng cho 2 miền Web và API.
│   │   │   │   ├── BaseApiFormRequest
│   │   │   │   │       extends FormRequest
│   │   │   │   └── BaseFormRequest
│   │   │   │           extends FormRequest
│   │   │   ├── Admin/...FormRequest
│   │   │   │           extend Core\BaseWebFormRequest
│   │   │   ├── Api/...FormRequest
│   │   │   │           extend Core\BaseApiFormRequest
│   │   │   └── Front/...FormRequest
│   │   │               extend Core\BaseWebFormRequest
│   │   ├── Resources/                                      - Các định nghĩa đối tượng trả về (DTO) - Các Lược đồ(Schema) đối tượng dữ liệu trả về Client của Swagger.
│   │   └── Responses/                                      - Các định nghĩa biểu mẫu trả về - Các Lược đồ(Schema) cấu trúc trả về Client của Swagger.
│   │       └── Traits/                                         + Các Traits mô tả cấu trúc/biểu mẫu trả về cho các yêu cầu từ Client.
│   │           ├── Core/BaseResult
│   │           └── Api|WebResult use Core\BaseResult
│   ├── Jobs/                                           -> Chứa các công việc(Jobs) có thể xếp hàng đợi cho ứng dụng.
│   ├── Listeners/                                      -> Chứa các lớp lắng nghe và xử lý các sự kiện(Events).
│   ├── Mail/                                           -> Chứa tất cả các lớp đại diện cho các email được gửi bởi ứng dụng.
│   ├── Models/                                         -> Chứa các lớp Mô hình Eloquent.
│   │   ├── Core                                            - BaseAuthModel|BaseModel|BasePivot là các Model cơ sở (định nghĩa cấu trúc chung cho các Model).
│   │   │   ├── BaseAuthModel|BaseModel|BasePivot
│   │   │   └── Traits/...
│   │   ├── Traits/                                         - Các Traits định nghĩa mở rộng cho các Model (Nhằm tách biệt mục đích và rút ngắn cho tệp Model).
│   │   │   ├── Attributes/
│   │   │   ├── Methods/
│   │   │   ├── Relationships/
│   │   │   └── Scopes/
│   │   └── Something
│   │           extend BaseModel
│   │           use Traits
│   │               ...Attribute,
│   │               ...Method,
│   │               ...Relationship,
│   │               ...Scope
│   ├── Notifications/                                  -> Chứa các Thông báo `giao dịch` được ứng dụng gửi đi.
│   ├── Observers/                                      -> Chứa các Người giám sát(observer) của ứng dụng.
│   ├── Policies/                                       -> Chứa các lớp chính sách ủy quyền cho ứng dụng.
│   ├── Providers/                                      -> Chứa các Nhà cung cấp dịch vụ cho ứng dụng.
│   ├── Repositories/                                   -> Chứa các Repository cho ứng dụng.
│   │   ├── Core/                                           - BaseRepo là lớp chứa các hàm có sẵn hỗ trợ cho Repository.
│   │   │   ├── Contracts/IBaseRepo
│   │   │   └── BaseRepo
│   │   │           implements Contracts\IBaseRepo
│   │   ├── Contracts/I...Repo
│   │   │           extends Core\Contracts\IBaseRepo
│   │   └── ...Repo extends Core\BaseRepo
│   │               implements Contracts\I...Repo
│   ├── Rules/                                          -> Chứa các Đối tượng Quy tắc xác thực tùy chỉnh cho ứng dụng.
│   │   ├── Core/BaseRule
│   │   └── ...Rule.php extends Core\BaseRule
│   └── Services/                                       -> Chứa các lớp Dịch vụ(Service-Logic) cho ứng dụng.
│       ├── Core/BaseService
│       ├── Traits/
│       └── ...Service extends Core\BaseService
├── bootstrap/                                          -> Chứa `app.php` tập tin khởi động khung(Framework).
│   ├── cache/...                                           - Các tệp được tạo khung để tối ưu hóa hiệu suất.
│   └── constants/                                          - Các tệp định nghĩa các Hằng số được tải tự động theo hệ thống.
│       ├── autoload.php
│       └── files/... .php
├── config/                                             -> Chứa các Tệp cấu hình ứng dụng.
├── database/                                           -> Chứa các Database migrations, Model factories và Seeders.
│   ├── factories/                                          - Các Model factory.
│   ├── migrations/                                         - Các Database migration.
│   └── seeders/                                            - Các Seeder.
│       ├── Core/
│       │   └── Traits/
│       ├── Auth/...Seeder
│       └── ...
├── lang/                                               -> Chứa các tệp đa ngôn ngữ cho ứng dụng.
├── packages/                                           -> Chứa tất cả các gói tùy chỉnh Laravel của riêng bạn.
├── public/                                             -> Chứa tệp `index.php` - đây là điểm vào cho tất cả các yêu cầu vào ứng dụng và cấu hình tải tự động.
├── resources/                                          -> Chứa các Views cũng như các nội dung thô, chưa được biên dịch của bạn như CSS hoặc JavaScript. 
│   ├── css/(admin|front)/
│   ├── js/(admin|front)/
│   └── views/
│       ├── (admin|front)/
│       ├── errors/
│       └── vendor/
├── routes/                                             -> Chứa các Định nghĩa tuyến đường cho ứng dụng (riêng biệt cho các miền: Admin / Front / API).
│   ├── api.php
│   ├── web.php
│   ├── admin/(home|auth|...).php
│   ├── front/(home|auth|...).php
│   └── api/
│       ├── admin/(auth|user|...).php
│       └── front/(auth|user|...).php
├── storage/                                            -> Chứa nhật ký, các mẫu Blade đã biên dịch, các phiên(Session) dựa trên tệp, bộ đệm tệp và các tệp khác do khung tạo ra.
├── tests/                                              -> Chứa các bài kiểm tra tự động.
└── vendor/                                             -> Chứa các phụ thuộc tự động tải Composer.
```
