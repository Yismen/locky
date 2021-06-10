# Dainsys Locky  
A laravel UI wrapper for spatie/laravel-permission with Bootstrap 4!
## Installation
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
* If you havent published the `laravel/ui` scafold, do so by running the `php artisan ui:auth`.
* Views:
- The package ships with it's own views, therefore you MUST publish the package public assets by running `php artisan vendor:publish --tag=locky-public`. However, this is not necessary if you are planning to use your views. In this case you can run `php artisan vendor:publish --tag=locky-views` and make them extends your own layout view. 
* Migrations:
- By default the packages migrations will run if you execute the `php artisan migrate` command. However, you can set the `with_migrations` option to false and handle the migrations yourselve. To do this, first run the `php artisan vendor:publish --tag=locky-config` command.
- Add the following liks to the auth portion of your `layouts.app` links:
````javascript 
@include('locky::_nav-links')
````
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
- Please read Larave Authorization's documentations at https://laravel.com/docs/7.x/authorization
- This package add the concept of actives or inactive users by adding query scopes. Just use the scope `actives()` or `inactives()` to filter as desired. 
- You can activate an user by calling the `activate()` method on a Eloquent User record; use `inactivate()` to inactivate an user.
### Dependencies
* Dainsys Components: https://packagist.org/packages/dainsys/components
* Laravel Ui: https://laravel.com/docs/7.x/authorization
* Spatie Permission: https://docs.spatie.be/laravel-permission/v3/introduction/

 
