import signal, os, time
from threading import Lock
import picamera


from PIL import Image
import numpy as np
import io
import MySQLdb

db = MySQLdb.connect("localhost","root","hansung","picture")
cursor=db.cursor()
lck = Lock()




prior_image = None
width = 640
height = 480
threshold = 30
minPixelsChanged = width * height * 3 / 100
print("minPixelsChanged=",minPixelsChanged)
print ('Creating in-memory stream')



        


def detect_motion(camera):
    step = 1  
    numImages = 1 
    captureCount = 0 
    global prior_image
    
    stream = io.BytesIO()
  
   
    
    stream.seek(0)
    camera.capture(stream, 'rgba',True)
    data1 = np.fromstring(stream.getvalue(), dtype=np.uint8)
    time.sleep(1)
    stream.seek(0)
    camera.capture(stream, 'rgba',True)
    data2 = np.fromstring(stream.getvalue(), dtype=np.uint8)
               
    data3 = np.abs(data1 - data2)  
    numTriggers = np.count_nonzero(data3 > threshold) / 4 / threshold

    print("Trigger cnt=",numTriggers)

    if numTriggers > minPixelsChanged:
        captureCount = 1 
    return  captureCount  



    
    fin = open("my_image.jpg")    
    img = fin.read()

    
with picamera.PiCamera() as camera:
        camera.resolution = (1280, 720)
        stream = picamera.PiCameraCircularIO(camera, seconds=10)
        camera.start_recording(stream, format='h264')
        print 'record start'
        try:
           while True:
                   imagename = time.strftime("%Y%m%d%H%M.jpg",time.localtime())

                   camera.wait_recording(1)
                   camera.capture('/home/pi/www/'+imagename)
                   
                   fin = open(imagename)    
                   img = fin.read()
                   
                   with db:
                            image_name = imagename
                            data = img
                            cursor.execute("INSERT INTO picture(name,data) VALUES(%s,%s)", (image_name,data))
                                            print 'capture'
                   camera.wait_recording(1)
                   if detect_motion(camera):
                        print('Motion detected!')
                       
                        dtFileStr = time.strftime("%Y%m%d%H%M%Safter.h264",time.localtime())
                       
                        camera.split_recording(dtFileStr)
                      
                        dtFileStr2 = time.strftime("%Y%m%d%H%M%Sbefore.h264",time.localtime())
                        with db:
                            image_name = imagename
                            data = img
                            cursor.execute("INSERT INTO video(name) VALUES(%s)", (dtFileStr))
                            cursor.execute("INSERT INTO video(name) VALUES(%s)", (dtFileStr2))
                        stream.copy_to(dtFileStr2, seconds=10)
                        stream.clear()
                 
                        
                        while detect_motion(camera):
                            camera.wait_recording(1)
                        print('Motion stopped!')
                        camera.split_recording(stream)

                           
                             
        finally:
                camera.stop_recording()
                print 'stop'
        
