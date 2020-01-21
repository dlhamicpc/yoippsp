<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('honeyPot', function () {
            $inputEmail = '<input type="email" name="new_email" style="display:none" placeholder="email@email.com">';
            return "<?php echo '$inputEmail'?>";
        });

        Blade::directive('appName', function () {
            return "<?php echo config('app.name', 'Yoippsp');?>";
        });
        
        /* Validator::extend('check_three', function($attribute,$value, $parameters){
            //dd($value);
            return $value == 'a@a';
        }); */

        //Custom Validators
        $validatorPath = '\App\YoippspFunctions\Validators\CustomValidation@';

        Validator::extend('name', $validatorPath.'name');
        //Validator::extend('city', $validatorPath.'city');
        //::extend('state', $validatorPath.'state');
        //::extend('country', $validatorPath.'country');
        Validator::extend('gender', $validatorPath.'gender');
        Validator::extend('mobile_number', $validatorPath.'mobile_number');
        
           
    }

}
