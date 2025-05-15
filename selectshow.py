import tkinter as tk
import tkinter.font
from tkinter import ttk
import time
import sys
import os
import sqlite3

class showClass:
    def __init__(self, entry):
        self.idshow = entry[0]
        self.label = entry[1]
        self.sets = entry[2]

def addShow():
    startString = sys.executable + ' editshow.py 0'
    os.system(startString)
    selShow.destroy()


def deleteShow():
    result = False
    for s in shL:
        if s.label == showList.get():
            idshow = str(s.idshow)
            result = True
    if result:
        con = sqlite3.connect('Centerstage.sqlite3')
        cur = con.cursor()
        sqlString = 'DELETE FROM show WHERE show.idshow=' + idshow
        cur.execute(sqlString)
        con.commit()
        con.close()
        selShow.destroy()

def selectShow():
    result = False
    for s in shL:
        if s.label == showList.get():
            idshow = str(s.idshow)
            result = True
    if result:
        con = sqlite3.connect('Centerstage.sqlite3')
        cur = con.cursor()
        sqlString = 'UPDATE current_show SET idshow=' + idshow + ' WHERE idshow=' + str(curShow)
        cur.execute(sqlString)
        con.commit()
        con.close()
        selShow.destroy()


def editShow():
    result = False
    for s in shL:
        if s.label == showList.get():
            idshow = str(s.idshow)
            result = True
    if result:
        startString = sys.executable + ' editshow.py ' + idshow
        os.system(startString)
        selShow.destroy()


def exitMenu():
    pass

selMode = sys.argv[1]
shL = []
shNameL = []

con = sqlite3.connect('Centerstage.sqlite3')
cur = con.cursor()
for row in cur.execute('SELECT * FROM show'):
    shL.append(showClass(row))
    shNameL.append(showClass(row).label)
for row in cur.execute('SELECT * FROM current_show'):
    curShow = row[0]
con.close()

selShow = tk.Tk()
selShow.title("Show")
selShow.config(bg="#aaaaaa")
# main.geometry("800x600+200+200")
selShow.resizable(False, False)

TitleFont = tk.font.Font(family='Helvetica', size=21, weight='bold')
ButtonFont = tk.font.Font(family='Helvetica', size=15, weight='bold')

Title = tk.Label(selShow, text='Select Show', fg='#ffff00', bg='#aaaaaa', font=TitleFont, padx=10, pady=10)
Title.grid(row=0, column=0, sticky='ew', columnspan=4)
blankLabel1 = tk.Label(selShow, text='', bg='#aaaaaa')
blankLabel1.grid(row=1, column=0, sticky='ew', columnspan=4)
showList = ttk.Combobox(selShow, state='readonly', values=shNameL)
showList.grid(row=2, column=0, sticky='ew', columnspan=4)
blankLabel2 = tk.Label(selShow, text='', bg='#aaaaaa')
blankLabel2.grid(row=3, column=0, sticky='ew', columnspan=4)
button1 = tk.Button(selShow, text='Add Show', command=addShow, font=ButtonFont)
button1.grid(row=4, column=0, sticky='ew')
button2 = tk.Button(selShow, text='Delete Show', command=deleteShow, font=ButtonFont)
button2.grid(row=4, column=1, sticky='ew')
match selMode:
    case '1':
        button3 = tk.Button(selShow, text='Edit Show', command=editShow, font=ButtonFont)
    case '2':
        button3 = tk.Button(selShow, text='Select Show', command=selectShow, font=ButtonFont)
    case _:
        button3 = tk.Label(selShow, text='', bg='#aaaaaa')
button3.grid(row=4, column=2, sticky='ew')
button5 = tk.Button(selShow, text='Exit', command=exitMenu, font=ButtonFont)
button5.grid(row=4, column=3, sticky='ew')

selShow.mainloop()
