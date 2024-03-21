<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNotebookRequest;
use App\Http\Requests\UpdateNotebookRequest;
use App\Models\Notebook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;


/**
 * @OA\Info(
 *     title="Notebook API",
 *     version="1.0",
 *     description="API for managing notes in a notebook",
 *     @OA\Contact(
 *         email="contact@example.com"
 *     ),
 *     @OA\License(
 *         name="MIT License",
 *         url="http://example.com/license"
 *     )
 * )
/**
 * @OA\Schema(
 *      schema="Notebook",
 *      type="object",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          format="int",
 *          description="Notebook entry ID",
 *          example=1
 *      ),
 *      @OA\Property(
 *          property="full_name",
 *          type="string",
 *          description="full name",
 *          example="WitianiaCo"
 *      ),
 *     @OA\Property(
 *           property="company_name",
 *           type="string",
 *           description="company name",
 *           example="WitianiaCo"
 *       ),
 *     @OA\Property(
 *           property="phone",
 *           type="string",
 *           description="phone number",
 *           example="+79990802508"
 *      ),
 *     @OA\Property(
 *     property="email",
 *     type="string",
 *     description="eamil",
 *     example="witiania@gmail.com"
 * ),
 *     @OA\Property(
 *     property="birthday",
 *     type="string",
 *     description="birthday",
 *     example="08.02.1992"
 * ),
 *     @OA\Property(
 *     property="created_at",
 *     type="date",
 *     example="2024-03-20T09:52:53.000000Z"
 * ),
 *     @OA\Property(
 *     property="updated_at",
 *     type="date",
 *     example="2024-03-20T09:52:53.000000Z"
 * )
 * )
 */
class NotebookController extends Controller
{

    /**
     * @OA\Get(
     *     path="/v1/notebook",
     *     summary="Get a list of notes in a notebook",
     *     tags={"notebook"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="page number",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             default=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful receipt of records",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Notebook")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No entries found"
     *     )
     * )
     */
    public function show(Request $request): JsonResponse
    {
        $page = $request->get('page', 1);
        $paginator = Notebook::query()->simplePaginate(10, ['*'], 'page', $page);

        return response()->json($paginator);
    }

    /**
     * @OA\Post(
     *     path="/v1/notebook",
     *     summary="Create a new note in the notebook",
     *     tags={"notebook"},
     *     @OA\RequestBody(
     *         description="Note details",
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="full_name", type="string", example="Witiania"),
     *              @OA\Property(property="company_name", type="string", example="WitianiaCo"),
     *              @OA\Property(property="phone", type="string", example="+79990802508"),
     *              @OA\Property(property="email", type="string", example="witiania@gmail.com"),
     *              @OA\Property(property="birthday", type="string", example="08.02.1992"),
     *              @OA\Property(property="photo_url", type="string", example="http://example.com/photo.jpg")
     *          )
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Note created successfully",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Notebook")
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid input"
     *      )
     *      )
     *     ),
     *
     */
    public function create(CreateNotebookRequest $request): JsonResponse
    {
        $model = new Notebook();
        $model->fill([
            'full_name' => $request->json('full_name'),
            'company_name' => $request->json('company_name'),
            'phone' => $request->json('phone'),
            'email' => $request->json('email'),
            'birthday' => $request->json('birthday'),
            'photo_url' => $request->json('photo_url'),
        ]);
        $model->save();
        return response()->json($model);
    }

    /**
     * @OA\Get(
     *     path="/v1/notebook/{id}",
     *     summary="Get a single note by ID",
     *     tags={"notebook"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the note",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Note found",
     *         @OA\JsonContent(ref="#/components/schemas/Notebook")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Note not found"
     *     )
     * )
     */

    public function showOne(int $id): JsonResponse
    {
        $model = Notebook::query()->where(['id' => $id])->first();
        if (null === $model) {
            return response()->json(null, 404);
        }

        return response()->json($model);
    }

    /**
     * @OA\Put(
     *     path="/v1/notebook/{id}",
     *     summary="Update a note by ID",
     *     tags={"notebook"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the note",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Note details",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Notebook")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Note updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Notebook")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Note not found"
     *     )
     * )
     */
    public function update(UpdateNotebookRequest $request, int $id): JsonResponse
    {
        /** @var ?Notebook $model */
        $model = Notebook::query()->where(['id' => $id])->first();
        if (null === $model) {
            return response()->json(null, 404);
        }

        $model->fill([
            'full_name' => $request->json('full_name', $model->full_name),
            'company_name' => $request->json('company_name', $model->company_name),
            'phone' => $request->json('phone', $model->phone),
            'email' => $request->json('email', $model->email),
            'birthday' => $request->json('birthday', $model->birthday),
            'photo_url' => $request->json('photo_url', $model->photo_url),
        ]);
        $model->save();

        return response()->json($model);
    }

    /**
     * @OA\Delete(
     *     path="/v1/notebook/{id}",
     *     summary="Delete a note by ID",
     *     tags={"notebook"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the note",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Note deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Note not found"
     *     )
     * )
     */
    public function delete(int $id): JsonResponse
    {
        /** @var ?Notebook $model */
        $model = Notebook::query()->where(['id' => $id])->first();
        if (null === $model) {
            return response()->json(null, 404);
        }

        $model->delete();

        return response()->json();
    }
}
