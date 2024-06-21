<?php

namespace App\Services;

use App\Entities\AppServiceResponse;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\ProjectType;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use LaravelIdea\Helper\App\Models\_IH_Project_C;

class ProjectService
{
    public function projectExistsInTable(string $uuid): bool
    {
        return Project::whereUuid($uuid)->exists();
    }


    public function getAllProjectTypes(): AppServiceResponse
    {
        try {
            $output = serviceResponse(
                true,
                'Successfully retrieved all project types.',
                [
                    'model' => ProjectType::all(),
                ],
                422
            );
        }
        catch (Exception $exception) {
            Log::error("An attempt to retrieve all project types resulted in this exception message: {$exception->getMessage()}");

            $output = serviceResponse(
                FALSE,
                'Could not retrieve all project types.',
                [],
                422
            );
        }

        return $output;
    }

    public function getAllProjectStatuses(): AppServiceResponse
    {
        try {
            $output = serviceResponse(
                true,
                'Successfully retrieved all project statuses.',
                [
                    'model' => ProjectStatus::all(),
                ],
                422
            );
        }
        catch (Exception $exception) {
            Log::error("An attempt to retrieve all project statuses resulted in this exception message: {$exception->getMessage()}.");

            $output = serviceResponse(
                FALSE,
                'Could not retrieve all project statuses.',
                [],
                422
            );
        }

        return $output;
    }

    public function getPaginatedProjectsForLivewireComponent(
        string $searchTerm='',
        int $projectTypeId=0,
        int $projectStatusId=0,
        int $perPage=5,
        string $sortBy='created_at',
        string $sortDirection='desc',
    ): LengthAwarePaginator|array|Project|Builder|\Illuminate\Pagination\LengthAwarePaginator|_IH_Project_C
    {
        return Project::search($searchTerm)
            ->when($projectTypeId !== 0, function ($query) use($projectTypeId){
                $query->where('type_id', $projectTypeId);
            })
            ->when($projectStatusId !== 0, function ($query) use($projectStatusId){
                $query->where('status_id', $projectStatusId);
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    public function getProject(string $uuid): AppServiceResponse
    {
        try {
            $output = serviceResponse(
                true,
                'Successfully retrieved the project identified by uuid: ' . $uuid,
                [
                    'model' => Project::whereUuid($uuid)->firstOrFail(),
                ],
                422
            );
        }
        catch (Exception $exception) {
            Log::error("An attempt to retrieve a project resulted in this exception message: {$exception->getMessage()}");

            $output = serviceResponse(
                FALSE,
                'Could not retrieve the project identified by uuid: ' . $uuid,
                [
                    'args' => ['uuid' => $uuid],
                ],
                422
            );
        }

        return $output;
    }

    public function getAllProjects(): AppServiceResponse
    {
        try {
            $output = serviceResponse(
                true,
                'Successfully retrieved all projects.',
                [
                    'models' => Project::all(),
                ],
                422
            );
        }
        catch (Exception $exception) {
            Log::error("An attempt to retrieve all projects resulted in this exception message: {$exception->getMessage()}");

            $output = serviceResponse(
                FALSE,
                'Could not retrieve all projects',
                [
                    'args' => [],
                ],
                422
            );
        }

        return $output;
    }

    public function markProjectDeleted(string $uuid): AppServiceResponse
    {
        try {
            $projectToBeDeleted = Project::whereUuid($uuid)->firstOrFail();
            $output = serviceResponse(
                Project::whereUuid($uuid)->delete(),
                'Successfully deleted the project identified by uuid: ' . $uuid,
                [
                    'model' => $projectToBeDeleted,
                ],
                422
            );
        }
        catch (Exception $exception) {
            Log::error("An attempt to delete a project resulted in this exception message: {$exception->getMessage()}");

            $output = serviceResponse(
                FALSE,
                'Could not delete the project identified by uuid: ' . $uuid,
                [
                    'arg' => $uuid,
                ],
                422
            );
        }

        return $output;
    }

    public function createProject(array $formData): Project|false
    {
        try {
            $now = now();

            $newModel = new Project;
            $newModel->setName($formData['name']);
            $newModel->setTypeId($formData['type_id']);
            $newModel->setStatusId($formData['status_id']);
            $newModel->setCreatedAt($now);
            //$newModel->setUpdatedAt($now);
            $newModel->setDeletedAt(null);
            $newModel->save();

            return $newModel;
        }
        catch (Exception $exception) {
            Log::error($exception->getMessage() . ' ' . $exception->getTraceAsString());
            return false;
        }
    }
}
