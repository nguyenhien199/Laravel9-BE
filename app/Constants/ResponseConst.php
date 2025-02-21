<?php

namespace App\Constants;

/**
 * Class ResponseConst
 *
 * @package App\Constants
 */
class ResponseConst
{
    // For HTTP
    public const CODE_OK                    = 'OK';                          // Success.
    public const CODE_BAD_REQUEST           = 'BAD_REQUEST';                 // A bad request, please try again.
    public const CODE_UNAUTHORIZED          = 'UNAUTHORIZED';                // An exception, failed authorization attempt.
    public const CODE_UNPROCESSABLE_ENTITY  = 'UNPROCESSABLE_ENTITY';        // An exception, the Entity cannot handle.
    public const CODE_FORBIDDEN             = 'FORBIDDEN';                   // You don't have permission to access.
    public const CODE_NOT_FOUND             = 'NOT_FOUND';                   // The Resource you are looking for is not available.
    public const CODE_INTERNAL_SERVER_ERROR = 'INTERNAL_SERVER_ERROR';       // An exception, Please contact technical department.
    public const CODE_METHOD_NOT_ALLOWED    = 'METHOD_NOT_ALLOWED';          // An exception, The request method is not supported by the system.
    public const CODE_METHOD_NOT_FOUND      = 'METHOD_NOT_FOUND';            // An exception, the method {ClassName->MethodName} not found.
    public const CODE_MODEL_NOT_FOUND       = 'MODEL_NOT_FOUND';             // An exception, the model {ModelName} not found.
    public const CODE_FAILED_VALIDATION     = 'FAILED_VALIDATION';           // An exception, failed validation attempt.
    public const CODE_TOKEN_EXPIRED         = 'TOKEN_EXPIRED';               // An exception, token has expired

    // For Data
    public const CODE_DATA_NOT_FOUND = 'DATA_NOT_FOUND';                     // :data does not exist or has been deleted.
    public const CODE_DATA_INVALID   = 'DATA_INVALID';                       // :data invalid.
    public const CODE_DATA_EXIST     = 'DATA_EXIST';                         // :data exists.
    public const CODE_DATA_DUPLICATE = 'DATA_DUPLICATE';                     // :data duplicate.

}
