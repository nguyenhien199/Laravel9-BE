<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Response Message Language Lines
    |--------------------------------------------------------------------------
    */

    /*
     * Success message
     */
    'ok' => 'Thành công',
    'success' => 'Thành công',

    /*
     * Common Error message
     */
    'error' => [
        'bad_request' => 'Một yêu cầu không tốt, vui lòng thử lại.',
        'unauthorized' => 'Một ngoại lệ, nỗ lực ủy quyền không thành công.',
        'forbidden' => 'Bạn không có quyền truy cập.',
        'not_found' => 'Tài nguyên bạn đang tìm kiếm không có sẵn.',
        'method_not_found' => 'Một ngoại lệ, phương thức :attribute không được tìm thấy.',
        'model_not_found' => 'Một ngoại lệ, mô hình :attribute không được tìm thấy.',
        'method_not_allowed' => 'Một ngoại lệ, phương thức yêu cầu không được hệ thống hỗ trợ.',
        'unprocessable_entity' => 'Một ngoại lệ, thực thể không thể xử lý.',
        'failed_validation' => 'Một ngoại lệ, xác thực dữ liệu không thành công.',
        'internal_server_error' => 'Một ngoại lệ, lỗi máy chủ nội bộ - vui lòng liên hệ bộ phận kỹ thuật.',

        'data_not_found' => 'Tài nguyên không tồn tại hoặc đã bị xóa.',
        'action_not_found' => 'Hành động không tồn tại.',
    ],

    'auth' => [
        'error' => [
            'failed' => 'Cố gắng xác thực không thành công.',
            'not_found' => 'Tài khoản không tồn tại hoặc đã bị xóa.',
            'not_active' => 'Tài khoản không hoạt động.',
            'password' => 'Mật khẩu không đúng.',
            'unverified' => 'Tài khoản chưa được xác minh.',
        ],
    ],

    'token' => [
        'error' => [
            'blacklisted' => 'Mã thông báo đã bị hủy.',
            'expired' => 'Mã thông báo đã hết hạn.',
            'invalid' => 'Mã thông báo không hợp lệ.',
        ],
    ],

    'user' => [
        'error' => [
            'email_exist' => 'Email :attribute đã tồn tại trong hệ thống.',
            'delete_admin' => 'Bạn không có quyền xóa tài khoản Quản trị viên.',
            'delete_himself' => 'Bạn không có quyền xóa tài khoản của mình.',
            'edit_admin' => 'Không có quyền để chỉnh sửa tài khoản Quản trị viên.',
            'edit_himself' => 'Bạn không có quyền chỉnh sửa tài khoản của mình.',
            'edit_status_himself' => 'Bạn không có quyền chỉnh sửa trạng thái tài khoản của mình.',
            'phone_exist' => 'Số điện thoại :attribute đã tồn tại trong hệ thống.',
            'quick_lock' => 'Đã xảy ra sự cố với việc khóa nhanh tài khoản này.',
            'quick_unlock' => 'Đã xảy ra sự cố với việc mở khóa nhanh tài khoản này.',
            'username_exist' => 'Tên đăng nhập :attribute đã tồn tại trong hệ thống.',
        ],
    ],

];
