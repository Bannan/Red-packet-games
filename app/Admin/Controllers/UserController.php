<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class UserController extends Controller
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

            $content->header('会员');
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

            $content->header('会员');
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

            $content->header('会员');
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
        return Admin::grid(User::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->mobile('手机号')->sortable();
            $grid->nickname('昵称');
            $grid->column('balance', '余额(元)')->display(function () {
                return '￥' . number_format($this->balance, 2);
            })->sortable();
            $grid->openid('微信openid')->sortable();
            $grid->parent_id('推荐人ID')->sortable();
            $grid->robot('机器人')->sortable();
            $grid->column('level', '等级');

            $grid->created_at('修改日期');
            $grid->updated_at('注册日期');

            $grid->filter(function ($filter) {
                $filter->like('openid', '微信openid');
                $filter->like('mobile', '手机号');
                $filter->between('created_at', '注册日期')->datetime();
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
        return Admin::form(User::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('openid', '微信openid');
            $form->select('parent_id', '推荐人')->options(function ($id) {
                if ($user = User::find($id)) {
                    return [$user->id => $user->nickname];
                }
            })->ajax('/admin/api/users');
            $form->switch('robot', '机器人')->states([
                'on' => ['value' => 1, 'text' => '打开', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
            ]);
            $form->currency('balance', '余额')->symbol('￥')->rules('required|numeric');
            $form->display('created_at', '注册日期');
            $form->display('updated_at', '修改日期');
        });
    }

    public function users(Request $request)
    {
        $q = $request->get('q');
        return User::where('nickname', 'like', "%$q%")->paginate(null, ['id', 'nickname as text']);
    }
}
