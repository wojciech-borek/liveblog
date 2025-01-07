import subprocess
import os
import time

audio_folder = "audio_files"
if not os.path.exists(audio_folder):
    os.makedirs(audio_folder)

def process_youtube_live_stream(stream_url):
    print("Started download stream...")

    command_yt_dlp = [
        "yt-dlp", "-f", "bestaudio", "-o", "-", stream_url
    ]

    process_yt_dlp = subprocess.Popen(command_yt_dlp, stdout=subprocess.PIPE, stderr=subprocess.PIPE)

    try:
        file_index = 0
        audio_data = b""

        while True:
            start_time = time.time()
            while time.time() - start_time < 10:
                audio_chunk = process_yt_dlp.stdout.read(1024 * 1024)
                if not audio_chunk:
                    if process_yt_dlp.poll() is not None:
                        print("Proces yt-dlp ended")
                        break
                    continue

                audio_data += audio_chunk

            if audio_data:
                # Zapisz dane audio bezpośrednio do pliku WAV za pomocą ffmpeg
                file_name = os.path.join(audio_folder, f"audio_chunk_{file_index}.wav")
                command_ffmpeg = [
                    "ffmpeg",
                    "-f", "webm",  # Format wejściowy (webm)
                    "-i", "pipe:0",  # Wejście z pipe
                    "-ar", "16000",  # Częstotliwość próbkowania
                    "-ac", "1",      # Mono
                    "-y",            # Nadpisz plik
                    file_name        # Wyjście
                ]

                # Uruchomienie procesu ffmpeg
                process_ffmpeg = subprocess.Popen(command_ffmpeg, stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.PIPE)

                # Sprawdzenie, czy ffmpeg jest aktywny, zanim zapiszemy dane
                if process_ffmpeg.poll() is not None:
                    print("Proces ffmpeg zakończył się przed czasem. Spróbuj ponownie.")
                    continue  # Pomijamy zapis, jeśli proces ffmpeg zakończył się

                try:
                    # Zapisywanie danych do ffmpeg (stdin)
                    process_ffmpeg.stdin.write(audio_data)  # Zapisujemy dane audio do ffmpeg
                    process_ffmpeg.stdin.close()  # Zamykamy stdin po zakończeniu zapisu
                except BrokenPipeError as e:
                    print(f"Błąd zapisu do ffmpeg: {e}")
                    # Poczekaj chwilę i spróbuj ponownie
                    time.sleep(1)
                    continue  # Przechodzimy do kolejnej iteracji

                # Oczekiwanie na zakończenie procesu ffmpeg
                process_ffmpeg.communicate()

                print(f"Zapisano plik: {file_name}")
                file_index += 1
                audio_data = b""  # Resetujemy dane audio po zapisaniu pliku

            # Poczekaj chwilę przed kolejnym odczytem
            time.sleep(1)

    except KeyboardInterrupt:
        # Zatrzymujemy proces po przerwaniu
        process_yt_dlp.terminate()
        print("Stream został zatrzymany.")

if __name__ == "__main__":
    YOUTUBE_STREAM_URL = "https://www.youtube.com/watch?v=zZDfLQxi_sw"
    process_youtube_live_stream(YOUTUBE_STREAM_URL)
