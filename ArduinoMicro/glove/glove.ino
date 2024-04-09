// C++ code
//
const int middle = A2;//lilav
const int pointer = A1;//siv
const int thumb = A0;//bql

int valueMiddle;
int valuePointer;
int valueThumb;
int threshold = 90;
void setup()
{
  Serial.begin(115200);
}

void loop()
{
  valueMiddle = analogRead(middle);
  valuePointer = analogRead(pointer);
  valueThumb = analogRead(thumb);
  
  //Serial.println(valueThumb);
  
 
  if (valueMiddle < threshold) {
    Serial.println("Middle finger is bent!");
  }

  if (valuePointer < threshold) {
    Serial.println("Pointer finger is bent!");
  }

  if (valueThumb < threshold) {
    Serial.println("Thumb is bent!");
  }

  delay(1000);
}