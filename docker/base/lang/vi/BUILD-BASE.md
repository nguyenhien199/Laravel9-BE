# BUILD BASE-IMAGE

_(Môi trường cơ sở ít được thay đổi/nâng cấp, khi xây dựng mất rất nhiều thời gian nên được chia tách tại đây và thực hiện theo đúng tài liệu này để xây dựng.)_

**Hãy bắt đầu từ thư mục gốc của dự án, sau đó thực hiện các bước sau:**

## #Bước 1: Di chuyển

- Từ thư mục gốc của dự án, di chuyển:
```bash
cd ./docker/base
```

## #Bước 2: Cấu hình

_(Bước này chỉ thực hiện lần đầu khi khởi tạo Dự án.)_

- Sao chép tệp mẫu và lưu nó vào thư mục hiện tại (với tên bắt buộc `.env`).
```bash
cp .env-temp.env .env
```

- Thay đổi thông tin cấu hình để phù hợp với môi trường, các khối:
  + `## PROJECT`
  + `## BASE IMAGE NAME`
  + `## PHP VERSION`
  + `## PHP EXTENSION OPTION INSTALL`

> 📝**GHI CHÚ:**
> - `COMPOSE_PROJECT_NAME`: Là tên của dự án - được Docker-Compose sử dụng. Giá trị này được thêm vào trước cùng với tên dịch vụ để tên của container khi khởi động.
> - `JV_BASE_IMAGE_NAME`: Là tên của hình ảnh docker `Base-Image` sẽ được xây dựng (bao gồm đầy đủ các thành phần tên `repository:tag`).
> - `JV_PHP_VERSION`: Là phiên bản PHP cần xây dựng trong hình ảnh docker `Base-Image`.
> - `JV_DISTRIBUTION`: Là phiên bản nhân của hệ điều hành Debian sẽ xây dựng lên hình ảnh docker `Base-Image`.  
>                      Để trống -> Để có phiên bản mới nhất được hỗ trợ(tương ứng với phiên bản PHP đã chọn ở trên - `JV_PHP_VERSION`).
> - `JV_INSTALL_...`: Giá trị của các tiền tố này chấp nhận 2 giá trị `true/false` (được viết thường) - là lựa chọn Có / Không để cài đặt.
>
>> - Đọc kỹ các ghi chú trong file `.env` vừa sao chép để hiểu rõ hơn.
>> - Đảm bảo cài đặt các PHP Extension thích hợp cho dự án.
>> - Không nên cài đặt dư thừa, sẽ dẫn đến dung lượng hình ảnh docker tăng lên - gây lãng phí tài nguyên, đồng thời tốn nhiều thời gian xây dựng hơn.

- Lưu thông tin đã cấu hình trong tệp `.env` và đẩy lên GIT của Dự án:

> 🔥**QUAN TRỌNG:**
>> Khi sao chép mã nguồn này vào Dự án thực tế:
>> - Cấu hình các tham số trong tệp `.env` cho phù hợp.
>> - Chỉnh sửa tệp `/docker/base/.gitignore` (bỏ phần `.env`) và đẩy tệp `.env` vào GIT của Dự án.
>> <br/><br/>
>> ==> `Mục đích là lưu cấu hình cho hình ảnh docker Base-Image cho dự án.`

## #Bước 3: Xây dựng hình ảnh docker

- Xây dựng hình ảnh với các tham số (_thường dùng_):
```bash
bash build.sh --no-cache --memory=512m --progress=plain
```

> 📝**GHI CHÚ:**
> - Để biết danh sách các tham số được hỗ trợ, thực hiện lệnh sau:
> ```bash
> bash build.sh -h
> ```

## #Bước 4: Trở lại

- Sau khi xây dựng hình ảnh docker thành công, thực hiện lệnh sau để quay trở lại thư mục gốc của dự án:
```bash
cd ../../
```

# END !!!
