import { NextRequest, NextResponse } from "next/server";
import OpenAI from "openai";
import { AI_BUDGET } from "@/lib/ai-config";

const openai = new OpenAI();

export async function POST(req: NextRequest) {
  try {
    const { text, language } = await req.json();

    if (!text) {
      return NextResponse.json(
        { error: "Text is required" },
        { status: 400 }
      );
    }

    // Limit text length for TTS to prevent abuse
    const truncatedText = text.slice(0, 1000);

    const mp3 = await openai.audio.speech.create({
      model: AI_BUDGET.TTS_MODEL,
      voice: AI_BUDGET.TTS_VOICE,
      input: truncatedText,
    });

    // Get the audio as a buffer
    const buffer = Buffer.from(await mp3.arrayBuffer());

    return new NextResponse(buffer, {
      status: 200,
      headers: {
        "Content-Type": "audio/mpeg",
        "Content-Length": buffer.length.toString(),
        "Cache-Control": "public, max-age=3600",
      },
    });
  } catch (error: unknown) {
    // Handle API key errors
    if (
      error instanceof Error &&
      ("status" in error || "code" in error)
    ) {
      const apiError = error as { status?: number; code?: string };
      if (
        apiError.status === 401 ||
        apiError.code === "invalid_api_key" ||
        !process.env.OPENAI_API_KEY
      ) {
        return NextResponse.json(
          { error: "Voice feature is not available in demo mode" },
          { status: 503 }
        );
      }
    }

    console.error("Voice Response API error:", error);
    return NextResponse.json(
      { error: "Failed to generate audio" },
      { status: 500 }
    );
  }
}
