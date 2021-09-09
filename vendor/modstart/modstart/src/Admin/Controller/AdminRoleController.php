<?php


namespace ModStart\Admin\Controller;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use ModStart\Admin\Auth\AdminPermission;
use ModStart\Admin\Concern\HasAdminCRUD;
use ModStart\Admin\Model\AdminRole;
use ModStart\Admin\Model\AdminRoleRule;
use ModStart\Admin\Model\AdminUser;
use ModStart\Core\Dao\ModelUtil;
use ModStart\Core\Util\ArrayUtil;
use ModStart\Core\Util\ConvertUtil;
use ModStart\Core\Util\CRUDUtil;
use ModStart\Detail\Detail;
use ModStart\Field\AbstractField;
use ModStart\Field\Tree;
use ModStart\Form\Form;
use ModStart\Form\Type\FormMode;
use ModStart\Show\Show;
use ModStart\Grid\Grid;
use ModStart\Grid\GridFilter;

class AdminRoleController extends Controller
{
    use HasAdminCRUD;

    protected function grid()
    {
        $grid = new Grid(AdminRole::class, function (Grid $grid) {
            $grid->display('id', L('ID'))->sortable(true)->width(80);
            $grid->text('name', L('Role Name'))->width(200);
            $grid->tree('rules', L('Role Permission'))
                ->columnNameId('rule')->spread(false)
                ->tree(AdminPermission::menuAll())
                ->hookValueUnserialize(function ($value, AbstractField $field) {
                    return $value->pluck('rule');
                });
            $grid->gridFilter(function (GridFilter $filter) {
                $filter->eq('id', L('ID'));
                $filter->like('name', L('Name'));
            });
        });
        if (AdminPermission::isNotPermit('AdminRoleManage')) {
            $grid->canAdd(false)->canEdit(false)->canDelete(false);
        }
        $grid->title(L('Admin Role'));
        return $grid;
    }

    protected function form()
    {
        $form = new Form(AdminRole::class, function (Form $form) {
            $form->display('id', L('ID'))->editable(true);
            $form->text('name', L('Role Name'))->rules('required|unique:admin_role,name,' . CRUDUtil::id());
            $form->tree('rules', L('Role Permission'))->rules('required')
                ->columnNameId('rule')->tree(AdminPermission::menuAll())
                ->hookValueUnserialize(function ($value, AbstractField $field) {
                    return collect($value)->pluck('rule');
                })
                ->hookValueSerialize(function ($value, AbstractField $field) {
                    return collect(json_decode($value, true))->map(function ($item) {
                        return ['rule' => $item];
                    });
                });
            $form->display('created_at', L('Created At'));
            $form->display('updated_at', L('Updated At'));
            $form->hookSaving(function (Form $form) {
                if (FormMode::EDIT == $form->mode()) {
                    $datSubmitted = $form->dataSubmitted();
                    $newRules = ConvertUtil::toArray($datSubmitted['rules']);
                    
                    $oldRules = collect($form->item()->rules)->map(function ($o) {
                        return $o['rule'];
                    })->toArray();
                    list($inserts, $deletes) = ArrayUtil::diff($oldRules, $newRules);
                                        $inserts = collect($inserts)->map(function ($r) {
                        return ['rule' => $r];
                    });
                    $form->dataEditing(array_merge($form->dataEditing(), ['rules' => $inserts]));
                    if (!empty($deletes)) {
                        AdminRoleRule::where(['roleId' => $form->itemId()])->whereIn('rule', $deletes)->delete();
                    }
                    $userIds = $form->item()->users->pluck('id')->toArray();
                    if (!empty($userIds)) {
                        AdminUser::whereIn('id', $userIds)->update(['ruleChanged' => true]);
                    }
                }
            });
        });
        if (AdminPermission::isNotPermit('AdminRoleManage')) {
            $form->canAdd(false)->canEdit(false)->canDelete(false);
        }
        $form->title(L('Admin Role'));
        return $form;
    }

    protected function detail()
    {
        $detail = new Detail(AdminRole::class, function (Detail $detail) {
            $detail->display('id', L('ID'));
            $detail->text('name', L('Role Name'));
            $detail->tree('rules', L('Role Permission'))->columnNameId('rule')->tree(AdminPermission::menuAll())
                ->hookValueUnserialize(function ($value, AbstractField $field) {
                    return $value->map(function ($r) {
                        return $r['rule'];
                    })->toArray();
                });
            $detail->display('created_at', L('Created At'));
            $detail->display('updated_at', L('Updated At'));
        });
        $detail->title(L('Admin Role'));
        return $detail;
    }
}
