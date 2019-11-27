<?php

namespace App\Http\Controllers;

use App\Ticket as Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tickets = Ticket::where('status','=',1)->orderBy('created_at', 'desc')->get();
        return $this->showAll($tickets);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //
//        $user = Auth::user();
        $data = $request->all();
        $ticket = new Ticket([
            'user_id' => $data['user_id'],
            "category_id" => 1,
            "title" => $data['title'],
            "priority" => 'Alta',
            "description" => $data['description'],
            "tipoHerramienta" => $data['tipoHerramienta'],
            "tipoPregunta" => $data['tipoPregunta'],
            "tipoProblema" => $data['tipoProblema'],
            "status" => Ticket::STATUS_CREATED,
        ]);
        $ticket->save();
        return $this->successResponse(['data' => $data], 200);

    }

    /**
     * @param $ticket_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignTicket($ticket_id, Request $request)
    {
        $data = $request->all();
        $ticket = Ticket::find($ticket_id)->update(['assigned' => $data['assignee']]);
        return $this->successResponse(['data' => $ticket], 200);
    }

    /**
     * @param $ticket_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function attendTicket($ticket_id, Request $request)
    {
        $data = $request->all();
        $ticket = Ticket::find($ticket_id);
        $data = ['status' => Ticket::STATUS_ATTENDIND,
            'comment' => $data['comment'],
            'time_solution' => $data['time_solution'],
            'answer' => $data['answer'],
            'is_open' => true];
        $ticket->update($data);
        return $this->successResponse(['data' => $ticket], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
