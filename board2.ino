  #include "DHT.h"
#include <ESP8266WiFi.h>
#include <BH1750.h>
#include<Wire.h>
#define DHTPIN 14
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE); 
BH1750 lightMeter;

  
int samplingTime = 280;
int deltaTime = 40;
int sleepTime = 9680;
long previousMillis = 0;
long interval = 10000;
void setup(){  
  Serial.begin(9600); 
  Wire.begin();
   WiFi.begin("Asshole", "1233211234567");
   WiFi.mode(WIFI_STA);
   dht.begin();
     
lightMeter.begin();
 
Serial.println();
Serial.println();
Serial.print("Wait for WiFi... ");

while(WiFi.status() != WL_CONNECTED) {
Serial.print(".");
delay(500);
}
 
Serial.println("");
Serial.println("[成功]WiFi 已連接");
Serial.print("IP address: ");
Serial.println(WiFi.localIP());
  Serial.println("Server started");
  envir();
}
 String floatToString(float x, byte precision = 2) {
char tmp[50];
dtostrf(x, 0, precision, tmp);
return String(tmp);
}
void loop(){
 
    unsigned long currentMillis = millis();
 if(currentMillis - previousMillis > interval) {
   previousMillis = currentMillis;   
 envir();}
}

  
void envir(){
  temp();
  
  light();  
  }
void temp(){
  float h = dht.readHumidity();
float t = dht.readTemperature();
float f = dht.readTemperature(true);
if (isnan(h) || isnan(t) || isnan(f)) {
Serial.println("Failed to read from DHT sensor!");
return;
}
Serial.print("Humidity: ");
Serial.print(h);
Serial.print("%\t");
Serial.print("celsius: ");
Serial.print(t);
Serial.print("*C\t");
Serial.print("fahrenheit: ");
Serial.print(f);
Serial.print("*F\n");
 
const uint16_t port = 80;
const char * host = "192.168.2.33"; // ip or dns
Serial.print("連線至");
Serial.println(host);
 
// Use WiFiClient class to create TCP connections
WiFiClient client;
 
if (!client.connect(host, port)) {
Serial.println("connection failed");
Serial.println("wait 5 sec...");
delay(5000);
return;
}
 
  String url = "/dht11.php?celsius="+floatToString( dht.readTemperature())+"&humidity="+h+"&fahrenheit="+f;
  client.print(String("GET ") + url + " HTTP/1.1\r\n" +
  "Host: " + host + "\r\n" +
  "User-Agent: BoardDetectorESP8266davidouHomeSystem\r\n" +
  "Connection: close\r\n\r\n");
client.stop();
 
}

void light(){
  uint16_t lux = lightMeter.readLightLevel();
  Serial.print("Light: ");
  Serial.print(lux);
  Serial.println(" lx");
  delay(1000);
   const uint16_t port = 80;
const char * host = "192.168.2.33"; 
WiFiClient client;
 
if (!client.connect(host, port)) {
Serial.println("connection failed");
Serial.println("wait 5 sec...");
delay(5000);
return;
}
String light;
light = String(lux);
 String url = "/temt6000.php?light="+light;
  client.print(String("GET ") + url + " HTTP/1.1\r\n" +
  "Host: " + host + "\r\n" +
  "User-Agent: BoardDetectorESP8266davidouHomeSystem\r\n" +
  "Connection: close\r\n\r\n");
client.stop();  

}
