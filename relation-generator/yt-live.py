import subprocess
import tempfile
import whisper
import time
import requests
from transformers import MT5Tokenizer, MT5ForConditionalGeneration, pipeline

whisper_model = whisper.load_model("base")

local_model_path = "/var/www/html/relation-generator/local_models/google/mt5-base/"

tokenizer = MT5Tokenizer.from_pretrained(local_model_path)
model = MT5ForConditionalGeneration.from_pretrained(local_model_path)

summarizer = pipeline("summarization",
         model=model,
         tokenizer=tokenizer
     )

def chunk_text(text, max_words=400):
    words = text.split()
    return [' '.join(words[i:i+max_words]) for i in range(0, len(words), max_words)]

def generate_summaries(chunks):
    summaries = []
    for chunk in chunks:
        summary = summarizer(chunk, max_length=100, min_length=10, do_sample=False)
        summaries.append(summary[0]['summary_text'])
    return summaries

def process_youtube_live_stream(stream_url):
    with tempfile.NamedTemporaryFile(suffix=".wav") as tmpfile:
        command = [
            "yt-dlp", "-f", "bestaudio", "-o", "-", stream_url,
            "|", "ffmpeg", "-i", "pipe:0", "-f", "wav", "-acodec", "pcm_s16le", "-ar", "16000", "-ac", "1", tmpfile.name
        ]

        print("Started download stream...")

        process = subprocess.Popen(
            " ".join(command), shell=True, stdout=subprocess.PIPE, stderr=subprocess.PIPE
        )

        try:
            transcribed_text = ""
            while True:
                print("Sound processing...")

                result = whisper_model.transcribe(tmpfile.name)
                new_text = result["text"]
                transcribed_text += " " + new_text

                print("Transcription:", new_text)

                chunks = chunk_text(transcribed_text)
                summaries = generate_summaries(chunks)

                print("\n### Summaries ###")
                for i, summary in enumerate(summaries):
                    print(f"Post {i+1}: {summary}")

                time.sleep(30)

        except KeyboardInterrupt:
            process.terminate()
            print("Break stream processing.")

if __name__ == "__main__":
    YOUTUBE_STREAM_URL = "https://www.youtube.com/watch?v=DthoIdawJgg"
    process_youtube_live_stream(YOUTUBE_STREAM_URL)
