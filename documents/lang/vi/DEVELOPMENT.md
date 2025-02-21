# BUILD AND DEPLOY

_`Base-Image` là viết ngắn gọn của: `Hình ảnh docker cơ sở`_  
_`App-Image` là viết ngắn gọn của: `Hình ảnh docker ứng dụng`_  

Tài liệu hướng dẫn: Xây dựng và Triển khai `App-Image` cho môi trưởng Phát triển.

**Hãy bắt đầu từ thư mục gốc của dự án, sau đó thực hiện các bước sau:**

## #Bước 0: Khởi tạo (Xây dựng `Base-Image`)

Có 2 cách thực hiện:

- Cách 1: Xây dựng `Base-Image` THỦ CÔNG - Theo tài liệu sau: 
  [/docker/base/BUILD-BASE.md](../../../docker/base/lang/vi/BUILD-BASE.md).

- Cách 2: Xây dựng `Base-Image` TỰ ĐỘNG - Xem tại `#Bước 3`.

> Tuy nhiên - Với lần đầu khởi tạo dự án, yêu cầu xem tài liệu tại `#Cách 1` để biết cách cấu hình các biến môi trường(`.env`) cho `Base-Image`.

## #Bước 1: Cấu hình tệp biến môi trường

- Sao chép tệp môi trường (có tên bắt buộc `.env`):
```bash
cp ./.env-local.env ./.env
```

- Thay đổi thông tin cấu hình để phù hợp với môi trường, các khối:
    + `## SAIL CONFIGURATION FOR DEVELOPMENT ##`
    + `## SUPERVISOR TURN ON/OFF SERVICE ##`
    + `## FOR APP ##`
    + ...

> 📝**GHI CHÚ:**
> - `## SAIL CONFIGURATION FOR DEVELOPMENT ##`:
>>  + `COMPOSE_PROJECT_NAME`: Tên dự án(format theo Docker-Compose). Giá trị này được thêm vào trước cùng với tên dịch vụ để đặt tên cho Container khi khởi động.
>>  + `COMPOSE_PROJECT_NETWORK`: Tên mạng nội bộ dự án(format theo Docker-Compose). Giá trị này được Docker-Compose tạo và đặt tên Network cho dự án.
>>  + `SAIL_FILES`: Đường dẫn tới tệp cấu hình `docker-compose.yml`. _(Tính từ thư mục gốc của dự án và không có dấu `/` ở đầu)_.
>>  + `APP_IMAGE_NAME`: Tên của `App-Image`. _(Hãy đặt tên cho phù hợp với dự án, ví dụ: `coffee/backend-app:latest`)_.
>>  + `APP_SERVICE`: Tên `service` tương ứng App container được cấu hình trong tệp `docker-compose.yml`.
>>  + `APP_PORT`/`APP_PORT_SSL`: Cổng để truy cập App (tương ứng http và https).
>>  + `SUPERVISOR_PORT`: Cổng để truy cập trình quản lý `Supervisord` - quản lý các dịch vụ/tiến trình tương ứng của App.
>>  + `..._TAG`: Các hậu tố - Tương ứng với các Tag hình ảnh docker (phiên bản) của các `service` trong tệp `docker-compose.yml`.
>>  + `..._FORWARD`: Các hậu tố - Tương ứng với các cổng để truy cập các dịch vụ/ứng dụng khác được cấu hình trong `services` trong tệp `docker-compose.yml`.
>
> - `## SUPERVISOR TURN ON/OFF SERVICE ##`:
>>  + `SUV_WEB_SERVER`:          Bật(`true`) - Tắt(`false`) dịch vụ `Web-Server(Nginx/Apache)` dưới sự quản lý của Supervisord.
>>  + `SUV_SCHEDULER`:           Bật(`true`) - Tắt(`false`) dịch vụ `Scheduler(Laravel)` dưới sự quản lý của Supervisord.
>>  + `SUV_SCHEDULER_NUMPROCS`:  Là số tiến trình `Scheduler(Laravel)` mà Supervisord sẽ tạo (Mặc định: là 0 nếu `SUV_SCHEDULER=false`, là 1 nếu `SUV_SCHEDULER=true` và `SUV_SCHEDULER_NUMPROCS` rỗng).
>>  + `SUV_WORKER`:              Bật(`true`) - Tắt(`false`) dịch vụ `Worker(Laravel)` dưới sự quản lý của Supervisord.
>>  + `SUV_WORKER_NUMPROCS`:     Là số tiến trình `Worker(Laravel)` mà Supervisord sẽ tạo (Mặc định: là 0 nếu `SUV_WORKER=false`, là 1 nếu `SUV_WORKER=true` và `SUV_WORKER_NUMPROCS` rỗng).
>
> - `## FOR APP ##`:
>>  + Các cấu hình trong khối này, là cấu hình của ứng dụng PHP.
>
>> - Ngoài ra, tất cả các cấu hình khác có thể giữ nguyên.
>> - Vui lòng đọc kỹ các ghi chú trong file `.env` vừa sao chép.

