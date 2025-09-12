<?php










if (! function_exists('resolve_model')) {
//todo هر بار ماژول میسازی تستش کن
    function resolve_model(string $model): string
    {
        $map = config('modelmap');

        if (array_key_exists($model, $map)) {
            return "Modules\\{$map[$model]}\\App\\Models\\{$model}";
        }

        return "App\\Models\\{$model}";
    }
}
