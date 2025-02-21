# BUILD AND DEPLOY - TESTING

Tài liệu hướng dẫn: Xây dựng và Triển khai cho môi trưởng Kiểm thử.

**📝Thực hiện theo hướng dẫn trong tài liệu: [Xây dựng và triển khai cho môi trường Sản xuất](./PRODUCTION.md).**

Và chú ý các điểm khác biệt sau đây:

- Mục `#Bước 1: Xây dựng App-Image`: 
  Thay vì sử dụng tệp lệnh Bash trong thư mục `docker/production`, thì với môi trường Kiểm thử hãy sử dụng tệp lệnh Bash trong thư mục `docker/testing`. 
  _(Các tham số trong tệp lệnh vẫn được giữ nguyên)_.
   ```bash
   'bash ./docker/production/build.sh ...'
   ->
   'bash ./docker/testing/build.sh ...'
   ```

- Mục `#Xây dựng và Triển khai ... - Sử dụng Bash Script` -> `#Cấu hình Máy chủ` -> `3. Tạo (hoặc tải lên) tệp cấu hình biến môi trường...`: 
  Thay vì đặt tên file là `production.env`, thì hãy đặt tên file là `testing.env` tương ứng với tên môi trường để tránh nhầm lẫn.


- Mục `#Xây dựng và Triển khai ... - Sử dụng Bash Script` -> `#Cấu hình Máy chủ` -> `7. Cấu hình tham số trong Script ~/project/bash_deploy_script.sh`: 
  Bắt buộc phải đặt tham số `SOURCE_TO_BUILD="testing"`.
  Ngoài ra, các tham số còn lại cần đặt sao cho phù hợp cho môi trường Testing của bạn.
