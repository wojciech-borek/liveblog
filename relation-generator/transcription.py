import whisper
import os

whisper_model = whisper.load_model("base")

audio_folder = "audio_files"

# Folder na transkrypcje
output_folder = "transcriptions"
if not os.path.exists(output_folder):
    os.makedirs(output_folder)

def transcribe_audio_files(folder_path):
    audio_files = [f for f in os.listdir(folder_path) if f.endswith(".mp4")]

    if not audio_files:
        print("Brak plików audio do transkrypcji.")
        return

    for audio_file in audio_files:
        file_path = os.path.join(folder_path, audio_file)
        print(f"Rozpoczynanie transkrypcji pliku: {audio_file}")

        try:
            print(file_path)
            result = whisper_model.transcribe(file_path)
            transcribed_text = result["text"]

            output_file = os.path.join(output_folder, f"{audio_file}.txt")
            with open(output_file, "w", encoding="utf-8") as f:
                f.write(transcribed_text)
            print(f"Zapisano transkrypcję: {output_file}")

        except Exception as e:
            print(f"Error podczas transkrypcji pliku {audio_file}: {e}")

if __name__ == "__main__":
    transcribe_audio_files(audio_folder)
