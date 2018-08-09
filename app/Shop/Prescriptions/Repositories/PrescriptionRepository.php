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
use App\Shop\Tools\UploadableTrait;
use App\User;
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

    public function updatePrescription(array $update): bool
    {
        // TODO: Implement updatePrescription() method.
    }

    public function deletePrescription()
    {
        // TODO: Implement deletePrescription() method.
    }

    public function listPrescription(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection
    {
        // TODO: Implement listPrescription() method.
    }

    public function findPrescriptionById(int $id): Prescription
    {
        // TODO: Implement findPrescriptionById() method.
    }

    public function findUser(): User
    {
        // TODO: Implement findUser() method.
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