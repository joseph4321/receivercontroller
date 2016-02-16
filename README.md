# Reciever Controller

This code was written to control the video source of multicast receivers.  The receivers output multicast video in a transport stream as mp4.  The control functions used soap, while the video streams were controlled using rtsp.  The output video was what showed up on the set top box in the guest rooms.  This application became absolutely essential as it provided an easy, point and click way to:
- Check stream status
- Restart streams
- Reboot receivers
- Modify channel numbers
- Modify multicast destinations
- View a sample of the video stream
- View historical graph of signal strength
- Get receiver information such as channels playing, signal strength, receiver id, etc
- Provide email alerts for when channels went down or a receiver signal strength went below a provided threshold

There is also a daemon running in the background that automatically checks each receiver every five minutes.  The daemon verifies:
- The stream is still running
- The receiver is on the correct channel
- The receiver signal strength is above a provided threshold
- That the packet count coming from the stream is above a provided threshold
- Record the signal strength in an rrd database
- Corrective actions if any of the above criteria fail
- E-Mail alerts if the corrective actions do not resolve the issue  

<img src="https://raw.githubusercontent.com/joseph4321/receivercontroller/master/shot1.png" alt="Drawing" style="width: 400px;height: 400px"/>
