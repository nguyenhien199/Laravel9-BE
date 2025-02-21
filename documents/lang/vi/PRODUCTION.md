# BUILD AND DEPLOY - PRODUCTION

_`Base-Image` là viết ngắn gọn của: `Hình ảnh Docker cơ sở`_  
_`App-Image` là viết ngắn gọn của: `Hình ảnh Docker ứng dụng`_  

Tài liệu hướng dẫn: Xây dựng và Triển khai `App-Image` cho môi trưởng Sản xuất.

> Điều tiên quyết: Đảm bảo Máy chủ Sản xuất đã cài đặt Unix Shell(`bash`), Docker Engine và Docker-Compose (bao gồm cả Docker Compose plugin).

## #Xây dựng `App-Image` - Thủ công

**Hãy bắt đầu từ thư mục gốc của dự án, sau đó thực hiện các bước sau:**

### #Bước 0: Khởi tạo (Xây dựng `Base-Image`)

Có 2 cách thực hiện:

- Cách 1: Xây dựng `Base-Image` THỦ CÔNG - Theo tài liệu sau: 
  [/docker/base/BUILD-BASE.md](../../../docker/base/lang/vi/BUILD-BASE.md).

- Cách 2: Xây dựng `Base-Image` TỰ ĐỘNG - Xem tại `#Bước 1`.

> Tuy nhiên - Với lần đầu khởi tạo dự án, yêu cầu xem tài liệu tại `#Cách 1` để biết cách cấu hình các biến môi trường(`.env`) cho `Base-Image`.

### #Bước 1: Xây dựng `App-Image`

- Xây dựng `App-Image` với các tham số:
```bash
bash ./docker/production/build.sh --no-cache --memory=512m --progress=plain
```

> 📝Có thể mở rộng tham số:
> - `--no-cache`: Không sử dụng Cache khi xây dựng.
> - `--memory=512M` : Đặt giới hạn bộ nhớ(Memory) cho quá trình xây dựng.
> - `--progress=plain` : Xem chi tiết lịch sử xây dựng trên màn hình Console.
> - `--build-base`: Để buộc xây dựng lại `Base-Image`.
> - `--name=NAME`: Đặt tên cho `App-Image`.  
>    _(Với lần đầu xây dựng dự án, hãy nên sửa biến `PROD_IMAGE_REPO` trong script `/docker/production/build.sh` để đặt tên mặc định cho `App-Image`, hạn chế việc phải truyền tham số này thường xuyên)_
> - `--tag=TAG`: Đặt tên thẻ (tag) cho `App-Image`.
>> **Với lần đầu tiên xây dựng hoặc khi sử dụng tham số `--build-base`, sẽ tự động kích hoạt xây dựng `Base-Image` - được nhắc tại `#Bước 0 / Cách 2`.**  
>> Sau đó mới đến bước xây dựng `App-Image`.

- Để biết toàn bộ tham số được hỗ trợ, thực hiện lệnh sau:
```bash
bash ./docker/production/build.sh -h
```

## #Triển khai `App-Image` lên môi trường Sản xuất - Thực hiện thủ công.

