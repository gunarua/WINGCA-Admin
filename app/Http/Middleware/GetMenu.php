<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\Menu;
use App\Models\Role;

class GetMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            // 获取当前可以操作的栏目id
            $access_menus_id = Role::find(Auth::user()->role->role_id) ? Role::find(Auth::user()->role->role_id)->access_menus_id : "";
            // 查找所有一级栏目
            $parent_menus = Menu::whereRaw("FIND_IN_SET(id,?) AND menu_lv = 1",[$access_menus_id])->get();
            foreach( $parent_menus as $k => $v ){
                $v->child_menus = Menu::whereRaw("FIND_IN_SET(id,?) AND parent_id = ?",[$access_menus_id,$v->id])->get();
                foreach($v->child_menus as $key => $value){
                    $value->son_menus = Menu::whereRaw("parent_id = ?",[$value->id])->get();  
                }
            }
            session()->put('menus',$parent_menus);
        }
        return $next($request);
    }
}
