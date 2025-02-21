<?php

namespace App\Http\Resources\Api\Admin;

use App\Http\Resources\Core\BaseResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="Resources.Api.Admin.User",
 *      title="Resources.Api.Admin.User",
 *      description="User resource",
 * )
 */
final class UserResource extends BaseResource
{
    /**
     * Format Model field data.
     *
     * @param Model $model <p>Model instance.</p>
     * @param string $field <p>Model property.</p>
     * @return array
     */
    protected static function formatModelData(Model $model, string $field): array
    {
        if (in_array($field, [
                'email_verified_at',
                'phone_verified_at',
                'password_changed_at',
                'first_login_at',
                'last_login_at',
            ]) && !empty($model->{$field})
        ) {
            return [$field => carbon($model->{$field})];
        }
        elseif ($field == 'birthday' && !empty($model->{$field})) {
            return [$field => carbon($model->{$field})->format(DATE_FORMAT)];
        }
        else {
            return parent::formatModelData($model, $field);
        }
    }

    /**
     * @OA\Property(property="id", type="integer", nullable=false, example="1",
     *      description=""
     * ),
     * @OA\Property(property="status", type="integer", nullable=false, example="1",
     *      description="Status in list: (`1`: Active, `0`: Inactive)."
     * ),
     * @OA\Property(property="username", type="string", nullable=false, example="admin@example.com",
     *      description="Username to login."
     * ),
     * @OA\Property(property="firstname", type="string", nullable=false, example="First",
     *      description="First name."
     * ),
     * @OA\Property(property="lastname", type="string", nullable=false, example="Last",
     *      description="Last name."
     * ),
     * @OA\Property(property="gender", type="integer", nullable=false, example="1",
     *      description="Gender in list: (`0`: Other, `1`: Male, `2`: Female)."
     * ),
     * @OA\Property(property="birthday", type="string", format="date", nullable=true, example="1988-07-23",
     *      description="Birthday. <br/>Format date: `yyyy-mm-dd`."
     * ),
     * @OA\Property(property="phone", type="string", nullable=false, example="0987654322",
     *      description="Phone number. <br/>Format number: `098...`."
     * ),
     * @OA\Property(property="phone_verified_at", type="string", format="date", nullable=true, example="2023-12-12T00:00:00+07:00",
     *      description="Phone verified at. <br/>Format date(ATOM): `Y-m-d\TH:i:sP`."
     * ),
     * @OA\Property(property="email", type="string", nullable=false, example="user@example.com",
     *      description="Email."
     * ),
     * @OA\Property(property="email_verified_at", type="string", format="date", nullable=true, example="2023-12-12T00:00:00+07:00",
     *      description="Email verified at. <br/>Format date(ATOM): `Y-m-d\TH:i:sP`."
     * ),
     * @OA\Property(property="avatar", type="string", nullable=true, example="https://via.placeholder.com/640x480.png/F0F0F0?text=NO+IMAGE",
     *      description="Avatar url."
     * ),
     * @OA\Property(property="description", type="string", nullable=true, example="This is an example description",
     *      description="Description."
     * ),
     * @OA\Property(property="lang", type="string", nullable=true, example="ja",
     *      description="Locale code."
     * ),
     * @OA\Property(property="timezone", type="string", nullable=true, example="Asia/Tokyo",
     *      description="Timezone name."
     * ),
     * @OA\Property(property="organization", type="string", maxLength=255, nullable=true, example="Example co., Ltd",
     *      description="Organization/Company name."
     * ),
     * @OA\Property(property="department", type="string", maxLength=255, nullable=true, example="Product Operation Center",
     *      description="Department name."
     * ),
     * @OA\Property(property="position", type="string", maxLength=255, nullable=true, example="Director",
     *      description="Job position."
     * ),
     * @OA\Property(property="address", type="string", maxLength=255, nullable=true, example="Tran Thu Do street, Hoang Mai district",
     *      description="Address."
     * ),
     * @OA\Property(property="city", type="string", maxLength=255, nullable=true, example="Ha Noi",
     *      description="City name."
     * ),
     * @OA\Property(property="country", type="string", maxLength=255, nullable=true, example="Viet Nam",
     *      description="Country name."
     * ),
     * @OA\Property(property="password_changed_at", type="string", format="date", nullable=true, example="2023-12-12T00:00:00+07:00",
     *      description="Last Password changed at. <br/>Format date(ATOM): `Y-m-d\TH:i:sP`."
     * ),
     * @OA\Property(property="first_login_at", type="string", format="date", nullable=true, example="2023-12-12T00:00:00+07:00",
     *      description="First logged at. <br/>Format date(ATOM): `Y-m-d\TH:i:sP`."
     * ),
     * @OA\Property(property="first_login_ip", type="string", nullable=true, example="192.168.1.2",
     *      description="First logged ip."
     * ),
     * @OA\Property(property="last_login_at", type="string", format="date", nullable=true, example="2023-12-12T00:00:00+07:00",
     *      description="Last logged at. <br/>Format date(ATOM): `Y-m-d\TH:i:sP`."
     * ),
     * @OA\Property(property="last_login_ip", type="string", nullable=true, example="192.168.1.2",
     *      description="Last logged ip."
     * ),
     * @OA\Property(property="created_at", type="string", format="date", nullable=true, example="2023-12-12T00:00:00+07:00",
     *      description="Creation time at. <br/>Format date(ATOM): `Y-m-d\TH:i:sP`."
     * ),
     * @OA\Property(property="updated_at", type="string", format="date", nullable=true, example="2023-12-12T00:00:00+07:00",
     *      description="Last update time at. <br/>Format date(ATOM): `Y-m-d\TH:i:sP`."
     * ),
     * @OA\Property(property="deleted_at", type="string", format="date", nullable=true, example="2023-12-12T00:00:00+07:00",
     *      description="Soft delete time at. <br/>Format date(ATOM): `Y-m-d\TH:i:sP`."
     * ),
     */

    public int $id;
    public int $status;
    public string $username;
    public string $firstname;
    public string $lastname;
    public int $gender;
    public ?string $birthday = null;
    public string $phone;
    public ?Carbon $phone_verified_at = null;
    public string $email;
    public ?Carbon $email_verified_at = null;
    public ?string $avatar = null;
    public ?string $description = null;
    public ?string $lang = null;
    public ?string $timezone = null;
    public ?string $organization = null;
    public ?string $department = null;
    public ?string $position = null;
    public ?string $address = null;
    public ?string $city = null;
    public ?string $country = null;
    public ?Carbon $password_changed_at = null;
    public ?Carbon $first_login_at = null;
    public ?string $first_login_ip = null;
    public ?Carbon $last_login_at = null;
    public ?string $last_login_ip = null;
    public ?Carbon $created_at = null;
    public ?Carbon $updated_at = null;
    public ?Carbon $deleted_at = null;
}
