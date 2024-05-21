#include <WiFi.h>
#include <HTTPClient.h>

const char* ssid = "Xiaomi Mi 11";      
const char* password = "otednodoosem"; 

const int middle = 36; // Lilav
const int pointer = 39; // Siv
const int thumb = 34; // Bql

int valueMiddle;
int valuePointer;
int valueThumb;

int threshold = 90;

void setup() {
    Serial.begin(115200);
    delay(100);

    // Connect to WiFi
    Serial.println();
    Serial.print("Connecting to ");
    Serial.println(ssid);

    WiFi.begin(ssid, password);

    while (WiFi.status() != WL_CONNECTED) {
        delay(500);
        Serial.print(".");
    }

    Serial.println("");
    Serial.println("WiFi connected.");

    Serial.print("IP address: ");
    Serial.println(WiFi.localIP());
}

void sendDirection(String direction) {
    HTTPClient http;
    String url = "http://192.168.63.73/" + direction;
    http.begin(url);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    int httpResponseCode = http.GET();

    if (httpResponseCode > 0) {
        Serial.print("HTTP request sent successfully. Response code: ");
        Serial.println(httpResponseCode);
    } else {
        Serial.print("Error sending HTTP request. Error code: ");
        Serial.println(httpResponseCode);
    }

    http.end();
}

void loop() {
    valueMiddle = analogRead(middle);
    valuePointer = analogRead(pointer);
    valueThumb = analogRead(thumb);

    if (valueThumb < threshold) {
        Serial.println("Thumb is bent!");

        String currentDirection = "none";

        if (valueMiddle < threshold && valuePointer < threshold) {
            currentDirection = "forward";
            Serial.println(currentDirection);
            sendDirection(currentDirection);
        } else if (valueMiddle < threshold && valuePointer > threshold) {
            currentDirection = "left";
            Serial.println(currentDirection);
            sendDirection(currentDirection);
        } else if (valueMiddle > threshold && valuePointer < threshold) {
            currentDirection = "right";
            Serial.println(currentDirection);
            sendDirection(currentDirection);
            
        }
    }

    delay(500); 
}
