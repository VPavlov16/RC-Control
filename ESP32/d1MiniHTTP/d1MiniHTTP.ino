#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include <Servo.h>

// WiFi credentials
const char* ssid = "Xiaomi Mi 11";
const char* password = "otednodoosem";

const int forward = 1350;
const int backward = 1650;

const int left = 1300;
const int right = 1650; 

const int midpoint = 1500;

#define ESC_PIN 14
#define ESC_PIN2 12 // GPIO pin number for the ESC control

Servo esc;
Servo esc2; // Declare second servo for second ESC pin
WiFiServer server(80);

void setup() {
  Serial.begin(115200);
  esc.attach(ESC_PIN);
  esc2.attach(ESC_PIN2); // Attach second ESC to the designated pin
  delay(1000); // Wait for ESCs to initialize

  // Send a neutral signal to arm the ESCs
  esc.writeMicroseconds(midpoint);
  esc2.writeMicroseconds(midpoint);
  delay(5000); // Wait for ESCs to recognize the neutral signal (arming)

  // Connect to WiFi
  Serial.print("Connecting to WiFi...");
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("Connected to WiFi");
  Serial.println(WiFi.localIP());

  // Start HTTP server
  server.begin();
  Serial.println("HTTP server started");
}

void loop() {
  WiFiClient client = server.available();
  if (client) {
    // Handle incoming request asynchronously
    handleRequest(client);
  }
}

void handleRequest(WiFiClient client) {
  if (!client.connected()) {
    client.stop();
    return;
  }

  // Read the HTTP request
  String request = client.readStringUntil('\r');
  client.flush();

  // Process the request and send response
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

  // Move forward at half speed
  esc.writeMicroseconds(forward); // Adjusted from 1500 to move forward at half speed
  delay(1500); // Move for 1.5 seconds
  esc.writeMicroseconds(midpoint); // Stop the movement
}

void handleLeft(WiFiClient client) {
  client.println("HTTP/1.1 200 OK");
  client.println("Content-Type: text/plain");
  client.println();
  client.println("Left command received");
  Serial.println("Left command received");

  //esc.writeMicroseconds(1550); // Adjusted from 1500 to move left at half speed
  esc2.writeMicroseconds(left); // Adjusted from 1500 to move left at half speed
  delay(1500); // Move for 1.5 seconds
  //esc.writeMicroseconds(1500); // Stop the movement
  esc2.writeMicroseconds(midpoint);
}

void handleRight(WiFiClient client) {
  client.println("HTTP/1.1 200 OK");
  client.println("Content-Type: text/plain");
  client.println();
  client.println("Right command received");
  Serial.println("Right command received");

   esc2.writeMicroseconds(right); // Adjusted from 1500 to move left at half speed
  delay(1500); // Move for 1.5 seconds
  //esc.writeMicroseconds(1500); // Stop the movement
  esc2.writeMicroseconds(midpoint);
}

void handleBackward(WiFiClient client) {
  client.println("HTTP/1.1 200 OK");
  client.println("Content-Type: text/plain");
  client.println();
  client.println("Backward command received");
  Serial.println("Backward command received");

  // Move backward at half speed
  esc.writeMicroseconds(backward); // Adjusted from 1500 to move forward at half speed
  delay(1500); // Move for 1.5 seconds
  esc.writeMicroseconds(midpoint); // Stop the movement
}
