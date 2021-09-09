<?php


namespace ModStart\Core\Util;


use Illuminate\Support\Facades\Route;
use ModStart\Core\Input\InputPackage;
use ModStart\Grid\Grid;
use ModStart\Grid\Type\GridEngine;
use ModStart\View\Constants;

class CRUDUtil
{
    public static function id()
    {
        $input = InputPackage::buildFromInput();
        $id = $input->getInteger('_id');
        if (!$id) {
            $id = $input->getInteger('id');
        }
        return $id;
    }

    public static function ids()
    {
        $input = InputPackage::buildFromInput();
        $id = $input->getTrimString('_id');
        if (!$id) {
            $id = $input->getTrimString('id');
        }
        $ids = [];
        foreach (explode(',', $id) as $i) {
            $ids[] = intval($i);
        }
        return $ids;
    }

    public static function registerRouteResource($prefix, $class)
    {
        Route::match(['get', 'post'], "$prefix", "$class@index");
        Route::match(['get', 'post'], "$prefix/add", "$class@add");
        Route::match(['get', 'post'], "$prefix/edit", "$class@edit");
        Route::match(['get', 'post'], "$prefix/delete", "$class@delete");
        Route::match(['get', 'post'], "$prefix/show", "$class@show");
        Route::match(['get', 'post'], "$prefix/sort", "$class@sort");
    }

    public static function registerGridResource(Grid $grid, $class)
    {
        if ($grid->canAdd() && ($url = action($class . '@add'))) {
            switch ($grid->engine()) {
                case GridEngine::TREE_MASS:
                    $input = InputPackage::buildFromInput();
                    $pid = $input->get('_pid', $grid->treeRootPid());
                    $grid->urlAdd($url . '?' . http_build_query(['_pid' => $pid]));
                    break;
                default:
                    $grid->urlAdd($url);
                    break;
            }
        }
        if ($grid->canEdit() && ($url = action($class . '@edit'))) {
            $grid->urlEdit($url);
        }
        if ($grid->canDelete() && ($url = action($class . '@delete'))) {
            $grid->urlDelete($url);
        }
        if ($grid->canShow() && ($url = action($class . '@show'))) {
            $grid->urlShow($url);
        }
        if ($grid->canSort() && ($url = action($class . '@sort'))) {
            $grid->urlSort($url);
        }
    }

    public static function jsGridRefresh($index = 0)
    {
        return "[js]window.__grids.get($index).lister.refresh();";
    }

    public static function jsDialogCloseAndParentGridRefresh($index = 0)
    {
        return "[js]parent.__grids.get($index).lister.refresh();__dialogClose();";
    }

    public static function jsDialogClose()
    {
        return "[js]__dialogClose();";
    }

    public static function jsDialogCloseAndParentRefresh()
    {
        return "[js]parent.location.reload();";
    }
}
