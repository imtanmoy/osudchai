<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 8/9/18
 * Time: 10:14 AM
 */

namespace App\Shop\Prescriptions\Repositories;


use App\Models\Prescription;
use App\Shop\Base\BaseRepository;
use App\Shop\Prescriptions\Exceptions\PrescriptionInvalidArgumentException;
use App\Shop\Prescriptions\Exceptions\PrescriptionNotFoundException;
use App\Shop\Tools\UploadableTrait;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class PrescriptionRepository extends BaseRepository implements PrescriptionRepositoryInterface
{
    use UploadableTrait;

    protected $model;


    /**
     * PrescriptionRepository constructor.
     * @param Prescription $prescription
     */
    public function __construct(Prescription $prescription)
    {
        parent::__construct($prescription);
        $this->model = $prescription;
    }

    /**
     * @param array $params
     * @return Prescription
     * @throws PrescriptionInvalidArgumentException
     */
    public function createPrescription(array $params): Prescription
    {
        try {
            $prescription = new Prescription($params);
            $prescription->save();
            return $prescription;
        } catch (QueryException $e) {
            throw new PrescriptionInvalidArgumentException('Prescription creation error', 500, $e);
        }
    }

    /**
     * @param Prescription $prescription
     * @param User $user
     */
    public function attachToUser(Prescription $prescription, User $user)
    {
        if (isset($prescription)) {
            $user->prescriptions()->save($prescription);
        }
    }

    /**
     * @param array $update
     * @return bool
     */
    public function updatePrescription(array $update): bool
    {
        return $this->model->update($update);
    }

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function deletePrescription()
    {
        $this->model->user()->dissociate();
        return $this->model->delete();
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function listPrescription(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return Prescription
     */
    public function findPrescriptionById(int $id): Prescription
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new PrescriptionNotFoundException($e->getMessage());
        }
    }

    /**
     * @return User
     */
    public function findUser(): User
    {
        return $this->model->user;
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function savePrescriptionFile(UploadedFile $file): string
    {
        return $this->storeFile($file, 'prescriptions', 'public');
    }
}