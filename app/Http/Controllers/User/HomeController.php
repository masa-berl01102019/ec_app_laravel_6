<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index()
    {
        return view('user.index');
    }

    public function show()
    {
        $user = Auth::user();

        return view('user.show', ['user' => $user]);
    }

    public function edit()
    {
        $user = Auth::user();

        return view('user.edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {

        $form = $request->all();
        // リクエスト取得

        $form['birthday'] = implode('/',$request->birthday);
        // birthdayは配列で渡って来るのでdate型になるよう整形

        unset($form['_token']);
        // 不要なformのトークン削除しておく

        // validationクラスのインスタンスを作成して$formに渡してバリデーション
        $validator = Validator::make($form, [
            'user_last_name' => 'string|max:25|nullable',
            'user_first_name' => 'string|max:25|nullable',
            'user_last_name_kana' => 'string|max:25|nullable',
            'user_first_name_kana' => 'string|max:25|nullable',
            'gender' => 'numeric|min:0|max:3|nullable',
            'birthday' => 'date|nullable',
            'tel' => 'string|max:20|nullable',
            'post_code' => 'string|max:20|nullable',
            'prefecture' => 'string|max:50|nullable',
            'municipality' => 'string|max:50|nullable',
            'street_name' => 'string|max:50|nullable',
            'street_number' => 'string|max:50|nullable',
            'building' => 'string|max:50|nullable',
            'email' => [
                'required',
                'string',
                'email:rfc,dns,spoof',
                'max:50',
                Rule::unique('users')->ignore($id),
            ],
            'password' => 'required|string|min:8|max:20|password:user|',
            'new_password' => 'string|min:8|max:20|nullable',
        ]);
        // テーブルではnull許容でもバリデーションでデータ型を指定した場合は入力なしでnullが渡ってきた場合errorになるのでnullableをつける
        // min 以上　max 以下
        // Ruleクラスを使って$idのユーザーの以外のユーザーのemailアドレスに対してユニークをかけている
        // emailのバリデーション　参考サイト: https://blog.capilano-fw.com/?p=4475


        // パスワードに関してはバリデーションの項目を後で見直す必要あり


        if ($validator->fails()) { // バリデーションエラー以降の処理

            return redirect(route('user.edit'))
                ->withErrors($validator)
                ->withInput();

        } else { // バリデーション通った後の処理

            if(isset($form['new_password'])) {
                $form['password'] = Hash::make($request->new_password);
                // 新しいパスワードをハッシュ化して格納する
            } else {
                $form['password'] = Hash::make($request->password);
                // 古いパスワードをハッシュ化して格納する
            }

            $user = User::find($id);

            $user->fill($form)->save();
            // $userのカラム名と$formの対応するカラム名のみfill()でデータを差し替えてsave()で保存
            // modelの$fillableで定義したカラム名に対応しないカラム名が$form内に含まれていても値は無視され正常に処理を終える

            return redirect(route('user.profile'));
        }
    }

    public function close()
    {
        $user = Auth::user();

        return view('user.close', ['user' => $user]);
    }

    public function destroy(Request $request, $id)
    {
        $validatedData = $request->validate([
            'delete_flg' => 'numeric|min:0|max:1'
        ]);

        $user = User::find($id);

        $user->fill($validatedData)->save();

        Auth::logout();

        return redirect(route('home'));

    }
}
