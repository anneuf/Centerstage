#!/usr/bin/python
from evdev import InputDevice, categorize, ecodes
from select import select
import sqlite3 as lite
dev = InputDevice('/dev/input/event0')

con = lite.connect('/var/www/html/db/Centerstage.sqlite3')


while True:
   r,w,x = select([dev], [], [])
   for event in dev.read():
       if event.type == ecodes.EV_KEY:
           data = categorize(event)
           if data.keystate == 1:
              if (data.keycode) == "KEY_PAGEUP":
                 with con:
                    cur = con.cursor()
                    cur.execute("select pointer from pointer")
                    row = cur.fetchone()
                    actual_pointer = row[0]
                    cur.execute("select bof from running_show where idrunning_show=?", (str(actual_pointer),))
                    row = cur.fetchone()
                    bof = row[0]
                    if bof != 1:
                      new_pointer = actual_pointer - 1
                      cur.execute("update pointer set pointer =?", (str(new_pointer),))
                      con.commit()
              if (data.keycode) == "KEY_PAGEDOWN":
                 with con:
                    cur = con.cursor()
                    cur.execute("select pointer from pointer")
                    row = cur.fetchone()
                    actual_pointer = row[0]
                    cur.execute("select eof from running_show where idrunning_show=?", (str(actual_pointer),))
                    row = cur.fetchone()
                    eof = row[0]
                    if eof != 1:
                      new_pointer = actual_pointer + 1
                      cur.execute("update pointer set pointer =?", (str(new_pointer),))
                      con.commit()
                    
