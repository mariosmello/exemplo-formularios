<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function store(ContactRequest $request)
    {

        if ($request->get('error')) {

            return response()->json([
                'status' => false,
                'data' => [
                    'message' => 'Problema qualquer ao enviar o formulário'
                ],
            ]);

        } elseif($request->get('redirect')) {

            return response()->json([
                'status' => true,
                'data' => [
                    'redirect' => 'http://google.com'
                ],
            ]);

        } else {

            return response()->json([
                'status' => true,
                'data' => [
                    'message' => 'Formulário enviado com sucesso'
                ],
            ]);

        }

    }
}