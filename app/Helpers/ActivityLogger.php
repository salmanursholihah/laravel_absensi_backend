<?php
namespace App\Helpers;

use App\Models\ActivityLogs
;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
public static function log($action, $model = null, $description = null)
{
ActivityLogs::create([
'user_id' => Auth::id(),
'action' => $action,
'model_type' => $model ? \\get_class($model) : null,
'model_id' => $model->id ?? null,
'description' => $description
]);
}
}