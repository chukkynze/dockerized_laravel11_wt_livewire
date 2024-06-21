<?php

namespace App\Services;

use App\Entities\AppServiceResponse;
use App\Models\Task;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class TaskService
{
    public function taskExistsInTable(string $uuid): bool
    {
        return Task::whereUuid($uuid)->exists();
    }


    public function getPaginatedTasksForLivewireComponent(
        string $searchTerm='',
        int $perPage=5,
        string $sortBy='created_at',
        string $sortDirection='desc',
    ): LengthAwarePaginator|array|Task|Builder|\Illuminate\Pagination\LengthAwarePaginator
    {
        return Task::search($searchTerm)
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    public function getTask(string $uuid): AppServiceResponse
    {
        try {
            $output = serviceResponse(
                true,
                'Successfully retrieved the task identified by uuid: ' . $uuid,
                [
                    'model' => Task::whereUuid($uuid)->get(),
                ],
                422
            );
        }
        catch (Exception $exception) {
            Log::error("An attempt to retrieve a task resulted in this exception message: {$exception->getMessage()}");

            $output = serviceResponse(
                FALSE,
                'Could not retrieve the task identified by uuid: ' . $uuid,
                [
                    'args' => ['uuid' => $uuid],
                ],
                422
            );
        }

        return $output;
    }

    public function markTaskDeleted(string $uuid): AppServiceResponse
    {
        try {
            $taskToBeDeleted = Task::whereUuid($uuid)->firstOrFail();
            $output = serviceResponse(
                Task::whereUuid($uuid)->delete(),
                'Successfully deleted the task identified by uuid: ' . $uuid,
                [
                    'model' => $taskToBeDeleted,
                ],
                422
            );
        }
        catch (Exception $exception) {
            Log::error("An attempt to delete a task resulted in this exception message: {$exception->getMessage()}");

            $output = serviceResponse(
                FALSE,
                'Could not delete the task identified by uuid: ' . $uuid,
                [
                    'arg' => $uuid,
                ],
                422
            );
        }

        return $output;
    }

    public function createTask(array $formData): Task|false
    {
        try {
            $now = now();

            $newModel = new Task;
            $newModel->setName($formData['name']);
            $newModel->setPriority($formData['priority']);
            $newModel->setProjectId($formData['project_id']);
            $newModel->setStartDt(Carbon::parse($formData['start_dt'])->format('Y-m-d h:i:s'));
            $newModel->setDueByDt(Carbon::parse($formData['due_by_dt'])->format('Y-m-d h:i:s'));
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
