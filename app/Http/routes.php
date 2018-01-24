<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Illuminate\Http\Request;

/**
 * 前台路由
 */
# 登陆会话 (User)
Route::get('login', 'SessionController@login')->name('login');
Route::post('login', 'SessionController@login_store')->name('login');
Route::get('logout', 'SessionController@logout')->name('logout');
# 注册(User)
Route::get('register', 'SessionController@register')->name('register');
Route::post('register', 'SessionController@register_store')->name('register');


/**
 * 后台路由
 */

# 后台根路径
Route::get('/admin',['middleware'=>'CheckAdminSignIn',function (Request $request) {
    $key_data = collect([
        'menus' => $request->menus,
        'active' => "home"
    ]);
    return view('index/index',compact('key_data'));
}])->name('admin');

# 其他 后台路由
Route::group(['prefix' => 'admin'],function(){
    # 后台登录(App/User)
    Route::get('login','AdminSessionController@login')->name('admin.login');
    Route::post('login','AdminSessionController@login_store')->name('admin.login');
    Route::get('register','AdminSessionController@register')->name('admin.register');
    Route::post('register','AdminSessionController@register_store')->name('admin.register');
    Route::get('logout','AdminSessionController@logout')->name('admin.logout');

    # 用户管理路由(App/User)
    Route::group(['middleware'=>'CheckAdminSignIn','prefix'=>'users'],function(){
        Route::get('/','UsersController@index');
    });

    # 菜单管理路由(App/Models/Menu)
    Route::group(['middleware'=>'CheckAdminSignIn','prefix'=>'menus'],function(){
        Route::get('/','MenusController@index')->name('menus.index');
        Route::post('store','MenusController@store')->name('menus.store');
        Route::post('update','MenusController@update')->name('menus.update');
        Route::post('destroy','MenusController@destroy')->name('menus.destroy');
        // 菜单信息 ajax 请求接口
        Route::post('menu_info','MenusController@menu_info')->name('menus.info');
    });
});




