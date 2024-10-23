<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Actions\Order\CreateOrderAction;
use App\Actions\Order\GenerateInvoicesPDF;
use App\Actions\Order\GeneratePDF;
use App\Actions\Order\OrderChangeStatusAction;
use App\Enums\FormResponseStatuses;
use App\Enums\OrderStatus;
use App\Http\Resources\FormResponseCollection;
use App\Http\Resources\FormResponseResource;
use App\Models\FormResponse;
use App\Support\SpatieQueryBuilder\Filters\GlobalFilter;
use App\Support\SpatieQueryBuilder\Sorts\FieldSort;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class FormResponsesController
{
    public function index(Request $request): FormResponseCollection
    {
        $formResponses = QueryBuilder::for(FormResponse::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('form_id'),
                AllowedFilter::custom('search', new GlobalFilter([
                    'status' => FormResponseStatuses::class,
                    'user' => ['firstname', 'lastname', 'email'],
                ])),
            ])
            ->defaultSort('-id')
            ->allowedSorts(['id', AllowedSort::custom('ids_field', new FieldSort, 'id')])
            ->allowedIncludes(['form', 'user'])
            ->paginate($request->get('per_page', 20))
            ->appends($request->query());

        return new FormResponseCollection($formResponses);
    }

    public function show(Request $request, FormResponse $formResponse): FormResponseResource
    {
        return (new FormResponseResource($formResponse))->withAutoLoadRelations($request->get('include'));
    }

    public function destroy(FormResponse $formResponse): JsonResponse
    {
        $formResponse->answers()->delete();
        $formResponse->delete();

        return response()->json();
    }

    public function status(FormResponse $formResponse, Request $request): FormResponseResource
    {
        $formResponse->status = $request->status;

        if ($formResponse->status === FormResponseStatuses::paid()) {

            throw_if(
                $formResponse->user === null,
                ValidationException::withMessages(['La réponse doit être lié à un utilisateur pour pouvoir être passé en payé.'])
            );

            $order = $formResponse->order;

            if ($order === null) {
                $order = app(CreateOrderAction::class)->execute($formResponse->user, $formResponse);
                $order = app(OrderChangeStatusAction::class)->execute($order, OrderStatus::WAITING);
            }

            app(OrderChangeStatusAction::class)->execute(
                $order,
                OrderStatus::PAID
            );
        }

        $formResponse->save();

        return (new FormResponseResource($formResponse))->withAutoLoadRelations($request->get('include'));
    }

    public function invoices(FormResponse $formResponse): JsonResponse
    {
        throw_if(
            $formResponse->order === null,
            ValidationException::withMessages(['La réponse doit être lié à une commande pour pouvoir générer une facture.'])
        );

        //$media = $formResponse->order->mainInvoicesPdf;

        //if ($media === null) {
        $media = app(GenerateInvoicesPDF::class)->execute($formResponse->order);
        //}

        throw_if(
            $media === null,
            ValidationException::withMessages(['Aucune facture disponible.'])
        );

        return response()->json([
            'data' => [
                'url' => $media->getFullUrl(),
            ],
        ]);
    }

    public function order(FormResponse $formResponse): JsonResponse
    {
        throw_if(
            $formResponse->order === null,
            ValidationException::withMessages(['La réponse doit être lié à une commande pour pouvoir générer un bon de commande.'])
        );

        //$media = $formResponse->order->pdf;

        //if ($media === null) {
        $media = app(GeneratePDF::class)->execute($formResponse->order);
        //}

        return response()->json([
            'data' => [
                'url' => $media->getFullUrl(),
            ],
        ]);
    }
}
