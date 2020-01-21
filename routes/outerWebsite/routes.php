<?php
/*
|--------------------------------------------------------------------------
| outerWebsiteWebsite Routes
|--------------------------------------------------------------------------
*/


//home page
Route::view('/', 'outerWebsite.pages.index.index');

Route::get('/home', function(){
    return redirect('/');
})->where('any', '.*');

Route::get('/home{any}', function(){
    return redirect('/');
})->where('any', '.*');

Route::get('/index{any}', function(){
    return redirect('/');
})->where('any', '.*');



//services page
Route::view('/services', 'outerWebsite.pages.services.index');

Route::get('/service{any}', function(){
    return redirect('/services');
})->where('any', '.*');



//developers page
Route::view('/developers', 'outerWebsite.pages.developers.index');

Route::get('/developer{any}', function(){
    return redirect('/developers');
})->where('any', '.*');



//partners page
Route::view('/partners', 'outerWebsite.pages.partners.index');

Route::get('/partner{any}', function(){
    return redirect('/partners');
})->where('any', '.*');



//fees page
Route::view('/fees', 'outerWebsite.pages.fees.index');

Route::get('/fee{any}', function(){
    return redirect('/about');
})->where('any', '.*');



//help page
Route::view('/help', 'outerWebsite.pages.help.index');

Route::get('/help{any}', function(){
    return redirect('/help');
})->where('any', '.*');



//about page
Route::view('/about', 'outerWebsite.pages.about.index');

Route::get('/about{any}', function(){
    return redirect('/about');
})->where('any', '.*');



//contact page
Route::view('/contact', 'outerWebsite.pages.contact.index');

Route::get('/contact{any}', function(){
    return redirect('/contact');
})->where('any', '.*');

//contact store message
Route::post('/contact','WEB\outerWebsite\ContactUsouterController@store');



//forum page
Route::view('/forum', 'outerWebsite.pages.forum.index');

Route::get('/forum{any}', function(){
    return redirect('/forum');
})->where('any', '.*');
    


//documentation for api page
Route::view('/docs', 'outerWebsite.pages.api.documentation.index');

Route::get('/docs{any}', function(){
    return redirect('/docs');
})->where('any', '.*');



//Documentation for api page
Route::view('/docs', 'outerWebsite.pages.api.index');
Route::get('/docs{any}', function(){
    return redirect('/docs');
})->where('any', '.*');



//people-review page
Route::view('/people-review', 'outerWebsite.pages.people-review.index');

Route::get('/people{any}', function(){
    return redirect('/people-review');
})->where('any', '.*');



//security page
Route::view('/security', 'outerWebsite.pages.security.index');

Route::get('/security{any}', function(){
    return redirect('/security');
})->where('any', '.*');



//terms page
Route::view('/terms', 'outerWebsite.pages.terms.index');

Route::get('/term{any}', function(){
    return redirect('/terms');
})->where('any', '.*');



//privacy page
Route::view('/privacy', 'outerWebsite.pages.privacy.index');

Route::get('/privacy{any}', function(){
    return redirect('/privacy');
})->where('any', '.*');



//subscribe Post
Route::post('/subscribe', 'WEB\outerWebsite\SubscriberController@store');


/*
|--------------------------------------------------------------------------
| End of outerWebsiteWebsite Routes
|--------------------------------------------------------------------------
*/