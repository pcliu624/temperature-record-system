# temperature-record-system
![image](https://github.com/pcliu624/temperature-record-system/blob/main/TEMPSYS.png)
                       ******************************Instruction************************************
 Setup: 
  install xampp, 
  download fusion charts. https://www.fusioncharts.com/
  html file and fusion charts file move under location:/xampp/htdocs
      
 database setup:
  login phpmyadmin http://localhost/phpmyadmin/index.php?lang=en
  add a new database name project
  create 4 tables, 2 columns each:
  ![image](https://github.com/pcliu624/temperature-record-system/blob/main/celdb.png)
  datatype:
  1st column int
  2nd column datetime
                    
 install the library of esp8266.h, bh1750.h, Wire.h in Arduino IDE
 type your wifi ssid and password, ip address
                    
 hardware requitment: nodeMCU, dht11 bh1750

 hardware setup:     
  dht11 out-----nodeMCU D5 pin
  bh1750 SCL------------D1 pin
  SDA            D2 pin
