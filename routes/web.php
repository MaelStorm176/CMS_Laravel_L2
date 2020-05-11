<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('make-migration',
    function () {
        /* */
        Schema::dropIfExists('craft_pizza');

        Artisan::call('migrate:rollback',[
            '--path'=>'\database\migrations\craft\2020_04_17_180915_pizza_craft.php',
            '--step'=>'1'
        ]);

        Artisan::call('migrate',[
            '--path'=>'\database\migrations\craft\2020_04_17_180915_pizza_craft.php',
            '--step'=>'1'
        ]);


        return back();
    })->name('make-migration');

Route::get('commentaire', 'Commentaire@index')->name('home');
Route::get('ajout_commentaire', 'Commentaire@ajout')->name('ajout_commentaire');
Route::get('clear_db', 'Commentaire@clear_db')->name('clear_db');
Route::get('afficher_comm', 'Commentaire@afficher')->name('afficher_comm');


/*PIZZA */
Route::post('pizza.upload','Pizza@upload')->name('pizza.upload');
Route::post('pizza.modifier','Pizza@modifier')->name('pizza.modifier');
Route::get('pizza_all', 'Pizza@all')->name('pizza_all');
Route::get('afficher_form','Pizza@afficher_form')->name('afficher_form');
Route::get('pizza.supprimer','Pizza@supprimer')->name('pizza.supprimer');
Route::get('pizza_all/{pizza_nom}','Pizza@detail');
Route::get('pizza_all/{pizza_nom}/remplissage_tab','Pizza@nutrition');
Route::post('pizza.promotion','Pizza@promotion')->name('promotion');
Route::post('code.upload','CodeController@upload')->name('code.upload');
Route::post('categorie.upload','Pizza@categorie_upload')->name('categorie.upload');




/*PANIER*/
Route::get('panier','Panier@afficher')->name('panier');
Route::get('panier.creer','Panier@creer')->name('panier.creer');
Route::get('panier.ajouter','Panier@ajouter')->name('panier.ajouter');
Route::get('panier.modifier','Panier@modifier')->name('panier.modifier');
Route::get('panier.contenu_supprimer','Panier@contenu_supprimer')->name('panier.contenu_supprimer');


/*COMMANDE*/
Route::get('valider', 'Commande@valider')->name('valider');
Route::get('afficher_commande', 'Commande@afficher_comm')->name('afficher_commande');
Route::get('historique', 'Commande@historique')->name('historique');
Route::get('historique_commande','AjaxPaginationController@ajaxPagination')->name('historique_commande');

/*PAYEMENT*/

Route::get('/test', function () {
    return view('payment_save');
});

Route::get('/payment_accepted', function () {
    return view('payment_accepted');
});
Route::get('/payment', 'StripePaymentController@index')->name('payment');
Route::get('testvalidite', 'StripePaymentController@testvalidite')->name('testvalidite');

/*CRAFT*/
Route::get('/craft', 'Craft@index')->name('craft');
Route::get('/craft', 'Craft@afficher')->name('craft');
Route::post('ajouter', 'Craft@ajouter')->name('craft.ajouter');
Route::post('craft_modifier', 'Craft@modifier')->name('craft_modifier');
Route::GET('craft_afficher_form', 'Craft@afficher_form')->name('craft_afficher_form');
Route::post('ajouter_ingredient', 'Craft@ajouter_ingredient')->name('ajouter_ingredient');
Route::get('supprimer_ingredient', 'Craft@supprimer')->name('supprimer_ingredient');

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Auth::routes(['verify' => true]);

Route::get('/table_vide',function (){
   $requete = DB::table('users')->select('id')->get();
   return $requete;
});
/**/
/* ACCUEIL */
Route::get('/','HomeController@index')->name('/');
Route::get('horaires','HomeController@horaires')->name('horaires');

/*ACCUEIL CAROUSEL*/
Route::post('/modif_carousel', 'Accueil_Carousel@modifier')->name('accueil_carousel');
Route::post('/modif_carousel_ajouter', 'Accueil_Carousel@ajouter')->name('accueil_carousel_ajouter');
Route::get('/afficher_form_carousel', 'Accueil_Carousel@afficher_form')->name('afficher_form_carousel');
Route::get('/modif_carousel_supprimer', 'Accueil_Carousel@supprimer')->name('accueil_carousel_supprimer');

/* PARAMETRE */
Route::get('update', 'ParametresController@update')->name('update');
Route::get('parametres', function(){
    return view('parametres');
})->name('parametres');
Route::get('conf_email', 'ParametresController@verify')->name('conf_email');
Route::get('verif_email', 'ParametresController@verif_email');

/* ADMINISTRATION */
Route::get('admin/home', 'Admin@index')->name('admin');
Route::get('admin/horaires', 'Admin@horaires')->name('adm_horaires');
Route::post('admin/horaires.modif', 'Admin@horaires_modif')->name('adm_horaires.modif');
Route::get('admin/secondaire', 'Admin@secondaire')->name('adm_secondaire');
Route::get('admin/avis', 'Admin@avis')->name('adm_avis');
Route::get('admin/engagements', 'Admin@engagements')->name('adm_engagements');
Route::get('admin/general', 'Admin@general')->name('adm_general');
Route::get('admin/commandes', 'Admin@commandes')->name('adm_commandes');
Route::get('admin/historique_commandes', 'Admin@historique_commandes')->name('adm_historique_commandes');
Route::get('admin/informations', 'Admin@informations')->name('adm_informations');
Route::get('admin/droits', 'Admin@droits')->name('adm_droits');
Route::get('admin/expulsions', 'Admin@expulsions')->name('adm_expulsions');
Route::get('admin/codes', 'Admin@codes')->name('adm_codes');
Route::get('admin/articles', 'Admin@articles')->name('adm_articles');
Route::get('admin/menus', 'Admin@menus')->name('adm_menus');
Route::get('admin/promotions', 'Admin@promotions')->name('adm_promotions');

/*********************/

Route::get('engagements', function(){
    return view('engagements');
})->name('engagements');

Route::get('avis', 'Commentaire@index')->name('avis');