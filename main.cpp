// #include <WiFi.h>
// #include <HTTPClient.h>

// const char* ssid = "VIDEOTRON2945";
// const char* password = "ThePizzaCompany2001";
// const char* server = "http://your-server-ip/check_rfid.php";

// void sendRFIDData(String rfidTag) {
//     HTTPClient http;
//     http.begin(server);
//     http.addHeader("Content-Type", "application/x-www-form-urlencoded");
//     String postData = "rfid_tag=" + rfidTag;
//     int httpResponseCode = http.POST(postData);
//     http.end();
// }