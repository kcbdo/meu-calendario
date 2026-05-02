<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * Controller de eventos do calendário
 *
 * @author Kathleen Barbosa <kathleencaroline357@gmail.com>
 * @since 02/05/2026
 * @version 1.0.0
 */
class EventController extends Controller
{
    /**
     * Lista todos os eventos
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $events = Event::orderBy('start_datetime', 'asc')->get();

        return response()->json($events);
    }

    /**
     * Salva um novo evento
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function insert(Request $request): JsonResponse
    {
        $validator = $this->validation($request);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Não foi possível criar o evento.',
                'errors'  => $validator->errors()
            ], 422);
        }

        $event = new Event();
        $this->save($event, $request);

        return response()->json($event, 201);
    }

    /**
     * Exibe um evento específico
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Evento não encontrado.'], 404);
        }

        return response()->json($event);
    }

    /**
     * Atualiza um evento existente
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Evento não encontrado.'], 404);
        }

        $validator = $this->validation($request);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Não foi possível atualizar o evento.',
                'errors'  => $validator->errors()
            ], 422);
        }

        $this->save($event, $request);

        return response()->json($event);
    }

    /**
     * Remove um evento
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Evento não encontrado.'], 404);
        }

        $event->delete();

        return response()->json(['message' => 'Evento removido com sucesso.']);
    }

    /**
     * Valida os dados da requisição
     *
     * @param Request $request
     * @return \Illuminate\Validation\Validator
     */
    private function validation(Request $request)
    {
        return Validator::make($request->all(), [
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'start_datetime' => 'required|date',
            'end_datetime'   => 'required|date|after:start_datetime',
            'color'          => 'nullable|string|max:7',
            'reminder_at'    => 'nullable|date',
        ], [
            'title.required'          => 'O título do evento é obrigatório.',
            'title.max'               => 'O título não pode ter mais que 255 caracteres.',
            'start_datetime.required' => 'A data de início é obrigatória.',
            'end_datetime.required'   => 'A data de término é obrigatória.',
            'end_datetime.after'      => 'A data de término deve ser após a data de início.',
        ]);
    }

    /**
     * Salva os dados do evento
     *
     * @param Event $event
     * @param Request $request
     * @return void
     */
    private function save(Event $event, Request $request): void
    {
        $event->title          = $request->title;
        $event->description    = $request->description;
        $event->start_datetime = $request->start_datetime;
        $event->end_datetime   = $request->end_datetime;
        $event->color          = $request->color ?? '#3B82F6';
        $event->reminder_at    = $request->reminder_at;
        $event->save();
    }
}
