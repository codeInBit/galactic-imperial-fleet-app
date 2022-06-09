<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreSpaceshipRequest;
use App\Http\Resources\SpaceshipResource;
use App\Http\Resources\ArmamentResource;
use Illuminate\Http\Request;
use App\Models\Spaceship;
use App\Models\Armament;
use Exception;
use DB;

class SpaceshipController extends Controller
{
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
     * @param  \Illuminate\Http\StoreSpaceshipRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreSpaceshipRequest $request)
    {
        try {
            DB::beginTransaction();

            $spaceship = Spaceship::create([
                'name' => $request->name,
                'class' => $request->class,
                'crew' => $request->crew,
                'image' => $request->image,
                'value' => $request->value,
                'status' => $request->status,
            ]);

            foreach ($request->armament as $value) {
                $spaceship->armaments()->create([
                    'title' => $value['title'],
                    'qty' => $value['qty'],
                ]);
            }

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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
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
