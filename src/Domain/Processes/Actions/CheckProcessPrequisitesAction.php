<?php

namespace Domain\Processes\Actions;

use Domain\Processes\Models\Process;
use Exception;
use Illuminate\Validation\ValidationException;

class CheckProcessPrequisitesAction
{
    /**
     * @throws Exception
     */
    public function execute(Process $process) // TODO use a DTO
    {
        if ($process->prerequisites->isEmpty()) {
            return $process;
        }

        $incomplete = $process->prerequisites->filter(function ($prerequisite) {
            return $prerequisite->completed_at === null;
        });

        if ($incomplete->isNotEmpty()) {
            throw ValidationException::withMessages([$incomplete]); // TODO make a custom exception

            return response()->json(['code' => ['PREREQUISITES_OUTSTANDING'], 'success' => false, 'message' => $exception->getMessage()], 400);
        }

        return $process;
    }
}
