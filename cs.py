import sqlite3
import tkinter as tk
import tkinter.font
import time


class pagesClass:
    def __init__(self, entry):
        self.idsong = entry[0]
        self.page = entry[1]
        self.content = entry[2]

class running_showClass:
    def __init__(self, entry):
        self.idrunning_show = entry[0]
        self.idshow = entry[1]
        self.idsets = entry[2]
        self.position = entry[3]
        self.song = entry[4]
        self.page = entry[5]
        self.pages = entry[6]

class songClass:
    def __init__(self, entry):
        self.idsong = entry[0]
        self.name = entry[1]
        self.artist = entry[2]
        self.lyrics_pages = entry[3]
        self.duration = entry[4]
        self.pitch = entry[5]
        self.tempo = entry[6]

class setsClass:
    def __init__(self, entry):
        self.idshow = entry[0]
        self.idset = entry[1]
        self.position = entry[2]
        self.song = entry[3]

class showClass:
    def __init__(self, entry):
        self.idshow = entry[0]
        self.label = entry[1]
        self.sets = entry[2]

cs = tk.Tk()
cs.title("Centerstage")
cs.config(bg="black")
cs.geometry("1920x1080")
# root.overrideredirect(True)
cs.resizable(False, False)


# Page
PageCanvas = tk.Canvas(cs, confine=True, height=1080, width=1500, bg='black', highlightthickness=0)
PageCanvas.place(x=0, y=0)
PageBorder = PageCanvas.create_rectangle(1500, 1080, 0, 0, outline='#ffff00', width=2)
PageFont = tk.font.Font(family='Helvetica', size=42, weight='bold')
# Time
TimeCanvas = tk.Canvas(cs, confine=True, height=100, width=420, bg='black', highlightthickness=0)
TimeCanvas.place(x=1500, y=0)
TimeBorder = TimeCanvas.create_rectangle(420, 100, 0, 0, outline='#ffff00', width=2)
TimeFont = tk.font.Font(family='Helvetica', size=68, weight='bold')
# Set
SetCanvas = tk.Canvas(cs, confine=True, height=80, width=420, bg='black', highlightthickness=0)
SetCanvas.place(x=1500, y=100)
SetBorder = SetCanvas.create_rectangle(420, 80, 0, 0, outline='#ffff00', width=2)
SetFont = tk.font.Font(family='Helvetica', size=30, weight='bold')
# Speed
SpeedCanvas = tk.Canvas(cs, confine=True, height=100, width=180, bg='black', highlightthickness=0)
SpeedCanvas.place(x=1500, y=180)
SpeedBorder = SpeedCanvas.create_rectangle(180, 100, 0, 0, outline='#ffff00', width=2)
SpeedFont = tk.font.Font(family='Helvetica', size=60, weight='bold')
# Pitch
PitchCanvas = tk.Canvas(cs, confine=True, height=100, width=100, bg='black', highlightthickness=0)
PitchCanvas.place(x=1680, y=180)
PitchBorder = PitchCanvas.create_rectangle(100, 100, 0, 0, outline='#ffff00', width=2)
PitchFont = tk.font.Font(family='Helvetica', size=60, weight='bold')
# Pages
PagesCanvas = tk.Canvas(cs, confine=True, height=100, width=140, bg='black', highlightthickness=0)
PagesCanvas.place(x=1780, y=180)
PagesBorder = PagesCanvas.create_rectangle(140, 100, 0, 0, outline='#ffff00', width=2)
PagesFont = tk.font.Font(family='Helvetica', size=60, weight='bold')
# Setlist
SetlistCanvas = tk.Canvas(cs, confine=True, height=800, width=420, bg='black', highlightthickness=0)
SetlistCanvas.place(x=1500, y=280)
SetlistBorder = SetlistCanvas.create_rectangle(420, 800, 0, 0, outline='#ffff00', width=2)
SetlistFont = tk.font.Font(family='Helvetica', size=34, weight='bold')

pagesList = []
running_showList = []
setsList = []
showList = []
songList = []

def loadData(pL, rL, seL, shL, soL):
    con = sqlite3.connect('Centerstage.sqlite3')

    # Get Pages
    cur = con.cursor()
    for row in cur.execute('SELECT * FROM pages'):
        pL.append(pagesClass(row))

    # Get Running_Show
    cur = con.cursor()
    for row in cur.execute('SELECT * FROM running_show'):
        rL.append(running_showClass(row))

    # Get Sets
    cur = con.cursor()
    for row in cur.execute('SELECT * FROM sets'):
        seL.append(setsClass(row))

    # Get Shows
    cur = con.cursor()
    for row in cur.execute('SELECT * FROM show'):
        shL.append(showClass(row))

    # Get Songs
    cur = con.cursor()
    for row in cur.execute('SELECT * FROM song'):
        soL.append(songClass(row))

    # Get Current Show
    cur = con.cursor()
    for row in cur.execute('SELECT * FROM current_show'):
        cS = row[0]
    for x in shL:
        if x.idshow == cS:
            return x

    con.close()

    return cS

def printtime():
    locTime = time.localtime(time.time())
    locTimeString = str(locTime.tm_hour) + ':' + str(locTime.tm_min).zfill(2) + ':' + str(locTime.tm_sec).zfill(2)
    TimeCanvas.create_rectangle(2,2,418,98, fill='#000000')
    TimeCanvas.create_text(210, 50, justify='center', fill='#ffff00', text=locTimeString, font=TimeFont)
    cs.after(1000, printtime)

def printset():
    showtext = currentShow.label
    settext = 'Set-' + str(currentSet)
    SetCanvas.create_rectangle(2, 2, 418, 78, fill='#000000')
    SetCanvas.create_text(210, 23, justify='center', fill='#00ff00', text=showtext, font=SetFont)
    SetCanvas.create_text(210, 57, justify='center', fill='#00ff00', text=settext, font=SetFont)

def printsong():
    speedtext = currentSong.tempo
    pitchtext = currentSong.pitch
    pagestext = str(currentPage) + '/' + str(currentSong.lyrics_pages)
    SpeedCanvas.create_rectangle(2, 2, 138, 98, fill='#000000')
    SpeedCanvas.create_text(90, 50, justify='center', fill='#ff0000', text=speedtext, font=SpeedFont)
    PitchCanvas.create_rectangle(2, 2, 98, 98, fill='#000000')
    PitchCanvas.create_text(50, 50, justify='center', fill='#ffff00', text=pitchtext, font=PitchFont)
    PagesCanvas.create_rectangle(2, 2, 138, 98, fill='#000000')
    PagesCanvas.create_text(70, 50, justify='center', fill='#ff00ff', text=pagestext, font=PageFont)

def getmaxsets(sl, cs):
    for x in sl:
        if x.idshow == cs:
            return x.sets

def getsong(sol, sel, cs, cp):
    for x in sel:
        if x.idset == cs and x.position == cp:
            for y in sol:
                if y.idsong == x.song:
                    return y

currentShow = loadData(pagesList, running_showList, setsList, showList, songList)
maxSets = getmaxsets(showList, currentShow)
currentSet = 1
currentPosition = 1
currentSong = getsong(songList, setsList, currentSet, currentPosition)
currentPage = 1


printtime()
printset()
printsong()

cs.mainloop()