<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreSpaceshipRequest;
use App\Http\Requests\UpdateSpaceshipRequest;
use App\Http\Resources\SpaceshipResource;
use App\Http\Resources\ArmamentResource;
use App\Services\SpaceshipService;
use Illuminate\Http\Request;
use App\Models\Spaceship;
use App\Models\Armament;
use Exception;
use DB;

class SpaceshipController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spaceships = Spaceship::query();

        return $this->searchableResponse(
            $spaceships,
            "App\Http\Resources\SpaceshipResource",
            [
                'search' => function ($spaceships, $searchString) {
                    $spaceships->where('name', 'like', "%{$searchString}%")
                        ->orwhere('class', 'like', "%{$searchString}%")
                        ->orwhere('status', 'like', "%{$searchString}%");
                }
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreSpaceshipRequest  $request
     * @param  SpaceshipService  $spaceshipService
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreSpaceshipRequest $request, SpaceshipService $spaceshipService)
    {
        try {
            DB::beginTransaction();

            $spaceshipService->createSpaceship($request->validated());

            DB::commit();

            return response()->json(["success" => true], Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollback();
            return $this->fatalErrorResponse($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Spaceship  $spaceship
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Spaceship $spaceship)
    {
        $response = new SpaceshipResource($spaceship->load('armaments'));
        return $this->successResponse($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateSpaceshipRequest  $request
     * @param  Spaceship  $spaceship
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSpaceshipRequest $request, SpaceshipService $spaceshipService, Spaceship $spaceship)
    {
        $spaceshipService->updateSpaceship($request->validated());

        return response()->json(["success" => true], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Spaceship  $spaceship
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Spaceship $spaceship)
    {
        $spaceship->delete();
        return response()->json(["success" => true], Response::HTTP_NO_CONTENT);
    }
}
