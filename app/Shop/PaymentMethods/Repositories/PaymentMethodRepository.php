<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/20/2018
 * Time: 6:40 PM
 */

namespace App\Shop\PaymentMethods\Repositories;


use App\Models\PaymentMethod;
use App\Shop\Base\BaseRepository;

class PaymentMethodRepository extends BaseRepository implements PaymentMethodRepositoryInterface
{
    protected $model;

    /**
     * PaymentMethodRepository constructor.
     * @param PaymentMethod $paymentMethod
     */
    public function __construct(PaymentMethod $paymentMethod)
    {
        parent::__construct($paymentMethod);
        $this->model = $paymentMethod;
    }


}
