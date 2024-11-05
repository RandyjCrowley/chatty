<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(Chat $chat): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat): void
    {
        //
    }
}
