<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | 次の言語行には、バリデータ クラスで使用されるデフォルトのエラー メッセージが含まれています。
    | これらのルールの中には、サイズ ルールなど複数のバージョンがあるものもあります。
    | ここで各メッセージを自由に調整してください。
    |
    */

    'accepted' => ':attributeを承認してください。',
    'accepted_if' => ' :otherが:valueの時、:attributeは。',
    'active_url' => ':attributeは、有効なURLではありません。',
    'after' => ':attributeには、:date以降の日付を指定してください。',
    'after_or_equal' => ':attributeは:date以降の日付、または:dateに指定してください。',
    'alpha' => ':attributeには、アルファベッドのみ使用できます。',
    'alpha_dash' => ":attributeには、英数字('A-Z','a-z','0-9')とハイフンと下線('-','_')が使用できます。",
    'alpha_num' => ":attributeには、英数字('A-Z','a-z','0-9')が使用できます。",
    'array' => ':attributeには、配列を指定してください。',
    'ascii' => ':attributeには、英数字と記号のみ使用可能です。',
    'before' => ':attributeには、:date以前の日付を指定してください。',
    'before_or_equal' => 'attributeは:date以前の日付、または:dateに指定してください。',
    'between' => [
        'array' => ':attributeの項目は、:min個から:max個にしてください。',
        'file' => ':attributeには、:min KBから:max KBまでのサイズのファイルを指定してください。',
        'numeric' => ':attributeには、:minから、:maxまでの数字を指定してください。',
        'string' => ':attributeは、:min文字から:max文字にしてください。',
    ],
    'boolean' => ":attributeには、'true'か'false'を指定してください。",
    'can' => ':attribute フィールドに不正な値が含まれています。',
    'confirmed' => ':attributeと:attribute確認が一致しません。',
    'current_password' => 'パスワードが間違っています。',
    'date' => ':attributeは、正しい日付ではありません。',
    'date_equals' => ':attributeは:dateにしてください。',
    'date_format' => ":attributeの形式は、':format'と合いません。",
    'decimal' => ':attributeは、小数点以下が:decimalである必要があります。',
    'declined' => ':attributeは拒否しなければなりません。',
    'declined_if' => ':otherが:valueのため、:attributeが却下されました。',
    'different' => ':attributeと:otherには、異なるものを指定してください。',
    'digits' => ':attributeは、:digits桁にしてください。',
    'digits_between' => ':attributeは、:min桁から:max桁にしてください。',
    'dimensions' => ':attributeの画像サイズが不正です。',
    'distinct' => ':attribute値が既に存在しています。',
    'doesnt_end_with' => ':attribute は次のいずれかで終わることはできません: :values。',
    'doesnt_start_with' => ':attribute は、次のいずれかで始まることはできません: :values。',
    'email' => ':attributeは、有効なメールアドレス形式で指定してください。',
    'ends_with' => ':attributeは:valuesで終わらなければなりません。',
    'enum' => '選択した:attributeが不正です。',
    'exists' => '選択された:attributeは、有効ではありません。',
    'file' => ':attributeはファイルで指定してください。',
    'filled' => ':attributeは必須です。',
    'gt' => [
        'array' => ':attribute項目は:valueより多くしてください。',
        'file' => ':attributeは:value kilobytesより大きくしてください。',
        'numeric' => ':attributeは:valueより大きくしてください。',
        'string' => ':attributeは:value文字より多くしてください。',
    ],
    'gte' => [
        'array' => ':attribute項目は:valueより多く、または:valueにしてください。',
        'file' => ':attributeは:value kilobytesより大きく、または:value kilobytesにしてください。',
        'numeric' => ':attributeは:valueより大きく、または:valueにしてください。',
        'string' => ':attributeは:value文字より多く、または:value文字にしてください。',
    ],
    'image' => ':attributeには、画像を指定してください。',
    'in' => '選択された:attributeは、有効ではありません。',
    'in_array' => ':attribute欄は:otherに存在しません。',
    'integer' => ':attributeには、整数を指定してください。',
    'ip' => ':attributeには、有効なIPアドレスを指定してください。',
    'ipv4' => ':attributeは正常IPv4にしてください。',
    'ipv6' => ':attributeは正常IPv6にしてください。',
    'json' => ':attributeには、有効なJSON文字列を指定してください。',
    'lowercase' => ':attributeは、小文字で入力してください。',
    'lt' => [
        'array' => ':attribute項目は:valueより少なくしてください。',
        'file' => ':attributeは:value kilobytesより小さくしてください。',
        'numeric' => ':attributeは:valueより小さくしてください。',
        'string' => ':attributeは:value文字より少なくしてください。',
    ],
    'lte' => [
        'array' => ':attribute項目は:valueより少なく、または:valueにしてください。',
        'file' => ':attributeは:value kilobytesより小さく、または:value kilobytesにしてください。',
        'numeric' => ':attributeは:valueより小さく、または:valueにしてください。',
        'string' => ':attributeは:value文字より少なく、または:value文字にしてください。',
    ],
    'mac_address' => ':attributeが正常のMACアドレスでなければなりません。',
    'max' => [
        'array' => ':attributeの項目は、:max個以下にしてください。',
        'file' => ':attributeには、:max KB以下のファイルを指定してください。',
        'numeric' => ':attributeには、:max以下の数字を指定してください。',
        'string' => ':attributeは、:max文字以下にしてください。',
    ],
    'max_digits' => ':attributeは :max 桁を超えてはなりません。',
    'mimes' => ':attributeには、:valuesタイプのファイルを指定してください。',
    'mimetypes' => ':attributeには、:valuesタイプのファイルを指定してください。',
    'min' => [
        'array' => ':attributeの項目は、:max個以上にしてください。',
        'file' => ':attributeには、:min KB以上のファイルを指定してください。',
        'numeric' => ':attributeには、:min以上の数字を指定してください。',
        'string' => ':attributeは、:min文字以上にしてください。',
    ],
    'min_digits' => ':attributeには少なくとも :min桁が必要です。',
    'missing' => ':attribute を入力する必要はありません。',
    'missing_if' => ':other が :value の場合、:attribute を入力する必要はありません。',
    'missing_unless' => ':other が :value でない限り、:attribute をは入力する必要はありません。',
    'missing_with' => ':values が存在する場合、:attribute をは入力する必要はありません。',
    'missing_with_all' => ':values が存在する場合、:attribute をは入力する必要はありません。',
    'multiple_of' => ':attributeが:valueの倍数でなければなりません。',
    'not_in' => '選択された:attributeは、有効ではありません。',
    'not_regex' => ':attributeフォーマットが不正です。',
    'numeric' => ':attributeには、数字を指定してください。',
    'password' => [
        'letters' => ':attributeには最低1文字が必要です。',
        'mixed' => ':attributeには最低1大文字と1小文字が必要です。',
        'numbers' => ':attributeには最低1数字が必要です。',
        'symbols' => ':attributeには最低1記号が必要です。',
        'uncompromised' => ":attributeがデータ漏れ現れたため、他の:attributeを利用してください。",
    ],
    'present' => ':attribute欄が存在しなければなりません。',
    'prohibited' => ':attributeが無効です。',
    'prohibited_if' => ':otherが:valuesでのため、:attributeが無効です。',
    'prohibited_unless' => ':otherが:valuesではないため、:attributeが無効です。',
    'prohibits' => ':attributeには:otherが許容されません。',
    'regex' => ':attributeには、有効な正規表現を指定してください。',
    'required' => ':attributeは、必ず指定してください。',
    'required_array_keys' => ':attribute フィールドには、:values のエントリが含まれている必要があります。',
    'required_if' => ':otherが:valueの場合、:attributeを指定してください。',
    'required_if_accepted' => ':otherが受け入れられる場合、:attributeフィールドは必須です。',
    'required_unless' => ':otherが:value以外の場合、:attributeを指定してください。',
    'required_with' => ':valuesが指定されている場合、:attributeも指定してください。',
    'required_with_all' => ':valuesが全て指定されている場合、:attributeも指定してください。',
    'required_without' => ':valuesが指定されていない場合、:attributeを指定してください。',
    'required_without_all' => ':valuesが全て指定されていない場合、:attributeを指定してください。',
    'same' => ':attributeと:otherが一致しません。',
    'size' => [
        'numeric' => ':attributeには、:sizeを指定してください。',
        'file' => ':attributeには、:size KBのファイルを指定してください。',
        'string' => ':attributeは、:size文字にしてください。',
        'array' => ':attributeの項目は、:size個にしてください。',
    ],
    'starts_with' => ':attributeが:valuesで始まらなければなりません。',
    'string' => ':attributeには、文字を指定してください。',
    'timezone' => ':attributeには、有効なタイムゾーンを指定してください。',
    'unique' => '指定の:attributeは既に使用されています。',
    'uploaded' => ':attributeアップロードが失敗しました。',
    'uppercase' => ':attributeは、大文字で入力してください。',
    'url' => ':attributeは、有効なURL形式で指定してください。',
    'ulid' => ':attributeは、有効なULIDである必要があります。',
    'uuid' => ':attributeは、有効なUUID形式で指定してください。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | ここでは、行に名前を付ける規則「attribute.rule」を使用して、
    | 属性のカスタム検証メッセージを指定できます。
    | これにより、特定の属性ルールに対して特定のカスタム言語行を簡単に指定できるようになります。
    |
    */

    'custom' => [
        'base64' => ':attributeがBase64エンコーディングでなければなりません。',
        'bigid' => ':attributeは、有効なBigId形式で指定してください。',
        'password' => [
            'existed_in_history' => '過去 :number 回以内に使用したパスワードを設定することはできません。',
            'incorrect' => 'パスワードが間違っています。',
            'mixture' => ':attribute には、少なくとも 1 つの大文字、1 つの小文字、1 つの数字、および 1 つの記号が含まれている必要があります。',
            'same_as_current' => ':attributeは、現在のパスワードと同じであってはなりません。',
        ],
        'phone' => [
            'invalid' => ':attribute有効な電話番号形式である必要があります。',
            'unique' => 'この電話番号はすでに登録されています。',
        ],
        'request' => [
            'data_not_found' => 'リクエストからデータは見つかりませんでした。',
            'field_not_empty' => ':attributeフィールドを空にすることはできません。',
            'field_not_found' => ':attributeフィールドがリクエスト内に見つかりませんでした。',
            'field_not_null' => ':attributeフィールドを null にすることはできません。',
        ],
        'time' => ':attributeは、正しい日付ではありません(H:i)。',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | 次の言語行は、属性プレースホルダーを、「email」ではなく「E-Mail Address」など、
    | より読みやすいものに置き換えるために使用されます。
    | これは単にメッセージをより表現力豊かにするのに役立ちます。
    |
    */

    'attributes' => [],

];
