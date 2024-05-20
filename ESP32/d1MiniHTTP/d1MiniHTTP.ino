#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include <Servo.h>

// WiFi credentials
const char* ssid = "Xiaomi Mi 11";
const char* password = "otednodoosem";

const int forward = 1220;
const int backward = 1800;

const int left = 1220;
const int right = 1800; 

const int midpoint = 1500;

#define ESC_PIN 14
#define ESC_PIN2 12 

Servo esc;
Servo esc2; 
WiFiServer server(80);

void setup() {
  Serial.begin(115200);
  esc.attach(ESC_PIN);
  esc2.attach(ESC_PIN2); 
  delay(1000); 

  esc.writeMicroseconds(midpoint);
  esc2.writeMicroseconds(midpoint);
  delay(5000); 

  // Connect to WiFi
  Serial.print("Connecting to WiFi...");
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("Connected to WiFi");
  Serial.println(WiFi.localIP());

  server.begin();
  Serial.println("HTTP server started");
}

void loop() {
  WiFiClient client = server.available();
  if (client) {
    handleRequest(client);
  }
}

void handleRequest(WiFiClient client) {
  if (!client.connected()) {
    client.stop();
    return;
  }

  String request = client.readStringUntil('\r');
  client.flush();

  if (request.indexOf("/forward") != -1) {
    handleForward(client);
  } else if (request.indexOf("/left") != -1) {
    handleLeft(client);
  } else if (request.indexOf("/right") != -1) {
    handleRight(client);
  } else if (request.indexOf("/backward") != -1) {
    handleBackward(client);
  } else {
    handleRoot(client);
  }

  // Close the connection
  client.stop();
}

void handleRoot(WiFiClient client) {
  client.println("HTTP/1.1 200 OK");
  client.println("Content-Type: text/plain");
  client.println();
  client.println("ESP8266 Control Server");
  Serial.println("ESP8266 Control Server");
}

void handleForward(WiFiClient client) {
  client.println("HTTP/1.1 200 OK");
  client.println("Content-Type: text/plain");
  client.println();
  client.println("Forward command received");
  Serial.println("Forward command received");

  esc.writeMicroseconds(forward); 
  delay(1500);
  esc.writeMicroseconds(midpoint); 
}

void handleLeft(WiFiClient client) {
  client.println("HTTP/1.1 200 OK");
  client.println("Content-Type: text/plain");
  client.println();
  client.println("Left command received");
  Serial.println("Left command received");

  esc2.writeMicroseconds(left); 
  delay(1500); 
  esc2.writeMicroseconds(midpoint);
}

void handleRight(WiFiClient client) {
  client.println("HTTP/1.1 200 OK");
  client.println("Content-Type: text/plain");
  client.println();
  client.println("Right command received");
  Serial.println("Right command received");

  esc2.writeMicroseconds(right); 
  delay(1500); 
  esc2.writeMicroseconds(midpoint);
}

void handleBackward(WiFiClient client) {
  client.println("HTTP/1.1 200 OK");
  client.println("Content-Type: text/plain");
  client.println();
  client.println("Backward command received");
  Serial.println("Backward command received");

  esc.writeMicroseconds(backward); 
  delay(1500);
  esc.writeMicroseconds(midpoint); 
}
