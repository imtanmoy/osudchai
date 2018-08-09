<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 8/9/18
 * Time: 10:12 AM
 */

namespace App\Shop\Prescriptions\Repositories;


use App\Models\Prescription;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

interface PrescriptionRepositoryInterface extends BaseRepositoryInterface
{
    public function createPrescription(array $params): Prescription;

    public function attachToUser(Prescription $prescription, User $user);

    public function updatePrescription(array $update): bool;

    public function deletePrescription();

    public function listPrescription(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection;

    public function findPrescriptionById(int $id): Prescription;

    public function findUser(): User;

    public function savePrescriptionFile(UploadedFile $file): string;
}