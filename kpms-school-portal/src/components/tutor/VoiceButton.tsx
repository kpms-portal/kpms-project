"use client";

import { useState, useRef, useCallback } from "react";
import { Mic, MicOff } from "lucide-react";

/* eslint-disable @typescript-eslint/no-explicit-any */

interface VoiceButtonProps {
  language: "en-US" | "ur-PK";
  onTranscript: (text: string) => void;
  disabled?: boolean;
}

export default function VoiceButton({ language, onTranscript, disabled }: VoiceButtonProps) {
  const [isRecording, setIsRecording] = useState(false);
  const [isSupported, setIsSupported] = useState(true);
  const recognitionRef = useRef<any>(null);

  const startRecording = useCallback(() => {
    const SR = (window as any).SpeechRecognition || (window as any).webkitSpeechRecognition;
    if (!SR) {
      setIsSupported(false);
      return;
    }

    const recognition = new SR();
    recognition.lang = language;
    recognition.interimResults = false;
    recognition.continuous = false;

    recognition.onresult = (event: any) => {
      const transcript = event.results[0][0].transcript;
      onTranscript(transcript);
      setIsRecording(false);
    };

    recognition.onerror = () => {
      setIsRecording(false);
    };

    recognition.onend = () => {
      setIsRecording(false);
    };

    recognitionRef.current = recognition;
    recognition.start();
    setIsRecording(true);
  }, [language, onTranscript]);

  const stopRecording = useCallback(() => {
    if (recognitionRef.current) {
      recognitionRef.current.stop();
    }
    setIsRecording(false);
  }, []);

  if (!isSupported) {
    return (
      <button
        disabled
        className="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center"
        title="Voice not supported on this browser"
      >
        <MicOff className="w-5 h-5 text-gray-400" />
      </button>
    );
  }

  return (
    <div className="relative">
      {isRecording && (
        <div className="absolute inset-0 rounded-full border-2 border-[#FFD100] animate-ping" />
      )}
      <button
        type="button"
        disabled={disabled}
        onMouseDown={startRecording}
        onMouseUp={stopRecording}
        onTouchStart={startRecording}
        onTouchEnd={stopRecording}
        className={`w-10 h-10 rounded-full flex items-center justify-center transition-all ${
          isRecording
            ? "bg-[#003087] text-white scale-110"
            : "bg-[#F5F7FB] text-[#5a6577] hover:bg-[#e2e8f0]"
        } disabled:opacity-50`}
        title="Hold to speak"
      >
        <Mic className="w-5 h-5" />
      </button>
    </div>
  );
}
