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
 * App\Models\Attribute
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductAttribute[] $values
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attribute whereUpdatedAt($value)
 */
	class Attribute extends \Eloquent {}
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
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
 * App\Models\GenericName
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GenericName disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GenericName whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GenericName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GenericName whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GenericName whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GenericName withCacheCooldownSeconds($seconds)
 */
	class GenericName extends \Eloquent {}
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
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
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $sku
 * @property string $slug
 * @property string|null $description
 * @property float $price
 * @property int $is_active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $manufacturer_id
 * @property int $category_id
 * @property int $product_type_id
 * @property int|null $strength_id
 * @property int|null $generic_name_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductAttribute[] $attributes
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\ProductImages $featuredPhoto
 * @property-read \App\Models\GenericName|null $generic_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductImages[] $images
 * @property-read \App\Models\Manufacturer $manufacturer
 * @property-read \App\Models\ProductType $product_type
 * @property-read \App\Models\ProductStock $stock
 * @property-read \App\Models\Strength|null $strength
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereGenericNameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereManufacturerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereProductTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereStrengthId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductAttribute
 *
 * @property int $id
 * @property string $value
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $attribute_id
 * @property int $product_id
 * @property-read \App\Models\Attribute $attribute_name
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductAttribute whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductAttribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductAttribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductAttribute whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductAttribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductAttribute whereValue($value)
 */
	class ProductAttribute extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductImages
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property string|null $thumbnail_path
 * @property int $featured
 * @property string $provider
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $product_id
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImages whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImages whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImages wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImages whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImages whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImages whereThumbnailPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImages whereUpdatedAt($value)
 */
	class ProductImages extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductStock
 *
 * @property int $id
 * @property int $available_qty
 * @property int $minimum_order_qty
 * @property string $stock_status
 * @property int $subtract_stock
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $product_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductStock whereAvailableQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductStock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductStock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductStock whereMinimumOrderQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductStock whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductStock whereStockStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductStock whereSubtractStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductStock whereUpdatedAt($value)
 */
	class ProductStock extends \Eloquent {}
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductType disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductType withCacheCooldownSeconds($seconds)
 */
	class ProductType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Strength
 *
 * @property int $id
 * @property string $value
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Strength whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Strength whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Strength whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Strength whereValue($value)
 */
	class Strength extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserVerification
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserVerification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserVerification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserVerification whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserVerification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserVerification whereUserId($value)
 */
	class UserVerification extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $avatar
 * @property string|null $password
 * @property int $is_verified
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\Models\UserVerification $verification
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

