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
    'ok' => 'Success',
    'success' => 'Success',

    /*
     * Common Error message
     */
    'error' => [
        'bad_request' => 'A bad request, please try again.',
        'unauthorized' => 'An exception, failed authorization attempt.',
        'forbidden' => "You don't have permission to access.",
        'not_found' => 'The resource you are looking for is not available.',
        'method_not_found' => 'An exception, the method :attribute not found.',
        'model_not_found' => 'An exception, the model :attribute not found.',
        'method_not_allowed' => 'An exception, the request method is not supported by the system.',
        'unprocessable_entity' => 'An exception, the entity cannot handle.',
        'failed_validation' => 'An exception, failed validation attempt.',
        'internal_server_error' => 'An exception, internal server error - please contact technical department.',

        'data_not_found' => 'The resource does not exist or has been deleted.',
        'action_not_found' => 'The action does not exist.',
    ],

    'auth' => [
        'error' => [
            'failed' => 'Authentication attempt failed.',
            'not_found' => 'Account does not exist or has been deleted.',
            'not_active' => 'Account is inactive.',
            'password' => 'The provided password is incorrect.',
            'unverified' => 'Unverified account.',
        ],
    ],

    'token' => [
        'error' => [
            'blacklisted' => 'The token has been blacklisted.',
            'expired' => 'The token has expired.',
            'invalid' => 'The token is not valid.',
        ],
    ],

    'user' => [
        'error' => [
            'email_exist' => 'Email :attribute already exists in the system.',
            'delete_admin' => 'No permission to delete Administrator account.',
            'delete_himself' => 'You do not have the right to delete your account.',
            'edit_admin' => 'No permission to edit Administrator account.',
            'edit_himself' => 'You do not have the right to edit your account.',
            'edit_status_himself' => 'You do not have the right to edit your account status.',
            'phone_exist' => 'Phone number :attribute already exists in the system.',
            'quick_lock' => 'There was a problem with this quick account lockout.',
            'quick_unlock' => 'There was a problem with this quick account unlock.',
            'username_exist' => 'Username :attribute already exists in the system.',
        ],
    ],

];
