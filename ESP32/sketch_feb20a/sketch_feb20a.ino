#include <WiFi.h>
#include <WebServer.h>

const char* ssid = "Xiaomi Mi 11";
const char* password = "otednodoosem";

WebServer server(80);

void setup() {
  Serial.begin(115200);

  // Connect to Wi-Fi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");
  Serial.println(WiFi.localIP());


  // Define HTTP endpoints
  server.on("/", HTTP_GET, handleRoot);
  server.on("/forward", HTTP_GET, handleForward);
  server.on("/left", HTTP_GET, handleLeft);
  server.on("/right", HTTP_GET, handleRight);
  server.on("/backward", HTTP_GET, handleBackward);

  // Start server
  server.begin();
  Serial.println("HTTP server started");
}

void loop() {
  server.handleClient();
}

void handleRoot() {
  server.send(200, "text/plain", "ESP32 Control Server");
  Serial.println("ESP32 Control Server");
}

void handleForward() {
  server.send(200, "text/plain", "Forward command received");
  Serial.println("Forward command received");
}

void handleLeft() {
  server.send(200, "text/plain", "Left command received");
  Serial.println("Left command received");
}

void handleRight() {
  server.send(200, "text/plain", "Right command received");
  Serial.println("Right command received");
}

void handleBackward() {
  server.send(200, "text/plain", "Backward command received");
  Serial.println("Backward command received");
}