> `App-Image` đã được xây dựng hoàn chỉnh tại bước trên.  
> 
> Để triển khai một hình ảnh Docker lên một máy chủ nhân Linux đã cài đặt Docker Engine  
> theo cách thông thường, vui lòng tìm hiểu câu lệnh [docker run](https://docs.docker.com/reference/cli/docker/container/run).

## #Xây dựng và Triển khai `App-Image` lên môi trường Sản xuất - Sử dụng Bash Script.

Trong mã nguồn, có tệp mẫu `/docker/common/templates/bash_deploy_script.sh`.  
Có các nội dung xử lý chính như sau:

- Tương tác với GIT _(Chuyển nhánh/Lấy code mới nhất/Chuyển tới một Commit ID được chỉ định)_ để đóng gói mã nguồn vào `App-Image`.
- Chuyển tiếp lệnh tới `/docker/production/build.sh` - để thực hiện lệnh xây dựng `App-Image`. _(Đã được mô tả tại mục `#Xây dựng App-Image - Thủ công.` phía trên)_.
- Xóa Container cũ khỏi hệ thống Docker.
- Khởi tạo Container mới dựa trên `App-Image` vừa được xây dựng _(Có tham số để lựa chọn)_.
- Xóa các hình ảnh Docker cũ (các hình ảnh không có tên) và xóa Cache _(Có tham số để lựa chọn)_.

### #Cấu hình Máy chủ Sản xuất

> Các bước sau đây chỉ thực hiện duy nhất một lần - trong lần đầu tiên triển khai.

1. Tạo thư mục Dự án trên Máy chủ. (Ví dụ: đường dẫn thư mục `~/project`).  
   + `mkdir ~/project` -> Thư mục Dự án.
   + `mkdir ~/project/source` -> Thư mục mã nguồn.
   + `mkdir ~/project/warehouses` -> Thư mục kho lưu trữ.
   + `mkdir ~/project/configs` -> Thư mục các tệp cấu hình.

2. Tải tệp mẫu `bash_deploy_script.sh` lên thư mục vừa tạo: `~/project/bash_deploy_script.sh`.

3. Tạo (hoặc tải lên) tệp cấu hình biến môi trường (`~/project/configs/production.env`) - và cấu hình các biến môi trường phù hợp với dự án.

4. Cấu hình SSH-Key trên Git Server (Git website) - Vì Script tương tác với GIT thông qua xác thực bằng SSH-Key.  
   _Tham khảo hướng dẫn của Gitlab [tại đây](https://docs.gitlab.com/ee/user/ssh.html)._  
   📝 _(Nếu sử dụng xác thực GIT bằng Username/Password mỗi khi thực hiện triển khai, hãy bỏ qua bược này.)_

5. Tải tệp SSH Private Key vừa tạo lên Máy chủ - nên lưu trữ vào thư mục `~/.ssh` tương ứng với User đang kết nối `ssh`.  
   📝 _(Nếu sử dụng xác thực GIT bằng Username/Password mỗi khi thực hiện triển khai, hãy bỏ qua bược này.)_

6. Khởi tạo và kéo mã nguồn lần đầu về Máy chủ (Sử dụng `git clone`) - về thư mục vừa tạo: `~/project/source`.

7. Cấu hình tham số trong Script `~/project/bash_deploy_script.sh`.

   - `SOURCE_TO_BUILD`: Tên thư mục con trong thư mục gốc Docker, có chứa tệp lệnh Bash `build.sh` để thực thi xây dựng `App-Image`.
   - `PWD_WORKDIR`: Đường dẫn thư mục chứa mã nguồn (`~/project/source`) vừa tạo.
   - `PWD_WAREHOUSE`: Đường dẫn thư mục kho lưu trữ (`~/project/warehouses`) vừa tạo.
   - `ENV_FILE`: Đường dẫn tệp cấu hình biến môi trường (`~/project/configs/production.env`) vừa tạo.
   - 
   - `GIT_REMOTE_URL`: URL của kho Git sẽ sử dụng để kéo mã nguồn.
   - `GIT_REMOTE_NAME`: Tên Git Remote sử dụng để kéo mã nguồn (mặc định `origin`).
   - `GIT_BRANCH_NAME`: Tên nhánh mặc định để xây dựng `App-Image` (mặc định `master`).
   - `GIT_SSH_KEY`: Đường dẫn tệp SSH Private Key (`~/.ssh/...`) vừa tải lên _(Nếu sử dụng Username/Password để xác thực -> Hãy để trống)_.
   - 
   - `PROJECT_NETWORK`: Tên mạng trong Docker mà Container của `App-Image` sẽ liên kết _(Nếu không muốn liên kết -> Hãy để trống)_.
   - `APP_IMAGE_REPO`: Đặt Tên mặc định cho `App-Image` sẽ được xây dựng _(Đặt phù hợp với dự án, ví dụ: `coffee/backend-app`)_ **🔥Lưu ý: KHÔNG bao gồm phần TAG của một hình ảnh Docker**.
   - `APP_IMAGE_TAG`: Đặt Thẻ (Tag) mặc định cho `App-Image` - dùng để đánh dấu các phiên bản đã xây dựng, ví dụ: `latest`.
   - `APP_CONTAINER_NAME`: Đặt tên cho Container khi triển khai `App-Image`.
   - 
   - `APP_PORT_HTTP`/`APP_PORT_HTTPS`: Tương ứng với 2 Cổng sẽ được sử dụng để truy cập ứng dụng tương ứng của App Container (http và https) _(Nếu không muốn chuyển tiếp cổng -> Hãy để trống)_.
   - `SUPERVISOR_PORT`: Cổng sẽ được sử dụng để truy cập trình quản lý `Supervisord` - quản lý các dịch vụ/tiến trình tương ứng của App Container _(Nếu không muốn chuyển tiếp cổng -> Hãy để trống)_.
   - 
   - `PWD_WAREHOUSE_...`: Đường dẫn thư mục sẽ gắn với các thư mục tương ứng trong Container của `App-Image` _(Nếu không muốn liên kết -> Hãy để trống)_.
   - `PWD_CONTAINER_...`: Đường dẫn thư mục trong Container của `App-Image` sẽ được gắn _(Hãy chỉ đường dẫn chính xác)_.
   > - 🔥Tất cả các đường dẫn thư mục / tệp trong bước này -> ĐỀU PHẢI SỬ DỤNG ĐƯỜNG DẪN TUYỆT ĐỐI.
   > - 🔥Ngoài ra, tất cả các cấu hình khác không không được nhắc tới hãy giữ nguyên.

### #Thực thi Bash Script - Triển khai liên tục

- Xây dựng - Triển khai với các tham số:
```bash
# ví dụ:
bash ~/project/bash_deploy_script.sh --no-cache --memory=512m --progress=plain --rmi
```

- Để biết toàn bộ tham số được hỗ trợ, thực hiện lệnh sau:
```bash
bash ~/project/bash_deploy_script.sh -h
```
