<?php

namespace App\Services;

use App\Entities\AppServiceResponse;
use App\Exceptions\RepositoryException;
use App\ModelRepository\ProjectRepository;
use App\ModelRepository\ProjectStatusRepository;
use App\ModelRepository\ProjectTypeRepository;
use App\Models\Project;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use LaravelIdea\Helper\App\Models\_IH_Project_C;

class ProjectService
{

    public function __construct(
        public ProjectRepository $projectRepo,
        public ProjectTypeRepository $projectTypeRepo,
        public ProjectStatusRepository $projectStatusRepo,
    ){}


    /**
     * Does the project exist in the applications storage
     * - Database Check
     *
     * @param string $uuid
     * @return bool
     * @throws RepositoryException
     */
    public function doesProjectIdentifiedByUuidAlreadyExist(string $uuid): bool
    {
        return $this->projectRepo->doesModelIdentifiedByUuidExistInTable($uuid);
    }


    /**
     * Retrieve all the project types
     *
     * @return AppServiceResponse
     */
    public function getAllProjectTypes(): AppServiceResponse
    {
        try {
            $output = serviceResponse(
                true,
                'Successfully retrieved all project types.',
                [
                    'models' => $this->projectTypeRepo->getAllModels(),
                ],
            );
        }
        catch (Exception $exception) {
            Log::debug("An attempt to retrieve all project types resulted in this exception message: {$exception->getMessage()}");

            $output = serviceResponse(
                false,
                'Could not retrieve all project types.'
            );
        }

        return $output;
    }


    /**
     * Retrieve all the project statuses
     *
     * @return AppServiceResponse
     */
    public function getAllProjectStatuses(): AppServiceResponse
    {
        try {
            $output = serviceResponse(
                true,
                'Successfully retrieved all project statuses.',
                [
                    'models' => $this->projectStatusRepo->getAllModels(),
                ],
            );
        }
        catch (Exception $exception) {
            Log::debug("An attempt to retrieve all project statuses resulted in this exception message: {$exception->getMessage()}.");

            $output = serviceResponse(
                false,
                'Could not retrieve all project statuses.',
            );
        }

        return $output;
    }


    /**
     * @param string $searchTerm
     * @param int $projectTypeId
     * @param int $projectStatusId
     * @param int $perPage
     * @param string $sortBy
     * @param string $sortDirection
     * @return LengthAwarePaginator|array|Project|Builder|\Illuminate\Pagination\LengthAwarePaginator|_IH_Project_C
     * @throws RepositoryException
     */
    public function getPaginatedProjectsForLivewireComponent(
        string $searchTerm='',
        int $projectTypeId=0,
        int $projectStatusId=0,
        int $perPage=5,
        string $sortBy='created_at',
        string $sortDirection='desc',
    ): LengthAwarePaginator|array|Project|Builder|\Illuminate\Pagination\LengthAwarePaginator|_IH_Project_C
    {
        return $this->projectRepo->getCustomPaginatedSearch(
            $searchTerm,
            $projectTypeId,
            $projectStatusId,
            $perPage,
            $sortBy,
            $sortDirection
        );
    }


    /**
     * Get a single project and its attributes
     *
     * @param string $uuid
     * @return AppServiceResponse
     */
    public function getProject(string $uuid): AppServiceResponse
    {
        try {
            $output = serviceResponse(
                true,
                'Successfully retrieved all projects.',
                [
                    'model' => $this->projectRepo->getModelByUuid($uuid),
                ],
            );
        }
        catch (Exception $exception) {
            Log::error("An attempt to retrieve a project resulted in this exception message: {$exception->getMessage()}");

            $output = serviceResponse(
                false,
                "Could not retrieve the project identified by uuid: $uuid.",
                [
                    'args' => [
                        'uuid' => $uuid
                    ],
                ],
            );
        }

        return $output;
    }


    /**
     * Get a collection of projects
     *
     * @return AppServiceResponse
     */
    public function getAllProjects(): AppServiceResponse
    {
        try {
            $output = serviceResponse(
                true,
                'Successfully retrieved all projects.',
                [
                    'models' => $this->projectRepo->getAllModels(),
                ],
            );
        }
        catch (Exception $exception) {
            Log::error("An attempt to retrieve all projects resulted in this exception message: {$exception->getMessage()}");

            $output = serviceResponse(
                false,
                'Could not retrieve all projects',
                [
                    'args' => [],
                ],
            );
        }

        return $output;
    }


    /**
     * Mark a project as (soft) deleted
     *
     * @param string $uuid
     * @return AppServiceResponse
     */
    public function markProjectDeleted(string $uuid): AppServiceResponse
    {
        try {
            $projectToBeDeleted = $this->projectRepo->getModelByUuid($uuid);
            $output = serviceResponse(
                $this->projectRepo->softDeleteByUuid($uuid),
                "Successfully marked the project identified by uuid: $uuid as deleted",
                [
                    'model' => $projectToBeDeleted,
                ],
            );
        }
        catch (Exception $exception) {
            Log::debug("An attempt to delete a project resulted in this exception message: {$exception->getMessage()}");

            $output = serviceResponse(
                false,
                'Could not delete the project identified by uuid: ' . $uuid,
                [
                    'arg' => $uuid,
                ],
            );
        }

        return $output;
    }


    /**
     * Create a new project
     *
     * @param string $name
     * @param int $typeId
     * @param int $statusId
     * @return AppServiceResponse
     */
    public function createProject(
        string $name,
        int $typeId,
        int $statusId,
    ): AppServiceResponse
    {
        try {
            $newProject = $this->projectRepo->createModel($name, $typeId, $statusId);
            $output = serviceResponse(
                true,
                "Successfully created a new project.",
                [
                    'model' => $newProject,
                ],
            );
        }
        catch (Exception $exception) {
            Log::debug("An attempt to create a project resulted in this exception message: {$exception->getMessage()}");

            $output = serviceResponse(
                false,
                'Could not create a new project',
                [
                    'args' => [
                        'name' => $name,
                        'typeId' => $typeId,
                        'statusId' => $statusId,
                    ],
                ],
            );
        }

        return $output;
    }


    /**
     * Update an existing project
     *
     * @param string $identifier
     * @param string $name
     * @param int $typeId
     * @param int $statusId
     * @return AppServiceResponse
     */
    public function updateProject(
        string $identifier,
        string $name,
        int $typeId,
        int $statusId,
    ): AppServiceResponse
    {
        try {
            $updatedModel = $this->projectRepo->updateModelByUuid(
                $identifier,
                $name,
                $typeId,
                $statusId,
            );
            $output = serviceResponse(
                true,
                "Successfully created a new project.",
                [
                    'model' => $updatedModel,
                ],
            );
        }
        catch (Exception $exception) {
            Log::debug("An attempt to update a project resulted in this exception message: {$exception->getMessage()}");

            $output = serviceResponse(
                false,
                'Could not update a project',
                [
                    'args' => [
                        'identifier' => $identifier,
                        'name' => $name,
                        'typeId' => $typeId,
                        'statusId' => $statusId,
                    ],
                ],
            );
        }

        return $output;
    }
}
