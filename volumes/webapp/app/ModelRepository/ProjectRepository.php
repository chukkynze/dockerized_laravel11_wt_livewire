<?php

namespace App\ModelRepository;

use App\Exceptions\RepositoryException;
use App\Models\Project;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use LaravelIdea\Helper\App\Models\_IH_Project_C;
use LaravelIdea\Helper\App\Models\_IH_Project_QB;
use LaravelIdea\Helper\App\Models\_IH_ProjectType_C;
use Throwable;

class ProjectRepository
{

    public function __construct(
        public Project $model
    )
    {}


    /**
     * @throws RepositoryException
     */
    public function createModel(
        string $name,
        int $typeId,
        int $statusId,
    ): Project
    {
        try {
            $now = now();

            $newModel = new Project;
            $newModel->setName($name);
            $newModel->setTypeId($typeId);
            $newModel->setStatusId($statusId);
            $newModel->setCreatedAt($now);
            $newModel->setDeletedAt(null);
            $newModel->save();

            return $newModel;
        }
        catch (Exception $exception) {
            $msg = "Could not create a new model because of this exception: {$exception->getMessage()}";
            Log::error($msg, [
                'args' => [
                    'name' => $name,
                    'typeId' => $typeId,
                    'statusId' => $statusId,
                ],
                'exception' => [
                    'class'   => get_class($exception),
                    'code'    => $exception->getCode(),
                    'message' => $exception->getMessage(),
                    'file'    => $exception->getFile(),
                    'line'    => $exception->getLine(),
                    'trace'   => $exception->getTrace(),
                ]
            ]);

            throw new RepositoryException($msg);
        }
    }


    /**
     * @throws RepositoryException
     */
    public function doesModelIdentifiedByUuidExistInTable($uuid): bool
    {
        try {
            return $this->model->whereUuid($uuid)->exists();
        }
        catch (Exception $exception)
        {
            $msg = "Could not check if the model identified by uuid $uuid exists because of this exception: {$exception->getMessage()}";
            Log::error($msg, [
                'args' => [
                    'uuid' => $uuid,
                ],
                'exception' => [
                    'class'   => get_class($exception),
                    'code'    => $exception->getCode(),
                    'message' => $exception->getMessage(),
                    'file'    => $exception->getFile(),
                    'line'    => $exception->getLine(),
                    'trace'   => $exception->getTrace(),
                ]
            ]);

            throw new RepositoryException($msg);
        }
    }


    /**
     * @throws RepositoryException
     */
    public function getModelByUuid(string $uuid): Model|_IH_Project_QB|Project|Builder|null
    {
        try {
            return $this->model->whereUuid($uuid)->firstOrFail();
        }
        catch (Exception $exception)
        {
            $msg = 'Could not retrieve all models because of this exception: ' . $exception->getMessage();
            Log::error($msg, [
                'args' => [],
                'exception' => [
                    'class'   => get_class($exception),
                    'code'    => $exception->getCode(),
                    'message' => $exception->getMessage(),
                    'file'    => $exception->getFile(),
                    'line'    => $exception->getLine(),
                    'trace'   => $exception->getTrace(),
                ]
            ]);

            throw new RepositoryException($msg);
        }
    }

    /**
     * @throws RepositoryException
     */
    public function getAllModels(): _IH_ProjectType_C|Collection|array
    {
        try {
            return $this->model->all();
        }
        catch (Exception $exception)
        {
            $msg = 'Could not retrieve all models because of this exception: ' . $exception->getMessage();
            Log::error($msg, [
                'args' => [],
                'exception' => [
                    'class'   => get_class($exception),
                    'code'    => $exception->getCode(),
                    'message' => $exception->getMessage(),
                    'file'    => $exception->getFile(),
                    'line'    => $exception->getLine(),
                    'trace'   => $exception->getTrace(),
                ]
            ]);

            throw new RepositoryException($msg);
        }
    }


