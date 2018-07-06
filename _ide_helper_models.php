<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Admin
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin role($roles)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereUpdatedAt($value)
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property int $order
 * @property int $is_active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Category[] $children
 * @property-read \App\Models\Category|null $parent
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Category[] $subCategories
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category d()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Manufacturer
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $address
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manufacturer disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manufacturer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manufacturer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manufacturer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manufacturer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manufacturer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manufacturer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manufacturer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manufacturer withCacheCooldownSeconds($seconds)
 */
	class Manufacturer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductType
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductType disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductType withCacheCooldownSeconds($seconds)
 */
	class ProductType extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

