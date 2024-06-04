<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservations;
use Illuminate\Http\Request;
use App\Http\Resources\ReservationsResource;
use Moment\Moment;

class ReservationsController extends Controller
{
   /**
    * Display a listing of the resource.
    */

    public function index()
    {
        $query = Reservations::query();

        
        $query->where('created_at', '>=', (new Moment(date('Y-m-d'), 'America/Sao_Paulo'))->format('Y-m-d'));
        return ReservationsResource::collection($query->orderBy('created_at', 'DESC')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request['timeReservation'] = date('H:i:s', strtotime($request['timeReservation']));
        $request['dateReservation'] = date('Y-m-d', strtotime($request['dateReservation']));

        $reservationsExists = Reservations::where('dateReservation', $request['dateReservation'])->where('timeReservation', $request['timeReservation'])->get();
        $userReservationsDay = Reservations::where('user_id', $request['user_id'])->where('dateReservation', $request['dateReservation'])->get();

        if ($reservationsExists->count() >= 15) {
            return response()->json(['message' => 'Não há mais vagas para este horário'], 400);
        }

        $dayOfWeek = date('w', strtotime($request['dateReservation']));

        if ($dayOfWeek === '0') {
            return response()->json(['message' => 'Não é possível reservar para este dia'], 400);
        }

        if ($userReservationsDay->count() > 0) {
            return response()->json(['message' => 'Você já possui uma reserva para este dia'], 400);
        }


        $validatedData = $request->validate([
            'dateReservation' => 'required|date',
            'timeReservation' => 'required',
            'user_id' => 'required|integer',
        ]);


        $reservations = Reservations::create($validatedData);

        return new ReservationsResource($reservations);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservations $reservations)
    {
        return new ReservationsResource($reservations);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservations $reservations)
    {
        $reservations->update($request->validated());

        return new ReservationsResource($reservations);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservations $reservations)
    {
        $reservations->delete();

        return response()->noContent();
    }

    /**
     * return reservations by user id
     */

    public function userId($id)
    {
        $reservations = Reservations::where('user_id', $id)->orderBy('id', 'DESC')->get();
        return new ReservationsResource($reservations);
    }

}
