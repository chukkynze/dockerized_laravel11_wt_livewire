<?php

namespace App\ModelRepository;

use App\Exceptions\RepositoryException;
use App\Models\ProjectStatus;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use LaravelIdea\Helper\App\Models\_IH_ProjectType_C;

class ProjectStatusRepository
{
    /**
     * @throws RepositoryException
     */
    public function getAllModels(): _IH_ProjectType_C|Collection|array
    {
        try {
            return ProjectStatus::all();
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
}
