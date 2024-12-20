import whisper
from transformers import MT5Tokenizer, MT5ForConditionalGeneration, pipeline

from summa import summarizer
import requests

def transcribe_video(model, video_file):
    print(f"Transkrypcja pliku wideo: {video_file}")
    result = model.transcribe(video_file, language="pl")
    return result['text']

def split_text(text, chunk_size=300):
    words = text.split()
    return [' '.join(words[i:i + chunk_size]) for i in range(0, len(words), chunk_size)]

def summarize_text(chunks, summarizer_model=None):
    summaries = []
    for i, chunk in enumerate(chunks):
        print(f"Podsumowanie fragmentu {i + 1}")
        print(chunk)

        if len(chunk.strip()) > 0:
            summary = summarizer_model(chunk, max_length=150, min_length=10, do_sample=False)[0]['summary_text']
            summaries.append(summary)
        else:
            print("Wprowadzony tekst jest pusty!")
    return summaries

def generate_social_posts(summaries, context=""):
    posts = []
    for i, summary in enumerate(summaries):
        post = f"✨ {summary}\n📍 {context}\n➡️ Zobacz więcej: [LINK]"
        posts.append(post)
    return posts

def main(video_file):
    whisper_model = whisper.load_model("base")
    full_text = transcribe_video(whisper_model, video_file)
    chunks = split_text(full_text, chunk_size=300)

    local_model_path = "/var/www/html/relation-generator/local_models/google/mt5-base/"

    tokenizer = MT5Tokenizer.from_pretrained(local_model_path)
    model = MT5ForConditionalGeneration.from_pretrained(local_model_path)

    summarizer_model = pipeline("summarization",
         model=model,
         tokenizer=tokenizer
     )
    summaries = summarize_text(chunks, summarizer_model=summarizer_model)

    context = "Kluczowe momenty wydarzenia"
    posts = generate_social_posts(summaries, context)

    for i, post in enumerate(posts):
        print(f"Post {i + 1}:\n{post}\n")

if __name__ == "__main__":
    input_video_path = "data/input_video.mp4"
    main(input_video_path)