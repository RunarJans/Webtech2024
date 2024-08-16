import requests
import time
import random  # Simuleert temperatuurmeting; vervang dit met je eigen sensor logica

def get_temperature():
    # Vervang deze functie met je eigen logica om de temperatuur te meten
    return round(random.uniform(20.0, 30.0), 1)

def send_temperature(temperature):
    url = "http://server-of-runar.pxl.bjth.xyz/post_temperature.php"
    headers = {"Content-Type": "application/json"}
    payload = {"temperature": str(temperature)}
    try:
        response = requests.post(url, json=payload, headers=headers)
        response.raise_for_status()  # Zorg ervoor dat de aanvraag succesvol is
        print(f"Temperature {temperature} sent successfully.")
    except requests.RequestException as e:
        print(f"Error sending temperature: {e}")

if __name__ == "__main__":
    while True:
        temp = get_temperature()
        send_temperature(temp)
        time.sleep(10)  # Wacht 60 seconden voordat je de temperatuur opnieuw verzendt
