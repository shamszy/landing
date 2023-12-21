<?php

namespace App\Libs\Repositories;

use App\Exceptions\DatabaseException;
use App\Http\Resources\DocumentResource;
use App\Libs\Actions\DocumentAction;
use App\Libs\Repositories\Contracts\DocumentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

/**
 * DocumentRepository
 */
readonly class DocumentRepository implements DocumentRepositoryInterface
{
    /**
     * @param DocumentAction $action
     */
    public function __construct(private DocumentAction $action)
    {}

    /**
     * @param $request
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function createDocument($request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'documentType' => 'required',
            'document' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }else {
            return $this->action->createDocumentAction($request);
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getAllDocuments(): AnonymousResourceCollection
    {
        return $this->action->getAllDocumentsAction();
    }

    /**
     * @param $slug
     * @return DocumentResource
     */
    public function getSingleDocument($slug): DocumentResource
    {
        return $this->action->getSingleDocumentAction($slug);
    }

    /**
     * @param $request
     * @param $slug
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function updateDocument($request, $slug): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'documentType' => 'required',
            'document' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }else {
            return $this->action->updateDocumentAction($request, $slug);
        }
    }

    /**
     * @param $slug
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function deleteDocument($slug): JsonResponse
    {
        return $this->action->deleteDocumentAction($slug);
    }

}
