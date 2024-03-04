#include <WiFi.h>
#include <MQTT.h>

const char* ssid = "Xiaomi Mi 11";
const char* password = "otednodoosem";
const char* mqtt_server = "public.mqtthq.com";
const int mqtt_port = 1883;

WiFiClient net;
MQTTClient client;

//unsigned long lastMillis = 0; // Variable to store the last time a message was sent

void setup() {
  Serial.begin(115200);
  WiFi.begin(ssid, password);
  
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.println("Connecting to WiFi...");
  }

  Serial.println("Connected to WiFi");

  client.begin(mqtt_server, mqtt_port, net); 

  while (!client.connect("")) {
    Serial.println("Connecting to MQTT broker...");
    delay(5000);
  }

  Serial.println("Connected to MQTT broker");
  client.subscribe("RCControl");
  if(client.subscribe("RCControl")){
    Serial.println("Subscribed sucessfully!");
  }
  
}

void loop() {
  client.loop();

  client.onMessage(messageReceived);
    //client.publish("RCControl", "churka");
  
}

void messageReceived(String &topic, String &payload) {
  Serial.print("Message received on topic: ");
  Serial.println(topic);
  Serial.print("Message: ");
  Serial.println(payload);
}

