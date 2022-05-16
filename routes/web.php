<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
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
        Artisan::call('migrate:rollback',[
            '--path'=>'\database\migrations\2020_04_17_180915_pizza_craft.php'
        ]);

        Artisan::call('migrate',[
            '--path'=>'\database\migrations\2020_04_17_180915_pizza_craft.php'
        ]);
        return back();
    })->name('make-migration');

/* AVIS */
Route::post('ajout_commentaire', 'Commentaire@ajout')->name('ajout_commentaire')->middleware('verified');
Route::get('avis','Commentaire@afficher')->name('avis');
Route::get('commentaire',"Commentaire@voir")->name('commentaire')->middleware('verified');


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
Route::get('code.supprimer','CodeController@supprimer')->name('code.supprimer');
Route::post('categorie.upload','Pizza@categorie_upload')->name('categorie.upload');
Route::post('categorie.supprimer','Pizza@categorie_supprimer')->name('categorie.supprimer');

/* ENGAGEMENT*/
Route::get('engagements', 'Engagement@index')->name('engagements');

/*MENU*/
Route::post('menu.upload','Menu@upload')->name('menu.upload');
Route::post('menu.modifier','Menu@modifier')->name('menu.modifier');
Route::post('menu.promotion','Menu@promotion')->name('menu.promotion');
Route::get('menu.supprimer','Menu@supprimer')->name('menu.supprimer');
Route::get('contenu.supprimer','Menu@contenu_supprimer')->name('contenu.supprimer');
Route::get('afficher_form_menu','Menu@afficher_form')->name('afficher_form_menu');
Route::get('afficher_cat','Menu@afficher_cat')->name('afficher_cat');
Route::get('pizza_all/menu/{menu_nom}','Menu@detail')->name('afficher_menu');

/*PANIER*/
Route::get('panier','Panier@afficher')->name('panier');
Route::get('panier.creer','Panier@creer')->name('panier.creer');
Route::get('panier.ajouter','Panier@ajouter')->name('panier.ajouter');
Route::get('panier.ajouter_menu','Panier@ajouter_menu')->name('panier.ajouter_menu');
Route::get('panier.modifier','Panier@modifier')->name('panier.modifier');
Route::get('panier.contenu_supprimer','Panier@contenu_supprimer')->name('panier.contenu_supprimer');


/*COMMANDE*/
Route::get('valider', 'Commande@valider')->name('valider');
Route::get('afficher_commande', 'Commande@afficher_comm')->name('afficher_commande');
Route::get('afficher_commande2', 'Commande@afficher_comm2')->name('afficher_commande2');
Route::get('historique_commande','AjaxPaginationController@ajaxPagination')->name('historique_commande');

/*PAYEMENT*/

Route::get('/payment_accepted', function () {
    return view('payment_accepted');
});
Route::get('/payment', 'StripePaymentController@index')->name('payment')->middleware('auth');
Route::get('testvalidite', 'StripePaymentController@testvalidite')->name('testvalidite');
Route::get('/utiliser_points', 'StripePaymentController@utiliser_points')->name('utiliser_points');

/*CRAFT*/
Route::get('/craft', 'Craft@afficher')->name('craft');
Route::post('craft_ajouter', 'Craft@ajouter')->name('craft_ajouter');
Route::post('craft_modifier', 'Craft@modifier')->name('craft_modifier');
Route::GET('craft_afficher_form', 'Craft@afficher_form')->name('craft_afficher_form');
Route::post('craft_ajouter_ingredient', 'Craft@ajouter_ingredient')->name('craft_ajouter_ingredient');
Route::get('craft_supprimer_ingredient', 'Craft@supprimer')->name('craft_supprimer_ingredient');

Route::get('/clear-cache', function() {
    if (\Illuminate\Support\Facades\Auth::user()->role == 'admin') {
        Artisan::call('cache:clear');
        return "Cache is cleared";
    }
    else
    {
        abort(404);
    }
})->middleware('auth');

