<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace DefStudio\BladeCompiler\Helpers;

use Exception;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Throwable;

class BladeCompiler
{
    public function render(string $content, array $data = []): string
    {
        if (View::exists($content)) {
            return View::make($content, $data)->render();
        }

        $php = Blade::compileString($content);

        $obLevel = ob_get_level();
        ob_start();
        extract($data, EXTR_SKIP);

        try {
            eval('?'.'>'.$php);
        } catch (Exception $e) {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }
            throw $e;
        } catch (Throwable $e) {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }
            throw new Exception($e);
        }

        $html = ob_get_clean();

        if (!$html) {
            $html = '';
        }

        return $html;
    }
}
