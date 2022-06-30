# <center>Horseloft API Framework</center>

A simple php API framework

# 版本说明
1. 版本号第一位数字为大版本号，版本变更不向下兼容，用于整体功能升级和框架结构升级
2. 版本号第二位数字为中版本号，版本变更向下兼容，用于新增功能
3. 版本号第三位数字为小版本号，版本变更向下兼容，用于BUG修复
4. v1.x.x依赖PHP需>=7.1
5. v2.x.x依赖PHP需>=8.1

# 基础功能说明

## 目录结构
> Application   项目代码主目录
>
> > Controllers	    控制器目录，路由指向的代码目录
> >
> > Interceptor	    拦截器目录，路由可选参数 interceptor 代码目录
> >
> > Models		    模型目录，数据库模型代码目录（非必要目录）
> >
> > Runtime		    异常处理目录，用于异常捕获的处理
>
> Config	框架配置文件目录
>
> Core		框架基础加载目录
>
> Log		框架默认日志目录
>
> Public    框架项目入口目录
>
> Route		框架路由文件目录

## 项目安装
1. 重命名 env.ini.example 为 env.ini

   ```shell
   mv env.ini.example env.ini
   ```

2. 安装项目依赖

   ```shell
   composer install
   ```

## 路由
1. 目录**Route**中的文件将被自动加载

2. 路由仅支持**GET**和**POST**请求

3. 路由指向的类方法必须是**静态方法**

4. 支持三种路由声明方式

   ```php
   use Horseloft\Phalanx\Builder\Route;
   
   // 1 路由组
   Route::group([], function () {
   		// 2 POST请求路由
       Route::post('index', 'IndexController::index');
   });
   // 3 GET请求路由
   Route::get('/', 'IndexController::index');
   ```

5. 配置路由命名空间（路由基础命名空间 **Application\Controllers**）

   ```php
   // 路由指向 Application\Controllers\Home\IndexController 下的index方法
   Route::group(['namespace' => 'Home'], function () {
       Route::post('index', 'IndexController::index');
   });
   
   // 路由指向 Application\Controllers\Home\IndexController 下的index方法
   Route::get('index', 'IndexController::index', 'Home');
   ```

6. 配置路由拦截器

   ```php
   // 拦截器名称default，对应目录(Application/Interceptor)下的DefaultInterceptor.php
   Route::group(['interceptor' => ['default']], function () {
       Route::post('index', 'IndexController::index');
   });
   
   // 拦截器名称default，对应目录Interceptor下的DefaultInterceptor.php
   Route::get('index', 'IndexController::index', null, 'default');
   ```

7. 配置路由前缀（仅路由组支持）

   ```php
   // 完整路由为：home/index
   Route::group(['prefix' => 'home'], function () {
       Route::post('index', 'IndexController::index');
   });
   ```

## 路由拦截器（Interceptor）
1. 仅当拦截器返回值**强等于true**时，允许请求通过拦截器；其他格式的返回值将作为本次请求的返回值

2. 配置路由拦截器

   ```php
   // 拦截器名称default，对应目录Interceptor下的DefaultInterceptor.php
   Route::group(['interceptor' => ['default']], function () {
       Route::post('index', 'IndexController::index');
   });
   
   // 拦截器名称default，对应目录Interceptor下的DefaultInterceptor.php
   Route::get('index', 'IndexController::index', null, 'default');
   ```

3. 编写路由拦截器

   ```php
   namespace Application\Interceptor;
   
   use Horseloft\Phalanx\Builder\Request;
   
   class DefaultInterceptor
   {
       public static function handle(Request $request)
       {
           /*
            * 编写拦截器逻辑代码
            */ 
   
           return true;
       }
   }
   ```

## 异常处理

### 默认异常捕捉

1. 项目中的异常默认由 **Application\Runtime\Runtime::handle()** 处理

2. **handle()**方法中的返回值将作为本次请求的返回值

3. **handle()**方法必须有两个参数**Request**和**Throwable**，且参数顺序固定位**示例**中的位置

4. 示例：

   ```php
   namespace Application\Runtime;
   
   use Horseloft\Phalanx\Builder\Request;
   use Throwable;
   
   class Exception
   {
       public static function handle(Request $request, Throwable $e)
       {
           return "Default Exception: " . $e->getMessage() . " " . json_encode($request->all());
       }
   }
   ```

### 自定义异常处理
1. 在目录中编写异常捕捉类，类名称必须与异常名称一致

2. 自定义异常捕捉类，格式和功能与**默认异常捕捉类**一致

3. 示例：

   ```php
   // HorseloftException
   namespace Application\Runtime;
   
   use Horseloft\Phalanx\Builder\Request;
   use Throwable;
   
   class HorseloftException
   {
       public static function handle(Request $request, Throwable $e)
       {
           return "Default Exception: " . $e->getMessage() . " " . json_encode($request->all());
       }
   }
   ```

## 配置文件
1. 配置文件位于Config目录
2. 配置文件返回值格式**必须**为数组
3. 文件名称将作为配置信息的下标使用
4. 使用**config()**方法获取配置项的值（注意：在配置文件中使用config()方法可能无法正常获取返回值）
5. 示例：database.php，文件内容如下

   ```php
   return [
       'default' => 'mysql',
       'connections' => [
           'mysql' => [
               'host' => 'localhost',
               'port' => 3306,
               'database' => 'horseloft',
               'username' => 'root',
               'password' => '123456',
               'driver' => 'mysql'
           ],
       ]
   ];
   ```

   1. 获取全部返回值

      ```php
      config('database'); // 返回值：数组格式的全部内容
      ```

   2. 获取配置文件中指定信息

      ```php
      config('databases.default'); // 返回值：'mysql'
      
      config('databases.connections.mysql'); // 返回值如下：
      array(
        'host' => 'localhost',
        'port' => 3306,
        'database' => 'horseloft',
        'username' => 'root',
        'password' => '123456',
        'driver' => 'mysql'
      );
      
      config('databases.connections.mysql.host'); // 返回值：'localhost'
      ```

## 辅助函数
**辅助函数参考文件：Core/functions.php**
1. env()
2. config()
3. root_path()
4. log_path()
5. config_path()
6. route()
7. method()
8. action()
9. interceptor()
10. cookie()
11. session()
12. headers()

## 数据库
1. 使用**horseloft\plodder**作为框架的数据库工具
2. 参考文档：