    /**
     * @throws RepositoryException
     */
    public function getCustomPaginatedSearch(
        string $searchTerm='',
        int $projectTypeId=0,
        int $projectStatusId=0,
        int $perPage=5,
        string $sortBy='created_at',
        string $sortDirection='desc',
    ): LengthAwarePaginator|array|Project|Builder|\Illuminate\Pagination\LengthAwarePaginator|_IH_Project_C
    {
        try {
            return $this->model->search($searchTerm)
                ->when($projectTypeId !== 0, function ($query) use($projectTypeId){
                    $query->where('type_id', $projectTypeId);
                })
                ->when($projectStatusId !== 0, function ($query) use($projectStatusId){
                    $query->where('status_id', $projectStatusId);
                })
                ->orderBy($sortBy, $sortDirection)
                ->paginate($perPage);
        }
        catch (Exception $exception)
        {
            $msg = 'Could not retrieve search results because of this exception: ' . $exception->getMessage();
            Log::error($msg, [
                'args' => [],
                'exception' => [
                    'class'   => get_class($exception),
                    'code'    => $exception->getCode(),
                    'message' => $exception->getMessage(),
                    'file'    => $exception->getFile(),
                    'line'    => $exception->getLine(),
                    'trace'   => $exception->getTrace(),
                ]
            ]);

            throw new RepositoryException($msg);
        }
    }


    /**
     * @throws RepositoryException
     */
    public function updateModelByUuid(
        string $uuid,
        string $name,
        int $typeId,
        int $statusId,
    ): Project
    {
        try {
            $now = now();

            $modelToUpdate = $this->getModelByUuid($uuid);

            $modelToUpdate->setName($name);
            $modelToUpdate->setTypeId($typeId);
            $modelToUpdate->setStatusId($statusId);
            $modelToUpdate->setUpdatedAt($now);
            $modelToUpdate->setDeletedAt(null);
            $modelToUpdate->save();

            return $modelToUpdate;
        }
        catch (Exception $exception) {
            $msg = "Could not update the model identified by $uuid because of this exception: {$exception->getMessage()}";
            Log::error($msg, [
                'args' => [
                    'uuid' => $uuid,
                    'name' => $name,
                    'typeId' => $typeId,
                    'statusId' => $statusId,
                ],
                'exception' => [
                    'class'   => get_class($exception),
                    'code'    => $exception->getCode(),
                    'message' => $exception->getMessage(),
                    'file'    => $exception->getFile(),
                    'line'    => $exception->getLine(),
                    'trace'   => $exception->getTrace(),
                ]
            ]);

            throw new RepositoryException($msg);
        }
    }


    /**
     * @throws RepositoryException
     */
    public function softDeleteByUuid(string $uuid): bool
    {
        try {
            return $this->model->whereUuid($uuid)->deleteOrFail();
        }
        catch (Exception $exception)
        {
            $msg = "Could not delete the model identified by uuid $uuid because of this exception: {$exception->getMessage()}";
            Log::error($msg, [
                'args' => [],
                'exception' => [
                    'class'   => get_class($exception),
                    'code'    => $exception->getCode(),
                    'message' => $exception->getMessage(),
                    'file'    => $exception->getFile(),
                    'line'    => $exception->getLine(),
                    'trace'   => $exception->getTrace(),
                ]
            ]);

            throw new RepositoryException($msg);
        }
        catch (Throwable $exception) {
            $msg = "Could not delete the model identified by uuid $uuid because of this exception: {$exception->getMessage()}";
            Log::error($msg, [
                'args' => [],
                'exception' => [
                    'class'   => get_class($exception),
                    'code'    => $exception->getCode(),
                    'message' => $exception->getMessage(),
                    'file'    => $exception->getFile(),
                    'line'    => $exception->getLine(),
                    'trace'   => $exception->getTrace(),
                ]
            ]);

            throw new RepositoryException($msg);
        }
    }
}
