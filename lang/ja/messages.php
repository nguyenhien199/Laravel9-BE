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
    'ok' => '成功',
    'success' => '成功',

    /*
     * Common Error message
     */
    'error' => [
        'bad_request' => '不正なリクエストです。',
        'unauthorized' => 'アクセス権がない、もしくは認証に失敗しました。',
        'forbidden' => 'アクセスが禁止されています。',
        'not_found' => 'リソースが見つかりません。',
        'method_not_found' => ':attributeメソッドが見つかりません。',
        'model_not_found' => ':attributeモデルが見つかりません。',
        'method_not_allowed' => '許可されていないメソッドです。',
        'unprocessable_entity' => '処理できないエンティティです。',
        'failed_validation' => 'バリデーションに失敗しました。入力値が不正です。',
        'internal_server_error' => 'サーバーにてエラーが発生しました。',

        'data_not_found' => 'オブジェクトが存在しない、または削除されました。',
        'action_not_found' => 'アクションは存在しません。',
    ],

    'auth' => [
        'error' => [
            'failed' => '認証試行に失敗しました。',
            'not_found' => 'アカウントが存在しないか、削除されています。',
            'not_active' => 'アカウントは非アクティブです。',
            'password' => 'パスワードが間違っています。',
            'unverified' => '未検証のアカウント。',
        ],
    ],

    'token' => [
        'error' => [
            'blacklisted' => 'トークンはブラックリストに登録されました。',
            'expired' => 'トークンの有効期限が切れています。',
            'invalid' => 'トークンは無効です。',
        ],
    ],

    'user' => [
        'error' => [
            'email_exist' => '電子メール :attribute はすでにシステムに存在しています。',
            'delete_admin' => '管理者アカウントを削除する許可はありません。',
            'delete_himself' => 'アカウントを削除する権利はありません。',
            'edit_admin' => '管理者アカウントを編集する許可はありません。',
            'edit_himself' => 'アカウントを編集する権利はありません。',
            'edit_status_himself' => 'アカウントのステータスを編集する権利はありません。',
            'phone_exist' => '電話番号 :attribute はすでにシステムに存在しています。',
            'quick_lock' => 'このクイックアカウントのロックアウトに問題がありました。',
            'quick_unlock' => 'このクイックアカウントのロック解除に問題がありました。',
            'username_exist' => 'ユーザー名 :attribute はすでにシステムに存在しています。',
        ],
    ],

];