Auth::routes(['verify' => true]);
/**/
/* ACCUEIL */
Route::get('/','HomeController@index')->name('/');
Route::get('horaires','HomeController@horaires')->name('horaires');
Route::post('newsletter_ajout', 'HomeController@newsletter_ajout')->name('newsletter_ajout');

/*ACCUEIL CAROUSEL*/
Route::post('/modif_carousel', 'Accueil_Carousel@modifier')->name('accueil_carousel');
Route::post('/modif_carousel_ajouter', 'Accueil_Carousel@ajouter')->name('accueil_carousel_ajouter');
Route::get('/afficher_form_carousel', 'Accueil_Carousel@afficher_form')->name('afficher_form_carousel');
Route::get('/modif_carousel_supprimer', 'Accueil_Carousel@supprimer')->name('accueil_carousel_supprimer');

/* PARAMETRE */
Route::get('update', 'ParametresController@update')->name('update');
Route::get('parametres', 'ParametresController@index')->middleware('auth')->name('parametres');
Route::get('conf_email', 'ParametresController@verify')->middleware('auth')->name('conf_email');
Route::get('verif_email', 'ParametresController@verif_email')->middleware('auth');
Route::post('modif_adresse', 'ParametresController@modif_adresse')->middleware('auth')->name('modif_adresse');

/*CREANEAUX*/
route::get('/creneaux','Creneaux@index')->name('creneaux.index');
route::get('/creneaux/reserver','Creneaux@reserver')->name('creneaux.reserver');
route::get('/creneaux_ajouter','Creneaux@ajouter')->name('creneaux.ajouter');
route::get('/creneaux_supprimer','Creneaux@supprimer')->name('creneaux.supprimer');
route::get('/creneaux_reini','Creneaux@reini')->name('creneaux.reini');
Route::get('supprimer_reservation', 'Creneaux@supprimer_reservation')->name('supprimer_reservation');

