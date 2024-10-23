<?php

use App\Http\Controllers\API;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::get('/config', API\ConfigController::class);

Route::middleware(['auth:sanctum'])->group(function (Router $router) {
    // current resources
    Route::get('/auth/user', [API\AuthController::class, 'show']);

    Route::apiResource('users', API\UserController::class)->middleware([HandlePrecognitiveRequests::class]);
    Route::apiResource('contents', API\ContentController::class)->middleware([HandlePrecognitiveRequests::class]);
    Route::apiResource('categories', API\CategoryController::class)->middleware([HandlePrecognitiveRequests::class]);
    Route::apiResource('pages', API\PagesController::class)->middleware([HandlePrecognitiveRequests::class]);
    Route::post('pages/deleteSlider', [API\PagesController::class, 'removeSlider']);
    Route::post('pages/moveSlider', [API\PagesController::class, 'moveSlider']);
    Route::apiResource('settings', API\SettingController::class)->middleware([HandlePrecognitiveRequests::class]);

    Route::post('sort/{resource}', API\SortController::class)->name('sort');

    // other resources
    Route::apiResource('forms', API\FormController::class)->middleware([HandlePrecognitiveRequests::class]);
    Route::post('forms/{form}/addStep', [API\FormController::class, 'addStep']);
    Route::post('forms/{form}/export', [API\FormController::class, 'export']);

    Route::apiResource('formSteps', API\FormStepsController::class)->middleware([HandlePrecognitiveRequests::class]);
    Route::post('formSteps/{formStep}/addSection', [API\FormStepsController::class, 'addSection']);

    Route::apiResource('formSections', API\FormSectionsController::class)->middleware([HandlePrecognitiveRequests::class]);
    Route::post('formSections/{formSection}/addField', [API\FormSectionsController::class, 'addField']);
    Route::post('formSections/{formSection}/syncFields', [API\FormSectionsController::class, 'syncFields']);

    Route::apiResource('formFields', API\FormFieldsController::class)->middleware([HandlePrecognitiveRequests::class]);

    Route::apiResource('fieldOptions', API\FieldOptionsController::class)->middleware([HandlePrecognitiveRequests::class]);
    Route::apiResource('fieldRules', API\FieldRulesController::class)->middleware([HandlePrecognitiveRequests::class]);

    Route::apiResource('formResponses', API\FormResponsesController::class)->middleware([HandlePrecognitiveRequests::class]);

    Route::apiResource('posts', API\PostsController::class)->middleware([HandlePrecognitiveRequests::class]);
});
