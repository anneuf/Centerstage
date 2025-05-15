import tkinter as tk
import tkinter.font
from tkinter import ttk
import time
import sys
import os
import sqlite3

def changeName():
    con = sqlite3.connect('Centerstage.sqlite3')
    cur = con.cursor()
    sqlString = sqlPartString[0] + showNameString.get() + sqlPartString[1]
    cur.execute(sqlString)
    con.commit()
    con.close()
    editShow.destroy()

def editSets():
    startString = sys.executable + ' editset.py ' + str(selShow)
    os.system(startString)
def exitEditShow():
    editShow.destroy()

selShow = sys.argv[1]

editShow = tk.Tk()
editShow.title('Showname')
editShow.config(bg="#aaaaaa")
# main.geometry("800x600+200+200")
editShow.resizable(False, False)

showNameString = tk.StringVar(value='')
showIdList = []

con = sqlite3.connect('Centerstage.sqlite3')
cur = con.cursor()
for row in cur.execute('SELECT * FROM show WHERE idshow=' + str(selShow)):
    showNameString.set(value=row[1])
for row in cur.execute('SELECT * FROM show'):
    showIdList.append(row[0])
con.close()

newShowId = max(showIdList) + 1

match selShow:
    case '0':
        titleText = 'Add Show'
        sqlPartString = ['INSERT INTO show (idshow,label,sets) VALUES (' + str(newShowId) + ',\"', '\",1)']
    case _:
        titleText = 'Edit Show'
        sqlPartString = ['UPDATE show SET label=\"', '\" WHERE idshow=' + str(selShow)]

TitleFont = tk.font.Font(family='Helvetica', size=21, weight='bold')
ButtonFont = tk.font.Font(family='Helvetica', size=15, weight='bold')

Title = tk.Label(editShow, text=titleText, fg='#ffff00', bg='#aaaaaa', font=TitleFont, padx=10, pady=10)
Title.grid(row=0, column=0, sticky='ew', columnspan=2)
blankLabel1 = tk.Label(editShow, text='', bg='#aaaaaa')
blankLabel1.grid(row=1, column=0, sticky='ew', columnspan=2)
showLabel1 = tk.Label(editShow, text='Showname:', fg='#00ff00', bg='#aaaaaa', font=ButtonFont)
showLabel1.grid(row=2, column=0, sticky='ew', columnspan=2)
showName = tk.Entry(editShow, textvariable=showNameString, fg='#ff0000', bg='#aaaaaa', font=ButtonFont)
showName.grid(row=3, column=0, sticky='ew', columnspan=2)
blankLabel2 = tk.Label(editShow, text='', bg='#aaaaaa')
blankLabel2.grid(row=4, column=0, sticky='ew', columnspan=2)
button1 = tk.Button(editShow, text=titleText, command=changeName, font=ButtonFont)
button1.grid(row=5, column=0, sticky='ew')
button2 = tk.Button(editShow, text='EditSets', command=editSets, font=ButtonFont)
button2.grid(row=6, column=0, sticky='ew')
button3 = tk.Button(editShow, text='Exit', command=exitEditShow, font=ButtonFont)
button3.grid(row=7, column=0, sticky='ew')

editShow.mainloop()