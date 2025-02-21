<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Các dòng ngôn ngữ sau chứa các thông báo lỗi mặc định được lớp trình
    | xác thực sử dụng. Một số quy tắc này có nhiều phiên bản, chẳng hạn như
    | quy tắc kích thước. Vui lòng chỉnh sửa từng thông báo ở đây.
    |
    */

    'accepted' => 'Trường :attribute phải được chấp nhận.',
    'accepted_if' => 'Trường :attribute phải được chấp nhận khi :other là :value.',
    'active_url' => 'Trường :attribute không phải là một URL hợp lệ.',
    'after' => 'Trường :attribute phải là một ngày sau ngày :date.',
    'after_or_equal' => 'Trường :attribute phải là một ngày sau hoặc bằng ngày :date.',
    'alpha' => 'Trường :attribute chỉ có thể chứa các chữ cái.',
    'alpha_dash' => 'Trường :attribute chỉ có thể chứa chữ cái, số và dấu gạch ngang.',
    'alpha_num' => 'Trường :attribute chỉ có thể chứa chữ cái và số.',
    'array' => 'Kiểu dữ liệu của trường :attribute phải là dạng mảng.',
    'ascii' => 'Trường :attribute chỉ được chứa các ký tự chữ số và ký hiệu một byte.',
    'before' => 'Trường :attribute phải là một ngày trước ngày :date.',
    'before_or_equal' => 'Trường :attribute phải là một ngày trước hoặc bằng ngày :date.',
    'between' => [
        'array' => 'Trường :attribute phải có từ :min - :max phần tử.',
        'file' => 'Dung lượng tập tin trong trường :attribute phải từ :min - :max kB.',
        'numeric' => 'Trường :attribute phải nằm trong khoảng :min - :max.',
        'string' => 'Trường :attribute phải từ :min - :max ký tự.',
    ],
    'boolean' => 'Trường :attribute phải là true hoặc false.',
    'can' => 'Trường :attribute chứa giá trị không được phép.',
    'confirmed' => 'Giá trị xác nhận trong trường :attribute không khớp.',
    'current_password' => 'Mật khẩu hiện tại không đúng.',
    'date' => 'Trường :attribute không phải là định dạng của ngày-tháng.',
    'date_equals' => 'Trường :attribute phải là một ngày bằng với :date.',
    'date_format' => 'Trường :attribute không giống với định dạng :format.',
    'decimal' => 'Trường :attribute phải có :decimal chữ số thập phân.',
    'declined' => 'Trường :attribute phải được từ chối.',
    'declined_if' => 'Trường :attribute phải được từ chối khi :other là :value.',
    'different' => 'Trường :attribute và :other phải khác nhau.',
    'digits' => 'Độ dài của trường :attribute phải gồm :digits chữ số.',
    'digits_between' => 'Độ dài của trường :attribute phải nằm trong khoảng :min and :max chữ số.',
    'dimensions' => 'Trường :attribute có kích thước ảnh không hợp lệ.',
    'distinct' => 'Trường :attribute có giá trị bị trùng lặp.',
    'doesnt_end_with' => 'Trường :attribute không được kết thúc bằng một trong các giá trị sau: :values.',
    'doesnt_start_with' => 'Trường :attribute không được bắt đầu bằng một trong các giá trị sau: :values.',
    'email' => 'Trường :attribute phải là một địa chỉ email hợp lệ.',
    'ends_with' => 'Trường :attribute phải kết thúc bằng một trong những giá trị sau: :values.',
    'enum' => 'Giá trị :attribute đã chọn không hợp lệ.',
    'exists' => 'Giá trị đã chọn trong trường :attribute không hợp lệ.',
    'file' => 'Trường :attribute phải là một tập tin.',
    'filled' => 'Trường :attribute không được bỏ trống.',
    'gt' => [
        'array' => 'Trường :attribute phải lớn hơn :max phần tử.',
        'file' => 'Dung lượng tập tin trong trường :attribute phải lớn hơn :max KB.',
        'numeric' => 'Trường :attribute phải lớn hơn :max.',
        'string' => 'Trường :attribute phải lớn hơn :max ký tự.',
    ],
    'gte' => [
        'array' => 'Trường :attribute phải lớn hơn hoặc bằng :max phần tử.',
        'file' => 'Dung lượng tập tin trong trường :attribute phải lớn hơn hoặc bằng :max KB.',
        'numeric' => 'Trường :attribute phải lớn hơn hoặc bằng :max.',
        'string' => 'Trường :attribute phải lớn hơn hoặc bằng :max ký tự.',
    ],
    'image' => 'Các tập tin trong trường :attribute phải là định dạng hình ảnh.',
    'in' => 'Giá trị đã chọn trong trường :attribute không hợp lệ.',
    'in_array' => 'Trường :attribute không tồn tại trong :other.',
    'integer' => 'Trường :attribute phải là một số nguyên.',
    'ip' => 'Trường :attribute phải là một địa chỉa IP.',
    'ipv4' => 'Trường :attribute phải là địa chỉ IPv4 hợp lệ.',
    'ipv6' => 'Trường :attribute phải là địa chỉ IPv6 hợp lệ.',
    'json' => 'Trường :attribute phải là chuỗi JSON hợp lệ.',
    'lowercase' => 'Trường :attribute phải là chữ thường.',
    'lt' => [
        'array' => 'Trường :attribute phải có nhỏ hơn :min phần tử.',
        'file' => 'Dung lượng tập tin trong trường :attribute phải nhỏ hơn :min KB.',
        'numeric' => 'Trường :attribute phải nhỏ hơn là :min.',
        'string' => 'Trường :attribute phải có nhỏ hơn :min ký tự.',
    ],
    'lte' => [
        'array' => 'Trường :attribute phải có nhỏ hơn hoặc bằng :min phần tử.',
        'file' => 'Dung lượng tập tin trong trường :attribute phải nhỏ hơn hoặc bằng :min KB.',
        'numeric' => 'Trường :attribute phải nhỏ hơn hoặc bằng là :min.',
        'string' => 'Trường :attribute phải có nhỏ hơn hoặc bằng :min ký tự.',
    ],
    'mac_address' => 'Trường :attribute phải là một địa MAC hợp lệ.',
    'max' => [
        'array' => 'Trường :attribute không được lớn hơn :max phần tử.',
        'file' => 'Dung lượng tập tin trong trường :attribute không được lớn hơn :max KB.',
        'numeric' => 'Trường :attribute không được lớn hơn :max.',
        'string' => 'Trường :attribute không được lớn hơn :max ký tự.',
    ],
    'max_digits' => 'Trường :attribute không được nhiều hơn :max chữ số.',
    'mimes' => 'Trường :attribute phải là một tập tin có định dạng: :values.',
    'mimetypes' => 'Trường :attribute phải là một tệp có định dạng là: :values.',
    'min' => [
        'array' => 'Trường :attribute phải có tối thiểu :min phần tử.',
        'file' => 'Dung lượng tập tin trong trường :attribute phải tối thiểu :min KB.',
        'numeric' => 'Trường :attribute phải tối thiểu là :min.',
        'string' => 'Trường :attribute phải có tối thiểu :min ký tự.',
    ],
    'min_digits' => 'Trường :attribute phải có ít nhất :min chữ số.',
    'missing' => 'Trường :attribute phải bị thiếu.',
    'missing_if' => 'Trường :attribute phải bị thiếu khi :other là :value.',
    'missing_unless' => 'Trường :attribute phải bị thiếu trừ khi :other là :value.',
    'missing_with' => 'Trường :attribute phải bị thiếu khi có :values.',
    'missing_with_all' => 'Trường :attribute phải bị thiếu khi có :values trường.',
    'multiple_of' => 'Trường :attribute cần chia hết cho :value.',
    'not_in' => 'Giá trị đã chọn trong trường :attribute không hợp lệ.',
    'not_regex' => 'Trường :attribute định dạng không hợp lệ.',
    'numeric' => 'Trường :attribute phải là một số.',
    'password' => [
        'letters' => 'Trường :attribute phải chứa ít nhất một chữ cái.',
        'mixed' => 'Trường :attribute phải chứa ít nhất một chữ hoa và một chữ thường.',
        'numbers' => 'Trường :attribute phải chứa ít nhất một số.',
        'symbols' => 'Trường :attribute phải chứa ít nhất một ký hiệu.',
        'uncompromised' => 'Trường :attribute đã xuất hiện trong một vụ rò rỉ dữ liệu. Vui lòng chọn một :attribute khác.',
    ],
    'present' => 'Trường :attribute phải có (hiện diện).',
    'prohibited' => 'Trường :attribute bị cấm.',
    'prohibited_if' => 'Trường :attribute bị cấm khi :other là :value.',
    'prohibited_unless' => 'Trường :attribute bị cấm trừ khi :other có giá trị trong :values.',
    'prohibits' => 'Trường :attribute bị cấm :other không có mặt.',
    'regex' => 'Định dạng trường :attribute không hợp lệ.',
    'required' => 'Trường :attribute không được bỏ trống.',
    'required_array_keys' => 'Trường :attribute phải chứa các mục nhập cho: :values.',
    'required_if' => 'Trường :attribute không được bỏ trống khi trường :other là :value.',
    'required_if_accepted' => 'Trường :attribute không được bỏ trống khi trường :other được chấp nhận.',
    'required_unless' => 'Trường :attribute không được bỏ trống trừ khi :other có giá trị trong :values.',
    'required_with' => 'Trường :attribute không được bỏ trống khi trường :values có giá trị.',
    'required_with_all' => 'Trường :attribute không được bỏ trống khi :values có giá trị.',
    'required_without' => 'Trường :attribute không được bỏ trống khi trường :values không có giá trị.',
    'required_without_all' => 'Trường :attribute không được bỏ trống khi tất cả :values không có giá trị.',
    'same' => 'Trường :attribute và :other phải giống nhau.',
    'size' => [
        'array' => 'Trường :attribute phải chứa :size phần tử.',
        'file' => 'Dung lượng tập tin trong trường :attribute phải bằng :size kB.',
        'numeric' => 'Trường :attribute phải bằng :size.',
        'string' => 'Trường :attribute phải chứa :size ký tự.',
    ],
    'starts_with' => 'Trường :attribute phải được bắt đầu bằng một trong những giá trị sau: :values.',
    'string' => 'Trường :attribute phải là một chuỗi.',
    'timezone' => 'Trường :attribute phải là một múi giờ hợp lệ.',
    'unique' => 'Trường :attribute đã có trong hệ thống.',
    'uploaded' => 'Trường :attribute không thể tải lên.',
    'uppercase' => 'Trường :attribute phải là chữ in hoa.',
    'url' => 'Trường :attribute không giống với định dạng một URL.',
    'ulid' => 'Trường :attribute phải là một ULID hợp lệ.',
    'uuid' => 'Trường :attribute không phải là một chuỗi UUID hợp lệ.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Tại đây, bạn có thể chỉ định các thông báo xác thực tùy chỉnh cho các thuộc tính bằng cách
    | sử dụng quy ước "attribute.rule" để đặt tên cho các dòng. Điều này giúp bạn nhanh chóng
    | chỉ định một dòng ngôn ngữ tùy chỉnh cụ thể cho một quy tắc thuộc tính nhất định.
    |
    */

    'custom' => [
        'base64' => 'Trường :attribute không phải là một encode Base64 hợp lệ.',
        'bigid' => 'Trường :attribute không phải là BigId hợp lệ.',
        'password' => [
            'existed_in_history' => 'Bạn không thể đặt mật khẩu mà bạn đã sử dụng trước đó trong vòng :number lần gần đây nhất.',
            'incorrect' => 'Mật khẩu không đúng.',
            'mixture' => 'Trường :attribute phải chứa ít nhất một chữ cái viết hoa, một chữ cái viết thường, một chữ số và một ký tự đặc biệt.',
            'same_as_current' => 'Trường :attribute không được giống với mật khẩu hiện tại.',
        ],
        'phone' => [
            'invalid' => 'Trường :attribute phải là một số điện thoại hợp lệ.',
            'unique' => 'Số điện thoại này đã được đăng ký.',
        ],
        'request' => [
            'data_not_found' => 'Không có dữ liệu được tìm thấy từ yêu cầu.',
            'field_not_empty' => 'Trường :attribute không được bỏ trống.',
            'field_not_found' => 'Trường :attribute từ yêu cầu không được tìm thấy.',
            'field_not_null' => 'Trường :attribute không được vô giá trị(null).',
        ],
        'time' => 'Trường :attribute không phải là định dạng của giờ(H:i).',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | Các dòng ngôn ngữ sau đây được sử dụng để hoán đổi phần giữ chỗ thuộc tính của chúng tôi
    | bằng nội dung nào đó thân thiện với người đọc hơn, chẳng hạn như "Địa chỉ email" thay vì "email".
    | Điều này chỉ đơn giản giúp chúng tôi làm cho thông điệp của mình có tính biểu cảm hơn.
    |
    */

    'attributes' => [],

];
