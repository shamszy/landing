<?php

namespace App\Libs\Actions;

use App\Exceptions\DatabaseException;
use App\Http\Resources\DocumentResource;
use App\Libs\Services\AwsService;
use App\Libs\Traits\AuthUserTrait;
use App\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * DocumentAction
 */
readonly class DocumentAction
{
    use AuthUserTrait;

    /**
     * @param Document $model
     * @param AwsService $awsService
     */
    public function __construct(private Document $model, private AwsService $awsService)
    {}

    /**
     * @param $request
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function createDocumentAction($request): JsonResponse
    {
        try {
            $document = $this->model->create([
                'company_id' => $this->getAuthUser()->company->id,
                'document_type' => $request->documentType. ' For '. $this->getAuthUser()->company->name,
                'document_link' => $this->awsService->pushFileToAwsS3BucketService($request, 'document'),
            ]);
            return response()->json([
                'message' =>  $request->documentType. ' document added successfully',
                'data' => new DocumentResource($document),
                'success' => true
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            throw  new DatabaseException("Sorry unable to add document", $e->getMessage());
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getAllDocumentsAction(): AnonymousResourceCollection
    {
        if ($this->getAuthUser()->role == 'company') {
            $documents = $this->model->where('company_id', '=', $this->getAuthUser()->company->id)->get();
        } else {
            $documents = $this->model->latest()->paginate(10);
        }
        return DocumentResource::collection($documents)->additional([
            'message' => "All documents fetched successfully",
            'success' => true
        ], Response::HTTP_OK);
    }

    /**
     * @param $slug
     * @return DocumentResource
     */
    public function getSingleDocumentAction($slug): DocumentResource
    {
        $document = $this->model->whereSlug($slug)->firstOrFail();
        return (new DocumentResource($document))->additional( [
            'message' => "Document details fetched successfully",
            'success' => true
        ], Response::HTTP_OK);
    }

    /**
     * @param $request
     * @param $slug
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function updateDocumentAction($request, $slug): JsonResponse
    {
        $document = $this->model->whereSlug($slug)->firstOrFail();
        try {
            $document->update([
                'document_type' => empty($request->documentType) ? $document->document_type : $request->documentType. ' For '. $this->getAuthUser()->company->name,
                'document_link' => empty($request->document) ? $document->document_link : $this->awsService->pushFileToAwsS3BucketService($request, 'document'),
            ]);
            return response()->json([
                'message' =>  $request->documentType. ' document updated successfully',
                'data' => new DocumentResource($document),
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw  new DatabaseException("Sorry unable to update document", $e->getMessage());
        }
    }

    /**
     * @param $slug
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function deleteDocumentAction($slug): JsonResponse
    {
        $document = $this->model->whereSlug($slug)->firstOrFail();
        try {
            $document->delete();
            return response()->json([
                'message' => 'Document deleted successfully',
                'data' => new DocumentResource($document),
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw  new DatabaseException("Sorry unable to delete document", $e->getMessage());
        }
    }

}
