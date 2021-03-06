<?php

namespace App\Admin\Controllers;

use App\Models\Level;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class LevelController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('代理层级');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('代理层级');
            $content->description('修改');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('代理层级');
            $content->description('创建');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Level::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->title('名称');
            $grid->column('min', '最小额度(元)')->display(function () {
                return '￥' . number_format($this->min, 2);
            })->sortable();
            $grid->column('rebate', '返佣金额')->display(function ($rebate) {
                return $rebate . '%';
            })->sortable();
            $grid->created_at('创建日期');
            $grid->updated_at('修改日期');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Level::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('title', '层级名称')->rules('required|string');
            $form->currency('min', '最小额度')->symbol('￥')->rules('required|numeric');
            $form->rate('rebate', '返佣金额比例')->rules('required|numeric')->setWidth(2);
            $form->display('created_at', '创建日期');
            $form->display('updated_at', '修改日期');
        });
    }
}