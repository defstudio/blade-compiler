<?php

use App\Models\User;
use DefStudio\BladeCompiler\Helpers\BladeCompiler;
use Illuminate\Http\RedirectResponse;


if (!function_exists('blade')) {
    function blade(): BladeCompiler
    {
        return app(BladeCompiler::class);
    }
}
