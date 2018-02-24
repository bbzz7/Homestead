<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index','test']
        ]);
    }

    //
    public function index(User $user) {
        $users=$user->paginate(10);
        return view('users.index', compact('users'));
    }

    //
    public function create() {
        return view('users.create');
    }

    //
    public function show(User $user) {
        return view('users.show', compact('user'));
    }

    //
    public function store(Request $request) {
        $this->validate($request, [
            'name'     => 'required|max:50',
            'email'    => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }

    //
    public function edit(User $user) {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    //
    public function update(User $user, Request $request) {
        $this->validate($request, [
            'name'     => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');
        return redirect()->route('users.show', $user->id);
    }

    public function test(){
        //虚拟数据
        $data = [
            ['cat_id' => '1', 'cat_name' => '手机类型', 'parent_id' => '0', 'path' => '0-1'],
            ['cat_id' => '26', 'cat_name' => '家用电器', 'parent_id' => '0', 'path' => '0-26'],
            ['cat_id' => '3', 'cat_name' => '小型手机', 'parent_id' => '1', 'path' => '1-3'],
            ['cat_id' => '4', 'cat_name' => '3G手机', 'parent_id' => '1', 'path' => '1-4'],
            ['cat_id' => '6', 'cat_name' => '手机', 'parent_id' => '0', 'path' => '0-6'],
            ['cat_id' => '29', 'cat_name' => '家用空调', 'parent_id' => '27', 'path' => '27-29'],
            ['cat_id' => '8', 'cat_name' => '耳机', 'parent_id' => '6', 'path' => '6-8'],
            ['cat_id' => '9', 'cat_name' => '电池', 'parent_id' => '6', 'path' => '6-9'],
            ['cat_id' => '27', 'cat_name' => '大家电', 'parent_id' => '26', 'path' => '26-27'],
            ['cat_id' => '12', 'cat_name' => '充值卡', 'parent_id' => '0', 'path' => '0-12'],
            ['cat_id' => '28', 'cat_name ' => '平板电脑', 'parent_id' => '27', 'path' => '27-28'],
            ['cat_id' => '16', 'cat_name' => '服装', 'parent_id' => '0', 'path' => '0-16'],
            ['cat_id' => '30', 'cat_name' => '家电配件', 'parent_id' => '27', 'path' => '27-30'],
        ];
        // dd($this->subMenu('0',$data));
        return $this->subMenu('0',$data);
    }

    public function subMenu($parentID, $dataArr) {
        //sub
        $subMenu = [];
        for ($i = 0; $i < count($dataArr); $i++) {
            if ($dataArr[$i]['parent_id'] == $parentID) {
                array_push($subMenu, $dataArr[$i]);
            }
        }
        //递归
        for ($j = 0; $j < count($subMenu); $j++) {
            $subMenu[$j]['subMenu']=$this->subMenu($subMenu[$j]['cat_id'],$dataArr);
        }
        return $subMenu;
    }
}
