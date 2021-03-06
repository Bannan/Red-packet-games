<?php

namespace App\Admin\Controllers;

use App\Models\Game;
use App\Models\Screening;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ScreeningController extends Controller
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

            $content->header('游戏大厅');
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

            $content->header('游戏大厅');
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

            $content->header('游戏大厅');
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
        return Admin::grid(Screening::class, function (Grid $grid) {
            $grid->model()->with('game');

            $grid->id('ID')->sortable();
            $grid->column('game.title', '所属游戏')->sortable();
            $grid->thumb('缩略图')->image();
            $grid->title('游戏大厅');
            $grid->num('每组人数');

            $grid->created_at('创建日期');
            $grid->updated_at('修改日期');

            $grid->filter(function ($filter) {
                $filter->equal('game_id', '所属游戏')->select(Game::pluck('title', 'id'));
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Screening::class, function (Form $form) {

            $form->tab('大厅信息', function (Form $form) {
                $form->display('id', 'ID');
                $form->image('thumb', '缩略图')->rules('required');
                $form->select('game_id', '所属游戏')->options(Game::pluck('title', 'id'))->rules('required');
                $form->text('title', '大厅名称')->rules('required|string');
                $form->number('num', '每组人数')->rules('required|numeric');

                $form->display('created_at', '创建日期');
                $form->display('updated_at', '修改日期');
            })->tab('红包配置', function (Form $form) {
                $form->hasMany('red_prices', '红包玩法', function (Form\NestedForm $form) {
                    $form->image('thumb', '缩略图');
                    $form->text('title', '名称')->rules('required|string');
                    $form->currency('value', '红包金额')->symbol('￥')->rules('required|numeric');
                    $form->currency('min', '可抢最小金额')->symbol('￥')->rules('required|numeric');
                    $form->currency('max', '可抢最大金额')->symbol('￥')->rules('required|numeric');
                    $form->rate('service_fee', '服务费比例')->rules('required|numeric')->setWidth(1);
                });
            });
        });
    }
}