## #Bước 2: Giới thiệu và Cài đặt `sail` (giao diện dòng lệnh)

### #Giới thiệu `sail`

- `sail`: Là giao diện dòng lệnh nhẹ để tương tác với môi trường Phát triển Docker mặc định của Laravel.  
  Xem thông tin đầy đủ [tại đây](https://laravel.com/docs/11.x/sail#introduction).

- `sail`: Được hỗ trợ trên MacOS, Linux, Windows (thông qua [WSL2](https://learn.microsoft.com/en-us/windows/wsl/about)).

- `docker/sail`: Trong dự án là một bản sao của Laravel Sail và được chỉnh sửa phù hợp với mục đích sử dụng của dự án.  
  Vd:  
    - Cấu hình người dùng mặc định từ `sail` sang `www-data` để khớp với các quyền khi sử dụng kết hợp `php-fpm` và `nginx`.  
      _(Laravel Sail ban đầu được sử dụng như một sự tích hợp giữa `ubuntu` và `apache2`.)_
    - Có thể tương tác trực tiếp với bước xây dựng `Base-Image` để tối giản các bước phát triển.

### #Cài đặt `sail`

Vì `sail` là giao diện dòng lệnh, nên cần cấp một số quyền nhất định.

Cài đặt thực thi cho `sail`:
```bash
bash ./docker/setup_sail.sh
```

- Hướng dẫn nhanh về danh sách dòng lệnh `sail`:
```bash
./docker/sail --help
```

## #Bước 3: Xây dựng - Khởi động ứng dụng

- Xây dựng `App-Image` với các tham số:
```bash
./docker/sail build --no-cache --memory=512M --progress=plain
```

> 📝**GHI CHÚ:**
> - `--no-cache` : Không sử dụng Cache khi xây dựng.
> - `--memory=512M` : Đặt giới hạn bộ nhớ(Memory) cho quá trình xây dựng.
> - `--progress=plain` : Xem chi tiết lịch sử xây dựng trên màn hình Console.
>> **Với lần đầu tiên xây dựng hoặc khi sử dụng tham số `build`, sẽ tự động kích hoạt xây dựng `Base-Image` - được nhắc tại `#Bước 0 / Cách 2`.**  
>> Sau đó mới đến bước xây dựng `App-Image`.

- Khởi động ứng dụng với `sail`:
```bash
./docker/sail up -d
```

> 📝Có thể mở rộng tham số:
> - `--build` : Buộc xây dựng lại `App-Image` - trước khi khởi động các Container.
>> **Với lần đầu tiên xây dựng - cũng sẽ tự động kích hoạt xây dựng `Base-Image` - được nhắc tại `#Bước 0 / Cách 2`.**  
>> Sau đó mới đến bước xây dựng `App-Image` và khởi động các Container.

> 🔥**QUAN TRỌNG:** 
> - Nếu gặp lỗi "ERROR [internal] load metadata for `docker.io/xxxyyy:latest`" vui lòng thử lại với quyền `sudo`.

## #Mở rộng thêm: 

- Đăng nhập vào App bash (với người dùng: `www-data`):
```bash
./docker/sail bash
```

- Đăng nhập vào App bash (với người dùng: `root`):
```bash
./docker/sail root-bash
```

- Cài đặt thư viện phụ thuộc cho PHP:
```bash
./docker/sail composer install --optimize-autoloader
```
