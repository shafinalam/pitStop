<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class TextToSpeechController extends Controller
{
    public function convertToSpeech(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
        ]);

        $text = $request->input('text');

        try {
            // Initialize OpenAI Client
            $client = OpenAI::client(config('services.openai.key'));

            // Call OpenAI Text-to-Speech API
            $response = $client->audio()->speech([
                'model' => 'tts-1', // Use 'tts-1' or 'tts-1-hd' for better quality
                'voice' => 'alloy', // Available voices: alloy, echo, fable, onyx, nova, shimmer
                'input' => $text,
            ]);

            // Get the generated audio file
            $audioContent = $response->getBody()->getContents();
            dd($audioContent);
            // Return an audio response
//            return response($audioContent)
//                ->header('Content-Type', 'audio/mpeg')
//                ->header('Content-Disposition', 'inline; filename="speech.mp3"');

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to generate speech: ' . $e->getMessage()], 500);
        }
    }
}
