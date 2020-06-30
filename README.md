# Dainsys Locky  
A wrapper for Spatie/Laravel-Permission: 
## Installation
* Add the following key to the `composer.json` file in your app's root:
````javascript
"repositories": [
    {
        "type": "git",
        "url": "https://github.com/Yismen/locky.git"
    }
]
````
* Install with `composer` by runining the command `composer require dainsys/locky`
* Add the `Dainsys\Locky\WithLockyAcl;` to your `User` model(s);
```javascript
use Illuminate\Foundation\Auth\User as Authenticatable;
use Dainsys\Locky\WithLockyAcl;

class User extends Authenticatable
{
    use WithLockyAcl;
}
```
* Set you `LOCKY_SUPER_USER_EMAIL=super.user@email-example.com` in the .env file.
* Views:
- The package ships with it's own views, therefore you MUST publish the package public assets by running `php artisan vendor:publish --tag=locky-public`. However, this is not necessary if you are planning to use your views. In this case you can run `php artisan vendor:publish --tag=locky-views` and make them extends your own layout view. 
* Migrations:
- By default the packages migrations will run if you execute the `php artisan migrate` command. However, you can set the `with_migrations` option to false and handle the migrations yourselve. To do this, first run the `php artisan vendor:publish --tag=locky-config` command.
- You could also publish the package migrations by running `php artisan vendor:publish --tag=locky-migrations` and tweak them to suit your needs.
## Usage
* After installing this package, you can limit user access by creating Laravel Policies with `php artisan make:policy` command and add the checks `return $user->hasAnyRole(["role1", "role2"])` or `return $user->hasAnyPermission(["permission1", "permission2"])` and by updating the Controller's constructor method:
```javascript
use App\YourModel;

class MyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(YourModel::class, 'model');
    }
}
```
 