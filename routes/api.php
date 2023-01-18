<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Account\AvatarController;
use App\Http\Controllers\Account\ProfileController;

use App\Http\Controllers\Carreras\CarrerasAdminController;
use App\Http\Controllers\Carreras\CarrerasEstudianteController;

use App\Http\Controllers\Semestres\SemestresAdminController;
use App\Http\Controllers\Semestres\SemestresEstudianteController;
use App\Http\Controllers\Materias\MateriasEstudianteController;
use App\Http\Controllers\Materias\MateriasAdminController;

use App\Http\Controllers\Documentos\DocumentosAdminController;
use App\Http\Controllers\Documentos\DocumentosEstudianteController;

use App\Http\Controllers\Comentarios\ComentariosAdminController;
use App\Http\Controllers\Comentarios\ComentariosEstudianteController;

use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\ComentarioSoftwareController;
use App\Http\Controllers\DocumentosController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/





Route::prefix('v1')->group(function ()
{
    // Hacer uso del archivo auth.php
    require __DIR__ . '/auth.php';

    // Se hace uso de grupo de rutas y que pasen por el proceso de auth con sanctum
    Route::middleware(['auth:sanctum'])->group(function ()
    {
        // Se hace uso de grupo de rutas
        Route::prefix('profile')->group(function ()
        {
            Route::controller(ProfileController::class)->group(function ()
            {
                Route::get('/', 'show')->name('profile');
                Route::post('/', 'store')->name('profile.store');
            });
            Route::post('/avatar', [AvatarController::class, 'store'])->name('profile.avatar');
           


        });
        ///AQUI ENTRA LALS RUTAS A PROTEGER 

        //RUTAS DE CARRERAS PARA EL ADMINISTRADOR

            Route::post('/carreras/admin', [CarrerasAdminController::class, 'store_admin']);

            Route::get('/carreras/admin', [CarrerasAdminController::class, 'index_admin']);

            Route::get('/carreras/adminE', [CarrerasAdminController::class, 'index_adminE']);

            Route::get('/carreras/admin/{id}', [CarrerasAdminController::class, 'show_admin']);

            Route::put('/carreras/admin/{id}', [CarrerasAdminController::class, 'update_admin']);

            Route::get('/carreras/desactiva/admin/{carreras}', [CarrerasAdminController::class, 'destroy_admin']);

            //RUTAS DE CARRERAS PARA EL ESTUDIANTE

            Route::post('/carreras/estudiante', [CarrerasEstudianteController::class, 'store_estudiante']);

            Route::get('/carreras/estudiante', [CarrerasEstudianteController::class, 'index_estudiante']);

            Route::get('/carreras/estudianteE', [CarrerasEstudianteController::class, 'index_estudianteE']);

            Route::get('/carreras/estudiante/{id}', [CarrerasEstudianteController::class, 'show_estudiante']);

            Route::put('/carreras/estudiante/{id}', [CarrerasEstudianteController::class, 'update_estudiante']);

            Route::get('/carreras/desactiva/estudiante/{carreras}', [CarrerasEstudianteController::class, 'destroy_estudiante']);

            // RUTAS DE SEMESTRES PARA EL ADMINISTRADOR 

            Route::post('/semestres/admin/{carreras}', [SemestresAdminController::class, 'store_admin']);

            Route::get('/semestres/admin', [SemestresAdminController::class, 'index_admin']);

            Route::get('/semestres/adminE', [SemestresAdminController::class, 'index_adminE']);

            Route::get('/semestres/admin/{id}', [SemestresAdminController::class, 'show_admin']);

            Route::put('/semestres/admin/{id}', [SemestresAdminController::class, 'update_admin']);

            Route::get('/semestres/desactiva/admin/{semestres}', [SemestresAdminController::class, 'destroy_admin']);

            // RUTAS DE SEMESTRES PARA EL ESTUDIANTE

            Route::post('/semestres/estudiante/{carreras}', [SemestresEstudianteController::class, 'store_estudiante']);

            Route::get('/semestres/estudiante', [SemestresEstudianteController::class, 'index_estudiante']);

            Route::get('/semestres/estudianteE', [SemestresEstudianteController::class, 'index_estudianteE']);

            Route::get('/semestres/estudiante/{id}', [SemestresEstudianteController::class, 'show_estudiante']);

            Route::put('/semestres/estudiante/{id}', [SemestresEstudianteController::class, 'update_estudiante']);

            Route::get('/semestres/desactiva/estudiante/{semestres}', [SemestresEstudianteController::class, 'destroy_estudiante']);
            
            // RUTAS DE MATERIAS PARA EL ADMINISTRADOR


            Route::post('/materias/admin/{semestres}', [MateriasAdminController::class, 'store_admin']);

            Route::get('/materias/admin', [MateriasAdminController::class, 'index_admin']);

            Route::get('/materias/adminE', [MateriasAdminController::class, 'index_adminE']);

            Route::get('/materias/admin/{id}', [MateriasAdminController::class, 'show_admin']);

            Route::put('/materias/admin/{id}', [MateriasAdminController::class, 'update_admin']);

            Route::get('/materias/desactiva/admin/{materias}', [MateriasAdminController::class, 'destroy_admin']);
            // RUTAS DE MATERIAS PARA EL ESTUDIANTE


            Route::post('/materias/estudiante/{semestres}', [MateriasEstudianteController::class, 'store_estudiante']);

            Route::get('/materias/estudiante', [MateriasEstudianteController::class, 'index_estudiante']);

            Route::get('/materias/estudianteE', [MateriasEstudianteController::class, 'index_estudianteE']);

            Route::get('/materias/estudiante/{id}', [MateriasEstudianteController::class, 'show_estudiante']);

            Route::put('/materias/estudiante/{id}', [MateriasEstudianteController::class, 'update_estudiante']);

            Route::get('/materias/desactiva/estudiante/{materias}', [MateriasEstudianteController::class, 'destroy_estudiante']);
            
            //GESTION COMENTARIOS ADMINISTRADOR

            Route::post('/comentarios/admin/{materias}', [ComentariosAdminController::class, 'store_admin']);

            Route::get('/comentarios/admin/', [ComentariosAdminController::class, 'index_admin']);

            Route::get('/comentarios/admin/{id}', [ComentariosAdminController::class, 'show_admin']);

            Route::put('/comentarios/admin/{id}', [ComentariosAdminController::class, 'update_admin']);

            Route::delete('/comentarios/admin/{id}', [ComentariosAdminController::class, 'delete_admin']);


            //GESTION COMENTARIOS ADMINISTRADOR

            Route::post('/comentarios/estudiante/{materias}', [ComentariosEstudianteController::class, 'store_estudiante']);

            Route::get('/comentarios/estudiante/', [ComentariosEstudianteController::class, 'index_estudiante']);

            Route::get('/comentarios/estudiante/{id}', [ComentariosEstudianteController::class, 'show_estudiante']);

            Route::put('/comentarios/estudiante/{id}', [ComentariosEstudianteController::class, 'update_estudiante']);

            Route::delete('/comentarios/estudiante/{id}', [ComentariosEstudianteController::class, 'delete_estudiante']);
            
            //GESTION DOCUMENTOS ADMINISTRADOR

            // Route::post('/documentos/admin/{materias}', [DocumentosAdminController::class, 'store_admin']);
            // Route::post('/documentos/{documentos}/actualizar', [DocumentosAdminController::class, 'update_admin']);
            // Route::get('/documentos/{id}', [DocumentosAdminController::class, 'show_admin']);
            Route::get('/documentos/admin', [DocumentosAdminController::class, 'index_admin']);


            // Route::get('/register', [RegisterController::class, 'registro']);



    });
});

// Route::post('/carreras', [CarrerasController::class, 'store']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Hacer uso del archivo auth.php
require __DIR__ . '/auth.php';

//SECCION DOCUMENTOS

Route::post('/documentos', [DocumentosController::class, 'store']);