/* ADMINISTRATION */
Route::middleware('can:accessAdminpanel')->group(function() {
    Route::get('admin/home', 'Admin@index')->name('admin');

    /* MODERATION */
    Route::group([
        'middleware' => 'App\Http\Middleware\CheckModeration',
    ], function () {
        /* EXPULSIONS */
        Route::get('admin/expulsions', 'Admin@expulsions')->name('adm_expulsions');
        Route::post('admin/expulsions_ajout', 'Admin@expulsion_ajout')->name('adm_explusion_ajout');
        Route::get('admin/expulsion_supprimer', 'Admin@expulsion_supprimer')->name('adm_explusion_supprimer');
        /* UTILISATEURS INFOS */
        Route::get('admin/informations', 'Admin@informations')->name('adm_informations');
        Route::post('admin/informations', 'Admin@informations')->name('adm_informations');
        /* AVIS */
        Route::get('admin/avis', 'Admin@avis')->name('adm_avis');
        Route::get('admin/supprimer_avis', 'Admin@supprimer_avis')->name('adm_supprimer_avis');
    });

    /* RESTAURATION */
    Route::group([
        'middleware' => 'App\Http\Middleware\CheckRestauration',
    ], function () {
        /* COMMANDES */
        Route::get('admin/commandes', 'Admin@commandes')->name('adm_commandes');
        Route::get('admin/historique_commandes', 'Admin@historique_commandes')->name('adm_historique_commandes');
        Route::get('admin/historique_commandes', 'Admin@historique_commandes')->name('adm_historique_commandes');
        /* PLANNING */
        Route::get('admin/horaires', 'Admin@horaires')->name('adm_horaires');
        Route::post('admin/horaires.modif', 'Admin@horaires_modif')->name('adm_horaires.modif');
        Route::get('admin/feriee_supprimer', 'Admin@feriee_supprimer')->name('adm_feriee_supprimer');
        Route::get('admin/feriee_ajout', 'Admin@feriee_ajout')->name('adm_feriee_ajout');
        Route::get('admin/fermeture_supprimer', 'Admin@fermeture_supprimer')->name('adm_fermeture_supprimer');
        Route::get('admin/fermeture_ajout', 'Admin@fermeture_ajout')->name('adm_fermeture_ajout');
        /* CARTE */
        Route::get('admin/codes', 'Admin@codes')->name('adm_codes');
        Route::get('admin/articles', 'Admin@articles')->name('adm_articles');
        Route::get('admin/menus', 'Admin@menus')->name('adm_menus');
        Route::get('admin/promotions', 'Admin@promotions')->name('adm_promotions');
        Route::get('admin/promotions/refresh_article', 'Admin@refresh_article'); //AJAX
        /* CRENEAUX */
        Route::get('admin/creneaux', 'Admin@creneaux')->name('adm_creneaux');
        Route::get('admin/ingredients', 'Admin@ingredients')->name('adm_ingredients');
    });

    /* PARAMETRE */
    Route::group([
        'middleware' => 'App\Http\Middleware\CheckParametre',
    ], function () {
        /* GENERAL */
        Route::get('admin/general', 'Admin@general')->name('adm_general');
        Route::post('admin/telephone', 'Admin@telephone')->name('adm_telephone');
        Route::post('admin/identite', 'Admin@identite')->name('adm_identite');
        Route::post('admin/adresse', 'Admin@adresse')->name('adm_adresse');
        Route::post('admin/images', 'Admin@images')->name('adm_images');
        Route::post('admin/couleurs', 'Admin@couleurs')->name('adm_couleurs');
        Route::post('admin/gmail', 'Admin@gmail')->name('adm_gmail');
        Route::post('admin/points', 'Admin@points')->name('adm_points');
        /* PAGE ACCUEIL */
        Route::get('admin/page_accueil', 'Admin@page_accueil')->name('adm_page_accueil');
        Route::get('partenaire_ajout', 'Admin@partenaire_ajout')->name('partenaire_ajout');
        Route::get('partenaire_supprimer', 'Admin@partenaire_supprimer')->name('partenaire_supprimer');
        Route::get('admin/afficher_form_reseaux', 'Admin@afficher_form_reseaux')->name('afficher_form_reseaux');
        Route::post('admin/modifier_reseau', 'Admin@modifier_reseau')->name('adm_modifier_reseau');
        /* ENGAGEMENTS */
        Route::get('admin/engagements', 'Admin@engagements')->name('adm_engagements');
        Route::post('admin/ajout_engagement', 'Admin@ajout_engagement')->name('ajout_engagement');
        Route::get('admin/supprimer_engagement', 'Admin@supprimer_engagement')->name('supprimer_engagement');
        Route::post('admin/modif_engagement', 'Admin@modif_engagement')->name('modif_engagement');
        Route::get('admin/enga_afficher_form', 'Admin@enga_afficher_form')->name('enga_afficher_form');
    });

    /* DROITS */
    Route::group([
        'middleware' => 'App\Http\Middleware\CheckUpgrade',
    ], function () {
        Route::get('admin/droits', 'Admin@droits')->name('adm_droits');
        Route::get('admin/supprimer_droits', 'Admin@supprimer_droits')->name('adm_supprimer_droits');
        Route::post('admin/droits_ajouter', 'Admin@droits_ajouter')->name('adm_droits_ajouter');
        Route::get('admin/droits_modifier', 'Admin@droits_modifier')->name('adm_droits_modifier');
    });

    /* NEWSLETTER */
    Route::group([
        'middleware' => 'App\Http\Middleware\CheckNewsletter',
    ], function () {
        Route::get('admin/newsletter', 'Admin@newsletter')->name('adm_newsletter');
        Route::get('admin/newsletter_supprimer', 'Admin@newsletter_supprimer')->name('adm_newsletter_supprimer');
        Route::post('admin/envoi_mail', 'Admin@envoi_mail')->name('adm_envoi_mail');
    });
});

/*********************/
